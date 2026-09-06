@extends('layouts.app')

@section('content')

    <section class="section">

        <div class="container">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>
                    <h3 class="fw-bold mb-0">Riwayat Prediksi</h3>
                    <p class="text-muted mb-0">Semua hasil prediksi yang pernah dilakukan.</p>
                </div>

                <div class="d-flex gap-2">

                    <a href="{{ route('admin.prices') }}" class="btn btn-outline-success">
                        <i class="bi bi-tag me-1"></i> Kelola Harga
                    </a>

                    <a href="{{ route('admin.history.export', request()->query()) }}" class="btn btn-outline-primary">
                        <i class="bi bi-download me-1"></i> Export CSV
                    </a>

                    @if ($predictions->count() > 0)
                        <form method="POST" action="{{ route('admin.history.destroyAll') }}"
                              onsubmit="return confirm('Hapus SEMUA riwayat prediksi? Tindakan ini tidak bisa dibatalkan.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="bi bi-trash3 me-1"></i> Hapus Semua
                            </button>
                        </form>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary">
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

            <div class="card shadow-card p-3 p-md-4 mb-4">

                <form method="GET" action="{{ route('admin.history') }}" class="row g-3 align-items-end">

                    <div class="col-md-3">
                        <label for="fruit" class="form-label fw-semibold">Jenis Buah</label>
                        <select name="fruit" id="fruit" class="form-select">
                            <option value="">Semua</option>
                            @foreach ($fruits as $fruitOption)
                                <option value="{{ $fruitOption }}" @selected(request('fruit') === $fruitOption)>
                                    {{ ucfirst($fruitOption) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="date_from" class="form-label fw-semibold">Dari Tanggal</label>
                        <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>

                    <div class="col-md-3">
                        <label for="date_to" class="form-label fw-semibold">Sampai Tanggal</label>
                        <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>

                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-success flex-grow-1">
                            <i class="bi bi-funnel me-1"></i> Filter
                        </button>

                        @if (request()->hasAny(['fruit', 'date_from', 'date_to']))
                            <a href="{{ route('admin.history') }}" class="btn btn-outline-secondary">
                                Reset
                            </a>
                        @endif
                    </div>

                </form>

            </div>

            <div class="card shadow-card p-3 p-md-4">

                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead>
                            <tr>
                                <th>Gambar</th>
                                <th>Buah</th>
                                <th>Confidence</th>
                                <th>Berat (kg)</th>
                                <th>Harga/Kg</th>
                                <th>Total Harga</th>
                                <th>Waktu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($predictions as $prediction)

                                <tr>
                                    <td>
                                        @if ($prediction->image_path)
                                            <a href="{{ url('/media/' . $prediction->image_path) }}" target="_blank" rel="noopener">
                                                <img
                                                    src="{{ url('/media/' . $prediction->image_path) }}"
                                                    alt="{{ $prediction->fruit }}"
                                                    style="width:56px;height:56px;object-fit:cover;border-radius:10px;">
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-capitalize fw-semibold">{{ $prediction->fruit }}</td>
                                    <td>{{ $prediction->confidence }}%</td>
                                    <td>{{ $prediction->weight }}</td>
                                    <td>Rp {{ number_format($prediction->price_per_kg, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($prediction->total_price, 0, ',', '.') }}</td>
                                    <td>{{ $prediction->created_at->format('d M Y H:i') }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.history.destroy', $prediction) }}"
                                              onsubmit="return confirm('Hapus riwayat prediksi ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        Belum ada riwayat prediksi.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="mt-3">
                    {{ $predictions->links() }}
                </div>

            </div>

        </div>

    </section>

@endsection
