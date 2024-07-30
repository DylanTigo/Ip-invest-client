<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    use HasFactory;

    protected $fillable = [
        'user',
        'module',
        'consulter',
        'modifier',
        'ajouter',
        'supprimer'
    ];

    protected $casts = [
        'consulter' => 'boolean',
        'modifier' => 'boolean',
        'ajouter' => 'boolean',
        'supprimer' => 'boolean'
    ];

    public function module_data()
    {
        return $this->belongsTo(Module::class, 'module', 'id');
    }

    public function user_data()
    {
        return $this->belongsTo(User::class, 'user', 'id');
    }
}
