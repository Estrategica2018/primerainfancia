<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Estratégica') }}</title>

<!-- Scripts
    <script src="{{ asset('js/app.js') }}" defer></script>
    -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <!--
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css" rel="stylesheet"
          type="text/css">


    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">


    <!-- Styles

     -->
    <script src="https://code.jquery.com/jquery-3.3.1.js" type="text/javascript"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
            crossorigin="anonymous"></script>


    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"
            type="text/javascript"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"
            type="text/javascript"></script>

    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js" type="text/javascript"></script>

</head>
<style>
    /*
    .py-4 {
        padding-top: 0.5rem!important;
    }
    .footer {
        position: relative;
        margin-top: -150px;
        height: 150px;
        clear:both;
        padding-top:20px;
    }
    body{
        font-size: x-small;
        font-weight: 400;
    }
    .btn-group-sm>.btn, .btn-sm {
        padding: .23rem .5rem;
        font-size: .700rem;
        line-height: 0.8;
        border-radius: .2rem;
    }
    .table td, .table th {
        padding: .5rem;
        vertical-align: baseline;
        border-top: 0.7px solid #dee2e6;
    }
    .form-control {

        font-size: 0.7rem;
        font-weight: 400;
    }
*/
</style>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container" style="display: contents;">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{url('imagenes/logo_biblioamigos.png')}}"
                     alt="Estratégica Comunicaciones"
                     data-retina="https://www.estrategicacomunicaciones.com/wp-content/uploads/2016/01/logo-estrategica-grand.png"
                     data-retina_w="759" data-retina_h="239" style="height: 150px;">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->

                <ul class="navbar-nav ml-auto">
                    <h3 style="color: #146BC9; font-family: Helvetica; font-weight:700"
                    >Herramienta de selección y priorización para la conformación de colecciones según metodología MinCultura</h3>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Salir') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <main class="py-4">
        @guest
        @else
            <div class="container-fluid">
                <nav class=" navbar navbar-dark bg-primary navbar-expand-lg">
                    <!-- Navbar content -->
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav ">
                            @if(\Illuminate\Support\Facades\Auth::user()->hasAnyRole(['administrador_plataforma']))
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Administrador
                                    </a>
                                    <div class="dropdown-menu bg-primary" aria-labelledby="navbarDropdown">
                                        <a class="nav-link" href="{{route('administrador')}}">Gestión usuarios</a>
                                        <a class="nav-link" href="{{route('administrador_priorizacion')}}">Gestión
                                            priorización</a>
                                    </div>
                                </li>
                            @endif
                            @if(\Illuminate\Support\Facades\Auth::user()->hasAnyRole(['administrador_plataforma','ministerio']))
                                <li class="nav-item {{ (request()->is('home','/')) ? 'active' : '' }}">
                                    <a class="nav-link" href="{{route('home')}}">Preselección <span class="sr-only">(current)</span></a>
                                </li>
                            @endif
                            @if(\Illuminate\Support\Facades\Auth::user()->hasAnyRole(['administrador_plataforma','comite_educativo']))
                                <li class="nav-item {{ (request()->is('comite')) ? 'active' : '' }}">
                                    <a class="nav-link" href="{{route('comite')}}">Comite Editorial</a>
                                </li>
                            @endif
                            @if(\Illuminate\Support\Facades\Auth::user()->hasAnyRole(['administrador_plataforma','usuario']))
                                <li class="nav-item {{ (request()->is('priorizacion')) ? 'active' : '' }}">
                                    <a class="nav-link" href="{{route('priorizacion')}}">Priorización</a>
                                </li>
                            @endif
                            @if(\Illuminate\Support\Facades\Auth::user()->hasAnyRole(['administrador_plataforma']))
                                <li class="nav-item {{ (request()->is('priorizacion_resultado')) ? 'active' : '' }}">
                                    <a class="nav-link" href="{{route('priorizacion_resultado')}}">Resultado
                                        priorización </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </nav>
            </div>
        @endguest
        @yield('content')
    </main>
</div>
@yield('javascript')

<br>
<footer class="bd-footer text-muted bg-primary text-white-50 container-fluid" style="max-width: 98%;">
    <div class=" text-center">
        <div>
            <img class="mt-2" src="{{url('/imagenes/logo.png')}}" data-retina_w="759" data-retina_h="239" style="height: 30px;">
        </div>
        <div class="">
            <a class="navbar-brand" href="https://www.estrategicacomunicaciones.com">

                <small style="color: white">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Copyright © Estratégica Comunicaciones
                    https://www.estrategicacomunicaciones.com
                </small>
            </a>
        </div>
        <div class="mt-2"></div>
    </div>
</footer>
</body>

</html>
