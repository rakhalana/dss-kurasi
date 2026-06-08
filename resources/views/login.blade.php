@extends('base.app')

@section('title', 'Login')
@section('class-body', 'bg-light')

@section('content')
    <div class="login-page">
        <div class="login-wrapper">
            <div class="card login-card" data-aos="zoom-in" data-aos-duration="800">
                <div class="row no-gutters">
                    <!-- Sisi Kiri: Branding & Welcome -->
                    <div class="col-md-5 d-none d-md-block">
                        <div class="login-left">
                            <div data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
                                <!-- <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="brand-logo"> -->
                                <h2>Sistem Pendukung Keputusan Kurasi Produk UMKM</h2>
                                <p>
                                    Selamat datang kembali di portal manajemen data kurasi UMKM. Akses dashboard untuk
                                    mengelola penilaian produk.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Sisi Kanan: Form Login -->
                    <div class="col-md-7">
                        <div class="login-right">
                            <div class="login-form-wrap" data-aos="fade-left" data-aos-delay="400" data-aos-duration="1000">
                                <h3>Login</h3>
                                <p class="subtitle">Masuk ke akun Anda untuk melanjutkan</p>

                                <form action="{{ route('login') }}" method="POST">
                                    @csrf

                                    @if (session('status'))
                                        <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm"
                                            role="alert" style="border-radius: 12px;">
                                            <div class="d-flex align-items-center">
                                                <i data-lucide="check-circle" class="mr-2 lucide-sm"></i>
                                                <span>{{ session('status') }}</span>
                                            </div>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i data-lucide="mail"></i>
                                                </span>
                                            </div>
                                            <input type="email" name="email" id="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email', request()->cookie('remember_email')) }}"
                                                placeholder="Masukkan email" required autofocus>
                                        </div>
                                        @error('email')
                                            <div class="text-danger small mt-1 pl-1">
                                                <i data-lucide="alert-circle" class="lucide-xs mr-1"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i data-lucide="lock"></i>
                                                </span>
                                            </div>
                                            <input type="password" name="password" id="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Masukkan password" required>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-light border-left-0 btn-toggle-password"
                                                    type="button"
                                                    style="border: 1px solid #ced4da; border-left: none; background: white;">
                                                    <i data-lucide="eye" class="text-muted"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @error('password')
                                            <div class="text-danger small mt-1 pl-1">
                                                <i data-lucide="alert-circle" class="lucide-xs mr-1"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group d-flex justify-content-between align-items-center mt-4">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="remember"
                                                name="remember" {{ request()->cookie('remember_email') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="remember">
                                                Ingat Saya
                                            </label>
                                        </div>

                                        <a href="{{ route('password.request') }}" class="forgot-link">Lupa Password?</a>
                                    </div>

                                    <button type="submit" class="btn btn-dark btn-block btn-login mt-4">
                                        <span>Masuk ke Dashboard</span>
                                        <i data-lucide="log-in" class="ml-2"></i>
                                    </button>
                                </form>

                                <div class="login-footer-text">
                                    &copy; {{ date('Y') }} SPK Kurasi UMKM. All rights reserved.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Trigger AOS again to be sure
            if (typeof AOS !== 'undefined') {
                AOS.refresh();
            }
        });
    </script>
@endpush