<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Nest Dashboard</title>
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <meta name="description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta property="og:title" content="" />
        <meta property="og:type" content="" />
        <meta property="og:url" content="" />
        <meta property="og:image" content="" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- Favicon -->
        <!-- <link rel="shortcut icon" type="image/x-icon" href="{{ asset('imgs/theme/favicon.svg') }}" /> -->
        <!-- Template CSS -->
        <!-- <link href="{{ asset('css/main.css?v=1.0') }}" rel="stylesheet" type="text/css" /> -->
    </head>

    <body id="app">
        <div class="screen-overlay"></div>
        <aside class="navbar-aside" id="offcanvas_aside">
            <div class="aside-top">
                <a href="index.html" class="brand-wrap">
                    <img src="{{ asset('imgs/theme/favicon.svg') }}" class="logo" alt="Nest Dashboard" />
                </a>
                <div>
                    <button class="btn btn-icon btn-aside-minimize"><i class="text-muted material-icons md-menu_open"></i></button>
                </div>
            </div>
            <nav>
                @include('layout.dashboard.menu.nav')
            </nav>
        </aside>
        <main class="main-wrap">
            <header class="main-header navbar">
                @include('layout.dashboard.menu.header')
            </header>
            
            <section class="content-main">

                <router-view></router-view>
                
            </section>
            <!-- content-main end// -->
            <!-- <footer class="main-footer font-xs">
                <div class="row pb-30 pt-15">
                    <div class="col-sm-6">
                        <script>
                            document.write(new Date().getFullYear());
                        </script>
                        ©, Nest - HTML Ecommerce Template .
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end">All rights reserved</div>
                    </div>
                </div>
            </footer> -->
        </main>
        <!-- <script src="{{ asset('js/vendors/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('js/vendors/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/vendors/select2.min.js') }}"></script>
        <script src="{{ asset('js/vendors/perfect-scrollbar.js') }}"></script>
        <script src="{{ asset('js/vendors/jquery.fullscreen.min.js') }}"></script>
        <script src="{{ asset('js/vendors/chart.js') }}"></script> -->
        <!-- Main Script -->
        <!-- <script src="{{ asset('js/main.js?v=1.0') }}" type="text/javascript"></script>
        <script src="{{ asset('js/custom-chart.js') }}" type="text/javascript"></script> -->
    </body>
</html>
