<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Result extends Model
{
    protected $fillable = ['student_id', 'subject', 'marks', 'total_marks', 'exam_name'];

    protected $casts = [
        'marks' => 'decimal:2',
        'total_marks' => 'decimal:2',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function getPercentageAttribute(): float
    {
        return $this->total_marks > 0
            ? round(($this->marks / $this->total_marks) * 100, 1)
            : 0;
    }
}
