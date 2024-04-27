@extends('layouts.main')

@section('content')
    <div class="mt-5 ml-5 w-6/12 border border-gray-300 rounded-md">
        <div class="rounded-t-md bg-gray-300 font-medium tracking-wide px-5 py-4 text-xl">
            Edit produk
        </div>
        <form action="{{ route('admin.produk.update', $produk->id_produk) }}" method="POST" class="m-5 flex flex-col">
            @csrf
            @method('PUT')
            <input type="hidden" id="id_produk" value="{{ $produk->id_produk }}">
            <div class="flex items-center mt-5">
                <label for="nama_produk" class="font-medium w-5/12">Nama Produk</label>
                <div class="flex flex-col w-5/12">
                    <input type="text" name="nama_produk" id="nama_produk" value="{{ $produk->nama }}" autofocus required
                        class="p-2 w-full border border-neutral-300 outline-neutral-400 rounded-md"
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
                        <input type="number" name="harga_produk" id="harga_produk" value="{{ $produk->harga }}" required
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
                <label for="diskon_produk" class="font-medium w-5/12">Diskon</label>
                <div class="flex flex-col w-5/12">
                    <div class="flex">
                        <input type="number" name="diskon_produk" id="diskon_produk" value="{{ $produk->diskon }}" required
                            class="p-2 w-full border border-r-0 border-neutral-300 outline-none rounded-l-md"
                            placeholder="Masukkan diskon produk">
                        <span id="rp" class="p-2 rounded-r-md border border-l-0 border-neutral-300">%</span>
                    </div>
                    @error('diskon_produk')
                        <label class="text-red-500 font-medium tracking-wide flex items-center">
                            <i class="bi bi-exclamation-circle mr-3"></i>
                            {{ $message }}
                        </label>
                    @enderror
                </div>
            </div>
            <div class="flex items-center mt-5">
                <label for="tambah_stok_produk" class="font-medium w-5/12">Tambah Stok Produk</label>
                <div class="flex flex-col w-5/12">
                    <input type="number" name="tambah_stok_produk" id="tambah_stok_produk"
                        class="p-2 w-full border border-neutral-300 outline-neutral-400 rounded-md"
                        placeholder="Masukkan penambahan stok produk">
                    @error('tambah_stok_produk')
                        <label class="text-red-500 font-medium tracking-wide flex items-center">
                            <i class="bi bi-exclamation-circle mr-3"></i>
                            {{ $message }}
                        </label>
                    @enderror
                </div>
            </div>
            <div class="flex items-center mt-5">
                <label for="kurang_stok_produk" class="font-medium w-5/12">Kurang Stok Produk</label>
                <div class="flex flex-col w-5/12">
                    <input type="number" name="kurang_stok_produk" id="kurang_stok_produk"
                        class="p-2 w-full border border-neutral-300 outline-neutral-400 rounded-md"
                        placeholder="Masukkan pengurangan stok produk">
                    @error('kurang_stok_produk')
                        <label class="text-red-500 font-medium tracking-wide flex items-center">
                            <i class="bi bi-exclamation-circle mr-3"></i>
                            {{ $message }}
                        </label>
                    @enderror
                </div>
            </div>
            <div class="flex items-center mt-10">
                <a href="{{ route('admin.produk') }}"
                    class="py-2 text-center text-white font-medium w-3/12 bg-red-500 hover:bg-red-600 rounded-md">Kembali</a>
                <button id="simpan-btn"
                    class="py-2 ml-5 text-center text-white font-medium w-3/12 bg-green-500 hover:bg-green-600 rounded-md">Simpan</button>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            $('#tambah_stok_produk').on('input', function() {
                if ($(this).val() != '') {
                    $('#kurang_stok_produk').attr('disabled', 'true').addClass(
                        'cursor-not-allowed bg-gray-300')
                } else {
                    $('#kurang_stok_produk').removeAttr('disabled').removeClass(
                        'cursor-not-allowed bg-gray-300')
                }
            })

            $('#kurang_stok_produk').on('input', function() {
                if ($(this).val() != '') {
                    $('#tambah_stok_produk').attr('disabled', 'true').addClass(
                        'cursor-not-allowed bg-gray-300')
                } else {
                    $('#tambah_stok_produk').removeAttr('disabled').removeClass(
                        'cursor-not-allowed bg-gray-300')
                }
                let s = $(this).val()
                $.ajax({
                    url: '/produk/stok/' + $('#id_produk').val(),
                    type: 'GET',
                    success: function(stok) {
                        if (stok.stok < s) {
                            $('#stok-alert').removeClass('hidden')
                            $('#simpan-btn').addClass('cursor-not-allowed').attr('disabled',
                                'true')
                        } else {
                            $('#stok-alert').addClass('hidden')
                            $('#simpan-btn').removeClass('cursor-not-allowed').RemoveAttr(
                                'disabled')
                        }
                    },
                    error: function(err) {
                        console.error(err);
                    }
                })
            })
        })
    </script>
@endsection
