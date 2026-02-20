<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = ['name', 'roll_number', 'class_name', 'section', 'year', 'parent_id'];

    protected $casts = [
        'year' => 'integer',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Guardian::class, 'parent_id');
    }

    public function fees(): HasMany
    {
        return $this->hasMany(Fee::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class);
    }
}
