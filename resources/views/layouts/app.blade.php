<html>

<head>
    <title>
        @hasSection('title')
            @yield('title') | {{ config('app.name') }}
        @else
            {{ config('app.name') }}
        @endif
    </title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <!-- Font Awesome JS -->
    <script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" data-auto-replace-svg="nest"></script>

    <style>
        .site-header {
            background-color: #333;
            padding: 16px;
        }

        .site-header__title {
            color: #fff;
            font-size: 24px;
            margin-bottom: 0;
        }

        .site-header__link {
            color: #fff;
        }

        .site-header__link:hover {
            color: #fff;
        }

        .site-navbar {
            float: left;
            width: 100%;
            max-width: 260px;
            padding-top: 16px;
            padding-left: 16px;
            padding-right: 8px;
        }

        .site-content {
            float: left;
            width: calc(100% - 260px);
            padding-top: 16px;
            padding-left: 8px;
            padding-right: 16px;
        }

        .subtechnique {
            border-width: 0 !important;
        }

        .subtechnique td:first-child {
            padding: 10px;
            border-top: none;
            border-width: 0 0;
        }

        a {
            text-decoration: none;
            color: #3742dc;
        }

        .site-footer {
            margin-top: 24px;
            background-color: #f7f7f7;
            display: flex;
            align-items: center;
            padding: 16px;
        }

        .site-footer__copy {
            margin-bottom: 0;
        }

        .site-footer::before, .site-footer::after {
            content: " ";
            display: table;
            clear: both;
        }

        .site-footer__copy-icon {
            font-size: 18px;
            position: relative;
            top: 1px;
            margin-right: 3px;
        }

        .site-footer__link {
            color: #4a5568;
        }

        .input-group-append .btn {
            height: 38px;
            -webkit-border-radius: 0 8px 8px 0;
            -moz-border-radius: 0 8px 8px 0;
            border-radius: 0 8px 8px 0;
            color: #fff;
        }
    </style>
</head>

<body>
@section('sidebar')

@show

<header class="site-header d-flex align-items-center justify-content-between">
    <h1 class="site-header__title">
        <a href="/" class="site-header__link">{{ config('app.name') }}</a>
    </h1>

    @include('elements.search')
</header>
<main class="site-main clearfix">
    <nav class="site-navbar">
        @include('elements.menu')
    </nav>
    <div class="site-content">
        @yield('content')
    </div>
</main>
<footer class="site-footer">
    <p class="site-footer__copy">
        <a class="site-footer__link" target="_blank" href="{{ config('app.owner_url') }}"><i
                class="fab fa-github [ site-footer__copy-icon ]"></i> Websteam</a>
    </p>
</footer>
</body>

</html>
