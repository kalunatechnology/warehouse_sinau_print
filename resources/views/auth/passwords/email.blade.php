@extends('layouts.auth')

@section('title_page', 'Forget Password | WMS Sinau Print')

@section('content')
 @php
        $version = date('YmdHis');
    @endphp
    <div class="card">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <!-- Logo -->
            <div class="app-brand justify-content-center">
                <img class="w-100" src="{{ asset('assets/img/logo/logo.jpg') }}?v={{ $version }}" alt="">
            </div>
            <!-- /Logo -->
            <h4 class="mb-2 fw-bold">RESET PASSWORD</h4>
            <p class="mb-4">Reset password akun admin POS</p>


            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>

                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" placeholder="Enter your email" required
                        autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="mb-2">
                        <button type="submit" class="btn btn-primary w-100">
                            {{ __('Send Password Reset Link') }}
                        </button>
                    </div>
                    <div class="mb-2">
                        <button type="submit" class="btn btn-secondary w-100">
                            {{ __('Back to Login') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
