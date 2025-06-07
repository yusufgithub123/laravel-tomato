<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'image_path',
        'disease_name',
        'disease_class',
        'accuracy',
        'is_healthy',
        'symptoms',
        'causes',
        'prevention',
        'treatment',
        'severity'
    ];

    protected $casts = [
        'accuracy' => 'decimal:2',
        'is_healthy' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getSeverityColorAttribute(): string
    {
        return match($this->severity) {
            'none' => '#4CAF50',      // Green
            'low' => '#FFC107',       // Yellow
            'medium' => '#FF9800',    // Orange
            'high' => '#F44336',      // Red
            default => '#9E9E9E'      // Gray
        };
    }

    public function getSeverityTextAttribute(): string
    {
        return match($this->severity) {
            'none' => 'Tidak Ada',
            'low' => 'Ringan',
            'medium' => 'Sedang',
            'high' => 'Berat',
            default => 'Tidak Diketahui'
        };
    }
}