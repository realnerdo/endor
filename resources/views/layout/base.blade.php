<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>@yield('title')</title>
        {{ Html::style('css/app.css') }}
    </head>
    <body>

    @if (Auth::check())
        @include('layout.sidebar')

        <main class="main">
            @if (session()->has('flash_message'))
                <div class="notification">
                    <span><i class="typcn typcn-coffee"></i> {{ session()->get('flash_message') }}</span>
                    <button class="close-notification"><i class="typcn typcn-delete-outline"></i></button>
                </div>
                <!-- /.notification -->
            @endif
            <div class="row">
                <div class="col-12">
                    <h1 class="section-title">
                        @yield('sectionTitle')
                        @yield('add')
                    </h1>
                    <!-- /.section-title -->
                </div>
                <!-- /.col-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <section class="panel">
                    @yield('content')
                </section>
                <!-- /.panel -->
            </div>
            <!-- /.row -->
        </main>
        <!-- /.main -->

        @yield('modal')
    @else
        @yield('auth')
    @endif

    @if ( Config::get('app.debug') )
        <script type="text/javascript">
            document.write('<script src="//cotizador.dev:35729/livereload.js?snipver=1" type="text/javascript"><\/script>')
        </script>
    @endif

    {{ Html::script('js/app.js') }}
    </body>
</html>
