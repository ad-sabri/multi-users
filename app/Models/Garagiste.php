<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Garagiste extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'locality',
        'tva',
        'user_id'
    ];

    public function user()
    {
        return $this->morphOne(User::class, 'role');
    }
}
