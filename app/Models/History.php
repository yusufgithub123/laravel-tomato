<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = [
        'user_id', 'image_path', 'disease_name', 
        'accuracy', 'is_healthy', 'solution'
    ];

    protected $casts = [
        'is_healthy' => 'boolean',
        'accuracy' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}