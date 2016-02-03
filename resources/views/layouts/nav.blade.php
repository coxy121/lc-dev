<!-- Fixed navbar -->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">LC - Dev</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse pull-right">
            <ul class="nav navbar-nav">
                <li class="active"><a href="/">Home</a></li>
                <li><a href="#about">About</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Content <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/widget">Widgets</a></li>
                    </ul>
                </li>
                @if (Auth::check())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="/auth/facebook">
                                    <i class="fa fa-facebook"></i>&nbsp;&nbsp; Sync </a>
                            </li>
                            <li><a href="/auth/logout">Logout</a></li>
                        </ul>
                    </li>
                    <li><img class="circ" src="{{ Gravatar::get(Auth::user()->email)  }}"></li>
                @else

                    <li><img class="circ" src="{{ Gravatar::get('lee_cox@hotmail.co.uk') }}"></li>
                    <li><a href="/auth/login">Login</a></li>
                    <li><a href="/auth/register">Register</a></li>
                    <li>
                        <a href="/auth/facebook">
                            <i class="fa fa-facebook"></i>&nbsp;&nbsp; Sign in </a>
                    </li>
                @endif
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>