@extends('layouts.app')

@section('title', 'Login - Alumni15')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #e0f7fa 0%, #ffffff 100%);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .login-wrapper {
        margin-top: 80px;
        margin-bottom: 80px;
    }

    .login-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: all 0.3s ease-in-out;
    }

    .login-header {
        background-color: #007bff;
        color: white;
        padding: 30px 20px 20px;
        text-align: center;
    }

    .login-header img {
        height: 70px;
        margin-bottom: 10px;
    }

    .login-header h4 {
        font-weight: 600;
        font-size: 1.4rem;
    }

    .form-group label {
        font-weight: 500;
        margin-bottom: 5px;
    }

    .form-control {
        border-radius: 10px;
        padding: 10px 15px;
    }

    .form-check {
        text-align: left;
    }

    .btn-custom {
        background-color: #007bff;
        color: white;
        border-radius: 10px;
        padding: 10px;
        font-weight: 600;
        transition: background-color 0.3s ease;
    }

    .btn-custom:hover {
        background-color: #0056b3;
    }

    .card-footer {
        background-color: #f8f9fa;
        border-top: none;
        padding: 20px;
        text-align: center;
    }

    .card-footer .btn-link {
        font-weight: 500;
        text-decoration: none;
        color: #007bff;
        transition: color 0.2s;
        display: block;
    }

    .card-footer .btn-link:hover {
        color: #0056b3;
    }

</style>

<div class="container login-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card login-card text-center">
                <div class="card-header login-header">
                    <img src="{{ asset('images/logo_smpn15.png') }}" alt="Logo Alumni15">
                    <h4><i class="fas fa-sign-in-alt mr-2"></i> Login</h4>
                </div>
                <div class="card-body px-4 py-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group text-left">
                            <label for="email"><i class="fas fa-envelope mr-1 text-primary"></i> Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group text-left">
                            <label for="password"><i class="fas fa-lock mr-1 text-primary"></i> Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" required>
                            @error('password')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group form-check text-left">
                            <input class="form-check-input" type="checkbox" name="remember"
                                   id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Ingat saya
                            </label>
                        </div>

                        <button type="submit" class="btn btn-custom btn-block mt-3">
                            <i class="fas fa-sign-in-alt mr-1"></i> Login
                        </button>
                    </form>
                </div>
                <div class="card-footer">
                    <a href="{{ route('register.alumni') }}" class="btn btn-link">Daftar sebagai Alumni</a>
                    <a href="{{ route('register.guru') }}" class="btn btn-link">Daftar sebagai Guru</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
