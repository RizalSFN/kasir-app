@extends('layouts.main')

@section('content')
    <div class="m-5">
        <div class="flex items-center justify-between" id="laporan-filter">
            <form action="" method="GET" class="flex items-center">
                <label for="dari" class="font-medium mr-5">Dari : </label>
                <input type="date" name="dari" id="dari" value="{{ $dari }}"
                    class="p-2 border border-black rounded-md">
                <label for="dari" class="font-medium mx-5">Sampai : </label>
                <input type="date" name="sampai" id="sampai" value="{{ $sampai }}"
                    class="p-2 border border-black rounded-md">
                <button
                    class="p-2 bg-green-400 hover:bg-green-500 text-white font-medium rounded-md mx-5">Tampilkan</button>
            </form>
            <button type="button" onclick="print()"
                class="p-2 bg-blue-400 hover:bg-blue-500 text-white font-medium rounded-md flex items-center">
                <i class="bi bi-printer mr-3"></i>
                Cetak
            </button>
        </div>
        <div id="laporan-heading" class="hidden mb-10">
            <h1 class="w-full text-center font-bold text-2xl">LAPORAN</h1>
            <table class="w-8/12 font-medium tracking-wide mt-8">
                <tr>
                    <td class="w-3/12 py-1">Petugas</td>
                    <td class="w-1/12">:</td>
                    <td>{{ auth()->user()->name }}</td>
                </tr>
                <tr>
                    <td class="py-1">Perihal</td>
                    <td>:</td>
                    <td>Transaksi</td>
                </tr>
                <tr>
                    <td class="py-1">Periode</td>
                    <td>:</td>
                    <td>{{ $periode_dari . ' sampai ' . $periode_sampai }}</td>
                </tr>
                <tr>
                    <td class="py-1">Total Pembayaran</td>
                    <td>:</td>
                    <td>Rp <span id="total_print"></span></td>
                </tr>
                <tr>
                    <td class="py-1">Total Transaksi</td>
                    <td>:</td>
                    <td>{{ count($data) }}</td>
                </tr>
            </table>
        </div>
        <div class="mt-10 flex items-center justify-between mx-5" id="laporan-filter">
            <span class="tracking-wide">
                Total pembayaran :
                <b id="total"></b>
            </span>
            <span class="tracking-wide">
                Total transaksi :
                <b>{{ count($data) }}</b>
            </span>
        </div>
        <table class="mt-2 border border-gray-200 text-center w-full">
            <thead>
                <tr class="bg-gray-200 text-neutral-400 font-medium text-sm">
                    <td class="w-1/12 py-3">ID TRANSAKSI</td>
                    <td class="w-1/12 py-3">MEMBER</td>
                    <td class="w-2/12 py-3">TOTAL HARGA</td>
                    <td class="w-2/12 py-3">POTONGAN MEMBER</td>
                    <td class="w-2/12 py-3">WAKTU</td>
                    <td class="w-1/12 py-3" id="hidden-print">STATUS</td>
                    <td class="w-1/12 py-3" id="hidden-print">AKSI</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($new_data as $transaksi)
                    <tr class="border-b border-gray-200">
                        <td class="py-3">{{ $transaksi->id_penjualan }}</td>
                        <td class="py-3">{{ $transaksi->member_id ? $transaksi->member->nama : '-' }}</td>
                        <td class="py-3">Rp {{ $transaksi->total_harga_new }}</td>
                        <td class="hidden total_harga">{{ $transaksi->total_harga }}</td>
                        <td class="py-3">Rp {{ $transaksi->potongan_member ? $transaksi->potongan_member : '-' }}</td>
                        <td class="py-3">{{ $transaksi->created_at }}</td>
                        <td class="py-3" id="hidden-print">
                            <span
                                class="px-2 pt-1 pb-1.5 border {{ $transaksi->status == 'selesai' ? 'text-green-500 border-green-500 bg-green-100' : 'text-red-500 border-red-500 bg-red-100' }} font-medium rounded-md">{{ $transaksi->status }}</span>
                        </td>
                        <td class="py-3" id="hidden-print">
                            <a href="{{ route('admin.transaksi.struk', $transaksi->id_penjualan) }}"
                                class="py-2 px-4 text-white bg-green-400 hover:bg-green-500 rounded-md">
                                <i class="bi bi-printer"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                @if ($message != '')
                    <tr class="border-b border-gray-200">
                        <td class="py-3 font-medium" colspan="7">{{ $message }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function() {
            function updateTotalHarga() {
                let total = 0;

                $('.total_harga').each(function() {
                    total += parseFloat($(this).text())
                })

                $('#total').text($.number(total, 2, ',', '.'))
                $('#total_print').text($.number(total, 2, ',', '.'))
            }

            updateTotalHarga()

            $(document).on('input', '.total_harga', function() {
                updateTotalHarga()
            })
        })
    </script>
@endsection
