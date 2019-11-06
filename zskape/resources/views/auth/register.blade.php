@extends('layouts.master')
@section('content')
        <section class="container">
            <div id="contentMain" style="box-shadow: none;">
                <h1 style="text-align: center">Sign up</h1>
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

                <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div>
                        <label>Username</label>

                        <div>
                            <input type="text" required class="form-l" name="name" value="{{ old('name') }}">
                        </div>
                    </div>

                    <div>
                        <label>E-Mail Address</label>

                        <div>
                            <input type="email" required  class="form-l" name="email" value="{{ old('email') }}">
                        </div>
                    </div>

                    <div>
                        <label>Password</label>

                        <div>
                            <input type="password" required  class="form-l" name="password">
                        </div>
                    </div>

                    <div>
                        <label>Confirm Password</label>
                        <div>
                            <input type="password" required  class="form-l" name="password_confirmation">
                        </div>
                    </div>

                    <div style="margin-top:10px">
                        <div>
                            <button type="submit" class="btn btn-form-l special-btn">
                                Register
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection