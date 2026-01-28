@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="px-5">

    {{-- HEADER --}}
    <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight text-slate-800">
            Tambah Produk
        </h1>
        <p class="text-sm text-slate-500">
            Kelola data produk, supplier, dan harga jual
        </p>
    </div>

    <div class="mb-8">
        <div class="w-full max-w-4xl bg-white rounded-2xl shadow-sm p-6">

            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                {{-- INFORMASI PRODUK --}}
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">
                        Informasi Produk
                    </h2>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">
                                Nama Produk
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm
                                focus:ring-2 focus:ring-slate-900/10"
                                required>
                            @error('name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">
                                Kategori
                            </label>
                            <select name="category"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm"
                                required>
                                <option value="">Pilih Kategori</option>
                                @foreach(['Processor','VGA Card','RAM','Storage','Motherboard','Power Supply','Casing'] as $cat)
                                <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">
                                Deskripsi
                            </label>
                            <textarea name="description" rows="3"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- SUPPLIER & HARGA --}}
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-slate-800">
                            Supplier & Harga
                        </h2>
                        <button type="button" onclick="addSupplier()"
                            class="px-4 py-2.5 bg-slate-900 text-white text-sm rounded-xl hover:bg-slate-800">
                            + Tambah Supplier
                        </button>
                    </div>

                    <div id="suppliers-container" class="space-y-4">
                        <div class="supplier-row bg-slate-50 border border-slate-200 rounded-2xl p-5" data-index="0">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="font-semibold text-slate-700">Supplier #1</h3>
                                <button type="button" onclick="removeSupplier(0)"
                                    class="text-sm text-red-600 hover:text-red-700 remove-btn hidden">
                                    Hapus
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-slate-600 mb-1">
                                        Nama Supplier
                                    </label>
                                    <select name="suppliers[0][supplier_id]"
                                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm"
                                        required>
                                        <option value="">Pilih Supplier</option>
                                        @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">
                                            {{ $supplier->nama_supplier }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Stock</label>
                                    <input type="number" name="suppliers[0][stock]" value="0" min="0"
                                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Harga Beli</label>
                                    <input type="number" name="suppliers[0][harga_beli]"
                                        class="harga-beli w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm"
                                        onkeyup="calculateMargin(0)">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Harga Jual</label>
                                    <input type="number" name="suppliers[0][harga_jual]"
                                        class="harga-jual w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm"
                                        onkeyup="calculateMargin(0)">
                                </div>

                                <div class="md:col-span-2">
                                    <div class="bg-white border border-slate-200 rounded-xl p-3 text-sm">
                                        <span class="text-slate-500">Margin:</span>
                                        <span class="margin-display font-semibold ml-1">Rp 0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ACTION --}}
                <div class="flex gap-3">
                    <button type="submit"
                        class="flex-1 py-3 rounded-xl bg-slate-900 text-white text-sm hover:bg-slate-800">
                        Simpan Produk
                    </button>
                    <a href="{{ route('products.index') }}"
                        class="flex-1 py-3 rounded-xl bg-slate-100 text-slate-700 text-sm text-center hover:bg-slate-200">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    let supplierIndex = 1; // row pertama sudah 0

    function addSupplier() {
        const container = document.getElementById('suppliers-container');

        const html = `
    <div class="supplier-row bg-slate-50 border border-slate-200 rounded-2xl p-5" data-index="${supplierIndex}">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-slate-700">Supplier #${supplierIndex + 1}</h3>
            <button type="button" onclick="removeSupplier(${supplierIndex})"
                class="text-sm text-red-600 hover:text-red-700 remove-btn">
                Hapus
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-slate-600 mb-1">Nama Supplier</label>
                <select name="suppliers[${supplierIndex}][supplier_id]"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm"
                    required>
                    <option value="">Pilih Supplier</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Stock</label>
                <input type="number" name="suppliers[${supplierIndex}][stock]" value="0" min="0"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Harga Beli</label>
                <input type="number" name="suppliers[${supplierIndex}][harga_beli]"
                    class="harga-beli w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm"
                    onkeyup="calculateMargin(${supplierIndex})">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Harga Jual</label>
                <input type="number" name="suppliers[${supplierIndex}][harga_jual]"
                    class="harga-jual w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm"
                    onkeyup="calculateMargin(${supplierIndex})">
            </div>

            <div class="md:col-span-2">
                <div class="bg-white border border-slate-200 rounded-xl p-3 text-sm">
                    <span class="text-slate-500">Margin:</span>
                    <span class="margin-display font-semibold ml-1">Rp 0</span>
                </div>
            </div>
        </div>
    </div>
    `;

        container.insertAdjacentHTML('beforeend', html);
        supplierIndex++;
        updateRemoveButtons();
    }

    function removeSupplier(i) {
        const row = document.querySelector(`[data-index="${i}"]`);
        if (row) row.remove();
        updateRemoveButtons();
    }

    function updateRemoveButtons() {
        const rows = document.querySelectorAll('.supplier-row');
        const buttons = document.querySelectorAll('.remove-btn');

        if (rows.length <= 1) {
            buttons.forEach(btn => btn.classList.add('hidden'));
        } else {
            buttons.forEach(btn => btn.classList.remove('hidden'));
        }
    }

    function calculateMargin(i) {
        const row = document.querySelector(`[data-index="${i}"]`);
        const beli = parseFloat(row.querySelector('.harga-beli')?.value) || 0;
        const jual = parseFloat(row.querySelector('.harga-jual')?.value) || 0;
        const margin = jual - beli;

        const display = row.querySelector('.margin-display');
        display.textContent = 'Rp ' + margin.toLocaleString('id-ID');
        display.className =
            'margin-display font-semibold ml-1 ' +
            (margin >= 0 ? 'text-green-600' : 'text-red-600');
    }

    document.addEventListener('DOMContentLoaded', () => {
        updateRemoveButtons();
        calculateMargin(0);
    });
</script>

@endsection