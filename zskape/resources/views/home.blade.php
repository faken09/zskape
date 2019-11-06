@extends('layouts.master')

@section('title', $user->name .' - zskape')

@section('content')
    <section class="container">
        <div id="contentMain">
            <div id="topContentDivider" style="margin-bottom: 20px">

                @if (Auth::check() && Auth::user()->name == $user->name)
                    <h1>
                        {{"Welcome to your page ". $user->name}} <br /><small> See your lastest upload here</small><br />
                        @if($user->points >= 0)
                            <span class="points">{{$user->points }} points </span>
                        @else
                            <span class="points downvotes">{{$user->points }} points </span>
                        @endif

                    </h1>
                @else
                    <h1>
                        {{$user->name}} <br />
                        @if($user->points >= 0)
                            <span class="points">{{$user->points }} points </span>
                        @else
                            <span class="points downvotes">{{$user->points }} points </span>
                        @endif
                    </h1>
                @endif
            </div>
            <?php  $count = 0; ?>
            @foreach ($posts as $post)
                <?php  $count++; ?>
                <?php if ($count % 5 == 0) { ?>
                <div id="{{ $post->id }}" class="posts posts-last-on-row">
                    <?php } else { ?>
                    <div id="{{ $post->id }}" class="posts">
                        <?php } ?>
                            @if (Auth::check() && Auth::user()->name == $user->name)
                            {!! Form::open([
'method' => 'DELETE',
'route' => ['posts.destroy', $post->id],
'class'=>'form-btn-inline',
]) !!}
                            <button rel="nofollow" onclick="return confirm('Are you sure you want to delete?')"
                                    type="submit" class="nobtn big" style="color:red">Delete
                            </button>
                            {!! Form::close() !!}
                            @endif
                        <div class="posts-image"><a href="{{ url('/', $post->id) }}"><img
                                        src="{{url ("i/".$post->file_thumb.".".$post->file_extension) }}"
                                        alt="{{$post->title}}"></a>
                        </div>
                        <div class="posts-image-likes">{{ number_format($post->points, 0) }}</div>
                        <div class="posts-info">
                            <div class="posts-title"><a href="{{ url('/', $post->id) }}">{{ $post->title }}</a></div>
                            <div class="posts-sub-title">
                                <div class="posts-user lille">by <a href="#"> {{$post->user->name}} </a>
                                    &#187; <time datetime="{{$post->created_at}}">{{$post->created_at->diffForHumans()}}</time></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
    </section>
@endsection
@section('botBar')
    @parent
    <div id="contentDivider">
        <div id="pagesNavigation">
            {{-- Remove slash from url link & render more pages link if there is more --}}
            {!! str_replace('/?', '?', $posts->render()) !!}
        </div>
    </div>
@endsection
