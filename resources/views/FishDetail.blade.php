@extends('layouts.app')

@section('title', 'Detail ' . $product->nama)

@section('content')
<div class="container my-5 py-3">
    {{-- Menggunakan card yang ringkas dan elegan --}}
    <div class="card shadow-lg border-0 rounded-4 bg-light">
        <div class="card-body p-lg-5 p-md-4 p-3">
            <div class="row g-5"> 

                {{-- Bagian Gambar Produk --}}
                <div class="col-lg-6 col-md-6 d-flex flex-column"> 
                    <div class="image-container w-100 mb-4">
                        @php
                            $galleryImages = $product->gallery_images ?? [];
                            // Gabungkan gambar utama dan galeri
                            $allImages = collect([$product->gambar])->merge($galleryImages)->filter()->all();
                        @endphp

                        @if(count($allImages) > 0)
                            {{-- Carousel Gambar Utama --}}
                            <div id="productCarousel" class="carousel slide w-100" data-bs-ride="carousel">
                                <div class="carousel-inner rounded-4 shadow-sm"> 
                                    @foreach($allImages as $index => $image)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $image) }}" 
                                             class="d-block w-100 product-image-main" 
                                             alt="{{ $product->nama }} - Gambar {{ $index + 1 }}">
                                    </div>
                                    @endforeach
                                </div>
                                
                                @if(count($allImages) > 1)
                                {{-- Kontrol Navigasi (Prev/Next) --}}
                                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                                @endif
                            </div>

                            {{-- Thumbnail Gallery --}}
                            @if(count($allImages) > 1)
                            <div class="thumbnail-container mt-4">
                                @foreach($allImages as $index => $image)
                                <img src="{{ asset('storage/' . $image) }}" 
                                     class="thumbnail {{ $index === 0 ? 'active' : '' }}" 
                                     data-bs-target="#productCarousel" 
                                     data-bs-slide-to="{{ $index }}"
                                     alt="Thumbnail {{ $index + 1 }}">
                                @endforeach
                            </div>
                            @endif
                        @else
                            {{-- Placeholder jika tidak ada gambar --}}
                            <div class="product-image-main d-flex align-items-center justify-content-center bg-white text-secondary">
                                <p class="text-center m-0"><i class="bi bi-image" style="font-size: 2rem;"></i><br>Tidak ada gambar</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Bagian Detail Produk --}}
                <div class="col-lg-6 col-md-6">
                    {{-- Kategori sebagai badge --}}
                    <span class="badge bg-primary text-white fs-6 px-3 py-1 mb-3 rounded-pill">
                        <i class="bi bi-tag-fill me-1"></i> {{ $product->category->name ?? 'Umum' }}
                    </span>

                    <h1 class="display-5 fw-bold text-dark mb-4">{{ $product->nama }}</h1>

                    <div class="d-flex align-items-baseline mb-4 border-bottom pb-3">
                        <h2 class="fw-bolder text-success me-4">
                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                        </h2>
                        {{-- Badge Stok --}}
                        @if ($product->stok > 0)
                            <span class="badge bg-success-subtle text-success-emphasis fs-6 px-3 py-2 rounded-pill">
                                <i class="bi bi-check-circle-fill me-1"></i> Tersedia
                            </span>
                        @else
                            <span class="badge bg-danger-subtle text-danger-emphasis fs-6 px-3 py-2 rounded-pill">
                                <i class="bi bi-x-octagon-fill me-1"></i> Stok Kosong
                            </span>
                        @endif
                    </div>
                    
                    <p class="lead text-secondary mb-4">{{ $product->deskripsi }}</p>

                    {{-- Daftar Info Produk --}}
                    <div class="product-info-list mb-5">
                        <ul class="list-group rounded-3 border-0"> 
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong><i class="bi bi-box me-2 text-primary"></i> Stok Saat Ini:</strong>
                                <span class="fw-bold">{{ $product->stok }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong><i class="bi bi-truck me-2 text-primary"></i> Perkiraan Berat:</strong>
                                <span>{{ $product->berat ?? '-' }} gram</span>
                            </li>
                        </ul>
                    </div>

                    {{-- Tombol Aksi --}}
                    <form action="{{ route('keranjang.tambah', ['id' => $product->id]) }}" method="GET" class="d-flex flex-column flex-md-row gap-3 mt-4">
                        
                        <div class="input-group">
                            {{-- Input Jumlah --}}
                            <input type="number" name="jumlah" value="1" min="1" max="{{ $product->stok }}" class="form-control form-control-lg text-center" style="max-width: 100px; border-radius: 0.5rem 0 0 0.5rem;" required>
                            
                            {{-- Tombol Utama --}}
                            <button type="submit" class="btn btn-primary btn-lg flex-grow-1 shadow-sm" @if($product->stok <= 0) disabled @endif>
                                <i class="bi bi-cart-plus-fill me-2"></i> Tambah ke Keranjang
                            </button>
                        </div>

                        {{-- Tombol Kembali --}}
                        <a href="{{ route('fish.view') }}" class="btn btn-outline-secondary btn-lg shadow-sm">
                            <i class="bi bi-arrow-left me-2"></i> Kembali
                        </a>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
{{-- Pastikan ini menunjuk ke file CSS Anda --}}
<link rel="stylesheet" href="{{ asset('css/fishdetail.css') }}">
@endpush

@push('scripts')
{{-- Script untuk sinkronisasi thumbnail dan carousel --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var carousel = document.getElementById('productCarousel');
        var thumbnails = document.querySelectorAll('.thumbnail');

        // Fungsi untuk mengupdate kelas aktif
        function updateThumbnails(activeIndex) {
            thumbnails.forEach(function(thumb, index) {
                if (index === activeIndex) {
                    thumb.classList.add('active');
                } else {
                    thumb.classList.remove('active');
                }
            });
        }

        // Listener saat carousel bergeser
        carousel.addEventListener('slide.bs.carousel', function(event) {
            var nextIndex = event.to;
            updateThumbnails(nextIndex);
        });

        // Listener saat thumbnail diklik (untuk menambahkan kelas aktif segera)
        thumbnails.forEach(function(thumb) {
            thumb.addEventListener('click', function() {
                // Hapus kelas aktif dari semua thumbnail
                thumbnails.forEach(t => t.classList.remove('active'));
                // Tambahkan kelas aktif pada thumbnail yang diklik
                this.classList.add('active');
            });
        });
    });
</script>
@endpush