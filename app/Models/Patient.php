<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';

    protected $fillable = [
        'date_of_birth',
        'name',
        'owner_id',
        'type',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Owner::class);
    }

    public function treatments(): HasMany
    {
        return $this->hasMany(\App\Models\Treatment::class);
    }
}
