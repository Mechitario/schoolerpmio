<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = ['name', 'roll_number', 'class_name', 'section', 'year'];

    protected $casts = [
        'year' => 'integer',
    ];

    public function fees(): HasMany
    {
        return $this->hasMany(Fee::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class);
    }
}
