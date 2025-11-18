<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tambahproduk;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // Menampilkan halaman metode pembayaran
    public function showPaymentForm()
    {
        $keranjang = session()->get('keranjang', []);
        $total_harga = 0;
        foreach ($keranjang as $item) {
            $total_harga += $item['harga'] * $item['jumlah'];
        }
        return view('MetodePembayaran', compact('keranjang', 'total_harga'));
    }

    // Proses checkout
    public function process(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'metode' => 'required|string|max:50',
            'bukti_pembayaran' => 'nullable|image|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'total_harga' => 'required|numeric',
        ]);

        $keranjangItems = Session::get('keranjang', []);

        if (empty($keranjangItems)) {
            return redirect()->route('home')->with('error', 'Keranjang belanja Anda kosong!');
        }

        DB::beginTransaction();

        try {
            $buktiPembayaranPath = null;
            if ($request->hasFile('bukti_pembayaran')) {
                $buktiPembayaranPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
            }

            // Kurangi stok
            foreach ($keranjangItems as $productId => $item) {
                $jumlahDibeli = $item['jumlah'];
                $produk = Tambahproduk::where('id', $productId)->lockForUpdate()->first();
                if ($produk && $produk->stok >= $jumlahDibeli) {
                    $produk->stok -= $jumlahDibeli;
                    $produk->save();
                } else {
                    throw new \Exception("Stok untuk produk '{$item['nama']}' tidak mencukupi.");
                }
            }

            // Simpan transaksi
            $transaksi = Transaksi::create([
                'nama_pembeli' => $validatedData['nama'],
                'alamat' => $validatedData['alamat'],
                'no_hp' => $validatedData['no_hp'],
                'metode_pembayaran' => $validatedData['metode'],
                'bukti_pembayaran' => $buktiPembayaranPath,
                'total_harga' => $validatedData['total_harga'],
                'status' => 'Proses', // ✅ default status
            ]);

            // Simpan item transaksi
            foreach ($keranjangItems as $productId => $item) {
                TransaksiItem::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $productId,
                    'jumlah' => $item['jumlah'],
                    'harga' => $item['harga'],
                ]);
            }

            DB::commit();
            Session::forget('keranjang');

            return redirect()->route('pesanan.sukses')->with('success', 'Pesanan berhasil diproses!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput($request->except('bukti_pembayaran'))->with('error', $e->getMessage());
        }
    }

    // Halaman sukses checkout
    public function success()
    {
        return view('PesananSukses');
    }

    // Halaman riwayat pesanan
    public function riwayat()
    {
        $orders = Transaksi::with('items.produk')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('RiwayatPesanan', compact('orders'));
    }
}
