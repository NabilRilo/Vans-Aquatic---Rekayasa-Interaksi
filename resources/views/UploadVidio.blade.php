@extends('layouts.app')

@section('title', 'Upload Media')

@section('content')
<div class="container mt-5 text-center">
    <h2 class="text-primary fw-bold mb-4">
        <i class="mdi mdi-upload me-2"></i> Upload Video & Foto
    </h2>

    {{-- 🚨 PERUBAHAN UTAMA: Ganti action="#" ke action="{{ route('video.upload') }}" --}}
    {{-- Kita akan menggunakan satu rute upload untuk menangani kedua jenis file. --}}
    <form action="{{ route('video.upload') }}" method="POST" enctype="multipart/form-data" class="border p-4 rounded shadow-sm bg-light">
        @csrf

        {{-- Field untuk Video --}}
        <div class="mb-3">
            <label for="video" class="form-label fw-bold">Pilih Video (Opsional):</label>
            <input type="file" name="video" id="video" accept="video/*" class="form-control">
            <small class="form-text text-muted">Maksimal 500MB.</small>
        </div>

        {{-- Field BARU untuk Foto --}}
        <div class="mb-3">
            <label for="photo" class="form-label fw-bold">Pilih Foto (Opsional):</label>
            <input type="file" name="photo" id="photo" accept="image/*" class="form-control">
            <small class="form-text text-muted">Hanya gambar (JPG, PNG, dll.).</small>
        </div>
        
        {{-- Tombol BARU: Ganti type="button" menjadi type="submit" agar form terkirim --}}
        <button type="submit" class="btn btn-success">
            <i class="mdi mdi-upload me-1"></i> Upload Sekarang
        </button>
    </form>
    
    @if (session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger mt-3">Terdapat masalah saat upload file.</div>
    @endif


    <div class="mt-4">
        <a href="{{ route('home') }}" class="btn btn-secondary">
            <i class="mdi mdi-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection