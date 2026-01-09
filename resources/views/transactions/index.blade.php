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

    <div class="mb-4">
        <form action="{{ route('transactions.index') }}" method="GET">
            <div class="flex gap-2">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari transaksi..."
                    class="flex-1 px-4 py-2 border rounded-lg"
                >
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left">Tanggal</th>
                        <th class="px-4 py-3 text-left">Customer</th>
                        <th class="px-4 py-3 text-left">Produk</th>
                        <th class="px-4 py-3 text-left">Supplier</th>
                        <th class="px-4 py-3 text-left">Qty</th>
                        <th class="px-4 py-3 text-left">Total</th>
                        <th class="px-4 py-3 text-left">Tipe</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $transaction->transaction_date->format('d/m/Y') }}</td>
                        <td class="px-4 py-3">
                            <div class="font-medium">{{ $transaction->customer->name }}</div>
                            <div class="text-sm text-gray-500">{{ $transaction->customer->email }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-medium">{{ $transaction->product->name }}</div>
                            <div class="text-sm text-gray-500">{{ $transaction->product->category }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-sm font-medium text-gray-700">
                                {{ $transaction->supplier->nama_supplier ?? '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="font-semibold">{{ $transaction->quantity }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="font-semibold text-green-600">
                                Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                            </span>
                        </td>
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
                            <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus? Stok akan dikembalikan ke supplier.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-4 py-8 text-center text-gray-500">
                            Tidak ada transaksi ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $transactions->links() }}
    </div>
</div>
@endsection
