@extends('layouts.auth')

@section('title_page', 'Login Admin | WMS Sinau Print')

@section('content')
 @php
        $version = date('YmdHis');
    @endphp
    <div class="card">
        <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
                <img class="w-100" src="{{ asset('assets/img/logo/logo.jpg') }}?v={{ $version }}" alt="">
            </div>
            <!-- /Logo -->
            <h4 class="mb-2 fw-bold">LOGIN ADMIN WMS</h4>
            <p class="mb-4">Masuk sebagai admin untuk mengakses menu Warehouse (WMS)</p>

            <form id="formAuthentication" class="mb-3" action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" id="email" name="email" placeholder="Enter your email" autofocus
                        required />
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3 form-password-toggle">
                    <div class="d-flex justify-content-between">
                        <label class="form-label" for="password">Password</label>
                        @if (Route::has('password.request'))
                            <a class="form-label text-primary" href="{{ route('password.request') }}">
                                {{ __('Forgot Password?') }}
                            </a>
                        @endif
                    </div>
                    <div class="input-group input-group-merge">
                        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" placeholder="*******" aria-describedby="password" />
                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember"> Remember Me </label>
                    </div>
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary d-grid w-100" type="submit">Sign In</button>
                </div>
            </form>
        </div>
    </div>
@endsection
