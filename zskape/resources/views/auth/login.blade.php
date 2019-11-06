@extends('layouts.master')
@section('content')
    <section class="container">
        <div id="contentMain" style="background: none; box-shadow: none;">
            <h1 style="text-align: center">Log in </h1>
        <div id="login-panel">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form role="form" method="POST" action="{{ url('/auth/login') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div>
                    <label>E-Mail Address</label>
                    <div>
                        <input type="email" class="form-l" required name="email" value="{{ old('email') }}">
                    </div>
                </div>

                <div>
                    <label>Password</label>

                    <div>
                        <input type="password" required class="form-l" name="password">
                    </div>
                </div>

                        <div style="margin-top:10px; margin-bottom:10px; float:left; width:100%;">
                                <input class="form-l" style="float: left;" type="checkbox" name="remember"> <span class="remember_me">
Remember me</span>
                        </div>

                    <div>
                        <button type="submit" class="btn btn-form-l special-btn">Login</button>
                    </div>
            </form>
            <div id="forgot-pw">
                <a rel="nofollow" href="{{ url('/password/email') }}">Did you forget your password?</a>
            </div>
        </div>
        </div>
    </section>
@endsection