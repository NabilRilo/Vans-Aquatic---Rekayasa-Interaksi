<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FishController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\CartController; 
use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| Web Routes - Vans Aquatic
|--------------------------------------------------------------------------
|
| File ini berisi daftar route untuk aplikasi Vans Aquatic.
| Dikelola oleh Tim Pengembang 
|
*/

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =======================================================
// 1. ROUTE AUTENTIKASI (LOGIN & REGISTER) - Akses Publik
// =======================================================

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// =======================================================
// 2. HALAMAN UTAMA (ROOT /) - GERBANG LOGIN
// =======================================================

Route::get('/', function () {
    if (Auth::check()) {
        return view('HomePage');
    }
    return redirect()->route('login'); 
})->name('home');

Route::get('/home', function () {
    if (Auth::check()) {
        return view('HomePage');
    }
    return redirect()->route('login');
});


// =======================================================
// 3. ROUTE YANG DILINDUNGI (PERLU LOGIN - middleware 'auth')
// =======================================================

Route::middleware(['auth'])->group(function () {
    
    // Daftar ikan (produk)
    Route::get('/fishView', [FishController::class, 'fishView'])->name('fish.view');

    // Detail produk
    Route::get('/fishDetail/{id}', [FishController::class, 'fishDetail'])->name('fish.detail');
    Route::get('/fish/{slug}', [FishController::class, 'fishDetail'])->name('fish.show');

    // Keranjang
    Route::get('/keranjang/tambah/{id}', [CartController::class, 'tambah'])->name('keranjang.tambah');
    Route::get('/keranjang', [CartController::class, 'index'])->name('keranjang.index');
    Route::delete('/keranjang/hapus/{id}', [CartController::class, 'hapus'])->name('keranjang.hapus');
    Route::patch('/keranjang/update/{id}', [CartController::class, 'update'])->name('keranjang.update');

    // Metode pembayaran
    Route::get('/metodepembayaran', [CheckoutController::class, 'showPaymentForm'])->name('metode.pembayaran');

    // Proses checkout
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

    // Sukses checkout
    Route::get('/pesanan/sukses', [CheckoutController::class, 'success'])->name('pesanan.sukses');
    
    // Hubungi Kami
    Route::get('/hubungi-kami', function () {
        return view('Hubungi-Kami'); 
    })->name('hubungi-kami');

    // Kategori
    Route::get('/kategori-barang', [KategoriController::class, 'index'])->name('kategori.barang');
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');

   // 🔹 Riwayat Pemesanan
Route::get('/riwayat-pesanan', [CheckoutController::class, 'riwayat'])->name('riwayat.pesanan');

// 🔹 Claim Garansi
Route::get('/claim-garansi/{id}', [CheckoutController::class, 'claimGaransi'])->name('claim.garansi');
Route::post('/claim-garansi/{id}', [CheckoutController::class, 'submitClaimGaransi'])->name('claim.garansi.submit');

Route::get('/upload-vidio', function () {
    return view('UploadVidio');
})->name('upload.vidio');

});
