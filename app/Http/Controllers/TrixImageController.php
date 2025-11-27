<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrixImageController extends Controller
{
    public function store(Request $request)
    {
        if ($request->hasFile('file')) {
            // Validasi file (opsional tapi disarankan)
            $request->validate([
                'file' => 'required|image|max:2048', // Max 2MB
            ]);

            // Simpan file ke folder 'public/trix-images'
            $path = $request->file('file')->store('trix-images', 'public');

            // Kembalikan URL publik gambar tersebut
            return response()->json([
                'url' => Storage::url($path)
            ], 200);
        }

        return response()->json(['error' => 'No file uploaded.'], 400);
    }
}