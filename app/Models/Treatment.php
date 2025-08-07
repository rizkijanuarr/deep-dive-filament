<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;

    protected $table = 'treatments';

    protected $fillable = [
        'description',
        'notes',
        'patient_id',
        'price',
    ];

    public function patients(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Patient::class);
    }
}
