@extends('layouts.app2')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container">
    <h1>Laporan Transaksi</h1>

    <form action="{{ route('laporan.index') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="start_date">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate ?? '' }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="end_date">Tanggal Selesai</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate ?? '' }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary btn-block">Tampilkan Laporan</button>
                </div>
            </div>
        </div>
    </form>
<h1> Laporan Keseluruhan </h1>
    @if(isset($transactions) && $transactions->isNotEmpty())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Nama Kasir</th>
                    <th>Total Harga</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>{{ $transaction->user->name }}</td>
                        <td>Rp {{ number_format($transaction->total_price, 2, ',', '.') }}</td>
                        <td>{{ $transaction->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-warning">Tidak ada transaksi untuk ditampilkan.</div>
    @endif
</div>
@endsection
