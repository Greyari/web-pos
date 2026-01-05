@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6">Tambah Pengguna</h1>

    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Nama</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="w-full px-4 py-2 border rounded-lg @error('name') border-red-500 @enderror"
                    required
                >
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Email</label>
                <input
                    type="text"
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full px-4 py-2 border rounded-lg @error('email') border-red-500 @enderror"
                    required
                >
                @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Peran</label>
                <select name="role" class="w-full px-4 py-2 border rounded-lg @error('role') border-red-500 @enderror" required>
                    <option value="">Pilih Peran</option>
                    <option value="kasir">Kasir</option>
                    <option value="owner">Owner</option>
                </select>
                @error('role')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Password</label>
                <textarea
                    name="password"
                    rows="4"
                    class="w-full px-4 py-2 border rounded-lg"
                >{{ old('password') }}</textarea>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                    Simpan
                </button>
                <a href="{{ route('users.index') }}" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400 text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
