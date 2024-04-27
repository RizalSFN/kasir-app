@extends('layouts.main')

@section('content')
    <div class="mt-5 ml-5 w-6/12 border border-gray-300 rounded-md">
        <div class="rounded-t-md bg-gray-300 font-medium tracking-wide px-5 py-4 text-xl">
            Tambah produk
        </div>
        @if (session('success'))
            <div
                class="px-4 mb-3 ml-5 py-2 w-6/12 mt-5 flex items-center font-medium tracking-wide bg-green-100 border border-green-500 text-green-500 rounded-md">
                <i class="bi bi-check2-circle mr-3"></i>
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('petugas.produk.store') }}" method="POST" class="m-5 flex flex-col">
            @csrf
            <div class="flex items-center">
                <label for="id_produk" class="font-medium w-5/12">ID Produk</label>
                <input type="text" name="id_produk" id="id_produk" value="{{ $new_id }}" readonly
                    class="bg-gray-200 p-2 w-5/12 outline-none rounded-md">
            </div>
            <div class="flex items-center mt-5">
                <label for="nama_produk" class="font-medium w-5/12">Nama Produk</label>
                <div class="flex flex-col w-5/12">
                    <input type="text" name="nama_produk" id="nama_produk" autofocus required
                        class="p-2 border border-neutral-300 outline-neutral-400 rounded-md"
                        placeholder="Masukkan nama produk">
                    @error('nama_produk')
                        <label class="text-red-500 font-medium tracking-wide flex items-center">
                            <i class="bi bi-exclamation-circle mr-3"></i>
                            {{ $message }}
                        </label>
                    @enderror
                </div>
            </div>
            <div class="flex items-center mt-5">
                <label for="harga_produk" class="font-medium w-5/12">Harga Produk</label>
                <div class="flex flex-col w-5/12">
                    <div class="flex">
                        <span id="rp" class="p-2 rounded-l-md border border-r-0 border-neutral-300">Rp</span>
                        <input type="number" name="harga_produk" id="harga_produk" required
                            class="p-2 w-full border border-l-0 border-neutral-300 outline-none rounded-r-md"
                            placeholder="Masukkan harga produk">
                    </div>
                    @error('harga_produk')
                        <label class="text-red-500 font-medium tracking-wide flex items-center">
                            <i class="bi bi-exclamation-circle mr-3"></i>
                            {{ $message }}
                        </label>
                    @enderror
                </div>
            </div>
            <div class="flex items-center mt-5">
                <label for="stok_produk" class="font-medium w-5/12">Stok Produk</label>
                <div class="flex flex-col w-5/12">
                    <input type="number" name="stok_produk" id="stok_produk" required
                        class="p-2 w-full border border-neutral-300 outline-neutral-400 rounded-md"
                        placeholder="Masukkan stok produk">
                    @error('stok_produk')
                        <label class="text-red-500 font-medium tracking-wide flex items-center">
                            <i class="bi bi-exclamation-circle mr-3"></i>
                            {{ $message }}
                        </label>
                    @enderror
                </div>
            </div>
            <div class="flex items-center mt-10">
                <a href="{{ route('petugas.produk') }}"
                    class="py-2 text-center text-white font-medium w-3/12 bg-red-500 hover:bg-red-600 rounded-md">Kembali</a>
                <button
                    class="py-2 ml-5 text-center text-white font-medium w-3/12 bg-green-500 hover:bg-green-600 rounded-md">Simpan</button>
            </div>
        </form>
    </div>
@endsection
