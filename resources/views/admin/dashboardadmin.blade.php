@extends('layouts.admin') {{-- Menggunakan layout admin --}}

@section('content')
    {{-- Semua elemen UI dashboard di sini --}}
    <h1>Dashboard Admin</h1>
    <p>Selamat Datang, {{ Auth::user()->name ?? 'Admin' }}</p>
    {{-- ... elemen UI lainnya ... --}}
@endsection