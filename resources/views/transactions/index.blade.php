@extends('layouts.app')

@section('title', 'Manajemen Transaksi')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Manajemen Transaksi</h1>
        <a href="{{ route('transactions.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i>Tambah Transaksi
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left">Tanggal</th>
                    <th class="px-4 py-3 text-left">Customer</th>
                    <th class="px-4 py-3 text-left">Produk</th>
                    <th class="px-4 py-3 text-left">Qty</th>
                    <th class="px-4 py-3 text-left">Total</th>
                    <th class="px-4 py-3 text-left">Tipe</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $transaction->transaction_date->format('d/m/Y') }}</td>
                    <td class="px-4 py-3">{{ $transaction->customer->name }}</td>
                    <td class="px-4 py-3">{{ $transaction->product->name }}</td>
                    <td class="px-4 py-3">{{ $transaction->quantity }}</td>
                    <td class="px-4 py-3">Rp {{ number_format($transaction->total_price) }}</td>
                    <td class="px-4 py-3">
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">
                            {{ $transaction->type }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm">
                            {{ $transaction->status }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $transactions->links() }}
    </div>
</div>
@endsection
