<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm mb-2 fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Marktplaats') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            {{-- <ul class="navbar-nav mr-auto">
            </ul> --}}

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto d-md-flex align-items-center">
                <!-- Authentication Links -->
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif
                @else
                <li class="nav-item d-none d-md-block horizontal">
                    <div class="text-center">{{ __('Hello') }}</div>

                </li>
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        @adman
                        <a class="dropdown-item" href="{{ route('adverts.create') }}">{{ __('New Advert') }}</a>
                        <a class="dropdown-item" href="{{ route('adverts.index') }}">{{ __('Manage Adverts') }}</a>
                        <div class="dropdown-divider"></div>
                        @endadman
                        @admin
                        <a class="dropdown-item" href="#">{{ __('Admin Dashboard') }}</a>
                        <div class="dropdown-divider"></div>
                        @endadmin
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                <li class="nav-item ml-md-4">
                    @adman
                    {{ __('(Advertiser)') }}
                    @endadman
                    @admin
                    {{ __('(Administrator)') }}
                    @endadmin
                    @visitor
                    {{ __('(Visitor)') }}
                    @endvisitor
                </li>
                @endguest
            </ul>
        </div>  {{-- Navbar-Collapse --}}
    </div>  {{-- Container --}}
</nav>