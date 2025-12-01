@extends('layouts.app')

@section('title', 'Upload Live Video')

@section('content')
<div class="container mt-5 text-center">
    <h2 class="text-primary fw-bold mb-4">
        <i class="mdi mdi-video-plus me-2"></i> Upload Live Video
    </h2>

    <form action="#" method="POST" enctype="multipart/form-data" class="border p-4 rounded shadow-sm bg-light">
        @csrf
        <div class="mb-3">
            <label for="video" class="form-label fw-bold">Pilih Video:</label>
            <input type="file" name="video" id="video" accept="video/*" class="form-control" required>
        </div>

        <button type="button" class="btn btn-success">
            <i class="mdi mdi-upload me-1"></i> Upload Sekarang
        </button>
    </form>

    <div class="mt-4">
        <a href="{{ route('home') }}" class="btn btn-secondary">
            <i class="mdi mdi-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection
