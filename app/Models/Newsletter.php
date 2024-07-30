<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'titre',
        'mail',
        'send'
    ];

    protected $casts = [
        'send' => 'boolean',
    ];
}
