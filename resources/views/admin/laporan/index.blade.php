@extends('layouts.main')

@section('content')
    <div class="mx-5 mt-5 mb-10">
        <form action="" method="GET" class="flex items-center" id="laporan-filter">
            <label for="dari" class="font-medium mr-5">Dari : </label>
            <input type="date" name="dari" id="dari" value="{{ $dari }}"
                class="p-2 border border-black rounded-md">
            <label for="sampai" class="font-medium mx-5">Sampai : </label>
            <input type="date" name="sampai" id="sampai" value="{{ $sampai }}"
                class="p-2 border border-black rounded-md">
            <select name="kategori" id="kategori" class="p-2 border border-black rounded-md ml-5">
                <option value="stok_masuk" {{ $kategori == 'stok_masuk' ? 'selected' : '' }}>Stok Masuk</option>
                <option value="stok_keluar" {{ $kategori == 'stok_keluar' ? 'selected' : '' }}>Stok Keluar</option>
            </select>
            <button class="p-2 bg-green-400 hover:bg-green-500 text-white font-medium rounded-md mx-5">Tampilkan</button>
            <button type="button" onclick="print()"
                class="p-2 bg-blue-400 hover:bg-blue-500 text-white font-medium rounded-md flex items-center">
                <i class="bi bi-printer mr-3"></i>
                Cetak
            </button>
        </form>
        <div id="laporan-heading" class="hidden">
            <h1 class="w-full text-center font-bold text-2xl">LAPORAN PETUGAS</h1>
            <table class="w-8/12 font-medium tracking-wide mt-8">
                <tr>
                    <td class="w-3/12 py-1">Petugas</td>
                    <td class="w-1/12">:</td>
                    <td>{{ auth()->user()->name }}</td>
                </tr>
                <tr>
                    <td class="py-1">Perihal</td>
                    <td>:</td>
                    <td>{{ $kategori == 'stok_masuk' ? 'Pemasukan Stok Barang' : 'Pengeluaran Stok Barang' }}</td>
                </tr>
                <tr>
                    <td class="py-1">Periode</td>
                    <td>:</td>
                    <td>{{ $periode_dari . ' sampai ' . $periode_sampai }}</td>
                </tr>
            </table>
        </div>
        <table class="mt-10 border border-gray-200 text-center w-full">
            <thead>
                <tr class="bg-gray-200 text-neutral-400 font-medium text-sm">
                    <td class="w-1/12 py-3">ID PRODUK</td>
                    <td class="w-2/12 py-3">NAMA PRODUK</td>
                    @if ($kategori == 'stok_masuk')
                        <td class="w-1/12 py-3">STOK MASUK</td>
                    @else
                        <td class="w-1/12 py-3">STOK KELUAR</td>
                    @endif
                    <td class="w-1/12 py-3">PELAKU</td>
                    <td class="w-2/12 py-3">WAKTU</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $d)
                    <tr class="border-b border-gray-200">
                        <td class="py-3">{{ $d->produk_id }}</td>
                        <td class="py-3">{{ $d->produk->nama }}</td>
                        @if ($kategori == 'stok_masuk')
                            <td class="w-1/12 py-3">{{ $d->stok_masuk }}</td>
                        @else
                            <td class="w-1/12 py-3">{{ $d->stok_keluar }}</td>
                        @endif
                        <td class="py-3">{{ $d->users->name }}</td>
                        <td class="py-3">{{ $d->created_at }}</td>
                    </tr>
                @endforeach
                @if ($message != '')
                    <tr class="border-b border-gray-200">
                        <td class="py-3 font-medium" colspan="6">{{ $message }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection
