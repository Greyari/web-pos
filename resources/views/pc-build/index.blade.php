@extends('layouts.app')

@section('title', 'Simulasi Rakit PC')

@section('content')
<div class="px-5">

    {{-- HEADER --}}
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-800">
                Simulasi Rakit PC
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Estimasi biaya & kompatibilitas komponen PC
            </p>
        </div>

        <button onclick="resetBuild()"
            class="px-4 py-2 rounded-xl bg-slate-100 text-sm font-medium text-slate-600 hover:bg-slate-200 transition">
            Reset Build
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        {{-- LEFT: COMPONENT SELECTOR --}}
        <div class="lg:col-span-2 space-y-6" id="component-selector">

            @foreach(['Processor', 'Motherboard', 'RAM', 'VGA Card', 'Storage', 'Power Supply', 'Casing'] as $category)
            <div class="bg-white rounded-2xl shadow-sm p-5">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs uppercase tracking-wide text-slate-400">
                        {{ $category }}
                    </p>
                    <button onclick="openSelector('{{ $category }}')"
                        class="px-4 py-2 rounded-xl bg-slate-900 text-white text-sm hover:bg-slate-800 transition">
                        Pilih
                    </button>
                </div>

                <div id="selected-{{ str_replace(' ', '-', strtolower($category)) }}" class="min-h-[60px]">
                    <p class="text-slate-400 text-sm">Belum dipilih</p>
                </div>
            </div>
            @endforeach

            {{-- COMPATIBILITY INFO --}}
            <div id="compatibility-status" class="hidden">
                <!-- Will be filled by JavaScript -->
            </div>
        </div>

        {{-- RIGHT: BUILD SUMMARY --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 flex flex-col sticky top-6">

            <h2 class="text-lg font-semibold text-slate-800 mb-4">
                Ringkasan Build
            </h2>

            {{-- SUMMARY LIST --}}
            <div id="summary-list" class="space-y-3 flex-1 text-sm">
                <p class="text-slate-400 text-center py-8">Belum ada komponen dipilih</p>
            </div>

            {{-- POWER ESTIMATION --}}
            <div id="power-estimate" class="mt-6 bg-slate-50 rounded-xl p-4 text-sm hidden">
                <div class="flex justify-between mb-1">
                    <span class="text-slate-500">Estimasi Daya</span>
                    <span class="font-medium" id="total-power">0W</span>
                </div>
                <p class="text-xs text-slate-400" id="psu-recommendation">
                    <!-- Filled by JS -->
                </p>
            </div>

            {{-- TOTAL --}}
            <div class="mt-6 pt-4 border-t">
                <div class="flex justify-between text-lg font-semibold">
                    <span>Total Estimasi</span>
                    <span id="total-price">Rp 0</span>
                </div>

                <button onclick="saveBuild()"
                    class="w-full mt-5 py-3 rounded-xl bg-slate-900 text-white text-sm hover:bg-slate-800 transition disabled:bg-slate-300 disabled:cursor-not-allowed"
                    id="save-btn" disabled>
                    Simpan Build
                </button>
            </div>
        </div>

    </div>
</div>

{{-- MODAL SELECTOR --}}
<div id="component-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-4xl w-full max-h-[80vh] overflow-hidden flex flex-col">

        {{-- Modal Header --}}
        <div class="p-6 border-b flex items-center justify-between">
            <h3 class="text-xl font-semibold" id="modal-title">Pilih Komponen</h3>
            <button onclick="closeSelector()" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Search --}}
        <div class="p-4 border-b">
            <input type="text" id="search-component" placeholder="Cari produk..."
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900">
        </div>

        {{-- Modal Body --}}
        <div class="flex-1 overflow-y-auto p-6">
            <div id="component-list" class="space-y-3">
                <!-- Will be filled by JavaScript -->
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
let currentBuild = {
    processor: null,
    motherboard: null,
    ram: null,
    'vga card': null,
    storage: null,
    'power supply': null,
    casing: null
};

let currentCategory = '';
let allProducts = @json($productsByCategory);

function openSelector(category) {
    currentCategory = category;
    document.getElementById('modal-title').textContent = `Pilih ${category}`;
    document.getElementById('component-modal').classList.remove('hidden');

    loadCompatibleProducts(category);
}

function closeSelector() {
    document.getElementById('component-modal').classList.add('hidden');
    document.getElementById('search-component').value = '';
}

