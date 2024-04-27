@extends('layouts.main')

@section('content')
    <div class="mt-5 ml-5 w-6/12 border border-gray-300 rounded-md">
        <div class="rounded-t-md bg-gray-300 font-medium tracking-wide px-5 py-4 text-xl">
            Edit diskon
        </div>
        <form action="{{ route('admin.diskon.update', $diskon->id) }}" method="POST" class="m-5 flex flex-col">
            @csrf
            @method('PUT')
            <div class="flex items-center mt-5">
                <label for="nominal_minimum" class="font-medium w-5/12">Minimal Pembayaran</label>
                <div class="flex flex-col w-5/12">
                    <input type="number" name="nominal_minimum" id="nominal_minimum"
                        value="{{ $diskon->minimum_transaksi }}" autofocus required
                        class="p-2 w-full border border-neutral-300 outline-neutral-400 rounded-md"
                        placeholder="Masukkan minimal pembayaran">
                    @error('nominal_minimum')
                        <label class="text-red-500 font-medium tracking-wide flex items-center">
                            <i class="bi bi-exclamation-circle mr-3"></i>
                            {{ $message }}
                        </label>
                    @enderror
                </div>
            </div>
            <div class="flex items-center mt-5">
                <label for="diskon" class="font-medium w-5/12">Diskon</label>
                <div class="flex flex-col w-5/12">
                    <div class="flex">
                        <input type="number" name="diskon" id="diskon" value="{{ $diskon->diskon }}" required
                            class="p-2 w-full border border-r-0 border-neutral-300 outline-none rounded-l-md"
                            placeholder="Masukkan diskon produk">
                        <span id="rp" class="p-2 rounded-r-md border border-l-0 border-neutral-300">%</span>
                    </div>
                    @error('diskon')
                        <label class="text-red-500 font-medium tracking-wide flex items-center">
                            <i class="bi bi-exclamation-circle mr-3"></i>
                            {{ $message }}
                        </label>
                    @enderror
                </div>
            </div>
            <div class="flex items-center mt-10">
                <a href="{{ route('admin.diskon') }}"
                    class="py-2 text-center text-white font-medium w-3/12 bg-red-500 hover:bg-red-600 rounded-md">Kembali</a>
                <button
                    class="py-2 ml-5 text-center text-white font-medium w-3/12 bg-green-500 hover:bg-green-600 rounded-md">Simpan</button>
            </div>
        </form>
    </div>
@endsection
