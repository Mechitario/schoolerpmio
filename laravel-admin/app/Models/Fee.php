<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fee extends Model
{
    protected $fillable = ['student_id', 'amount', 'paid_amount', 'status', 'month', 'paid_date'];

    protected $casts = [
        'paid_date' => 'datetime',
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::saving(function (Fee $fee) {
            $paid = (float) ($fee->paid_amount ?? 0);
            $total = (float) ($fee->amount ?? 0);
            $pending = $total - $paid;
            if ($pending <= 0) {
                $fee->status = 'PAID';
            } elseif ($paid <= 0) {
                $fee->status = 'PENDING';
            } else {
                $fee->status = 'PARTIAL';
            }
            if ($paid > 0 && ! $fee->paid_date) {
                $fee->paid_date = now();
            }
            if ($paid <= 0) {
                $fee->paid_date = null;
            }
        });
    }

    public function getPendingAmountAttribute(): float
    {
        $total = (float) $this->amount;
        $paid = (float) ($this->paid_amount ?? 0);
        return max(0, $total - $paid);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'PAID' => 'Fully paid',
            'PENDING' => 'Pending',
            'PARTIAL' => 'Partial',
            default => $this->status,
        };
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
