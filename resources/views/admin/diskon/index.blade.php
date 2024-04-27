@extends('layouts.main')

@section('content')
    <div class="mx-5 mt-5 mb-10">
        @if (count($diskon) == 0)
            <div class="flex justify-between items-center">
                <a href="{{ route('admin.diskon.create') }}"
                    class="p-2 text-white font-medium flex items-center bg-green-500 hover:bg-green-600 rounded-md tracking-wide">
                    <i class="bi bi-plus-circle mr-3"></i>
                    Tambah diskon
                </a>
            </div>
        @endif
        @if (session('success'))
            <div
                class="px-4 mb-3 py-2 w-4/12 mt-5 flex items-center font-medium tracking-wide bg-green-100 border border-green-500 text-green-500 rounded-md">
                <i class="bi bi-check2-circle mr-3"></i>
                {{ session('success') }}
            </div>
        @endif
        <table class="mt-10 border border-gray-200 text-center w-full">
            <thead>
                <tr class="bg-gray-200 text-neutral-400 font-medium text-sm">
                    <td class="w-2/12 py-3">MINIMAL PEMBAYARAN</td>
                    <td class="w-2/12 py-3">DISKON</td>
                    <td class="w-2/12 py-3">AKSI</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($diskon as $d)
                    <tr class="border-b border-gray-200">
                        <td class="py-3">Rp {{ number_format($d->minimum_transaksi, 2, ',', '.') }}</td>
                        <td class="py-3">{{ $d->diskon }} %</td>
                        <td class="py-3 flex justify-center">
                            <a href="{{ route('admin.diskon.delete', $d->id) }}"
                                class="py-2 px-3 text-white mr-2 bg-red-400 hover:bg-red-500 rounded-md">
                                <i class="bi bi-trash"></i>
                            </a>
                            <a href="{{ route('admin.diskon.edit', $d->id) }}"
                                class="py-2 px-3 text-white bg-yellow-400 hover:bg-yellow-500 rounded-md">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </td>
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
