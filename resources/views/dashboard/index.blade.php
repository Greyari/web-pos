@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="px-5">
    <h1 class="text-3xl font-bold mb-6">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-blue-500 text-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-80">Total Produk</p>
                    <p class="text-3xl font-bold">{{ $stats['total_products'] }}</p>
                </div>
                <i class="fas fa-box text-5xl opacity-80"></i>
            </div>
        </div>

        <div class="bg-green-500 text-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-80">Total Customer</p>
                    <p class="text-3xl font-bold">{{ $stats['total_customers'] }}</p>
                </div>
                <i class="fas fa-users text-5xl opacity-80"></i>
            </div>
        </div>

        <div class="bg-purple-500 text-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-80">Total Transaksi</p>
                    <p class="text-3xl font-bold">{{ $stats['total_transactions'] }}</p>
                </div>
                <i class="fas fa-receipt text-5xl opacity-80"></i>
            </div>
        </div>

        <div class="bg-orange-500 text-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-80">Total Revenue</p>
                    <p class="text-2xl font-bold">Rp {{ number_format($stats['total_revenue']) }}</p>
                </div>
                <i class="fas fa-dollar-sign text-5xl opacity-80"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4">Transaksi Terbaru</h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Tanggal</th>
                        <th class="px-4 py-2 text-left">Customer</th>
                        <th class="px-4 py-2 text-left">Produk</th>
                        <th class="px-4 py-2 text-left">Total</th>
                        <th class="px-4 py-2 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stats['recent_transactions'] as $transaction)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $transaction->transaction_date->format('d/m/Y') }}</td>
                        <td class="px-4 py-2">{{ $transaction->customer->name }}</td>
                        <td class="px-4 py-2">{{ $transaction->product->name }}</td>
                        <td class="px-4 py-2">Rp {{ number_format($transaction->total_price) }}</td>
                        <td class="px-4 py-2">
                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm">
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