function loadCompatibleProducts(category) {
    const categoryKey = category.toLowerCase().replace(' ', '_');
    const products = allProducts[category] || [];

    const listHtml = products.length > 0 ? products.map(product => {
        const price = product.suppliers && product.suppliers.length > 0
            ? Math.min(...product.suppliers.map(s => parseFloat(s.pivot.harga_jual)))
            : 0;

        const specs = getProductSpecs(product);

        return `
            <div class="border rounded-xl p-4 hover:border-slate-900 transition cursor-pointer"
                onclick="selectComponent('${category}', ${product.id}, '${product.name}', ${price})">
                <div class="flex justify-between items-start mb-2">
                    <div class="flex-1">
                        <h4 class="font-semibold text-slate-800">${product.name}</h4>
                        ${specs ? `<p class="text-xs text-slate-500 mt-1">${specs}</p>` : ''}
                    </div>
                    <p class="text-sm font-semibold text-slate-900 ml-4">
                        ${formatRupiah(price)}
                    </p>
                </div>
                ${product.description ? `<p class="text-sm text-slate-600 mt-2">${product.description}</p>` : ''}
            </div>
        `;
    }).join('') : '<p class="text-center text-slate-400 py-8">Tidak ada produk tersedia</p>';

    document.getElementById('component-list').innerHTML = listHtml;
}

function getProductSpecs(product) {
    const specs = [];

    if (product.socket) specs.push(`Socket: ${product.socket}`);
    if (product.tdp) specs.push(`TDP: ${product.tdp}W`);
    if (product.chipset) specs.push(`Chipset: ${product.chipset}`);
    if (product.ram_type) specs.push(`RAM: ${product.ram_type}`);
    if (product.ram_generation) specs.push(`${product.ram_generation} ${product.ram_speed}MHz ${product.ram_capacity}GB`);
    if (product.vga_power_consumption) specs.push(`Power: ${product.vga_power_consumption}W`);
    if (product.storage_type) specs.push(`${product.storage_type} ${product.storage_capacity}GB`);
    if (product.psu_wattage) specs.push(`${product.psu_wattage}W ${product.psu_efficiency || ''}`);
    if (product.form_factor) specs.push(`Form Factor: ${product.form_factor}`);

    return specs.join(' • ');
}

function selectComponent(category, id, name, price) {
    const categoryKey = category.toLowerCase().replace(' ', '-');
    const buildKey = category.toLowerCase().replace(' ', ' ');

    currentBuild[buildKey] = id;

    // Update display
    const selectedDiv = document.getElementById(`selected-${categoryKey}`);
    selectedDiv.innerHTML = `
        <p class="font-medium text-slate-800">${name}</p>
        <p class="text-sm text-slate-500 mt-1">${formatRupiah(price)}</p>
    `;

    closeSelector();
    updateSummary();
    checkCompatibility();
}

function updateSummary() {
    let summaryHtml = '';
    let totalPrice = 0;
    let hasComponents = false;

    for (const [category, productId] of Object.entries(currentBuild)) {
        if (productId) {
            hasComponents = true;
            const categoryName = category.charAt(0).toUpperCase() + category.slice(1);
            const categoryProducts = allProducts[categoryName] || [];
            const product = categoryProducts.find(p => p.id === productId);

            if (product) {
                const price = product.suppliers && product.suppliers.length > 0
                    ? Math.min(...product.suppliers.map(s => parseFloat(s.pivot.harga_jual)))
                    : 0;

                totalPrice += price;

                summaryHtml += `
                    <div class="flex justify-between">
                        <span class="text-slate-500">${categoryName}</span>
                        <span>${formatRupiah(price)}</span>
                    </div>
                `;
            }
        }
    }

    if (!hasComponents) {
        summaryHtml = '<p class="text-slate-400 text-center py-8">Belum ada komponen dipilih</p>';
    }

    document.getElementById('summary-list').innerHTML = summaryHtml;
    document.getElementById('total-price').textContent = formatRupiah(totalPrice);
    document.getElementById('save-btn').disabled = !hasComponents;
}

