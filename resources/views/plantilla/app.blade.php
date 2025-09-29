<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <!-- Title -->
    <title>@yield('titulo')</title>
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}" type="image/png">

    <!-- Animated css -->
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/bootstrap/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/overlay-scroll/OverlayScrollbars.min.css') }}">
    @yield('css')
    <style>
        .modal-backdrop.show {
            backdrop-filter: blur(20px);
            /* Ajusta el valor a tu gusto */
            background-color: rgba(105, 105, 105, 0.87);
            /* Mantiene un tono oscuro */
        }
    </style>
</head>

<body>

    <!-- Loading wrapper start -->
    <div id="loading-wrapper">
        <div class="spinner">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
            <div class="line4"></div>
            <div class="line5"></div>
            <div class="line6"></div>
        </div>
    </div>
    <!-- Loading wrapper end -->

    <!-- Page wrapper start -->
    <div class="page-wrapper">

        <!-- Sidebar wrapper start -->
        <nav class="sidebar-wrapper">

            <!-- Sidebar brand starts -->
            <div class="sidebar-brand">
                <a href="{{ route('dashboard') }}" class="logo">
                    <img src="{{ asset('assets/images/logo.png') }}" />
                </a>
            </div>
            <!-- Sidebar brand starts -->

            <!-- Sidebar menu starts -->
            <div class="sidebar-menu">
                <div class="sidebarMenuScroll">
                    <ul>
                        <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}" class="current-page">
                                <i class="bi bi-speedometer2"></i>
                                <span class="menu-text">Dashboard</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('clientes') ? 'active' : '' }}">
                            <a href="{{ route('clientes.index') }}" class="current-page">
                                <i class="bi bi-people"></i>
                                <span class="menu-text">Clientes</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('productos') ? 'active' : '' }}">
                            <a href="{{ route('productos.index') }}" class="current-page">
                                <i class="bi bi-box-seam"></i>
                                <span class="menu-text">Productos</span>
                            </a>
                        </li>

                        {{-- <li>
                            <a href="#">
                                <i class="bi bi-tools"></i>
                                <span class="menu-text">Servicios</span>
                            </a>
                        </li> --}}

                        <li class="sidebar-dropdown {{ request()->is('crear-cotizacion') ? 'active' : '' }}">
                            <a href="#">
                                <i class="bi bi-file-earmark-text"></i>
                                <span class="menu-text">Cotizaciones</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li class="{{ request()->is('crear-cotizacion') ? 'active' : '' }}">
                                        <a href="{{ route('cotizaciones.creando') }}" class="current-page">Crear
                                            Cotización</a>
                                    </li>
                                    <li>
                                        <a href="#">Lista de
                                            cotizaciones</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <hr>

                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="bi bi-gear"></i>
                                <span class="menu-text">Configuraciones</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li>
                                        <a href="#">Empresas</a>
                                    </li>
                                    <li>
                                        <a href="#">Usuarios</a>
                                    </li>
                                    <li>
                                        <a href="#">Perfil</a>
                                    </li>
                                </ul>
                            </div>
                        </li>


                    </ul>
                </div>
            </div>
            <!-- Sidebar menu ends -->

        </nav>

        <div class="main-container">

            <!-- Page header starts -->
            <div class="page-header">

                <!-- Toggle sidebar start -->
                <div class="toggle-sidebar" id="toggle-sidebar"><i class="bi bi-list"></i></div>
                <!-- Toggle sidebar end -->

                <!-- Logo sm starts -->
                <a href="{{ route('dashboard') }}" class="d-lg-none d-md-block">
                    <img src="{{ asset('assets/images/logo.png') }}" class="logo-sm" alt="Bootstrap Gallery">
                </a>
                <!-- Logo sm ends -->

                <!-- Breadcrumb start -->
                <ol class="breadcrumb d-lg-flex d-none">
                    <li class="breadcrumb-item">
                        <i class="bi bi-house"></i>
                        <a href="{{ route('dashboard') }}">Inicio</a>
                    </li>
                    <li class="breadcrumb-item breadcrumb-active" aria-current="page">@yield('titulo')</li>
                </ol>
                <!-- Breadcrumb end -->

                <!-- Header actions ccontainer start -->
                <div class="header-actions-container">
                    <!-- Header actions start -->
                    <ul class="header-actions">

                        <li class="dropdown">
                            <a href="#" id="userSettings" class="user-settings" data-toggle="dropdown"
                                aria-haspopup="true">
                                <span class="user-name d-none d-md-block"
                                    style="text-transform: capitalize">{{ Auth::user()->nombres }}</span>
                                <span class="avatar">
                                    <img src="{{ asset('assets/images/user3.png') }}" alt="Admin Templates">
                                    <span class="status online"></span>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userSettings">
                                <div class="header-profile-actions">
                                    <a href="#">Perfil</a>
                                    <a href="{{ route('salir') }}">Salir</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <!-- Header actions end -->

                </div>
                <!-- Header actions ccontainer end -->

            </div>
            <!-- Page header ends -->

            <!-- Content wrapper scroll start -->
            <div class="content-wrapper-scroll">
                @yield('contenido')
                <!-- fin del contenido -->

                <!-- App Footer start -->
                <div class="app-footer">
                    <span>© Desarrollado por Granada Store - CuscoDe - {{ date('Y') }}</span>
                </div>
                <!-- App footer end -->

            </div>
            <!-- Content wrapper scroll end -->

        </div>
    </div>

    <!-- js requeridos -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/modernizr.js') }}"></script>
    <script src="{{ asset('assets/js/moment.js') }}"></script>



    <!-- Overlay Scroll JS -->
    <script src="{{ asset('assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/overlay-scroll/custom-scrollbar.js') }}"></script>

    <!-- Main Js Required -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('js')

    @if ($mostrarModalEmpresa)
        <div class="modal fade show" id="modalEmpresa" tabindex="-1" aria-hidden="true"
            style="display:block; background:rgba(0,0,0,0.5)">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Selecciona tu empresa</h5>
                    </div>
                    <div class="modal-body">
                        <form id="formSeleccionEmpresa" action="{{ route('guardar.empresa') }}" method="POST">
                            @csrf
                            <select class="form-control" name="empresa_id" required>
                                <option value="">-- Selecciona una empresa --</option>
                                @foreach ($empresas as $empresa)
                                    <option value="{{ $empresa->id }}">{{ $empresa->nombre_comercial }}</option>
                                @endforeach
                            </select>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif




</body>

</html>
