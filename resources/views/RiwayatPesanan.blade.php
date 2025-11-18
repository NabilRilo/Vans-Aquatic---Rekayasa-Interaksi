@extends('layouts.app')

@section('title', 'Riwayat Pemesanan Saya')

@push('styles')
<style>
    .order-history-title {
        color: #0d6efd;
        font-weight: 700;
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
        <div class="alert alert-info text-center shadow-sm" role="alert">
            <i class="mdi mdi-information-outline me-2"></i> Anda belum memiliki riwayat pesanan.
            <br>
            <a href="{{ route('home') }}" class="btn btn-sm btn-primary mt-3">Mulai Belanja Sekarang</a>
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
                                $status_text = $order->status; // Ambil dari database
                                if($status_text == 'Proses'){
                                    $status_class = 'bg-primary';
                                    $status_icon = 'mdi-progress-clock';
                                } elseif($status_text == 'Diantarkan'){
                                    $status_class = 'bg-warning';
                                    $status_icon = 'mdi-truck-delivery';
                                } elseif($status_text == 'Selesai'){
                                    $status_class = 'bg-success';
                                    $status_icon = 'mdi-check-circle-outline';
                                } else {
                                    $status_class = 'bg-secondary';
                                    $status_icon = 'mdi-information-outline';
                                }
                            @endphp

                            <span class="badge {{ $status_class }} status-badge-custom">
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
                                    <p class="mb-1"><span class="fw-bold">Pembeli:</span> {{ $order->nama_pembeli }}</p>
                                    <p class="mb-1"><span class="fw-bold">Alamat:</span> {{ $order->alamat }}</p>
                                    <p class="mb-1"><span class="fw-bold">No. HP:</span> {{ $order->no_hp }}</p>
                                    <p class="mb-1"><span class="fw-bold">Metode Bayar:</span> {{ $order->metode_pembayaran }}</p>
                                </div>

                                {{-- Produk Dipesan --}}
                                <div class="col-lg-6 border-start pt-3 pt-lg-0">
                                    <h6 class="fw-bold mb-3 text-primary">
                                        <i class="mdi mdi-basket-fill me-2"></i> Detail Barang
                                    </h6>

                                    <ul class="list-group list-group-flush bg-light">
                                        @foreach($order->items as $item)
                                            <li class="list-group-item bg-light d-flex align-items-center">
                                                {{-- Foto produk --}}
                                                @php
                                                    $img = $item->produk->all_images[0] ?? $item->produk->gambar ?? 'default.jpg';
                                                @endphp
                                                <img src="{{ asset('storage/' . $img) }}" 
                                                     alt="{{ $item->produk->nama }}" 
                                                     class="produk-img me-3">

                                                <div class="flex-grow-1">
                                                    <span class="fw-bold">{{ $item->produk->nama }}</span> ({{ $item->jumlah }}x) <br>
                                                    <small class="text-muted">Rp {{ number_format($item->harga, 0, ',', '.') }}</small>
                                                </div>

                                                <span class="fw-bold">
                                                    Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <div class="text-end mt-3">
                                        <button class="btn btn-sm btn-success">Beri Ulasan</button>
                                        <button class="btn btn-sm btn-outline-primary">Beli Lagi</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="mt-5 text-center">
        <a href="{{ route('home') }}" class="btn btn-secondary">
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
</script>
@endpush