function checkCompatibility() {
    // Simple client-side compatibility check
    const processor = getSelectedProduct('processor');
    const motherboard = getSelectedProduct('motherboard');
    const ram = getSelectedProduct('ram');
    const psu = getSelectedProduct('power supply');

    let issues = [];
    let warnings = [];
    let totalPower = 0;

    // Check socket compatibility
    if (processor && motherboard) {
        if (processor.socket !== motherboard.socket) {
            issues.push(`Socket tidak kompatibel! Processor (${processor.socket}) tidak cocok dengan Motherboard (${motherboard.socket})`);
        }
    }

    // Check RAM compatibility
    if (ram && motherboard) {
        if (ram.ram_generation !== motherboard.ram_type) {
            issues.push(`Tipe RAM tidak kompatibel! RAM ${ram.ram_generation} tidak cocok dengan Motherboard ${motherboard.ram_type}`);
        }
    }

    // Calculate power
    if (processor && processor.tdp) totalPower += processor.tdp;
    const vga = getSelectedProduct('vga card');
    if (vga && vga.vga_power_consumption) totalPower += vga.vga_power_consumption;
    totalPower += 80; // Motherboard, RAM, Storage estimation

    // Check PSU
    if (psu) {
        const recommended = Math.ceil(totalPower * 1.2);
        if (psu.psu_wattage < recommended) {
            issues.push(`PSU tidak mencukupi! Direkomendasikan minimal ${recommended}W, PSU Anda: ${psu.psu_wattage}W`);
        }
    }

    // Update display
    const statusDiv = document.getElementById('compatibility-status');
    if (issues.length > 0) {
        statusDiv.className = 'bg-red-50 border border-red-100 rounded-2xl p-5';
        statusDiv.innerHTML = `
            <p class="text-sm font-medium text-red-700 mb-2">⚠ Terdapat masalah kompatibilitas:</p>
            <ul class="text-xs text-red-600 space-y-1 ml-4">
                ${issues.map(issue => `<li>• ${issue}</li>`).join('')}
            </ul>
        `;
        statusDiv.classList.remove('hidden');
    } else if (warnings.length > 0) {
        statusDiv.className = 'bg-yellow-50 border border-yellow-100 rounded-2xl p-5';
        statusDiv.innerHTML = `
            <p class="text-sm font-medium text-yellow-700 mb-2">⚡ Perhatian:</p>
            <ul class="text-xs text-yellow-600 space-y-1 ml-4">
                ${warnings.map(warning => `<li>• ${warning}</li>`).join('')}
            </ul>
        `;
        statusDiv.classList.remove('hidden');
    } else if (hasAnyComponent()) {
        statusDiv.className = 'bg-emerald-50 border border-emerald-100 rounded-2xl p-5';
        statusDiv.innerHTML = `
            <p class="text-sm font-medium text-emerald-700">✓ Semua komponen kompatibel</p>
            <p class="text-xs text-emerald-600 mt-1">Socket, RAM type, dan daya PSU mencukupi</p>
        `;
        statusDiv.classList.remove('hidden');
    } else {
        statusDiv.classList.add('hidden');
    }

    // Update power estimate
    if (totalPower > 0) {
        document.getElementById('power-estimate').classList.remove('hidden');
        document.getElementById('total-power').textContent = `${totalPower}W`;
        document.getElementById('psu-recommendation').textContent =
            `PSU ${Math.ceil(totalPower * 1.3)}W direkomendasikan`;
    }
}

function getSelectedProduct(category) {
    const productId = currentBuild[category];
    if (!productId) return null;

    const categoryName = category.charAt(0).toUpperCase() + category.slice(1);
    const categoryProducts = allProducts[categoryName] || [];
    return categoryProducts.find(p => p.id === productId);
}

function hasAnyComponent() {
    return Object.values(currentBuild).some(id => id !== null);
}

function resetBuild() {
    if (confirm('Reset semua komponen yang dipilih?')) {
        currentBuild = {
            processor: null,
            motherboard: null,
            ram: null,
            'vga card': null,
            storage: null,
            'power supply': null,
            casing: null
        };

        // Reset displays
        document.querySelectorAll('[id^="selected-"]').forEach(div => {
            div.innerHTML = '<p class="text-slate-400 text-sm">Belum dipilih</p>';
        });

        updateSummary();
        document.getElementById('compatibility-status').classList.add('hidden');
        document.getElementById('power-estimate').classList.add('hidden');
    }
}

function saveBuild() {
    const buildName = prompt('Nama build:');
    if (!buildName) return;

    fetch('{{ route("pc-build.save") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            build_name: buildName,
            processor_id: currentBuild.processor,
            motherboard_id: currentBuild.motherboard,
            ram_id: currentBuild.ram,
            vga_id: currentBuild['vga card'],
            storage_id: currentBuild.storage,
            psu_id: currentBuild['power supply'],
            casing_id: currentBuild.casing
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Build berhasil disimpan!');
            resetBuild();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal menyimpan build');
    });
}

function formatRupiah(number) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(number);
}

// Search functionality
document.getElementById('search-component').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const products = allProducts[currentCategory] || [];

    const filtered = products.filter(p =>
        p.name.toLowerCase().includes(searchTerm) ||
        (p.description && p.description.toLowerCase().includes(searchTerm))
    );

    const listHtml = filtered.map(product => {
        const price = product.suppliers && product.suppliers.length > 0
            ? Math.min(...product.suppliers.map(s => parseFloat(s.pivot.harga_jual)))
            : 0;

        const specs = getProductSpecs(product);

        return `
            <div class="border rounded-xl p-4 hover:border-slate-900 transition cursor-pointer"
                onclick="selectComponent('${currentCategory}', ${product.id}, '${product.name}', ${price})">
                <div class="flex justify-between items-start mb-2">
                    <div class="flex-1">
                        <h4 class="font-semibold text-slate-800">${product.name}</h4>
                        ${specs ? `<p class="text-xs text-slate-500 mt-1">${specs}</p>` : ''}
                    </div>
                    <p class="text-sm font-semibold text-slate-900 ml-4">
                        ${formatRupiah(price)}
                    </p>
                </div>
            </div>
        `;
    }).join('');

    document.getElementById('component-list').innerHTML = listHtml ||
        '<p class="text-center text-slate-400 py-8">Tidak ada hasil</p>';
});
</script>
@endpush
