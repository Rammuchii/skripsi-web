@extends('layouts.app')

@section('content')

    <section class="section">

        <div class="container" style="max-width: 480px;">

            <div class="card shadow-card p-4 p-md-5">

                <div class="text-center mb-4">

                    <i class="bi bi-shield-lock fs-1 text-success"></i>

                    <h3 class="fw-bold mt-3">Admin Login</h3>

                    <p class="text-muted">Masuk untuk mengelola harga buah dan riwayat prediksi.</p>

                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">

                    @csrf

                    <div class="mb-3">
                        <label for="username" class="form-label fw-semibold">ID</label>
                        <input
                            type="text"
                            name="username"
                            id="username"
                            class="form-control"
                            value="{{ old('username') }}"
                            required
                            autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control"
                            required>
                    </div>

                    <div class="form-check mb-4">
                        <input type="checkbox" name="remember" id="remember" class="form-check-input">
                        <label for="remember" class="form-check-label">Ingat saya</label>
                    </div>

                    <button type="submit" class="btn btn-success w-100 py-2">
                        Login
                    </button>

                </form>

            </div>

        </div>

    </section>

@endsection
