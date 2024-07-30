<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expert extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_complet',
        'fonction',
        'telephone',
        'email',
        'description',
        'cacher',
        'photo',
        'photo_url'
    ];

    protected $casts = [
        'cacher' => 'boolean'
    ];
}
