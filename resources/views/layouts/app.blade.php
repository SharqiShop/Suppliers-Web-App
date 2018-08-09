<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sharqi</title>

    <!-- Fonts -->
    {{--<link rel="stylesheet" href="https://colorlib.com/polygon/build/css/custom.min.css">--}}

    <link rel="stylesheet" href="{{ URL::asset('assets/css/min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>


    {{--<script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>--}}
    {{--<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>--}}
    {{--<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/3/css/bootstrap.css" />--}}

    {{--<!-- Include Date Range Picker -->--}}
    {{--<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>--}}

    {{--<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />--}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.css" />




    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Sharqi
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->

                @if (Auth::user())
                    @if ((Auth::user()->role == 1) || (Auth::user()->role == 3) ) <!-- ADMIN ROLE-->
                        <ul class="nav navbar-nav">
                            @if ((Auth::user()->role == 1))
                                 <li><a href="{{ url('/') }}">Suppliers</a></li>
                            @endif

                            <li class="dropdown">
                                {{--<li class="dropdown">--}}
                                {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">--}}
                                <a href="/accounting/cost" >
                                    Accounting <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" style="left:unset; right: unset;">
                                    <li><a href="/accounting/cost">Products Cost</a></li>
                                    <li><a href="/accounting/trans">Transactions</a></li>
                                    <li><a href="/accounting/summary">Summary</a></li>

                                </ul>
                            </li>

                        </ul>
                        @if ((Auth::user()->role == 1))
                            <ul class="nav navbar-nav">
                                <li><a href="{{ url('/onhold') }}">OnHold</a></li>
                            </ul>
                        @endif
                    @endif

                    @if (Auth::user()->role == 3)
                    <ul class="nav navbar-nav">
                        <li><a href="{{ url('/orders') }}">Orders</a></li>
                    </ul>
                    @endif

                        @if (Auth::user()->role < 2)
                    <ul class="nav navbar-nav">
                        <li><a href="{{ url('/orders') }}">Orders</a></li>
                    </ul>
                        @endif
                        @if (Auth::user()->role < 2)
                    <ul class="nav navbar-nav">
                        <li><a href="{{ url('/stock') }}">Stock</a></li>
                    </ul>
                            @endif
                @endif

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        {{--<li><a href="{{ url('/register') }}">Register</a></li>--}}
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- JavaScripts -->

    <script>
        jQuery('ul.nav li.dropdown').hover(function() {
            jQuery(this).find('.dropdown-menu').stop(true, true).delay(50).fadeIn();
        }, function() {
            jQuery(this).find('.dropdown-menu').stop(true, true).delay(50).fadeOut();
        });
    </script>

    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
