@extends('layouts.app')

@section('title', 'Simulasi Rakit PC')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6">Simulasi Rakit PC</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-4">
            <!-- Processor -->
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="font-bold text-lg mb-3 flex items-center">
                    <i class="fas fa-microchip mr-2 text-blue-600"></i>
                    Processor
                </h3>
                <select id="processor" class="w-full px-4 py-2 border rounded-lg">
                    <option value="">Pilih Processor</option>
                    @foreach($components['processors'] as $item)
                    <option value="{{ $item->id }}" data-price="{{ $item->price }}" data-name="{{ $item->name }}">
                        {{ $item->name }} - Rp {{ number_format($item->price) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- VGA Card -->
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="font-bold text-lg mb-3 flex items-center">
                    <i class="fas fa-tv mr-2 text-green-600"></i>
                    VGA Card
                </h3>
                <select id="vga" class="w-full px-4 py-2 border rounded-lg">
                    <option value="">Pilih VGA Card</option>
                    @foreach($components['vgas'] as $item)
                    <option value="{{ $item->id }}" data-price="{{ $item->price }}" data-name="{{ $item->name }}">
                        {{ $item->name }} - Rp {{ number_format($item->price) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- RAM -->
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="font-bold text-lg mb-3 flex items-center">
                    <i class="fas fa-memory mr-2 text-purple-600"></i>
                    RAM
                </h3>
                <select id="ram" class="w-full px-4 py-2 border rounded-lg">
                    <option value="">Pilih RAM</option>
                    @foreach($components['rams'] as $item)
                    <option value="{{ $item->id }}" data-price="{{ $item->price }}" data-name="{{ $item->name }}">
                        {{ $item->name }} - Rp {{ number_format($item->price) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Storage -->
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="font-bold text-lg mb-3 flex items-center">
                    <i class="fas fa-hdd mr-2 text-orange-600"></i>
                    Storage
                </h3>
                <select id="storage" class="w-full px-4 py-2 border rounded-lg">
                    <option value="">Pilih Storage</option>
                    @foreach($components['storages'] as $item)
                    <option value="{{ $item->id }}" data-price="{{ $item->price }}" data-name="{{ $item->name }}">
                        {{ $item->name }} - Rp {{ number_format($item->price) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Motherboard -->
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="font-bold text-lg mb-3 flex items-center">
                    <i class="fas fa-server mr-2 text-red-600"></i>
                    Motherboard
                </h3>
                <select id="motherboard" class="w-full px-4 py-2 border rounded-lg">
                    <option value="">Pilih Motherboard</option>
                    @foreach($components['motherboards'] as $item)
                    <option value="{{ $item->id }}" data-price="{{ $item->price }}" data-name="{{ $item->name }}">
                        {{ $item->name }} - Rp {{ number_format($item->price) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Power Supply -->
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="font-bold text-lg mb-3 flex items-center">
                    <i class="fas fa-bolt mr-2 text-yellow-600"></i>
                    Power Supply
                </h3>
                <select id="psu" class="w-full px-4 py-2 border rounded-lg">
                    <option value="">Pilih Power Supply</option>
                    @foreach($components['psus'] as $item)
                    <option value="{{ $item->id }}" data-price="{{ $item->price }}" data-name="{{ $item->name }}">
                        {{ $item->name }} - Rp {{ number_format($item->price) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Casing -->
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="font-bold text-lg mb-3 flex items-center">
                    <i class="fas fa-box mr-2 text-gray-600"></i>
                    Casing
                </h3>
                <select id="casing" class="w-full px-4 py-2 border rounded-lg">
                    <option value="">Pilih Casing</option>
                    @foreach($components['casings'] as $item)
                    <option value="{{ $item->id }}" data-price="{{ $item->price }}" data-name="{{ $item->name }}">
                        {{ $item->name }} - Rp {{ number_format($item->price) }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Summary Panel -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6 sticky top-6">
                <h2 class="text-2xl font-bold mb-4">Ringkasan Build</h2>

                <div id="build-summary" class="space-y-2 mb-4 min-h-[200px]">
                    <p class="text-gray-500 italic">Pilih komponen untuk memulai</p>
                </div>

                <div class="border-t pt-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-semibold">Total:</span>
                        <span id="total-price" class="text-2xl font-bold text-blue-600">Rp 0</span>
                    </div>
                </div>

                <button onclick="resetBuild()" class="w-full bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400 mt-4">
                    Reset Build
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let buildComponents = {
    processor: null,
    vga: null,
    ram: null,
    storage: null,
    motherboard: null,
    psu: null,
    casing: null
};

function updateBuildSummary() {
    const summary = document.getElementById('build-summary');
    const totalPrice = document.getElementById('total-price');

    let html = '';
    let total = 0;

    for (const [key, value] of Object.entries(buildComponents)) {
        if (value) {
            html += `<div class="flex justify-between text-sm border-b pb-2">
                <span class="font-medium">${value.name}</span>
                <span>Rp ${parseInt(value.price).toLocaleString('id-ID')}</span>
            </div>`;
            total += parseFloat(value.price);
        }
    }

    if (html === '') {
        html = '<p class="text-gray-500 italic">Pilih komponen untuk memulai</p>';
    }

    summary.innerHTML = html;
    totalPrice.textContent = 'Rp ' + total.toLocaleString('id-ID');
}

document.querySelectorAll('select[id]').forEach(select => {
    select.addEventListener('change', function() {
        const componentType = this.id;
        const selectedOption = this.options[this.selectedIndex];

        if (selectedOption.value) {
            buildComponents[componentType] = {
                name: selectedOption.getAttribute('data-name'),
                price: selectedOption.getAttribute('data-price')
            };
        } else {
            buildComponents[componentType] = null;
        }

        updateBuildSummary();
    });
});

function resetBuild() {
    if (confirm('Yakin ingin reset build?')) {
        buildComponents = {
            processor: null,
            vga: null,
            ram: null,
            storage: null,
            motherboard: null,
            psu: null,
            casing: null
        };

        document.querySelectorAll('select[id]').forEach(select => {
            select.value = '';
        });

        updateBuildSummary();
    }
}
</script>
@endsection
