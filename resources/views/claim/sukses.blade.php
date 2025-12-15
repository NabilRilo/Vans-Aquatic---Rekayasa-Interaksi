@extends('layouts.app')

@section('title', 'Claim Garansi Berhasil Diproses!')

{{-- Push CSS khusus halaman ini ke stack 'styles' di layouts.app --}}
@push('styles')
<style>
    /* Gaya untuk Card utama agar terlihat menonjol */
    .order-success-card {
        max-width: 600px;
        margin: 40px auto;
        padding: 40px 20px;
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        background: #ffffff;
        position: relative;
        overflow: hidden;
    }

    /* Efek animasi untuk ikon check mark */
    .success-icon {
        font-size: 6rem;
        color: #198754; /* Green / Success */
        animation: scaleIn 0.5s ease-out;
        margin-bottom: 20px;
    }

    /* Animasi sederhana */
    @keyframes scaleIn {
        0% { transform: scale(0.5); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }

    .card-title {
        font-weight: 700;
        color: #0d6efd; /* Warna Primary Bootstrap */
        margin-bottom: 20px;
        animation: fadeIn 1s ease-out;
    }

    @keyframes fadeIn {
        0% { opacity: 0; transform: translateY(10px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .btn-action-group .btn {
        font-weight: 600;
        border-radius: 10px;
        padding: 10px 25px;
        transition: transform 0.2s;
    }
    .btn-action-group .btn:hover {
        transform: translateY(-2px);
    }
    .btn-whatsapp {
        background-color: #25d366;
        color: white;
        border: none;
    }
    .btn-whatsapp:hover {
        background-color: #128c7e;
        color: white;
    }
</style>
{{-- Anda mungkin tidak perlu file claimSukses.css jika menggunakan style inline ini --}}
{{-- <link href="{{ asset('css/claimSukses.css') }}" rel="stylesheet"> --}}
@endpush

@section('content')
<div class="container mt-5 mb-5 order-success-container">
    <div class="card order-success-card text-center">
        <div class="card-body">
            
            {{-- Ikon Sukses Animasi --}}
            <i class="mdi mdi-check-decagram-outline success-icon"></i>

            <h2 class="card-title">Klaim Anda Sudah Terikirim!</h2>
            
            <p class="lead text-dark">
                Mohon Bersabar Claim Anda Akan Segara Kami Proses
            </p>
            <p class="text-muted mb-4">
                Klaim Anda telah kami terima dan sedang diproses. Anda akan menerima notifikasi saat klaim anda diproses.
            </p>

            {{-- Kelompok Tombol Aksi Utama --}}
            <div class="mt-5 d-flex justify-content-center gap-3 btn-action-group">
                <a href="{{ route('home') }}" class="btn btn-primary shadow">
                    <i class="mdi mdi-home me-2"></i> Kembali ke Beranda
                </a>
                <a href="{{ route('riwayat.pesanan') }}" class="btn btn-info shadow">
                    <i class="mdi mdi-cart-check me-2"></i> Lihat Riwayat Pemesanan
                </a>
            </div>

            <hr class="my-5">

            {{-- Bagian Kontak Admin --}}
            <div class="contact-admin">
                <p class="fw-bold mb-3 text-secondary">Butuh bantuan atau pertanyaan tentang pesanan Anda?</p>
                <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-whatsapp shadow-lg">
                    <i class="mdi mdi-whatsapp me-2"></i> Chat Admin Via WhatsApp
                </a>
                <small class="d-block mt-3 text-muted">
                    Jam kerja layanan: Senin - Sabtu, 09:00 - 17:00 WIB
                </small>
            </div>
            
        </div>
    </div>
</div>
@endsection
