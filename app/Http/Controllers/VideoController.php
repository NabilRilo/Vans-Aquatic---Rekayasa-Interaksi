<?php

// app/Http/Controllers/VideoController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    // ... (fungsi index)

    public function upload(Request $request)
    {
        // 1. Validasi File (Salah satu harus diisi)
        $request->validate([
            'video' => 'nullable|mimes:mp4,mov,avi,mkv|max:500000', // Video: Maks 500MB
            'photo' => 'nullable|image|max:10240', // Foto: Maks 10MB
        ]);

        // Pastikan setidaknya satu file di-upload
        if (!$request->hasFile('video') && !$request->hasFile('photo')) {
            return redirect()->back()->withErrors(['file' => 'Anda harus memilih setidaknya satu Video atau Foto untuk diunggah.']);
        }

        // Variabel untuk data yang akan disimpan
        $path = null;
        $judul = null;
        
        // 2. Proses Upload Video
        if ($request->hasFile('video')) {
            $path = $request->file('video')->store('videos', 'public');
            $judul = 'Video: ' . $request->file('video')->getClientOriginalName();
        }

        // 3. Proses Upload Foto
        if ($request->hasFile('photo')) {
            // Gunakan direktori yang berbeda untuk foto di storage
            $path = $request->file('photo')->store('photos', 'public'); 
            $judul = 'Foto: ' . $request->file('photo')->getClientOriginalName();
        }

        // 4. Simpan Data ke Database
        Video::create([
            'judul' => $judul ?? 'Media Tidak Dikenal', 
            'video_path' => $path, // Kita menggunakan kolom video_path untuk menyimpan path media apapun (foto atau video)
        ]);

        return redirect()->route('upload.vidio')->with('success', 'Media berhasil diupload dan tercatat di admin!');
}
}