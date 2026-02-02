@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="px-5">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight text-slate-800">Edit Produk</h1>
        <p class="text-sm text-slate-500">Perbarui informasi produk dan spesifikasi</p>
    </div>

    <div class="mb-8">
        <div class="w-full max-w-5xl bg-white rounded-2xl shadow-sm p-6">
            <form action="{{ route('products.update', $product) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- BASIC INFO --}}
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Informasi Produk</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Nama Produk</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                                class="w-full px-4 py-2.5 rounded-xl border text-sm focus:ring-2 focus:ring-slate-900/10">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Kategori</label>
                            <select name="category" id="category" onchange="showSpecFields()" required
                                class="w-full px-4 py-2.5 rounded-xl border text-sm">
                                <option value="">Pilih Kategori</option>
                                @foreach(['Processor','VGA Card','RAM','Storage','Motherboard','Power Supply','Casing'] as $cat)
                                <option value="{{ $cat }}" {{ old('category', $product->category)===$cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- SPECS: Processor --}}
                <div id="spec-processor" class="spec-section {{ $product->category==='Processor' ? '' : 'hidden' }} mb-8">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Spesifikasi Processor</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-slate-50 rounded-xl">
                        <div><label class="block text-sm font-medium text-slate-600 mb-1">Socket *</label>
                            <input type="text" name="socket" value="{{ old('socket', $product->socket) }}" placeholder="LGA1700, AM5" class="w-full px-4 py-2.5 rounded-xl border text-sm"></div>
                        <div><label class="block text-sm font-medium text-slate-600 mb-1">TDP (Watt) *</label>
                            <input type="number" name="tdp" value="{{ old('tdp', $product->tdp) }}" placeholder="125" class="w-full px-4 py-2.5 rounded-xl border text-sm"></div>
                    </div>
                </div>

                {{-- SPECS: Motherboard --}}
                <div id="spec-motherboard" class="spec-section {{ $product->category==='Motherboard' ? '' : 'hidden' }} mb-8">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Spesifikasi Motherboard</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-slate-50 rounded-xl">
                        <div><label class="block text-sm font-medium text-slate-600 mb-1">Socket *</label>
                            <input type="text" name="socket" value="{{ old('socket', $product->socket) }}" placeholder="LGA1700, AM5" class="w-full px-4 py-2.5 rounded-xl border text-sm"></div>
                        <div><label class="block text-sm font-medium text-slate-600 mb-1">Chipset *</label>
                            <input type="text" name="chipset" value="{{ old('chipset', $product->chipset) }}" placeholder="Z790, B650" class="w-full px-4 py-2.5 rounded-xl border text-sm"></div>
                        <div><label class="block text-sm font-medium text-slate-600 mb-1">Tipe RAM *</label>
                            <select name="ram_type" class="w-full px-4 py-2.5 rounded-xl border text-sm">
                                <option value="">Pilih</option>
                                <option value="DDR4" {{ old('ram_type', $product->ram_type)=='DDR4' ? 'selected' : '' }}>DDR4</option>
                                <option value="DDR5" {{ old('ram_type', $product->ram_type)=='DDR5' ? 'selected' : '' }}>DDR5</option>
                            </select></div>
                        <div><label class="block text-sm font-medium text-slate-600 mb-1">Slot RAM *</label>
                            <input type="number" name="ram_slots" value="{{ old('ram_slots', $product->ram_slots) }}" placeholder="4" class="w-full px-4 py-2.5 rounded-xl border text-sm"></div>
                        <div><label class="block text-sm font-medium text-slate-600 mb-1">Max RAM Speed (MHz) *</label>
                            <input type="number" name="max_ram_speed" value="{{ old('max_ram_speed', $product->max_ram_speed) }}" placeholder="5600" class="w-full px-4 py-2.5 rounded-xl border text-sm"></div>
                        <div><label class="block text-sm font-medium text-slate-600 mb-1">Form Factor</label>
                            <select name="form_factor" class="w-full px-4 py-2.5 rounded-xl border text-sm">
                                <option value="">Pilih</option>
                                <option value="ATX" {{ old('form_factor', $product->form_factor)=='ATX' ? 'selected' : '' }}>ATX</option>
                                <option value="Micro-ATX" {{ old('form_factor', $product->form_factor)=='Micro-ATX' ? 'selected' : '' }}>Micro-ATX</option>
                                <option value="Mini-ITX" {{ old('form_factor', $product->form_factor)=='Mini-ITX' ? 'selected' : '' }}>Mini-ITX</option>
                            </select></div>
                    </div>
                </div>

                {{-- SPECS: RAM --}}
                <div id="spec-ram" class="spec-section {{ $product->category==='RAM' ? '' : 'hidden' }} mb-8">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Spesifikasi RAM</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4 bg-slate-50 rounded-xl">
                        <div><label class="block text-sm font-medium text-slate-600 mb-1">Generasi *</label>
                            <select name="ram_generation" class="w-full px-4 py-2.5 rounded-xl border text-sm">
                                <option value="">Pilih</option>
                                <option value="DDR4" {{ old('ram_generation', $product->ram_generation)=='DDR4' ? 'selected' : '' }}>DDR4</option>
                                <option value="DDR5" {{ old('ram_generation', $product->ram_generation)=='DDR5' ? 'selected' : '' }}>DDR5</option>
                            </select></div>
                        <div><label class="block text-sm font-medium text-slate-600 mb-1">Speed (MHz) *</label>
                            <input type="number" name="ram_speed" value="{{ old('ram_speed', $product->ram_speed) }}" placeholder="3200" class="w-full px-4 py-2.5 rounded-xl border text-sm"></div>
                        <div><label class="block text-sm font-medium text-slate-600 mb-1">Kapasitas (GB) *</label>
                            <input type="number" name="ram_capacity" value="{{ old('ram_capacity', $product->ram_capacity) }}" placeholder="16" class="w-full px-4 py-2.5 rounded-xl border text-sm"></div>
                    </div>
                </div>

                {{-- SPECS: VGA --}}
                <div id="spec-vga-card" class="spec-section {{ $product->category==='VGA Card' ? '' : 'hidden' }} mb-8">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Spesifikasi VGA Card</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-slate-50 rounded-xl">
                        <div><label class="block text-sm font-medium text-slate-600 mb-1">Konsumsi Daya (Watt) *</label>
                            <input type="number" name="vga_power_consumption" value="{{ old('vga_power_consumption', $product->vga_power_consumption) }}" placeholder="220" class="w-full px-4 py-2.5 rounded-xl border text-sm"></div>
                        <div><label class="block text-sm font-medium text-slate-600 mb-1">Power Connector</label>
                            <input type="text" name="vga_power_connector" value="{{ old('vga_power_connector', $product->vga_power_connector) }}" placeholder="8-pin x2" class="w-full px-4 py-2.5 rounded-xl border text-sm"></div>
                    </div>
                </div>

                {{-- SPECS: Storage --}}
                <div id="spec-storage" class="spec-section {{ $product->category==='Storage' ? '' : 'hidden' }} mb-8">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Spesifikasi Storage</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4 bg-slate-50 rounded-xl">
                        <div><label class="block text-sm font-medium text-slate-600 mb-1">Tipe *</label>
                            <select name="storage_type" class="w-full px-4 py-2.5 rounded-xl border text-sm">
                                <option value="">Pilih</option>
                                <option value="NVMe" {{ old('storage_type', $product->storage_type)=='NVMe' ? 'selected' : '' }}>NVMe</option>
                                <option value="SATA SSD" {{ old('storage_type', $product->storage_type)=='SATA SSD' ? 'selected' : '' }}>SATA SSD</option>
                                <option value="HDD" {{ old('storage_type', $product->storage_type)=='HDD' ? 'selected' : '' }}>HDD</option>
                            </select></div>
                        <div><label class="block text-sm font-medium text-slate-600 mb-1">Interface *</label>
                            <select name="storage_interface" class="w-full px-4 py-2.5 rounded-xl border text-sm">
                                <option value="">Pilih</option>
                                <option value="M.2" {{ old('storage_interface', $product->storage_interface)=='M.2' ? 'selected' : '' }}>M.2</option>
                                <option value='2.5"' {{ old('storage_interface', $product->storage_interface)=='2.5"' ? 'selected' : '' }}>2.5"</option>
                                <option value='3.5"' {{ old('storage_interface', $product->storage_interface)=='3.5"' ? 'selected' : '' }}>3.5"</option>
                            </select></div>
                        <div><label class="block text-sm font-medium text-slate-600 mb-1">Kapasitas (GB) *</label>
                            <input type="number" name="storage_capacity" value="{{ old('storage_capacity', $product->storage_capacity) }}" placeholder="1000" class="w-full px-4 py-2.5 rounded-xl border text-sm"></div>
                    </div>
                </div>

                {{-- SPECS: PSU --}}
                <div id="spec-power-supply" class="spec-section {{ $product->category==='Power Supply' ? '' : 'hidden' }} mb-8">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Spesifikasi Power Supply</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-slate-50 rounded-xl">
                        <div><label class="block text-sm font-medium text-slate-600 mb-1">Wattage *</label>
                            <input type="number" name="psu_wattage" value="{{ old('psu_wattage', $product->psu_wattage) }}" placeholder="850" class="w-full px-4 py-2.5 rounded-xl border text-sm"></div>
                        <div><label class="block text-sm font-medium text-slate-600 mb-1">Efficiency Rating</label>
                            <select name="psu_efficiency" class="w-full px-4 py-2.5 rounded-xl border text-sm">
                                <option value="">Pilih</option>
                                @foreach(['80+ Bronze','80+ Silver','80+ Gold','80+ Platinum','80+ Titanium'] as $eff)
                                <option value="{{ $eff }}" {{ old('psu_efficiency', $product->psu_efficiency)==$eff ? 'selected' : '' }}>{{ $eff }}</option>
                                @endforeach
                            </select></div>
                    </div>
                </div>

                {{-- SPECS: Casing --}}
                <div id="spec-casing" class="spec-section {{ $product->category==='Casing' ? '' : 'hidden' }} mb-8">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Spesifikasi Casing</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4 bg-slate-50 rounded-xl">
                        <div><label class="block text-sm font-medium text-slate-600 mb-1">Form Factor *</label>
                            <select name="form_factor" class="w-full px-4 py-2.5 rounded-xl border text-sm">
                                <option value="">Pilih</option>
                                <option value="ATX" {{ old('form_factor', $product->form_factor)=='ATX' ? 'selected' : '' }}>ATX</option>
                                <option value="Micro-ATX" {{ old('form_factor', $product->form_factor)=='Micro-ATX' ? 'selected' : '' }}>Micro-ATX</option>
                                <option value="Mini-ITX" {{ old('form_factor', $product->form_factor)=='Mini-ITX' ? 'selected' : '' }}>Mini-ITX</option>
                            </select></div>
                        <div><label class="block text-sm font-medium text-slate-600 mb-1">Max GPU Length (mm)</label>
                            <input type="number" name="max_gpu_length" value="{{ old('max_gpu_length', $product->max_gpu_length) }}" placeholder="380" class="w-full px-4 py-2.5 rounded-xl border text-sm"></div>
                        <div><label class="block text-sm font-medium text-slate-600 mb-1">Max CPU Cooler Height (mm)</label>
                            <input type="number" name="max_cpu_cooler_height" value="{{ old('max_cpu_cooler_height', $product->max_cpu_cooler_height) }}" placeholder="170" class="w-full px-4 py-2.5 rounded-xl border text-sm"></div>
                    </div>
                </div>

                {{-- SUPPLIERS --}}
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-slate-800">Supplier & Harga</h2>
                        <button type="button" onclick="addSupplier()" class="px-4 py-2.5 bg-slate-900 text-white text-sm rounded-xl hover:bg-slate-800">+ Tambah Supplier</button>
                    </div>
                    <div id="suppliers-container" class="space-y-4">
                        @php
                        $existingSuppliers = old('suppliers', $product->suppliers->map(fn($s) => [
                            'supplier_id' => $s->id,
                            'stock' => $s->pivot->stock,
                            'harga_beli' => $s->pivot->harga_beli,
                            'harga_jual' => $s->pivot->harga_jual,
                        ])->toArray());
                        @endphp
                        @foreach($existingSuppliers as $i => $s)
                        <div class="supplier-row bg-slate-50 border rounded-2xl p-5" data-index="{{ $i }}">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="font-semibold text-slate-700">Supplier #{{ $i+1 }}</h3>
                                <button type="button" onclick="removeSupplier({{ $i }})" class="text-sm text-red-600 hover:text-red-700 remove-btn">Hapus</button>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Nama Supplier</label>
                                    <select name="suppliers[{{ $i }}][supplier_id]" class="w-full px-4 py-2.5 rounded-xl border text-sm" required>
                                        @foreach($suppliers as $sup)
                                        <option value="{{ $sup->id }}" {{ $s['supplier_id']==$sup->id ? 'selected' : '' }}>{{ $sup->nama_supplier }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div><label class="block text-sm font-medium text-slate-600 mb-1">Stock</label>
                                    <input type="number" name="suppliers[{{ $i }}][stock]" value="{{ $s['stock'] }}" class="w-full px-4 py-2.5 rounded-xl border text-sm"></div>
                                <div><label class="block text-sm font-medium text-slate-600 mb-1">Harga Beli</label>
                                    <input type="number" name="suppliers[{{ $i }}][harga_beli]" value="{{ $s['harga_beli'] }}" class="harga-beli w-full px-4 py-2.5 rounded-xl border text-sm" onkeyup="calculateMargin({{ $i }})"></div>
                                <div><label class="block text-sm font-medium text-slate-600 mb-1">Harga Jual</label>
                                    <input type="number" name="suppliers[{{ $i }}][harga_jual]" value="{{ $s['harga_jual'] }}" class="harga-jual w-full px-4 py-2.5 rounded-xl border text-sm" onkeyup="calculateMargin({{ $i }})"></div>
                                <div class="md:col-span-2">
                                    <div class="bg-white border rounded-xl p-3 text-sm">
                                        <span class="text-slate-500">Margin:</span>
                                        <span class="margin-display font-semibold ml-1">Rp {{ number_format($s['harga_jual'] - $s['harga_beli'], 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- ACTIONS --}}
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 py-3 rounded-xl bg-slate-900 text-white text-sm hover:bg-slate-800">Update Produk</button>
                    <a href="{{ route('products.index') }}" class="flex-1 py-3 rounded-xl bg-slate-100 text-slate-700 text-sm text-center hover:bg-slate-200">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let supplierIndex = {{ count($existingSuppliers) }};
function showSpecFields() {
    const category = document.getElementById('category').value;
    document.querySelectorAll('.spec-section').forEach(s => s.classList.add('hidden'));
    if (category) {
        const specId = 'spec-' + category.toLowerCase().replace(' ', '-');
        const specSection = document.getElementById(specId);
        if (specSection) specSection.classList.remove('hidden');
    }
}
function addSupplier() {
    const html = `<div class="supplier-row bg-slate-50 border rounded-2xl p-5" data-index="${supplierIndex}">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-slate-700">Supplier #${supplierIndex+1}</h3>
            <button type="button" onclick="removeSupplier(${supplierIndex})" class="text-sm text-red-600 hover:text-red-700 remove-btn">Hapus</button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2"><label class="block text-sm font-medium text-slate-600 mb-1">Nama Supplier</label>
                <select name="suppliers[${supplierIndex}][supplier_id]" class="w-full px-4 py-2.5 rounded-xl border text-sm" required>
                    <option value="">Pilih Supplier</option>
                    @foreach($suppliers as $sup)<option value="{{ $sup->id }}">{{ $sup->nama_supplier }}</option>@endforeach
                </select></div>
            <div><label class="block text-sm font-medium text-slate-600 mb-1">Stock</label>
                <input type="number" name="suppliers[${supplierIndex}][stock]" value="0" min="0" class="w-full px-4 py-2.5 rounded-xl border text-sm"></div>
            <div><label class="block text-sm font-medium text-slate-600 mb-1">Harga Beli</label>
                <input type="number" name="suppliers[${supplierIndex}][harga_beli]" class="harga-beli w-full px-4 py-2.5 rounded-xl border text-sm" onkeyup="calculateMargin(${supplierIndex})"></div>
            <div><label class="block text-sm font-medium text-slate-600 mb-1">Harga Jual</label>
                <input type="number" name="suppliers[${supplierIndex}][harga_jual]" class="harga-jual w-full px-4 py-2.5 rounded-xl border text-sm" onkeyup="calculateMargin(${supplierIndex})"></div>
            <div class="md:col-span-2"><div class="bg-white border rounded-xl p-3 text-sm"><span class="text-slate-500">Margin:</span><span class="margin-display font-semibold ml-1">Rp 0</span></div></div>
        </div>
    </div>`;
    document.getElementById('suppliers-container').insertAdjacentHTML('beforeend', html);
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
    if (rows.length <= 1) buttons.forEach(b => b.classList.add('hidden'));
    else buttons.forEach(b => b.classList.remove('hidden'));
}
function calculateMargin(i) {
    const row = document.querySelector(`[data-index="${i}"]`);
    const beli = parseFloat(row.querySelector('.harga-beli')?.value) || 0;
    const jual = parseFloat(row.querySelector('.harga-jual')?.value) || 0;
    const margin = jual - beli;
    const display = row.querySelector('.margin-display');
    display.textContent = 'Rp ' + margin.toLocaleString('id-ID');
    display.className = 'margin-display font-semibold ml-1 ' + (margin >= 0 ? 'text-green-600' : 'text-red-600');
}
document.addEventListener('DOMContentLoaded', () => {
    updateRemoveButtons();
    @foreach($existingSuppliers as $i => $s)calculateMargin({{ $i }});@endforeach
});
</script>
@endsection
