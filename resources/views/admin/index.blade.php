@extends('layouts.master')

@section('title', 'zskape')

@section('content')
    <section class="container">
        <div id="contentMain">

            <h1>{!! $posts->count() !!} posts have been reported </h1>
            <?php  $count = 0; ?>
            @foreach ($posts as $post)
                <?php  $count++; ?>
                <?php if ($count % 5 == 0) { ?>
                <div id="{{ $post->id }}" class="posts posts-last-on-row">

                    <?php } else { ?>
                    <div id="{{ $post->id }}" class="posts">
                        <?php } ?>
                            {!! Form::open([
'method' => 'DELETE',
'route' => ['posts.destroy', $post->id],
'class'=>'form-btn-inline',
]) !!}
                            <button rel="nofollow" onclick="return confirm('Are you sure you want to delete?')"
                                    type="submit" class="nobtn big" style="color:red; float:right">Delete
                            </button>
                            {!! Form::close() !!}

                            {!! Form::open([
'method' => 'DELETE',
'route' => ['DeletePostReports', $post->id],
'class'=>'form-btn-inline',
]) !!}
                            <button rel="nofollow" onclick="return confirm('Are you sure you want to delete?')"
                                    type="submit" class="nobtn big" style="color:#00AF00; float:left">Remove reports
                            </button>
                            {!! Form::close() !!}
                        <div class="posts-image"><a href="{{ url('/', $post->id) }}"><img
                                        src="{{url ("i/".$post->file_thumb.".".$post->file_extension) }}" height="200"
                                        width="200" alt="{{$post->title}}"></a>
                        </div>
                        <div class="posts-image-likes">{{ number_format($post->rating, 0) }} {{-- $post->up --}}{{-- $post->down --}}</div>
                        <div class="posts-info">
                            <div class="posts-title"><a
                                        href="{{ url('/', $post->id) }}">{{ str_limit($post->title, $limit = 80, $end = '...')}}  </a>
                            </div>
                            <div class="posts-sub-title">
                                <div class="posts-user lille"><time datetime="{{$post->created_at}}">{{$post->created_at->diffForHumans()}}</time>  &#187; <a
                                            href="{{ url('user/'.$post->name) }}"> {{$post->name}} </a>

                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach

                    <div style="float:left; clear:both; width:100%"><h1>{!! $comments->count() !!} comments have been reported </h1></div>
                        <div id="comments">
                            {{-- Get all comments on posts --}}
                            @foreach($comments as $comment)

                                {{-- Check if user is logged in and user is owner of comment --}}
                                {{-- If user is owner of comment - Highlight comment by giving it a css class --}}
                                <div class="post-comment  @if (Auth::check() && Auth::user()->name == $comment->user->name) comment-owner @endif"
                                     id="<?php echo sprintf("%07d", $comment->id) ?>">
                                    {{-- Else no css class--}}

                                    <div class="top-comment-meta">
                                        <small>
                                            <span class="comment-user">
                                                {{-- If comment user is the post author then display it as the OP of the page --}}
                                                <a class="post-user" href="{{ url('user/'.$comment->user->name) }}">{{ $comment->user->name }}</a>

                                                <span class="comment-time"><time datetime="{{$comment->created_at}}">{{$comment->created_at->diffForHumans()}}</time></span>

                                        </small>
                                        {{-- If user is owner of comment - Show delete button options --}}
                                            {!! Form::open([
                                            'method' => 'DELETE',
                                            'route' => ['comments.destroy', $comment->id],
                                             'class'=>'form-btn-inline'
                                            ]) !!}
                                            <button  rel="nofollow" style="float:right; font-size: 11pt; color:red"
                                                    onclick="return confirm('Are you sure you want to delete {{ $comment->text }} ?')"
                                                    type="submit" class="nobtn">Delete
                                            </button>
                                        {!! Form::close() !!}
                                        {!! Form::open([
'method' => 'DELETE',
'route' => ['DeleteCommentReports', $comment->id],
'class'=>'form-btn-inline',
]) !!}
                                        <button rel="nofollow" onclick="return confirm('Are you sure you want to delete?')"
                                                type="submit" class="nobtn big" style="color:#00AF00;float:right; margin-right: 10px ">Remove reports
                                        </button>
                                    </div>
                                    <div class="postCommentFiles">
                                        {{-- if comment got file attach --}}
                                        @if($comment->file)
                                            <img class="comment_image"
                                                 src="{{url ("i/".$comment->file.".".$comment->file_extension) }}"
                                                 style="display:none">
                                            <img src="{{url ("i/".$comment->file_thumb.".".$comment->file_extension) }}"/>
                                        @endif
                                    </div>
                                    {{-- find links in comments and give them a href="" --}}
                                    <div class="comment">
                                        @if($comment->parent_id)
                                            <span> <a class="replyID replying"
                                                      href="#<?php echo sprintf("%07d", $comment->parent_id) ?>"><?php echo sprintf("%07d", $comment->parent_id) ?></a> &#171;</span>
                                        @endif
                                        {!! preg_replace( "~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a target='_blank' href=\"\\0\">\\0</a>", nl2br($comment->text)) !!}


                                    </div> {{-- Linebreaks on comments --}}
                                </div>

                            @endforeach
                        </div>
                </div>

                </div>

    </section>
@endsection
