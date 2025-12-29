@extends('layouts.app')

@section('title', 'Tambah Transaksi')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6">Tambah Transaksi</h1>

    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Customer</label>
                <select name="customer_id" class="w-full px-4 py-2 border rounded-lg @error('customer_id') border-red-500 @enderror" required>
                    <option value="">Pilih Customer</option>
                    @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                        {{ $customer->name }} - {{ $customer->email }}
                    </option>
                    @endforeach
                </select>
                @error('customer_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Produk</label>
                <select name="product_id" id="product_id" class="w-full px-4 py-2 border rounded-lg @error('product_id') border-red-500 @enderror" required>
                    <option value="">Pilih Produk</option>
                    @foreach($products as $product)
                    <option value="{{ $product->id }}" data-price="{{ $product->price }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->name }} - Rp {{ number_format($product->price) }} (Stok: {{ $product->stock }})
                    </option>
                    @endforeach
                </select>
                @error('product_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Jumlah</label>
                <input
                    type="number"
                    name="quantity"
                    id="quantity"
                    value="{{ old('quantity', 1) }}"
                    min="1"
                    class="w-full px-4 py-2 border rounded-lg @error('quantity') border-red-500 @enderror"
                    required
                >
                @error('quantity')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Tipe Transaksi</label>
                <select name="type" class="w-full px-4 py-2 border rounded-lg @error('type') border-red-500 @enderror" required>
                    <option value="">Pilih Tipe</option>
                    <option value="Invoice" {{ old('type') == 'Invoice' ? 'selected' : '' }}>Invoice</option>
                    <option value="Quotation" {{ old('type') == 'Quotation' ? 'selected' : '' }}>Quotation</option>
                    <option value="DO" {{ old('type') == 'DO' ? 'selected' : '' }}>Delivery Order</option>
                </select>
                @error('type')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Tanggal Transaksi</label>
                <input
                    type="date"
                    name="transaction_date"
                    value="{{ old('transaction_date', date('Y-m-d')) }}"
                    class="w-full px-4 py-2 border rounded-lg @error('transaction_date') border-red-500 @enderror"
                    required
                >
                @error('transaction_date')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6 p-4 bg-gray-100 rounded-lg">
                <p class="font-semibold">Estimasi Total: <span id="total_estimate">Rp 0</span></p>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                    Simpan
                </button>
                <a href="{{ route('transactions.index') }}" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400 text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('product_id');
    const quantityInput = document.getElementById('quantity');
    const totalEstimate = document.getElementById('total_estimate');

    function updateTotal() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
        const quantity = parseInt(quantityInput.value) || 0;
        const total = price * quantity;

        totalEstimate.textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    productSelect.addEventListener('change', updateTotal);
    quantityInput.addEventListener('input', updateTotal);

    updateTotal();
});
</script>
@endsection
