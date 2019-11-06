<!doctype html>
<html class="no-js" lang="">
<head>
    @include('includes.htmlHead')
</head>
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.3.min.js"><\/script>')</script>
{!! Html::script('js/jquery-ui.min.js')  !!}
{!! Html::script('js/noty/packaged/jquery.noty.packaged.min.js')  !!}
{!! Html::script('js/vendor/modernizr-2.8.3.min.js')  !!}
{!! Html::script('js/plugins.js')  !!}
{!! Html::script('js/main.js')  !!}

{!! Html::script('js/noty/themes/relax.js')  !!}
@if(Session::has('flash_message'))

@include('includes.notification_html')

<script type="text/javascript">
    function generate(type, text) {

        {{---  var n  = --}} noty({
            text        : text,
            type        : type,
            dismissQueue: true,
            layout      : 'bottomCenter',
            closeWith   : ['click'],
            theme       : 'relax',
            maxVisible  : 10,
            animation   : {
                open  : 'animated fadeIn',
                close : 'animated fadeOut',
                easing: 'swing',
                speed : 0
            }
        });
        {{--- console.log('html: ' + n.options.id); --}}
    }

    function generateAll() {
        @if(session('flash_message')[0] == 'warning')
        generate('warning', notification_html[0]);
        @endif
         @if(session('flash_message')[0] == 'error')
        generate('error', notification_html[1]);
        @endif

        @if(session('flash_message')[0] == 'info')
        generate('information', notification_html[2]);
        @endif
        @if(session('flash_message')[0] == 'success')
        generate('success', notification_html[3]);
        @endif
        @if(session('flash_message')[0] == 'delete')
        generate('delete', notification_html[4]);
        @endif
//            generate('notification');
//            generate('success');
    }

    $(document).ready(function () {

        setTimeout(function() {
            generateAll();
        }, 0);

    });

</script>

@endif
<!-- top nav -->

@include('includes.htmlFrontpageNavigation')

<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<!-- Add your site or application content here -->
@section('topBar')

    @yield('content')

@section('botBar')

@show




        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-53997756-1', 'auto');
    ga('send', 'pageview');

</script>
</body>
</html>
