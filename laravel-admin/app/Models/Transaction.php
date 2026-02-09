<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['type', 'amount', 'description', 'date'];

    protected $casts = [
        'date' => 'datetime',
        'amount' => 'decimal:2',
    ];
}
