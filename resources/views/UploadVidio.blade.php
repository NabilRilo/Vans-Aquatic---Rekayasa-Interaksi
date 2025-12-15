@extends('layouts.app')

@section('title', 'Upload Live Video')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/uploadlive.css') }}">
@endpush

@section('content')
<div class="upload-container d-flex justify-content-center align-items-center py-5">
    <div class="card shadow p-5 rounded-4" style="max-width: 700px; width: 100%;">

        <h2 class="text-center text-primary fw-bold mb-4">
            <i class="mdi mdi-video-plus me-2"></i> Upload Live Video
        </h2>

        <form action="#" method="POST" enctype="multipart/form-data" class="text-center">
            @csrf

            {{-- Area Drag & Drop Upload --}}
            <div class="upload-box mb-4 mx-auto">
                <label for="video" class="upload-area" id="upload-area">
                    <div class="upload-icon mb-3">
                        <i class="mdi mdi-upload" style="font-size: 55px; color: #0d6efd;"></i>
                    </div>

                    <h5 class="fw-semibold">Klik untuk upload atau drag & drop</h5>
                    <p class="text-muted mb-0">Video kondisi ikan secara live/real-time</p>
                    <p class="text-muted small">Format: MP4, MOV, AVI, dll • Maks 50MB</p>
                </label>
                <input type="file" name="video" id="video" accept="video/*" hidden required>
            </div>

            {{-- Tips --}}
            <div class="alert alert-info rounded-4 text-start mb-4">
                <h6 class="fw-bold">
                    <i class="mdi mdi-information-outline me-1"></i> Tips untuk Video yang Baik:
                </h6>
                <ul class="mb-0">
                    <li>Rekam video dalam kondisi pencahayaan yang baik</li>
                    <li>Tunjukkan kondisi ikan secara jelas dan detail</li>
                    <li>Rekam dari berbagai sudut (depan, samping, atas)</li>
                    <li>Durasi video minimal 30 detik</li>
                    <li>Pastikan video tidak buram atau goyang</li>
                </ul>
            </div>

            {{-- Button --}}
            <div class="d-flex gap-3 justify-content-center mt-3">
                <a href="{{ route('riwayat.pesanan') }}" class="btn btn-secondary rounded-pill px-4">
                    <i class="mdi mdi-arrow-left me-1"></i> Kembali
                </a>

                <button type="submit" class="btn btn-primary rounded-pill px-4">
                    <i class="mdi mdi-upload me-1"></i> Upload Sekarang
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
