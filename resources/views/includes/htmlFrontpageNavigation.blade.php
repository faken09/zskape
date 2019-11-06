<header id="topHeader">
    <nav id="navigation">
        <ul class="navLeft">
            <li id="navLogo">
                <a href="{{ url('/') }}">zskape</a>
            </li>
            <li>
                <a href="{{ url('transfer/upload') }}" {{ (Request::is('transfer/upload') ? 'class=activeNav' : '') }}><span class="navLink">Upload</span></a>
            </li>
            <li>
                {!! Form::open([
            'method' => 'GET',
            'route' => ['posts.search']
            ]) !!}
                {!! Form::text('search', null, ['id' => 'form-search-post', 'class' => 'form-l', 'required',  'placeholder' => 'Search']) !!}
                {!! Form::close() !!}
            </li>
        </ul>
        <ul class="navRight">
            @if (Auth::guest())
                <li>
                    <a href="{{ url('auth/login') }}" {{ (Request::is('auth/login') ? 'class=activeNav' : '') }}><span class="navLink">Log in</span></a>
                </li>
                <li>
                    <a href="{{ url('auth/register') }}" {{ (Request::is('auth/register') ? 'class=activeNav' : '') }}><span class="navLink">Sign up</span></a>
                </li>

            @endif
            @if (Auth::check())
                    @if(Auth::user()->role == 1)
                    <li>
                        <a href="{{ url('admin/panel') }}" {{ (Request::is('admin/panel') ? 'class=activeNav' : '') }}><span class="navLink">Adminpanel</span></a>
                    </li>
                    @endif
                <li>
                    <a href="{{ url('user/'.Auth::user()->name) }}" {{ (Request::is('user/'.Auth::user()->name) ? 'class=activeNav' : '') }}><span class="navLink">{{ Auth::user()->name }}</span></a>
                </li>
                <li>


                    <a href="{{ url('/auth/logout') }}" ><span class="navLink">Log out</span></a>
                </li>
            @endif
        </ul>
    </nav>
</header>
