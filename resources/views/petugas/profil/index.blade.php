@extends('layouts.main')

@section('content')
    <div class="mt-5 ml-5 w-6/12 border border-gray-300 rounded-md">
        <div class="rounded-t-md bg-gray-300 font-medium tracking-wide px-5 py-4 text-xl">
            Profil
        </div>
        @if (session('success'))
            <div
                class="px-4 mb-3 ml-5 py-2 w-6/12 mt-5 flex items-center font-medium tracking-wide bg-green-100 border border-green-500 text-green-500 rounded-md">
                <i class="bi bi-check2-circle mr-3"></i>
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('petugas.profil.update', $data->id) }}" method="POST" class="m-5 flex flex-col">
            @csrf
            @method('PUT')
            <div class="flex items-center mt-5">
                <label for="nama" class="font-medium w-5/12">Nama</label>
                <div class="flex flex-col w-5/12">
                    <input type="text" name="nama" id="nama" value="{{ $data->name }}" autofocus required
                        class="p-2 w-full border border-neutral-300 outline-neutral-400 rounded-md"
                        placeholder="Masukkan nama member">
                    @error('nama')
                        <label class="text-red-500 font-medium tracking-wide flex items-center">
                            <i class="bi bi-exclamation-circle mr-3"></i>
                            {{ $message }}
                        </label>
                    @enderror
                </div>
            </div>
            <div class="flex items-center mt-5">
                <label for="email" class="font-medium w-5/12">Email</label>
                <div class="flex flex-col w-5/12">
                    <input type="email" name="email" id="email" value="{{ $data->email }}" required
                        class="p-2 w-full border border-neutral-300 outline-neutral-400 rounded-md"
                        placeholder="Masukkan Email">
                    @if (session('error'))
                        <label class="text-red-500 font-medium tracking-wide flex items-center">
                            <i class="bi bi-exclamation-circle mr-3"></i>
                            {{ session('error') }}
                        </label>
                    @endif
                    @error('email')
                        <label class="text-red-500 font-medium tracking-wide flex items-center">
                            <i class="bi bi-exclamation-circle mr-3"></i>
                            {{ $message }}
                        </label>
                    @enderror
                </div>
            </div>
            <div class="flex items-center mt-5">
                <label for="password" class="font-medium w-5/12">Password Baru</label>
                <div class="flex flex-col w-5/12">
                    <input type="password" name="password" id="password"
                        class="p-2 w-full border border-neutral-300 outline-neutral-400 rounded-md"
                        placeholder="Masukkan Password">
                    @error('password')
                        <label class="text-red-500 font-medium tracking-wide flex items-center">
                            <i class="bi bi-exclamation-circle mr-3"></i>
                            {{ $message }}
                        </label>
                    @enderror
                </div>
            </div>
            <div class="flex items-center mt-5">
                <label for="konfirmasi_password" class="font-medium w-5/12">Konfirmasi Password</label>
                <div class="w-5/12 flex flex-col">
                    <input type="password" name="konfirmasi_password" id="konfirmasi_password"
                        class="p-2 w-full border border-neutral-300 outline-neutral-400 rounded-md"
                        placeholder="Masukkan Konfirmasi Password">
                    <label class="hidden text-red-500 font-medium tracking-wide" id="konfirmasi-alert"></label>
                </div>
            </div>
            <div class="flex items-center mt-10">
                <a href="{{ route('petugas.dashboard') }}"
                    class="py-2 text-center text-white font-medium w-3/12 bg-red-500 hover:bg-red-600 rounded-md">Kembali</a>
                <button id="simpan-btn"
                    class="py-2 ml-5 text-center text-white font-medium w-3/12 bg-green-500 hover:bg-green-600 rounded-md">Simpan</button>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            $('#konfirmasi_password').on('input', function() {
                if ($(this).val() != $('#password').val()) {
                    $('#simpan-btn').attr('disabled', 'true').addClass('cursor-not-allowed')
                    $('#konfirmasi-alert').removeClass('hidden').text('Konfirmasi password salah')
                } else {
                    $('#simpan-btn').removeAttr('disabled').removeClass('cursor-not-allowed')
                    $('#konfirmasi-alert').addClass('hidden')
                }
            })
        })
    </script>
@endsection
