<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tools extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = 'tools';

    protected $fillable = [
        'name',
    ];

    protected $casts = [
        // 'is_active' => 'boolean',
        // 'settings' => 'array',
        // 'data' => 'json',
        // 'published_at' => 'datetime',
    ];
}
