@extends('layouts.main')

@section('content')
    <div class="mt-5 mx-3 flex">
        <div class="w-3/12 py-5 px-3 rounded-md bg-white flex justify-between items-center shadow-lg">
            <div class="flex flex-col font-medium">
                <span class="font-bold text-2xl">{{ count($penjualan) }}</span>
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
        <div class="w-3/12 py-5 px-3 mr-3 rounded-md bg-white flex justify-between items-center shadow-lg">
            <div class="flex flex-col font-medium">
                <span class="font-bold text-2xl">{{ $member }}</span>
                <span class="font-medium text-lg tracking-wide mt-5">Total member</span>
            </div>
            <i class="bi bi-person-fill text-5xl"></i>
        </div>
        <div class="w-3/12 py-5 px-3 rounded-md bg-white flex justify-between items-center shadow-lg">
            <div class="flex flex-col font-medium">
                <span class="font-bold text-2xl">{{ $petugas }}</span>
                <span class="font-medium text-lg tracking-wide mt-5">Total petugas</span>
            </div>
            <i class="bi bi-person-badge-fill text-5xl"></i>
        </div>
    </div>
    <div class="mt-5 mx-3 pr-6 flex">
        <div class="w-3/12 py-5 px-3 mr-1 rounded-md bg-white flex justify-between items-center shadow-lg">
            <div class="flex flex-col font-medium">
                <span class="font-bold text-2xl">Rp <span id="total_pendapatan">0</span></span>
                <span class="font-medium text-lg tracking-wide mt-5">Pendapatan hari ini</span>
            </div>
            <i class="bi bi-cash text-5xl"></i>
        </div>
        @foreach ($penjualan as $p)
            <span class="pendapatan hidden">{{ $p->total_harga }}</span>
        @endforeach
    </div>
    <script>
        $(document).ready(function() {
            function updatePendapatan() {
                let total = 0

                $('.pendapatan').each(function() {
                    total += parseFloat($(this).text())
                })

                $('#total_pendapatan').text($.number(total, 2, ',', '.'))
            }

            updatePendapatan()

            $(document).on('input', '.pendapatan', function() {
                updatePendapatan()
            })
        })
    </script>
@endsection
