@extends('layouts.app')

@section('title', 'Riwayat Pemesanan Saya')

@push('styles')
<style>
    html {
    height: 100%; 
}

body {
    min-height: 100vh; /* Kunci: Menggunakan viewport height untuk tinggi minimal */
    margin: 0;
    padding: 0;
    
    /* Pindahkan gradient ke body */
    background: linear-gradient(to bottom, #e0f2f7, #ffffff); 
    background-color: transparent; 
    
    /* Opsi: Untuk memastikan gradient stabil saat scroll */
    background-attachment: fixed;

}
.page-title {
    font-family: 'Merriweather', serif;
    color: #005f73; /* Biru tua yang elegan */
    font-weight: 700;
    font-size: 2.5rem;
    text-align: center;
    margin-bottom: 3rem;
    display: flex;
    align-items: center;
    justify-content: center;
}
    .order-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .order-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
    }
    .card-header-custom {
        cursor: pointer;
        background-color: #ffffff;
        border-bottom: 1px solid #eee;
        transition: background-color 0.2s;
    }
    .card-header-custom:hover {
        background-color: #f8f9fa;
    }
    .status-badge-custom {
        padding: 0.4em 0.8em;
        font-size: 0.85rem;
        font-weight: 600;
        border-radius: 50px;
    }
    .produk-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 10px;
    }
</style>
@endpush

