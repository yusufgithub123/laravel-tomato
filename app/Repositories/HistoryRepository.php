<?php
// app/Repositories/HistoryRepository.php

namespace App\Repositories;

use App\Models\History;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HistoryRepository
{
    public function getAll($userId = null)
    {
        $query = History::query();
        
        if ($userId) {
            $query->where('user_id', $userId);
        } elseif (Auth::check()) {
            $query->where('user_id', Auth::id());
        }
        
        return $query->latest()->get();
    }

    public function create(array $data)
    {
        // Tambahkan user_id jika user login
        if (Auth::check()) {
            $data['user_id'] = Auth::id();
        }
        
        return History::create($data);
    }

    public function find($id)
    {
        $history = History::findOrFail($id);
        
        // Pastikan hanya pemilik yang bisa akses
        if (Auth::check() && $history->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }
        
        return $history;
    }

    public function update($id, array $data)
    {
        $history = $this->find($id);
        $history->update($data);
        return $history;
    }

    public function delete($id)
    {
        $history = $this->find($id);
        
        // Hapus file gambar
        if ($history->image_path && Storage::disk('public')->exists($history->image_path)) {
            Storage::disk('public')->delete($history->image_path);
        }
        
        $history->delete();
        return true;
    }

    public function getStatistics($userId = null)
    {
        $query = History::query();
        
        if ($userId) {
            $query->where('user_id', $userId);
        } elseif (Auth::check()) {
            $query->where('user_id', Auth::id());
        }
        
        return [
            'total_scans' => $query->count(),
            'healthy_scans' => $query->where('is_healthy', true)->count(),
            'diseased_scans' => $query->where('is_healthy', false)->count(),
            'average_accuracy' => $query->avg('accuracy') ?? 0,
            'latest_scan' => $query->latest()->first()
        ];
    }
}