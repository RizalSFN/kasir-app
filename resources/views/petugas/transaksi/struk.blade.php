@extends('layouts.app')

@section('component')
    <div class="flex mt-5 mx-5">
        <div class="flex flex-col w-5/12" id="hidden-print">
            @if (session('id'))
                <a href="{{ route('petugas.transaksi.proses') }}"
                    class="py-2 text-center text-white font-medium w-4/12 bg-red-500 hover:bg-red-600 rounded-md">Kembali</a>
            @else
                <a href="{{ route('petugas.transaksi') }}"
                    class="py-2 text-center text-white font-medium w-4/12 bg-red-500 hover:bg-red-600 rounded-md">Kembali</a>
            @endif
            <button onclick="print()"
                class="py-2 text-center text-white font-medium w-4/12 mt-3 bg-blue-500 hover:bg-blue-600 rounded-md">Cetak</button>
        </div>
        <div class="border border-black px-3">
            <h1 class="text-2xl text-center w-full py-5 font-medium mt-5">NamaToko</h1>
            <table class="mt-5 w-full tracking-wide font-mono mx-4">
                <tr>
                    <td>No. Transaksi</td>
                    <td>:</td>
                    <td>{{ $new_penjualan[0]->id_penjualan }}</td>
                </tr>
                <tr>
                    <td>Kasir</td>
                    <td>:</td>
                    <td>{{ $new_penjualan[0]->users->name }}</td>
                </tr>
                <tr>
                    <td>Member</td>
                    <td>:</td>
                    <td>{{ $new_penjualan[0]->member_id ? $new_penjualan[0]->member->nama : '-' }}</td>
                </tr>
                <tr>
                    <td>Waktu</td>
                    <td>:</td>
                    <td>{{ $new_penjualan[0]->waktu }}</td>
                </tr>
            </table>
            <hr class="h-[2px] bg-black w-full my-3">
            <div class="font-mono tracking-wide mx-4">
                @foreach ($new_detail as $n)
                    <div class="flex justify-between mt-2">
                        <span>{{ $n->produk->nama }}</span>
                        <span>Rp {{ $n->produk->harga }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>{{ $n->jumlah_beli }} x {{ $n->produk->harga }}
                            {{ $n->diskon ? '(Disc. ' . $n->diskon . '%)' : '' }}</span>
                        <span>{{ $n->diskon ? '- Rp ' . $n->sub_total_diskon_new : '' }}</span>
                    </div>
                @endforeach
            </div>
            <hr class="h-[2px] bg-black w-full my-3">
            <div class="flex flex-col mx-4 mb-3 font-mono">
                <div class="flex justify-between">
                    <span>Sub total</span>
                    <span>Rp {{ $new_penjualan[0]->total_harga }}</span>
                </div>
                @if ($new_penjualan[0]->member_id)
                    <div class="flex justify-between mt-2">
                        <span>Potongan member</span>
                        <span>Rp {{ $new_penjualan[0]->potongan_member }}</span>
                    </div>
                @endif
                <div class="flex justify-between mt-2">
                    <span>Total harga</span>
                    <span>Rp {{ $new_penjualan[0]->total_harga }}</span>
                </div>
                <div class="flex justify-between mt-2">
                    <span>Tunai</span>
                    <span>Rp {{ $new_penjualan[0]->tunai }}</span>
                </div>
                <div class="flex justify-between mt-2">
                    <span>Kembalian</span>
                    <span>Rp {{ $new_penjualan[0]->kembalian }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
