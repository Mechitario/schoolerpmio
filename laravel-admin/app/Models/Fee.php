<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fee extends Model
{
    protected $fillable = [
        'student_id',
        'parent_id',
        'amount',
        'paid_amount',
        'status',
        'month',
        'payment_date',
        'paid_date',
        'copy_fee',
        'dress_fee',
        'book_fee',
        'exam_fee',
        'received_amount',
        'balance_carried_forward',
        'remarks',
        'waived_off',
    ];

    protected $casts = [
        'paid_date' => 'datetime',
        'payment_date' => 'date',
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'copy_fee' => 'decimal:2',
        'dress_fee' => 'decimal:2',
        'book_fee' => 'decimal:2',
        'exam_fee' => 'decimal:2',
        'received_amount' => 'decimal:2',
        'balance_carried_forward' => 'decimal:2',
        'waived_off' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::saving(function (Fee $fee) {
            // Calculate total from fee items if not set or zero
            if (empty($fee->amount) || $fee->amount == 0) {
                $copyFee = isset($fee->copy_fee) ? (float) $fee->copy_fee : 0;
                $dressFee = isset($fee->dress_fee) ? (float) $fee->dress_fee : 0;
                $bookFee = isset($fee->book_fee) ? (float) $fee->book_fee : 0;
                $examFee = isset($fee->exam_fee) ? (float) $fee->exam_fee : 0;
                $calculatedTotal = $copyFee + $dressFee + $bookFee + $examFee;
                if ($calculatedTotal > 0) {
                    $fee->amount = $calculatedTotal;
                }
            }
            
            // received_amount = paid_amount (they are the same)
            if (isset($fee->received_amount)) {
                $fee->paid_amount = (float) $fee->received_amount;
            } elseif (!isset($fee->paid_amount)) {
                $fee->paid_amount = 0;
            }
            
            // Ensure received_amount matches paid_amount
            $fee->received_amount = $fee->paid_amount;
            
            $total = (float) ($fee->amount ?? 0);
            $paid = (float) ($fee->paid_amount ?? 0);
            $waived = isset($fee->waived_off) ? (float) $fee->waived_off : 0;
            
            // Waived off is added to paid/received amount for calculation
            // Effective paid = paid + waived
            $effectivePaid = $paid + $waived;
            $pending = $total - $effectivePaid;
            
            // Status calculation: total - (paid + waived) = pending
            if ($total > 0 && $effectivePaid >= $total) {
                // Fully paid (including waived amount)
                $fee->status = 'PAID';
            } elseif ($effectivePaid > 0 && $pending > 0) {
                // Partially paid (paid + waived > 0 but pending > 0)
                $fee->status = 'PARTIAL';
            } else {
                // Not paid (paid + waived = 0)
                $fee->status = 'PENDING';
            }
            
            if ($effectivePaid > 0 && ! $fee->paid_date) {
                $fee->paid_date = $fee->payment_date ?? now();
            }
            if ($effectivePaid <= 0) {
                $fee->paid_date = null;
            }
        });
    }

    public function getPendingAmountAttribute(): float
    {
        $total = (float) ($this->amount ?? 0);
        $paid = (float) ($this->paid_amount ?? 0);
        $waived = isset($this->waived_off) ? (float) $this->waived_off : 0;
        // Waived off is added to paid amount: total - (paid + waived) = pending
        return max(0, $total - ($paid + $waived));
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

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Guardian::class, 'parent_id');
    }
}
