@extends('layouts.main')

@section('content')
    <div class="mt-5 ml-5 w-6/12 border border-gray-300 rounded-md">
        <div class="rounded-t-md bg-gray-300 font-medium tracking-wide px-5 py-4 text-xl">
            Tambah member
        </div>
        <form action="{{ route('admin.member.store') }}" method="POST" class="m-5 flex flex-col">
            @csrf
            <div class="flex items-center">
                <label for="id_member" class="font-medium w-5/12">ID Member</label>
                <input type="text" name="id_member" id="id_member" value="{{ $new_id }}" readonly
                    class="bg-gray-200 p-2 w-5/12">
            </div>
            <div class="flex items-center mt-5">
                <label for="nama_member" class="font-medium w-5/12">Nama</label>
                <div class="flex flex-col w-5/12">
                    <input type="text" name="nama_member" id="nama_member" autofocus required
                        class="p-2 w-full border border-neutral-300 outline-neutral-400 rounded-md"
                        placeholder="Masukkan nama member">
                    @error('nama_member')
                        <label class="text-red-500 font-medium tracking-wide flex items-center">
                            <i class="bi bi-exclamation-circle mr-3"></i>
                            {{ $message }}
                        </label>
                    @enderror
                </div>
            </div>
            <div class="flex items-center mt-5">
                <label for="alamat_member" class="font-medium w-5/12">Alamat</label>
                <div class="flex flex-col w-5/12">
                    <textarea type="text" name="alamat_member" id="alamat_member" required
                        class="p-2 w-full border border-neutral-300 outline-neutral-400 rounded-md" placeholder="Masukkan alamat member"></textarea>
                    @error('alamat_member')
                        <label class="text-red-500 font-medium tracking-wide flex items-center">
                            <i class="bi bi-exclamation-circle mr-3"></i>
                            {{ $message }}
                        </label>
                    @enderror
                </div>
            </div>
            <div class="flex items-center mt-5">
                <label for="telepon_member" class="font-medium w-5/12">No. Telepon</label>
                <div class="flex flex-col w-5/12">
                    <input type="number" name="telepon_member" id="telepon_member" required
                        class="p-2 w-full border border-neutral-300 outline-neutral-400 rounded-md"
                        placeholder="Masukkan nomor telelpon member">
                    @error('nama_member')
                        <label class="text-red-500 font-medium tracking-wide flex items-center">
                            <i class="bi bi-exclamation-circle mr-3"></i>
                            {{ $message }}
                        </label>
                    @enderror
                </div>
            </div>
            <div class="flex items-center mt-10">
                <a href="{{ route('admin.member') }}"
                    class="py-2 text-center text-white font-medium w-3/12 bg-red-500 hover:bg-red-600 rounded-md">Kembali</a>
                <button
                    class="py-2 ml-5 text-center text-white font-medium w-3/12 bg-green-500 hover:bg-green-600 rounded-md">Simpan</button>
            </div>
        </form>
    </div>
@endsection