@section('content')
<div class="container mt-5">
    <h1 class="mb-5 text-center order-history-title">
        <i class="mdi mdi-clipboard-text-history me-3"></i> Riwayat Pemesanan Saya
    </h1>

    @if ($orders->isEmpty())
        {{-- BAGIAN 1: EMPTY STATE YANG LEBIH BAGUS --}}
        <div class="alert alert-light text-center shadow-sm py-5 border-0" role="alert" style="background-color: #f0f8ff;">
            <i class="mdi mdi-cart-off mdi-48px text-muted mb-3 d-block"></i>
            <h4 class="fw-bold text-dark">Belum ada pesanan nih!</h4>
            <p class="text-muted">Yuk, isi akuariummu dengan ikan hias dan perlengkapan terbaik kami.</p>
            <a href="{{ route('home') }}" class="btn btn-primary mt-3 rounded-pill px-4 shadow-sm">
                <i class="mdi mdi-shopping me-1"></i> Mulai Belanja Sekarang
            </a>
        </div>
    @else
        <div class="accordion" id="riwayatPesananAccordion">
            @foreach ($orders as $index => $order)
                <div class="card mb-4 order-card shadow">
                    <div class="card-header-custom p-3 p-md-4 d-flex flex-wrap justify-content-between align-items-center"
                         id="heading-{{ $order->id }}" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $order->id }}"
                         aria-expanded="false" aria-controls="collapse-{{ $order->id }}">

                        {{-- ID Pesanan & Tanggal --}}
                        <div class="d-flex align-items-center me-3 mb-2 mb-md-0">
                            <i class="mdi mdi-package-variant mdi-36px text-primary me-3"></i>
                            <div>
                                <p class="text-muted mb-0 small">No. Pesanan:</p>
                                <h5 class="mb-0 fw-bold text-dark">#{{ $order->id }}</h5>
                                <small class="text-secondary">{{ $order->created_at->format('d M Y, H:i') }}</small>
                            </div>
                        </div>

                        {{-- Total Harga & Status --}}
                        <div class="d-flex align-items-center me-3 mb-2 mb-md-0">
                            <div class="text-center me-4">
                                <p class="text-muted mb-0 small">Total Bayar</p>
                                <span class="text-success fw-bold fs-5">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                            </div>

                            @php
                                $status_text = $order->status;
                                if($status_text == 'Proses'){
                                    $status_class = 'bg-primary';
                                    $status_icon = 'mdi-progress-clock';
                                } elseif($status_text == 'Diantarkan' || $status_text == 'Dalam Perjalanan'){
                                    $status_class = 'bg-warning text-dark';
                                    $status_icon = 'mdi-truck-delivery';
                                } elseif($status_text == 'Selesai'){
                                    $status_class = 'bg-success';
                                    $status_icon = 'mdi-check-circle-outline';
                                } else {
                                    $status_class = 'bg-secondary';
                                    $status_icon = 'mdi-information-outline';
                                }
                            @endphp

                            <span class="badge {{ $status_class }} status-badge-custom shadow-sm">
                                <i class="mdi {{ $status_icon }} me-1"></i> {{ $status_text }}
                            </span>
                        </div>

                        <div class="ms-auto">
                            <i class="mdi mdi-chevron-down mdi-24px text-muted toggle-icon"></i>
                        </div>
                    </div>

                    {{-- DETAIL PESANAN --}}
                    <div id="collapse-{{ $order->id }}" class="collapse"
                         aria-labelledby="heading-{{ $order->id }}" data-bs-parent="#riwayatPesananAccordion">
                        <div class="card-body bg-light p-4">
                            <div class="row">
                                {{-- Info Pengiriman --}}
                                <div class="col-lg-6 mb-3 mb-lg-0">
                                    <h6 class="fw-bold mb-3 text-primary">
                                        <i class="mdi mdi-map-marker-outline me-2"></i> Info Pengiriman & Kontak
                                    </h6>
                                    <div class="bg-white p-3 rounded shadow-sm border">
                                        <p class="mb-1"><span class="fw-bold small text-muted">PEMBELI:</span> <br> {{ $order->nama_pembeli }}</p>
                                        <hr class="my-2">
                                        <p class="mb-1"><span class="fw-bold small text-muted">ALAMAT:</span> <br> {{ $order->alamat }}</p>
                                        <hr class="my-2">
                                        <p class="mb-1"><span class="fw-bold small text-muted">NO. HP:</span> <br> {{ $order->no_hp }}</p>
                                        <hr class="my-2">
                                        <p class="mb-0"><span class="fw-bold small text-muted">METODE BAYAR:</span> <br> {{ $order->metode_pembayaran }}</p>
                                    </div>
                                </div>

                                {{-- Produk Dipesan --}}
                                <div class="col-lg-6 border-start pt-3 pt-lg-0">
                                    <h6 class="fw-bold mb-3 text-primary">
                                        <i class="mdi mdi-basket-fill me-2"></i> Detail Barang
                                    </h6>

                                    <ul class="list-group list-group-flush bg-light rounded">
                                        @foreach($order->items as $item)
                                            <li class="list-group-item bg-light d-flex align-items-center border-bottom">
                                                {{-- Foto produk --}}
                                                @php
                                                    $img = $item->produk->all_images[0] ?? $item->produk->gambar ?? 'default.jpg';
                                                @endphp
                                                <img src="{{ asset('storage/' . $img) }}" 
                                                     alt="{{ $item->produk->nama }}" 
                                                     class="produk-img me-3 shadow-sm border">

                                                <div class="flex-grow-1">
                                                    <span class="fw-bold text-dark">{{ $item->produk->nama }}</span> 
                                                    <span class="badge bg-secondary rounded-pill ms-1">{{ $item->jumlah }}x</span> <br>
                                                    <small class="text-muted">@ Rp {{ number_format($item->harga, 0, ',', '.') }}</small>
                                                </div>

                                                <span class="fw-bold text-primary">
                                                    Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>

                                    {{-- BAGIAN 2: TOMBOL DENGAN TOOLTIP DAN IKON --}}
                                    <div class="text-end mt-4">
                                        <a href="{{ route('upload.vidio') }}" class="btn btn-sm btn-success mb-1 shadow-sm"
                                           data-bs-toggle="tooltip" title="Wajib upload video unboxing untuk klaim">
                                            <i class="mdi mdi-video-plus me-1"></i> Upload Live Video
                                        </a>
                                        
                                        <a href="{{ route('claim.garansi', $order->id) }}" class="btn btn-sm btn-warning text-dark mb-1 shadow-sm"
                                           title="Ajukan klaim garansi jika ada masalah">
                                            <i class="mdi mdi-shield-check-outline me-1"></i> Claim Garansi
                                        </a>
                                        <a href="{{ route('fish.view') }}" class="btn btn-sm btn-outline-primary">Beli Lagi</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- BAGIAN 3: FOOTER NOTE TAMBAHAN --}}
    <div class="mt-4 mb-5">
        <div class="alert alert-light border d-flex align-items-center small text-muted justify-content-center" role="alert">
            <i class="mdi mdi-information text-info me-2 fs-5"></i>
            <div>
                <strong>Info:</strong> Status pesanan diperbarui otomatis. Hubungi admin jika status tidak berubah 2x24 jam.
            </div>
        </div>
    </div>

    <div class="text-center mb-5">
        <a href="{{ route('home') }}" class="btn btn-secondary shadow-sm px-4">
            <i class="mdi mdi-home me-2"></i> Kembali ke Beranda
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.card-header-custom').forEach(header => {
        header.addEventListener('click', function() {
            const icon = this.querySelector('.toggle-icon');
            icon.classList.toggle('mdi-chevron-down');
            icon.classList.toggle('mdi-chevron-up');
        });
    });

    // Mengaktifkan Tooltip Bootstrap (Jika belum aktif di global script)
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush