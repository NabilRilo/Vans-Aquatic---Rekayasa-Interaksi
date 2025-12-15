@extends('layouts.app')

@section('title', 'Claim Garansi')

{{-- Menambahkan CSS kustom menggunakan @push('styles') --}}
@push('styles')
<link rel="stylesheet" href="{{ asset('css/claimgaransi.css') }}">
@endpush

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4 text-primary">
        <i class="mdi mdi-shield-check-outline me-2"></i> Formulir Claim Garansi
    </h2>

    <div class="card shadow p-4 rounded-4">
        <div class="mb-4">
            <h5>Detail Pesanan</h5>
            <p><strong>ID Pesanan:</strong> #{{ $order->id }}</p>
            <p><strong>Tanggal Pembelian:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
            <hr>
            <h6>Produk:</h6>
            <ul>
                @foreach ($order->items as $item)
                    <li>{{ $item->produk->nama }} ({{ $item->jumlah }}x)</li>
                @endforeach
            </ul>
        </div>

        <form action="{{ route('claim.garansi.submit', $order->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="alasan" class="form-label fw-bold">Alasan Claim Garansi</label>
                <textarea name="alasan" id="alasan" class="form-control" rows="4" placeholder="Tuliskan keluhan atau alasan pengajuan garansi..." required></textarea>
            </div>

            <div class="mb-3">
                <label for="bukti" class="form-label fw-bold">Upload Bukti (Foto/Video)</label>
                <input type="file" name="bukti" id="bukti" class="form-control" accept="image/*,video/*" required>
                
            </div>
            <div class="alert alert-info rounded-4 mt-4">
    <h6 class="fw-bold">
        <i class="mdi mdi-information-outline me-1"></i> Syarat & Ketentuan Garansi:
    </h6>
    <ul class="mb-0">
        <li>Garansi berlaku 3 hari setelah ikan diterima</li>
        <li>Ikan harus masih dalam kondisi air pengiriman</li>
        <li>Bukti foto/video harus jelas menunjukkan kondisi ikan</li>
        <li>Claim akan diproses maksimal 1x24 jam</li>
    </ul>
</div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('riwayat.pesanan') }}" class="btn btn-secondary">
                    <i class="mdi mdi-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="mdi mdi-send-outline me-1"></i> Kirim Claim
                </button>
            </div>
        </form>
    </div>
</div>
@endsection