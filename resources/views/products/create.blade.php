@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="px-5">
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
        <h1 class="text-2xl font-semibold tracking-tight text-slate-800">
            Tambah Produk Baru
        </h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6">
        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            {{-- Basic Information --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Produk</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Kategori</label>
                    <select name="category" id="category" required onchange="showSpecFields()"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Processor Specifications --}}
            <div id="spec-processor" class="spec-section hidden mb-6 p-4 bg-slate-50 rounded-lg">
                <h3 class="font-semibold text-slate-800 mb-4">Spesifikasi Processor</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Socket</label>
                        <input type="text" name="socket" value="{{ old('socket') }}" placeholder="Contoh: LGA1700, AM5"
                            class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">TDP (Watt)</label>
                        <input type="number" name="tdp" value="{{ old('tdp') }}" placeholder="Contoh: 125"
                            class="w-full px-4 py-2 border rounded-lg">
                    </div>
                </div>
            </div>

            {{-- Motherboard Specifications --}}
            <div id="spec-motherboard" class="spec-section hidden mb-6 p-4 bg-slate-50 rounded-lg">
                <h3 class="font-semibold text-slate-800 mb-4">Spesifikasi Motherboard</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Socket</label>
                        <input type="text" name="socket" value="{{ old('socket') }}" placeholder="Contoh: LGA1700, AM5"
                            class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Chipset</label>
                        <input type="text" name="chipset" value="{{ old('chipset') }}" placeholder="Contoh: Z790, B650"
                            class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tipe RAM</label>
                        <select name="ram_type" class="w-full px-4 py-2 border rounded-lg">
                            <option value="">Pilih</option>
                            <option value="DDR4" {{ old('ram_type') == 'DDR4' ? 'selected' : '' }}>DDR4</option>
                            <option value="DDR5" {{ old('ram_type') == 'DDR5' ? 'selected' : '' }}>DDR5</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Jumlah Slot RAM</label>
                        <input type="number" name="ram_slots" value="{{ old('ram_slots') }}" placeholder="Contoh: 4"
                            class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Max RAM Speed (MHz)</label>
                        <input type="number" name="max_ram_speed" value="{{ old('max_ram_speed') }}" placeholder="Contoh: 5600"
                            class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Form Factor</label>
                        <select name="form_factor" class="w-full px-4 py-2 border rounded-lg">
                            <option value="">Pilih</option>
                            <option value="ATX" {{ old('form_factor') == 'ATX' ? 'selected' : '' }}>ATX</option>
                            <option value="Micro-ATX" {{ old('form_factor') == 'Micro-ATX' ? 'selected' : '' }}>Micro-ATX</option>
                            <option value="Mini-ITX" {{ old('form_factor') == 'Mini-ITX' ? 'selected' : '' }}>Mini-ITX</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- RAM Specifications --}}
            <div id="spec-ram" class="spec-section hidden mb-6 p-4 bg-slate-50 rounded-lg">
                <h3 class="font-semibold text-slate-800 mb-4">Spesifikasi RAM</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Generasi</label>
                        <select name="ram_generation" class="w-full px-4 py-2 border rounded-lg">
                            <option value="">Pilih</option>
                            <option value="DDR4" {{ old('ram_generation') == 'DDR4' ? 'selected' : '' }}>DDR4</option>
                            <option value="DDR5" {{ old('ram_generation') == 'DDR5' ? 'selected' : '' }}>DDR5</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Speed (MHz)</label>
                        <input type="number" name="ram_speed" value="{{ old('ram_speed') }}" placeholder="Contoh: 3200"
                            class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Kapasitas (GB)</label>
                        <input type="number" name="ram_capacity" value="{{ old('ram_capacity') }}" placeholder="Contoh: 16"
                            class="w-full px-4 py-2 border rounded-lg">
                    </div>
                </div>
            </div>

            {{-- VGA Specifications --}}
            <div id="spec-vga-card" class="spec-section hidden mb-6 p-4 bg-slate-50 rounded-lg">
                <h3 class="font-semibold text-slate-800 mb-4">Spesifikasi VGA Card</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Konsumsi Daya (Watt)</label>
                        <input type="number" name="vga_power_consumption" value="{{ old('vga_power_consumption') }}" placeholder="Contoh: 220"
                            class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Power Connector</label>
                        <input type="text" name="vga_power_connector" value="{{ old('vga_power_connector') }}" placeholder="Contoh: 8-pin x2"
                            class="w-full px-4 py-2 border rounded-lg">
                    </div>
                </div>
            </div>

            {{-- Storage Specifications --}}
            <div id="spec-storage" class="spec-section hidden mb-6 p-4 bg-slate-50 rounded-lg">
                <h3 class="font-semibold text-slate-800 mb-4">Spesifikasi Storage</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tipe</label>
                        <select name="storage_type" class="w-full px-4 py-2 border rounded-lg">
                            <option value="">Pilih</option>
                            <option value="NVMe" {{ old('storage_type') == 'NVMe' ? 'selected' : '' }}>NVMe</option>
                            <option value="SATA SSD" {{ old('storage_type') == 'SATA SSD' ? 'selected' : '' }}>SATA SSD</option>
                            <option value="HDD" {{ old('storage_type') == 'HDD' ? 'selected' : '' }}>HDD</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Interface</label>
                        <select name="storage_interface" class="w-full px-4 py-2 border rounded-lg">
                            <option value="">Pilih</option>
                            <option value="M.2" {{ old('storage_interface') == 'M.2' ? 'selected' : '' }}>M.2</option>
                            <option value='2.5"' {{ old('storage_interface') == '2.5"' ? 'selected' : '' }}>2.5"</option>
                            <option value='3.5"' {{ old('storage_interface') == '3.5"' ? 'selected' : '' }}>3.5"</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Kapasitas (GB)</label>
                        <input type="number" name="storage_capacity" value="{{ old('storage_capacity') }}" placeholder="Contoh: 1000"
                            class="w-full px-4 py-2 border rounded-lg">
                    </div>
                </div>
            </div>

            {{-- Power Supply Specifications --}}
            <div id="spec-power-supply" class="spec-section hidden mb-6 p-4 bg-slate-50 rounded-lg">
                <h3 class="font-semibold text-slate-800 mb-4">Spesifikasi Power Supply</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Wattage</label>
                        <input type="number" name="psu_wattage" value="{{ old('psu_wattage') }}" placeholder="Contoh: 850"
                            class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Efficiency Rating</label>
                        <select name="psu_efficiency" class="w-full px-4 py-2 border rounded-lg">
                            <option value="">Pilih</option>
                            <option value="80+ Bronze">80+ Bronze</option>
                            <option value="80+ Silver">80+ Silver</option>
                            <option value="80+ Gold">80+ Gold</option>
                            <option value="80+ Platinum">80+ Platinum</option>
                            <option value="80+ Titanium">80+ Titanium</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Casing Specifications --}}
            <div id="spec-casing" class="spec-section hidden mb-6 p-4 bg-slate-50 rounded-lg">
                <h3 class="font-semibold text-slate-800 mb-4">Spesifikasi Casing</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Form Factor</label>
                        <select name="form_factor" class="w-full px-4 py-2 border rounded-lg">
                            <option value="">Pilih</option>
                            <option value="ATX">ATX</option>
                            <option value="Micro-ATX">Micro-ATX</option>
                            <option value="Mini-ITX">Mini-ITX</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Max GPU Length (mm)</label>
                        <input type="number" name="max_gpu_length" value="{{ old('max_gpu_length') }}" placeholder="Contoh: 380"
                            class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Max CPU Cooler Height (mm)</label>
                        <input type="number" name="max_cpu_cooler_height" value="{{ old('max_cpu_cooler_height') }}" placeholder="Contoh: 170"
                            class="w-full px-4 py-2 border rounded-lg">
                    </div>
                </div>
            </div>

            {{-- Suppliers Section --}}
            <div class="mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-slate-800">Supplier & Harga</h3>
                    <button type="button" onclick="addSupplier()"
                        class="px-4 py-2 bg-slate-900 text-white rounded-lg text-sm hover:bg-slate-800">
                        + Tambah Supplier
                    </button>
                </div>

                <div id="suppliers-container">
                    {{-- Supplier items will be added here --}}
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit"
                    class="px-6 py-3 bg-slate-900 text-white rounded-lg hover:bg-slate-800">
                    Simpan Produk
                </button>
                <a href="{{ route('products.index') }}"
                    class="px-6 py-3 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
