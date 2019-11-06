@extends('layouts.master')

@section('title', 'Upload and share - zskape')

@section('content')
    <section class="container">
        <div id="contentMain">
            <h1>Upload and share<br /><small>Create a post by uploading a image with a title</small></h1>
            {!! Form::open([
                'method' => 'POST',
                'route' => 'posts.store',
                'files'=> true
            ]) !!}
            {!! Form::file('file', array('class' => 'formText', 'required', 'style' => 'margin-bottom:10px; font-size:17px;')) !!}
            <?php // using partials so we reuse the form for create and update ?>
            {{-- Display characters count on form --}}
            @include('posts.form', ['submitButton' => 'Upload'])
            {!! Form::close() !!}
            {{-- Jquery onkeyup count charaters and display how many charecaters left --}}
            <script>
                document.getElementById('characters-count').innerHTML = 300;
                document.getElementById('form-character-limit').onkeyup = function () {
                    document.getElementById('characters-count').innerHTML = 300 - this.value.length;
                };
            </script>
            @include ('errors.list')   {{-- Request error messages--}}


        </div>
    </section>
@endsection