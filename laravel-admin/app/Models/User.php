<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'can_view_dashboard',
        'can_view_admin_users',
        'can_view_students',
        'can_view_staff',
        'can_view_fees',
        'can_view_academics',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'can_view_dashboard' => 'boolean',
            'can_view_admin_users' => 'boolean',
            'can_view_students' => 'boolean',
            'can_view_staff' => 'boolean',
            'can_view_fees' => 'boolean',
            'can_view_academics' => 'boolean',
        ];
    }
}
