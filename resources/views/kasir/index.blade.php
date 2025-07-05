@extends('layouts.app2')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-center">📋 Dashboard Kasir</h1>

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('kasir.create') }}" class="btn btn-primary">
            ➕ Buat Transaksi
        </a>
        <a href="{{ route('laporan.index') }}" class="btn btn-secondary">
            📊 Lihat Laporan
        </a>
    </div>

    <!-- Pesan Sukses -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tabel Transaksi -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID Transaksi</th>
                    <th>Nama Kasir</th>
                    <th>Total Harga</th>
                    <th>Tanggal</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                    <tr>
                        <td>#{{ $transaction->id }}</td>
                        <td>{{ $transaction->user->name }}</td>
                        <td>Rp {{ number_format($transaction->total_price, 2, ',', '.') }}</td>
                        <td>{{ $transaction->created_at->format('Y-m-d H:i:s') }}</td>
                        <td class="text-center">
                            <!-- Tombol Edit -->
                            <a href="{{ route('kasir.edit', $transaction->id) }}" class="btn btn-warning btn-sm">
                                ✏️ Edit
                            </a>

                            <!-- Tombol Hapus -->
                            <form action="{{ route('kasir.destroy', $transaction->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection