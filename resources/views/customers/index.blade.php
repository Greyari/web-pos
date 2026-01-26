@extends('layouts.app')

@section('title', 'Manajemen Customer')

@section('content')
<div class="px-5">
    <div class="flex justify-between items-center mb-2">
        <h1 class="text-2xl font-semibold mb-6 tracking-tight">Manajemen Customer</h1>
        <a href="{{ route('customers.create') }}" class="bg-blue-950 text-white px-4 py-2 rounded-lg hover:bg-blue-900">
            <i class="fas fa-plus mr-2"></i>Customer
        </a>
    </div>

    <div class="mb-4">
        <form action="{{ route('customers.index') }}" method="GET">
            <div class="flex gap-2">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari customer..."
                    class="placeholder:text-sm flex-1 px-4 py-2 border border-gray-300 rounded-lg">
                <button type="submit" class="bg-blue-950 text-white px-6 py-2 rounded-lg hover:bg-blue-900">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100 text-gray-800">
                <tr>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Telepon</th>
                    <th class="px-4 py-3 text-left">Alamat</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="px-4 py-3 text-gray-600 text-sm">{{ $customer->name }}</td>
                    <td class="px-4 py-3 text-gray-600 text-sm">{{ $customer->email }}</td>
                    <td class="px-4 py-3 text-gray-600 text-sm">{{ $customer->phone }}</td>
                    <td class="px-4 py-3 text-gray-600 text-sm">{{ $customer->address }}</td>
                    <td class="px-4 py-3 ">
                        <div class="flex gap-2">
                            <a href="{{ route('customers.edit', $customer) }}" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('customers.destroy', $customer) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $customers->links() }}
    </div>
</div>
@endsection