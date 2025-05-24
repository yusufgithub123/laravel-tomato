<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\History;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Silakan login untuk melihat riwayat.');
        }

        $histories = History::where('user_id', Auth::id())
                          ->orderBy('created_at', 'desc')
                          ->get();

        return view('pages.history', compact('histories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|max:2048',
            'disease_name' => 'required|string|max:255',
            'accuracy' => 'required|numeric|between:0,100',
            'is_healthy' => 'required|boolean',
            'solution' => 'nullable|string'
        ]);

        if (!Auth::check()) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthenticated'
        ], 401);
    }

        // Simpan gambar
        $imagePath = $request->file('image')->store('history_images', 'public');

        // Simpan ke database
        History::create([
            'user_id' => Auth::id(),
            'image_path' => $imagePath,
            'disease_name' => $validated['disease_name'],
            'accuracy' => $validated['accuracy'],
            'is_healthy' => $validated['is_healthy'],
            'solution' => $validated['solution'] ?? null
        ]);

        return response()->json([
        'success' => true,
        'redirect' => route('history')
    ]);

    }

    public function destroy($id)
    {
        $history = History::findOrFail($id);
        
        // Pastikan hanya pemilik yang bisa menghapus
        if ($history->user_id !== Auth::id()) {
            abort(403);
        }

        // Hapus file gambar
        Storage::disk('public')->delete($history->image_path);
        
        $history->delete();

        return back()->with('success', 'Riwayat berhasil dihapus.');
    }
}