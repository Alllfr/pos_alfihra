<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        // Mengambil semua transaksi dengan relasi user
        $transactions = Transaction::with('user')->latest()->get();
        return view('kasir.index', compact('transactions'));
    }

    public function create()
    {
        // Mengambil semua produk untuk ditampilkan di form transaksi
        $products = Product::all();
        return view('kasir.create', compact('products'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'product_id' => 'required|array',
            'quantity' => 'required|array',
        ]);

        // Membuat transaksi baru
        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'total_price' => 0, // akan dihitung nanti
        ]);

        $totalPrice = 0;

        // Menyimpan detail transaksi
        foreach ($request->product_id as $index => $productId) {
            $product = Product::find($productId);
            $quantity = $request->quantity[$index];
            $subtotal = $product->price * $quantity;

            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $productId,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ]);

            $totalPrice += $subtotal;
        }

        // Mengupdate total harga transaksi
        $transaction->update(['total_price' => $totalPrice]);

        return redirect()->route('kasir.index')->with('success', 'Transaksi berhasil dibuat.');
    }

    public function edit($id)
    {
        // Mengambil transaksi dan detailnya untuk diedit
        $transaction = Transaction::with('transactionDetails')->findOrFail($id);  // Ganti 'details' menjadi 'transactionDetails'
        $products = Product::all();
        return view('kasir.edit', compact('transaction', 'products'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'product_id' => 'required|array',
            'quantity' => 'required|array',
        ]);

        // Mengambil transaksi yang akan diupdate
        $transaction = Transaction::findOrFail($id);
        $transaction->transactionDetails()->delete(); // Hapus detail lama, ganti 'details()' menjadi 'transactionDetails()'

        $totalPrice = 0;

        // Menyimpan detail transaksi baru
        foreach ($request->product_id as $index => $productId) {
            $product = Product::find($productId);
            $quantity = $request->quantity[$index];
            $subtotal = $product->price * $quantity;

            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $productId,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ]);

            $totalPrice += $subtotal;
        }

        // Mengupdate total harga transaksi
        $transaction->update(['total_price' => $totalPrice]);

        return redirect()->route('kasir.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Menghapus transaksi dan detailnya
        $transaction = Transaction::findOrFail($id);
        $transaction->transactionDetails()->delete(); // Hapus detail transaksi, ganti 'details()' menjadi 'transactionDetails()'
        $transaction->delete();

        return redirect()->route('kasir.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    public function report(Request $request)
    {
        // Mengambil transaksi berdasarkan tanggal
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $transactions = Transaction::with('user')
            ->when($startDate, function ($query) use ($startDate) {
                return $query->where('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                return $query->where('created_at', '<=', $endDate);
            })
            ->get();

        return view('kasir.laporan', compact('transactions', 'startDate', 'endDate'));
    }
}
