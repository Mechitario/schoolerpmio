<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryCategory extends Model
{
    protected $fillable = ['name', 'total_lot', 'sold_lot'];

    protected $casts = [
        'total_lot' => 'integer',
        'sold_lot' => 'integer',
    ];

    public function getRemainingLotAttribute(): int
    {
        return max(0, $this->total_lot - $this->sold_lot);
    }
}
