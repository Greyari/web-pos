<div class="bg-white rounded-4xl p-5 shadow-sm border border-gray-100 w-full flex flex-col transition-all hover:shadow-md">
    {{-- IMAGE AREA --}}
    <div class="bg-[#f8f9fa] rounded-3xl aspect-square flex items-center justify-center overflow-hidden mb-4">
        @if($image)
        <img src="{{ $image }}" alt="{{ $name }}" class="object-cover w-full h-full transition-transform hover:scale-105">
        @else
        <div class="flex flex-col items-center opacity-20">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span class="text-xs font-bold mt-1">No Image</span>
        </div>
        @endif
    </div>
    {{-- PRODUCT INFO --}}
    <div class="flex flex-col flex-1 justify-between">
        <h3 class="text-base font-bold text-[#1a1c1e] mb-3 line-clamp-2 leading-tight">
            {{ $name }}
        </h3>

        <div class="flex items-center justify-between mt-auto">
            <span class="text-lg font-black text-[#1a1c1e]">
                £{{ number_format($price, 2, ',', '.') }}
            </span>

            <button class="bg-[#1a1c1e] hover:bg-black text-white w-10 h-10 rounded-full flex items-center justify-center transition-all active:scale-90 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v12m6-6H6" />
                </svg>
            </button>
        </div>
    </div>
</div>