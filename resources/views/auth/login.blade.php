@extends('layouts.app')

@section('component')
    <div class="w-3/12 mx-auto py-5 px-4 bg-white rounded-md mt-52">
        <h1 class="font-medium text-center p-5 w-full text-3xl">LOGIN</h1>
        @if (session('error'))
            <div
                class="px-4 mb-3 py-2 flex items-center font-medium tracking-wide bg-red-100 border border-red-500 text-red-500 rounded-md">
                <i class="bi bi-exclamation-circle mr-3"></i>
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('login.proses') }}" method="POST" class="flex flex-col">
            @csrf
            <div class="flex flex-col">
                <label for="email" class="mb-1 font-medium">Email</label>
                <input type="email" class="p-2 border border-black rounded-md" name="email" id="email"
                    value="{{ old('email') }}" placeholder="Masukkan email" autofocus required>
            </div>
            <div class="flex flex-col mt-5">
                <label for="password" class="mb-1 font-medium">Password</label>
                <input type="password" class="p-2 border border-black rounded-md" name="password" id="password"
                    placeholder="Masukkan password" required>
            </div>
            <button class="mt-8 w-full text-white bg-blue-500 hover:bg-blue-600 rounded-md font-medium py-2">LOGIN</button>
        </form>
    </div>
@endsection
