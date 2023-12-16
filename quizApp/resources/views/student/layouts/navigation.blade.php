<style type="text/css">
        body {
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8f9fa;
    }

    .navbar {
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .navbar-brand {
        color: #333;
        font-weight: bold;
        text-decoration: none;
    }

    .navbar-toggler-icon {
        background-color: #333;
    }

    .navbar-nav {
        display: flex;
        align-items: center;
        justify-content: center;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .nav-item {
        margin-left: 15px;
    }

    .nav-link {
        color: #333;
        font-weight: bold;
        text-decoration: none;
        transition: color 0.3s;
    }

    .nav-link:hover {
        color: #007bff;
    }

    .dropdown-menu {
        background-color: #fff;
        border: 1px solid #e0e0e0;
    }

    .dropdown-item {
        color: #333;
        text-decoration: none;
    }

    .dropdown-item:hover {
        background-color: #007bff;
        color: #fff;
    }    
</style>
<nav class="bg-white shadow-sm navbar navbar-expand-md navbar-light">

    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
           <b>Quiz Application</b> 
        </a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="mr-auto navbar-nav">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="ml-auto navbar-nav">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
