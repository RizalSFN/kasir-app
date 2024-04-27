@extends('layouts.app')

@section('component')
    <div class="flex">
        @if (auth()->user()->role == 'administrator')
            @include('layouts.partials.sidebar-admin')
        @else
            @include('layouts.partials.sidebar-petugas')
        @endif
        <div class="flex flex-col w-full">
            @include('layouts.partials.navbar')
            @yield('content')
        </div>
    </div>
@endsection