let supplierCount = 0;

function showSpecFields() {
    const category = document.getElementById('category').value;

    // Hide all spec sections
    document.querySelectorAll('.spec-section').forEach(section => {
        section.classList.add('hidden');
    });

    // Show relevant spec section
    if (category) {
        const specId = 'spec-' + category.toLowerCase().replace(' ', '-');
        const specSection = document.getElementById(specId);
        if (specSection) {
            specSection.classList.remove('hidden');
        }
    }
}

function addSupplier() {
    supplierCount++;
    const container = document.getElementById('suppliers-container');

    const html = `
        <div class="supplier-item border rounded-lg p-4 mb-4" id="supplier-${supplierCount}">
            <div class="flex justify-between items-center mb-4">
                <h4 class="font-medium text-slate-700">Supplier #${supplierCount}</h4>
                <button type="button" onclick="removeSupplier(${supplierCount})"
                    class="text-red-500 hover:text-red-700 text-sm">
                    Hapus
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Supplier</label>
                    <select name="suppliers[${supplierCount}][supplier_id]" required
                        class="w-full px-4 py-2 border rounded-lg">
                        <option value="">Pilih Supplier</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Stock</label>
                    <input type="number" name="suppliers[${supplierCount}][stock]" required
                        class="w-full px-4 py-2 border rounded-lg" min="0">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Harga Beli</label>
                    <input type="number" name="suppliers[${supplierCount}][harga_beli]" required
                        class="w-full px-4 py-2 border rounded-lg" min="0" step="0.01">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Harga Jual</label>
                    <input type="number" name="suppliers[${supplierCount}][harga_jual]" required
                        class="w-full px-4 py-2 border rounded-lg" min="0" step="0.01">
                </div>
            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', html);
}

function removeSupplier(id) {
    document.getElementById(`supplier-${id}`).remove();
}

// Add initial supplier on page load
document.addEventListener('DOMContentLoaded', function() {
    addSupplier();

    // Show spec fields if category is already selected (from old input)
    const category = document.getElementById('category').value;
    if (category) {
        showSpecFields();
    }
});
</script>
@endpush
