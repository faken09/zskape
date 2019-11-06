@extends('layouts.master')
@section('title', $post->title.' - zskape' )
@section('content')

    <section class="container">
        <div id="contentMain">
            <div class="contentRight">
                @foreach($posts as $p)
                    <div id="{{ $p->id }}" class="posts post-thumbnail">
                        <div class="posts-image"><a href="{{ url('/', $p->id) }}"><img
                                        src="{{url ("i/".$p->file_thumb.".".$p->file_extension) }}" height="200"
                                        width="200" alt="{{$p->title}}"></a>
                        </div>
                        <div class="posts-image-likes">{{ number_format($p->rating, 0) }} {{-- $post->up --}}{{-- $post->down --}}</div>
                        <div class="posts-info">
                            <div class="posts-title"><a
                                        href="{{ url('/', $p->id) }}">{{ str_limit($p->title, $limit = 50, $end = '...')}}  </a>
                            </div>
                            <div class="posts-sub-title">
                                <div class="posts-user lille"><time datetime="{{$p->created_at}}">{{$p->created_at->diffForHumans()}}</time>
                                    &#187; <a
                                            href="{{ url('user/'.$p->user->name) }}"> {{$p->user->name}} </a>

                                </div>
                            </div>
                        </div>

                    </div>

                @endforeach

            </div>
            <div class="contentLeft">
                <div id="{{ $post->id }}" class="post">
                    <div id="post-score">
                        <span class="points">{{ $post->rating }} points </span>
                        <a class="post-user"
                           href="{{ url('user/'.$post->user->name) }}">{{$post->user->name}}</a> <time datetime="{{$post->created_at}}">{{$post->created_at->diffForHumans()}}</time>
                        <span class="post-user-options">

                            @if($isReported == 'false')
                                {!! Form::open([
                                      'method' => 'POST',
                                      'route' => ['posts.report', $post->id],
                                      'class'=>'form-btn-inline'
                                  ]) !!}
                                <button rel="nofollow" onclick="return confirm('Are you sure you want to report?')"
                                        type="submit" class="nobtn">report
                                </button>
                                {!! Form::close() !!}
                            @else
                                <p class="nobtn important">you have reported this post</p>
                            @endif
                    </span>
                    </div>
                    <div id="post-page-content">

                        <span><img id="image" src="{{url ("i/".$post->id.".".$post->file_extension) }}"></span>

                        <div id="post-page-title">
                            <h1>{{$post->title}}</h1>
                        </div>


                        {{-- Check if post is rated by user --}}
                        @if($isRated !== 0 && $isRated !== 1) {{-- if post is not then display vote options--}}
                        <div class="vote-container">

                            {{-- Upvote --}}
                            {!! Form::open([
                                'method' => 'POST',
                                'route' => ['postsRatings.store', $post->id],
                                'class' => 'vote-form'
                                ]) !!}
                            {!! Form::submit('Upvote', ['class' => 'btn btn-upvote', 'rel' => 'nofollow']) !!}
                            {!!  Form::hidden('vote', '1') !!}
                            {!! Form::close() !!}

                            {{-- Downvote --}}
                            {!! Form::open([
                                'method' => 'POST',
                                'route' => ['postsRatings.store', $post->id],
                                'class' => 'vote-form'
                                ]) !!}
                            {!! Form::submit('Downvote', ['class' => 'btn btn-downvote', 'rel' => 'nofollow']) !!}
                            {!!  Form::hidden('vote', '0') !!}
                            {!! Form::close() !!}
                        </div>
                        @elseif($isRated == 1) {{-- if post is then display what was voted --}}
                        <div class="vote-container" id="isVoted">
                            <button class="btn btn-active-upvote">Upvoted</button>
                            <button class="btn btn-downvote btn-disable">Downvote</button>
                        </div>
                        @else($isRated == 0) {{-- if post is then display what was voted --}}
                        <div class="vote-container" id="isVoted">
                            <button class="btn btn-upvote btn-disable">Upvote</button>
                            <button class="btn btn-active-downvote">Downvoted</button>
                        </div>

                        @endif

                    </div>
                </div>
            </div>
            <div class="contentLeft">
                <hr>
                {{-- Display characters count on form --}}
                <div id="characters-count"></div>

                {{-- If user logged in then display post comment form--}}
                {!! Form::open([
                'method' => 'POST',
                'route' => ['comments.store', $post->id],
                'files' => true
                ]) !!}
                {!! Form::file('file', array('class' => 'formText', 'style' => 'margin-bottom:10px;', )) !!}
                {!! Form::textarea('text', null, ['class' => 'form-comment-post', 'id' => 'form-character-limit', 'required',  'placeholder' => 'Write a comment']) !!}
                {!! Form::submit('Comment', ['class' => 'btn special-btn btn-normal', 'style' => 'font-size:11px', 'rel' => 'nofollow']) !!}
                {!! Form::close() !!}


                {{-- Jquery onkeyup count charaters and display how many charecaters left --}}
                <script>
                    document.getElementById('characters-count').innerHTML = 1000;
                    document.getElementById('form-character-limit').onkeyup = function () {
                        document.getElementById('characters-count').innerHTML = 1000 - this.value.length;
                    };
                </script>
                {{-- Error list when deleting / posting new item to db --}}
                @include ('errors.list')

                <div id="comments">
                    <div id="post-comment-header"><p><span class="comments-count">{!! $post->comments->count() !!}
                                Comments </span></p></div>
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
                                                @if($post->user->name == $comment->user->name)
                                                    <span class="comment-op">OP
                                                     @endif <a class="post-user"
                                                               href="{{ url('user/'.$comment->user->name) }}">{{ $comment->user->name }}</a>

                                                <span class="comment-time"><time datetime="{{$comment->created_at}}">{{$comment->created_at->diffForHumans()}}</time></span>
                                                        @if($comment->replies->count())

                                                            @foreach($comment->replies as $replyComments)
                                                                <span>&#187;<a class="replyID"
                                                                               href="#<?php echo sprintf("%07d", $replyComments->id) ?>">{{$replyComments->user->name}}</a></span>
                                                            @endforeach

                                    @endif

                                </small>
                                @if($comment->active == 1)
                                {{-- If user is owner of comment - Show delete button options --}}
                                @if (Auth::check() && Auth::user()->name == $comment->user->name)
                                    {!! Form::open([
                                    'method' => 'DELETE',
                                    'route' => ['comments.destroy', $comment->id],
                                     'class'=>'form-btn-inline'
                                    ]) !!}
                                    <button rel="nofollow" style="float:right"
                                            onclick="return confirm('Are you sure you want to delete {{ $comment->text }} ?')"
                                            type="submit" class="nobtn nobtn-small">delete
                                    </button>
                                    {!! Form::close() !!}
                                @else
                                    {{--  else Show report button options --}}
                                    {!! Form::open([
                                             'method' => 'POST',
                                             'route' => ['comments.report', $comment->id],
                                             'class'=>'form-btn-inline'
                                            ]) !!}
                                    <button rel="nofollow" style="float:right"
                                            onclick="return confirm('Are you sure you want to report?')"
                                            type="submit" class="nobtn nobtn-small">
                                        report
                                    </button>
                                    {!! Form::close() !!}
                                @endif
                                    @endif
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
                                @if($comment->active == 0)
                                      <span class="comment-deleted">  {{ $comment->text }}</span>
                                    @else
                                {!! preg_replace( "~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~","<a target='_blank' href=\"\\0\">\\0</a>", nl2br($comment->text)) !!}
                                    @endif

                                <a class="reply-comment" id="{{$comment->id}}" href="#">[reply]</a>

                                <div class="reply-comment-form well">
                                    {!! Form::open([
                                    'method' => 'POST',
                                    'route' => ['comments.store', $post->id],
                                    'files' => true,
                                     'name' => 'reply-form',
                                     'id' => 'reply-form',
                                    ]) !!}
                                    {!! Form::file('file', array('class' => 'formText', 'style' => 'margin-bottom:10px;', )) !!}
                                    {!! Form::hidden('reply', $comment->id) !!}
                                    {!! Form::textarea('text', null, ['class' => 'form-comment-post', 'id' => 'form-character-limit', 'required',  'placeholder' => 'Write a comment']) !!}
                                    {!! Form::submit('Reply', ['class' => 'btn special-btn btn-normal', 'style' => 'font-size:11px;', 'rel' => 'nofollow']) !!}
                                    {!! Form::close() !!}
                                </div>

                            </div> {{-- Linebreaks on comments --}}
                        </div>

                    @endforeach
                </div>
            </div>

        </div>
        </div>
    </section>

    <script>
        // replace reply id with reply name
        $(document).ready(function () {
            // Make loop of each reply
            $(".replying").each(function () {
                // get the attr href with the parent id of the comment they are replying to
                var href = $(this).attr('href');
                // remove hastag from the href (parent_id) eg #000233 -> 000233
                var replyID = href.substring(1, href.length);
                // Find the comment with the parent id and get the username
                var replyName = $('#' + replyID + '.post-comment').find('.post-user').text();
                // replace parent id with the parent id username
                $(this).html(replyName);
            });


            // Hover highlight reply comment
            $('a[href^="#"]').hover(function (e) {
                // target element id
                var id = $(this).attr('href');

                // target element
                var $id = $(id);
                if ($id.length === 0) {
                    return;
                }
                // prevent standard hash navigation (avoid blinking in IE)
                e.preventDefault();


                $(id).stop().css("background-color", "#FFFF9C")
                        .animate({backgroundColor: "#FFFFFF"}, 3000);

            });


        });

        // Click replyID go to the reply comment on page
        // handle links with @href started with '#' only
        $(document).on('click', 'a[href^="#"]', function (e) {
            // target element id
            var id = $(this).attr('href');

            // target element
            var $id = $(id);
            if ($id.length === 0) {
                return;
            }
            // prevent standard hash navigation (avoid blinking in IE)
            e.preventDefault();
            // top position relative to the document
            var pos = $(id).offset().top;
            // animated top scrolling
            $('body, html').animate({scrollTop: pos});

        });

        $(function () {
            $('.reply-comment').on('click', function (e) {
                e.preventDefault();
                $(this).next('.reply-comment-form').toggle();
            });
        });


        $(document).ready(function () {
            $('.postCommentFiles').on('click', function () {
                $(this).find('img').toggle();
            });
        });
        {{-- full size image on click --}}
        $(document).ready(function () {
            $('#image').on('click', function () {
                $(this).toggleClass('full');
            });
        });
    </script>
@endsection
