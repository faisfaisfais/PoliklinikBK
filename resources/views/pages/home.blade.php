@extends('layouts.app')

@section('title', 'Poliklinik UDINUS')

@section('content')
    <!-- Navbar -->
    {{-- <nav class="navbar">
        <div class="logo">
            <img src="{{ asset('frontend/images/logopoliklinik.png') }}" alt="Logo Poliklinik">
        </div>
    </nav> --}}

    <!-- Main Content -->
    <div class="container">
        <!-- Box 1 -->
        <div class="box box1">
            <h1>Appointment Poliklinik</h1>
            <p>Universitas Dian Nuswantoro</p>
        </div>

        <!-- Box 2 and 3 -->
        <div class="login-container">
            <div class="box box2">
                <h3>Login Sebagai Pasien</h3>
                <form action="{{ route('pasien.login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="identifier">NIK atau No Rekam Medis</label>
                        <input id="identifier" type="text"
                            class="form-control w-75 @error('identifier') is-invalid @enderror" name="identifier"
                            value="{{ old('identifier') }}" required autocomplete="identifier" autofocus>

                        @error('identifier')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="btn-container mt-2">
                    <button type="submit" class="button">Sign In</button>
                    <a href="{{ route('pasien.register.form') }}" class="btn btn-signup">
                        Sign Up
                    </a>
                    </div>
                </form>
            </div>
            <div class="box box3">
                <h3>Login Sebagai Dokter</h3>

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Username</label>
                        <input id="username" type="text"
                            class="form-control w-75 @error('username') is-invalid @enderror" name="username"
                            value="{{ old('username') }}" required autocomplete="username" autofocus>

                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input id="password" type="password"
                            class="form-control w-75 @error('password') is-invalid @enderror" name="password" required
                            autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="btn-container mt-2">
                        <button type="submit" class="button">Sign In</button>
                        <a href="{{ route('register') }}" class="btn btn-signup ">
                            Sign Up
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
