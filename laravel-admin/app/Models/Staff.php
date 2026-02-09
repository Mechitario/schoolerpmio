<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Staff extends Model
{
    protected $table = 'staff';

    protected $fillable = ['name', 'role', 'salary'];

    public function salaries(): HasMany
    {
        return $this->hasMany(Salary::class);
    }
}
