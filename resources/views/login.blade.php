<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('index.css') }}">
    <title>Login</title>
</head>

<body class="hold-transition" style="background-color: #fafbfc;">

    <!-- errores de validacion -->
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show rounded-0" role="alert">
        <strong><i class="fas fa-times-circle"></i> ¡UPS!</strong>
        <p>Llene los campos necesarios</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <!-- otras alertas -->
    @if (session('msgType') && session('msg'))
    @switch (session('msgType'))
    @case ('error')
    <div class="alert alert-danger alert-dismissible fade show rounded-0" role="alert">
        <strong><i class="fas fa-times-circle"></i> ¡UPS!</strong>
        <p>{{ session('msg') }}</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @break
    @endswitch
    @endif

    <div class="container">
        <div class="card shadow-sm border border-light mx-auto mt-3" style="max-width: 400px;">
            <div class="card-header border-0 pt-5 pb-0">
                <h4 class="text-center font-weight-bold">Login</h4>
                <p class="text-center text-muted">Ingresa tus datos para iniciar sesion</p>
            </div>
            <div class="card-body">
                <form action="/" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control  @error('email') is-invalid @enderror">
                    </div>
                    <div class="form-group">
                        <label for="">Contraseña <span class="text-danger">*</span></label>
                        <input type="password" name="password" id="password" class="form-control  @error('password') is-invalid @enderror">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block font-weight-semibold">Entrar</button>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
</body>

</html>
