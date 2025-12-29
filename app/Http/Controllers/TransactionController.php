<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['customer', 'product'])
            ->latest()
            ->paginate(10);
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::where('stock', '>', 0)->get();
        return view('transactions.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:Invoice,Quotation,DO',
            'transaction_date' => 'required|date'
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($product->stock < $validated['quantity']) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        $validated['total_price'] = $product->price * $validated['quantity'];

        Transaction::create($validated);

        $product->decrement('stock', $validated['quantity']);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus');
    }

    public function report()
    {
        $transactions = Transaction::with(['customer', 'product'])->get();
        $totalRevenue = $transactions->sum('total_price');

        return view('transactions.report', compact('transactions', 'totalRevenue'));
    }

    public function downloadReport()
    {
        $transactions = Transaction::with(['customer', 'product'])->get();

        $csvData = "Tanggal,Customer,Produk,Jumlah,Total,Tipe,Status\n";

        foreach ($transactions as $trans) {
            $csvData .= sprintf(
                "%s,%s,%s,%d,%s,%s,%s\n",
                $trans->transaction_date->format('Y-m-d'),
                $trans->customer->name,
                $trans->product->name,
                $trans->quantity,
                $trans->total_price,
                $trans->type,
                $trans->status
            );
        }

        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="laporan-transaksi.csv"');
    }
}
