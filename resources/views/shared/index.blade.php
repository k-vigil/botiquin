<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Botiquin</title>
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('index.css') }}">
    @stack('links')
</head>

<body class="hold-transition sidebar-mini">

    <div id="preloader">
        <img src="{{ asset('1488.gif') }}" alt="" width="48">
    </div>

    <div class="wrapper">

        <nav class="main-header navbar navbar-expand navbar-dark border-0">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <button type="button" class="btn btn-link nav-link" data-widget="pushmenu">
                        <i class="fas fa-bars"></i>
                    </button>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->name }}</a>
                    <div class="dropdown-menu dropdown-menu-right border-light shadow-sm" style="min-width: 240px;">
                        <h6 class="dropdown-header text-left">Logueado como</h6>
                        <div class="px-3">
                            <h6 class="d-block font-weight-semibold mb-0">{{ Auth::user()->name }}</h6>
                            <span class="text-muted">{{ Auth::user()->email }}</span>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a href="/logout" class="dropdown-item">Salir</a>
                    </div>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-light-primary">
            <a href="/dashboard" class="brand-link border-0">
                <div class="brand-image d-flex align-items-center justify-content-center text-white" style="height: 32px; width: 32px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-activity">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
                    </svg>
                </div>
                <span class="brand-text font-weight-bold text-white">Botiquin</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
                    <div class="image">
                        <div class="bg-warning font-weight-semibold d-flex align-items-center justify-content-center rounded-circle" style="height: 32px; width: 32px;">A</div>
                    </div>
                    <div class="info">
                        <h6 class="d-block font-weight-semibold mb-0">{{ Auth::user()->name }}</h6>
                        <span class="text-muted">{{ Auth::user()->email }}</span>
                    </div>
                </div>

                <nav class="my-2">
                    <ul class="nav nav-pills nav-sidebar flex-column">
                        <li class="nav-item">
                            <a href="/dashboard" class="nav-link" id="dashboard">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item my-1"></li>
                        <li class="nav-item">
                            <a href="/categorias" class="nav-link" id="categorias">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Categorias</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/presentaciones" class="nav-link" id="presentaciones">
                                <i class="nav-icon fas fa-tag"></i>
                                <p>Presentaciones</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/medicamentos" class="nav-link" id="medicamentos">
                                <i class="nav-icon fas fa-heart"></i>
                                <p>Medicamentos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/stocks" class="nav-link" id="stocks">
                                <i class="nav-icon fas fa-clipboard"></i>
                                <p>Stocks</p>
                            </a>
                        </li>
                        <li class="nav-item my-1"></li>
                        <li class="nav-item">
                            <a href="/laboratorios" class="nav-link" id="laboratorios">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Laboratorios</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/lotes" class="nav-link" id="lotes">
                                <i class="nav-icon fas fa-calendar"></i>
                                <p>Lotes</p>
                            </a>
                        </li>
                        <li class="nav-item my-1"></li>
                        <li class="nav-item">
                            <a href="/entradas" class="nav-link" id="entradas">
                                <i class="nav-icon fas fa-folder-plus"></i>
                                <p>Entradas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/salidas" class="nav-link" id="salidas">
                                <i class="nav-icon fas fa-folder-minus"></i>
                                <p>Salidas</p>
                            </a>
                        </li>
                        <li class="nav-item my-1"></li>
                        <li class="nav-item">
                            <a href="/reportes" class="nav-link" id="reportes">
                                <i class="nav-icon fas fa-file"></i>
                                <p>Reportes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/logout" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <div class="content py-3">
                <div class="container-fluid">

                    @yield('content')

                </div>
            </div>
        </div>

    </div>

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        window.addEventListener('DOMContentLoaded', (e) => {
            setTimeout(() => {
                document.querySelector('#preloader').style.display = 'none'
            }, 500)
        })

        let http = axios.create({
            baseURL: "{{ url('') }}/api"
        })

        const Toast = Swal.mixin({
            toast: true,
            position: 'bottom-right',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: false,
        })
    </script>
    @stack('scripts')
</body>

</html>
