<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="Sistema de cotización profesional">
    <meta name="author" content="Alex Granada Campana" />
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}" />

    <!-- Title -->
    <title>Sistema de cotizaciones en línea</title>

    <!-- Animated css -->
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/bootstrap/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.min.css') }}">


</head>

<body class="login-container">

    <form action="{{ route('login.post') }}" class="login-form" method="POST">
        @csrf
        <div class="login-box">
            <div class="login-form">
                @error('email')
                    <div class="alert alert-danger" role="alert">
                        {{ $message }}
                    </div>
                @enderror

                <center>
                    <img src="{{ asset('assets/images/logo.png') }}" width="250px" />
                </center>
                <div class="login-welcome">
                    Bienvenido, por favor ingrese sus datos.
                </div>
                <div class="mb-3">
                    <label class="form-label">Usuario o correo electrónico</label>
                    <input type="email" class="form-control" name="email" required autocomplete="false" autofocus
                        placeholder="Ingrese su usuario o correo electrónico">
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <label class="form-label">Clave</label>
                        <a href="#" class="btn-link ml-auto">¿Olvidaste tu clave?</a>
                    </div>
                    <input type="password" class="form-control" name="password" required autocomplete="current-password"
                        placeholder="Ingrese su clave">
                </div>
                <div class="login-form-actions">
                    <button type="submit" class="btn"> <span class="icon">
                            <i class="bi bi-arrow-right-circle"></i> </span> Ingresar
                    </button>
                </div>
                <div class="login-form-actions">
                    <button type="submit" class="btn"> <img src="assets/images/google.svg" class="login-icon"
                            alt="Login with Google">
                        Acceder con Google</button>

                </div>
                <div class="login-form-footer">
                    <div class="additional-link">
                        Creado por <a href="https://cus-code.com">CUSCODE</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/modernizr.js') }}"></script>
    <script src="{{ asset('assets/js/moment.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>
