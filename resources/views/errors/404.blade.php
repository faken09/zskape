@extends('layouts.master')

@section('title', '404 page not found | zskape')

@section('content')

    <section class="container">
        <div id="contentMain" style="outline: none">
            <div id="login-panel" style="border: none;outline: none;box-shadow: none">
            <h1 style="text-align: center">404 <br />Not Found</h1>
            <p style="text-align: center">The requested page does not exist! <br/> The page have been removed or does not exists. <br /><br /> Our team is working hard to find it!</p>
            </div>
            {!! Html::image('img/404.jpg', '404', array('style' => 'display:block; margin:0 auto;')) !!}
        </div>
    </section>

@endsection