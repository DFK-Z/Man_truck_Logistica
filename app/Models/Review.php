<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'message', 'rating', 'is_approved'
    ];

    // Связь с пользователем
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Аксессор для имени пользователя
    public function getUserNameAttribute()
{
    return $this->user ? $this->user->name : 'Пользователь удалён';
}
}
