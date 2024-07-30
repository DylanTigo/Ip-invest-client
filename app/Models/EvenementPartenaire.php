<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class EvenementPartenaire extends Model
{
    use HasFactory;
    protected $table = 'evenement_partner';

    protected $fillable = [
        'evenement_id',
        'image',
    ];
}

