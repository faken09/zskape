@extends('layouts.master')

@section('title', 'zskape')

@section('content')
    <section class="container">
        <div id="contentMain">
            @if(isset($search))
                @if($posts->count() == 0)
                    <a href="{{ URL::previous() }}">Go Back</a>
                <p>search found no results</p>
                @else
               <p> search found {{$posts->count()}}  @if($posts->count() > 1)  results  @else  result @endif for {{$search}}</p>
                    @endif
            @endif
            <?php  $count = 0; ?>


            @foreach ($posts as $post)
                <?php  $count++; ?>
                <?php if ($count % 5 == 0) { ?>
                <div id="{{ $post->id }}" class="posts posts-last-on-row">
                    <?php } else { ?>
                    <div id="{{ $post->id }}" class="posts">
                        <?php } ?>
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
                                <div class="posts-user lille"><time title="" datetime="{{$post->created_at}}">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->created_at)->diffForHumans() }}</time>  &#187; <a
                                            href="{{ url('user/'.$post->name) }}"> {{$post->name}} </a>

                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach


                </div>

    </section>
@endsection
@if(!isset($search))
@section('botBar')
    @parent
    <div id="contentDivider">
        <div id="pagesNavigation">
            {{-- Remove slash from url link & render more pages link if there is more --}}
            {!! str_replace('/?', '?', $posts->render()) !!}
        </div>
    </div>
@endsection
@endif