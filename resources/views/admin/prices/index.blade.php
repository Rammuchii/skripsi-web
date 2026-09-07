@extends('layouts.app')

@section('content')

    <section class="section">

        <div class="container" style="max-width: 720px;">

            <div class="admin-header d-flex justify-content-between align-items-center mb-4">

                <div>
                    <h3 class="fw-bold mb-0">Kelola Harga Buah</h3>
                    <p class="text-muted mb-0">Harga per kilogram untuk masing-masing jenis buah.</p>
                </div>

                <div class="admin-actions d-flex gap-2">

                    <a href="{{ route('admin.history') }}" class="btn btn-outline-success">
                        <i class="bi bi-clock-history me-1"></i> History
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </button>
                    </form>

                </div>

            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow-card p-4 p-md-5">

                <form method="POST" action="{{ route('admin.prices.update') }}">

                    @csrf

                    @foreach (\App\Models\FruitPrice::EDITABLE_FRUITS as $fruit)

                        <div class="mb-3">

                            <label for="{{ $fruit }}" class="form-label fw-semibold text-capitalize">
                                {{ $fruit }} (Rp / Kg)
                            </label>

                            <input
                                type="number"
                                min="0"
                                step="1"
                                name="{{ $fruit }}"
                                id="{{ $fruit }}"
                                class="form-control"
                                value="{{ old($fruit, optional($prices->get($fruit))->price ?? 0) }}"
                                required>

                        </div>

                    @endforeach

                    <p class="text-muted small">
                        Kelas <strong>Non-Fruit</strong> memiliki harga tetap (Rp 0) dan tidak dapat diubah.
                    </p>

                    <button type="submit" class="btn btn-success w-100 py-2 mt-2">
                        Simpan Perubahan
                    </button>

                </form>

            </div>

        </div>

    </section>

@endsection
