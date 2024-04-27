@extends('layouts.main')

@section('content')
    <div class="mt-5 mx-3 flex">
        <div class="w-3/12 py-5 px-3 rounded-md bg-white flex justify-between items-center shadow-lg">
            <div class="flex flex-col font-medium">
                <span class="font-bold text-2xl">{{ $penjualan }}</span>
                <span class="font-medium text-lg tracking-wide mt-5">Transaksi hari ini</span>
            </div>
            <i class="bi bi-cart-check-fill text-5xl"></i>
        </div>
        <div class="w-3/12 py-5 px-3 mx-3 rounded-md bg-white flex justify-between items-center shadow-lg">
            <div class="flex flex-col font-medium">
                <span class="font-bold text-2xl">{{ $produk }}</span>
                <span class="font-medium text-lg tracking-wide mt-5">Total produk</span>
            </div>
            <i class="bi bi-box-fill text-5xl"></i>
        </div>
        <div class="w-3/12 py-5 px-3 rounded-md bg-white flex justify-between items-center shadow-lg">
            <div class="flex flex-col font-medium">
                <span class="font-bold text-2xl">{{ $member }}</span>
                <span class="font-medium text-lg tracking-wide mt-5">Total member</span>
            </div>
            <i class="bi bi-person-fill text-5xl"></i>
        </div>
    </div>
@endsection
