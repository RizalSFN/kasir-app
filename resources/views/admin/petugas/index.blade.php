@extends('layouts.main')

@section('content')
    <div class="mx-5 mt-5 mb-10">
        <div class="flex justify-between items-center">
            <a href="{{ route('admin.petugas.create') }}"
                class="p-2 text-white font-medium flex items-center bg-green-500 hover:bg-green-600 rounded-md tracking-wide">
                <i class="bi bi-plus-circle mr-3"></i>
                Tambah petugas
            </a>
            <form action="" method="GET" class="flex shadow w-2/12">
                <input type="text" class="p-2 rounded-l-md w-full outline-none border border-r-0 border-gray-200"
                    name="search" id="search" autofocus placeholder="Cari ...">
                <button class="p-2 rounded-r-md bg-white border border-l-0 border-gray-200"><i
                        class="bi bi-search"></i></button>
            </form>
        </div>
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
                    <td class="w-1/12 py-3">NO</td>
                    <td class="w-2/12 py-3">NAMA PETUGAS</td>
                    <td class="w-2/12 py-3">EMAIL PETUGAS</td>
                    <td class="w-1/12 py-3">STATUS</td>
                    <td class="w-2/12 py-3">AKSI</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $petugas)
                    <tr class="border-b border-gray-200">
                        <td class="py-3">{{ $loop->iteration }}</td>
                        <td class="py-3">{{ $petugas->name }}</td>
                        <td class="py-3">{{ $petugas->email }}</td>
                        <td class="py-3">
                            <span
                                class="px-2 pt-1 pb-1.5 border {{ $petugas->status == 'aktif' ? 'text-green-500 border-green-500 bg-green-100' : 'text-red-500 border-red-500 bg-red-100' }} font-medium rounded-md">{{ $petugas->status }}</span>
                        </td>
                        <td class="py-3 flex justify-center">
                            <a href="{{ route('admin.petugas.status', [$petugas->id, $petugas->status == 'aktif' ? 'nonaktif' : 'aktif']) }}"
                                class="py-2 px-3 text-white mr-2 {{ $petugas->status == 'aktif' ? 'bg-red-400 hover:bg-red-500' : 'bg-green-400 hover:bg-green-500' }} rounded-md">
                                <i class="bi {{ $petugas->status == 'aktif' ? 'bi-ban' : 'bi-check-circle' }}"></i>
                            </a>
                            <a href="{{ route('admin.petugas.edit', $petugas->id) }}"
                                class="py-2 px-3 text-white bg-yellow-400 hover:bg-yellow-500 rounded-md">
                                <i class="bi bi-pencil-square"></i>
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
@endsection
