<!doctype html>
<html lang="EN">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Marktplaats')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://kit.fontawesome.com/a7d26b2623.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script> --}}
    <script src="https://js.stripe.com/v3/"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="icon" href="/favicon.ico?v=2" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body>
    {{-- <main class="container mt-4"> --}}
    <div id="app">
        @include('navbars.main')
        {{-- @include('inc.navbar') --}}
        @yield('searchbar') {{-- with view, composerCategory@compose --}}
        @yield('content')
    </div>
    {{-- </main> --}}


    {{-- Success Alert --}}
    {{-- @if(session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{session('status')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
    @endif

    {{-- Error Alert --}}
    {{-- @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{session('error')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
    @endif --}}


</body>

<footer>
    @if(!request()->cookie('accepted'))
    <div class="container-fluid">
        <div class="alert alert-warning alert-dismissible fade show text-center fixed-bottom mx-auto my-0" role="alert">
            <strong>This site uses cookies to provide you with a great user experience. By using Trading Fields you accept our <a href="#" class="">use of cookies.</a></strong>
            <button type="button" class="close closecookie text-danger" data-dismiss="alert" aria-label="Close" style="right: auto;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    @endif
</footer>

</html>