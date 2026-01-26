@extends('layouts.app')

@section('title', 'Laporan Transaksi')

@section('content')
<div class="px-5">
    <div class="flex justify-between items-center ">
        <h1 class="text-2xl font-semibold mb-6 tracking-tight">Laporan Transaksi</h1>
        <a href="{{ route('report.download') }}" class="bg-green-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-green-700 ">
            <i class="fas fa-download mr-2 text-sm"></i>Download CSV
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-blue-500 text-white p-6 rounded-lg shadow">
            <p class="text-sm opacity-80">Total Transaksi</p>
            <p class="text-3xl font-bold">{{ $transactions->count() }}</p>
        </div>

        <div class="bg-green-500 text-white p-6 rounded-lg shadow">
            <p class="text-sm opacity-80">Total Revenue</p>
            <p class="text-2xl font-bold">Rp {{ number_format($totalRevenue) }}</p>
        </div>

        <div class="bg-purple-500 text-white p-6 rounded-lg shadow">
            <p class="text-sm opacity-80">Rata-rata Transaksi</p>
            <p class="text-2xl font-bold">Rp {{ number_format($transactions->count() > 0 ? $totalRevenue / $transactions->count() : 0) }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100 text-gray-800">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Tanggal</th>
                        <th class="px-4 py-3 text-left">Customer</th>
                        <th class="px-4 py-3 text-left">Produk</th>
                        <th class="px-4 py-3 text-left">Qty</th>
                        <th class="px-4 py-3 text-left">Total</th>
                        <th class="px-4 py-3 text-left">Tipe</th>
                        <th class="px-4 py-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $index => $transaction)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-4 py-3 text-gray-600 text-sm">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 text-gray-600 text-sm">{{ $transaction->transaction_date->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-gray-600 text-sm">{{ $transaction->customer->name }}</td>
                        <td class="px-4 py-3 text-gray-600 text-sm">{{ $transaction->product->name }}</td>
                        <td class="px-4 py-3 text-gray-600 text-sm">{{ $transaction->quantity }}</td>
                        <td class="px-4 py-3 text-gray-600 text-sm">Rp {{ number_format($transaction->total_price) }}</td>
                        <td class="px-4 py-3">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">
                                {{ $transaction->type }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="bg-{{ $transaction->status == 'Completed' ? 'green' : 'yellow' }}-100 text-{{ $transaction->status == 'Completed' ? 'green' : 'yellow' }}-800 px-2 py-1 rounded text-sm">
                                {{ $transaction->status }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection