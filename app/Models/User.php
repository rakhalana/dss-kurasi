<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Model representasi pengguna sistem (Admin & Kurator)
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Kolom-kolom yang dapat diisi secara massal
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Kolom-kolom yang disembunyikan untuk keperluan serialisasi data
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casting tipe data kolom database ke tipe data PHP
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
