<html>

<head>
    <title>{{ config('app.name') }} - @yield('title')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js"
            integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous">
    </script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js"
            integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous">
    </script>

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
            border-width: 0!important;
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
    </style>
</head>

<body>
@section('sidebar')

@show

<main class="site-main">
    <header class="site-header">
        <h1 class="site-header__title">{{ config('app.name') }}</h1>
    </header>
    <nav class="site-navbar">
        @include('elements.menu')
    </nav>
    <div class="site-content">
        @yield('content')
    </div>
</main>
</body>

</html>
