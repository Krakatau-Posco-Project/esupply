<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <title>{{ $setting->name }} | {{ $setting->title }}</title> --}}
    <title>Login</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="AdminLTE/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="AdminLTE/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        @if (session()->has('loginError'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                {{ session('loginError') }}
            </div>
        @endif
        @if (session()->has('successlogout'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{-- <h5><i class="icon fas fa-ban"></i> Alert!</h5> --}}
                {{ session('successlogout') }}
            </div>
        @endif
        @if (session()->has('nosession'))
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{-- <h5><i class="icon fas fa-ban"></i> Alert!</h5> --}}
                {{ session('nosession') }}
            </div>
        @endif

        <div class="card card-outline card-success">
            <div class="card-header text-center">
                <img src="{{ asset('pic/') . '/logokp.png' }}" alt="Krakatau Posco" class="brand-image" style="height: 22px;"><br>
                <a href="#" class="h1">E-Supply</a><br>
                <a href="#" class="h4">General Services</a><br>
                <a href="#" class="h5">Registration</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Search Employee</p>

                {{-- <form action="{{ route('authuser') }}" method="post"> --}}
                <form action="{{ route('register.search') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="idemp" class="form-control" placeholder="ID Employee" autofocus required value="{{ old('username') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        {{-- <div class="invalid-feedback">
                            {{ $message }}
                        </div> --}}
                    </div>

                    <div class="row">
                        <div class="col-8">
                            {{-- <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div> --}}
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Search</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                @if (isset($employee))
                    <br>
                    <br>
                    <form action="{{ route('register.store') }}" method="post">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" name="getidemp" class="form-control" placeholder="ID Employee" autofocus required value="{{ $employee->id_emp }}" readonly>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="getname" class="form-control" placeholder="ID Employee" required value="{{ $employee->name }}" readonly>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="getorgunit" class="form-control" placeholder="ID Employee" required value="{{ $employee->orgunit }}" readonly>
                        </div>

                        <div class="row">
                            <div class="col-8">

                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <input type="hidden" name="getiduserme" value="{{ $employee->id_user }}">
                                <input type="hidden" name="getidapprover" value="{{ $employee->appr1 }}">
                                <input type="hidden" name="newhash" value="{{ $employee->newhash }}">
                                <button type="submit" class="btn btn-primary btn-block">Register</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                @endif

                {{-- <div class="social-auth-links text-center mt-2 mb-3">
                    <a href="#" class="btn btn-block btn-primary">
                        <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                    </a>
                    <a href="#" class="btn btn-block btn-danger">
                        <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                    </a>
                </div> --}}
                <!-- /.social-auth-links -->

                {{-- <p class="mb-1">
                    <a href="forgot-password.html">I forgot my password</a>
                </p>
                <p class="mb-0">
                    <a href="register.html" class="text-center">Register a new membership</a>
                </p> --}}
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="AdminLTE/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="AdminLTE/dist/js/adminlte.min.js"></script>
</body>

</html>
