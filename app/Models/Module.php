<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'module',
        'description'
    ];

    public function users()
    {
        return $this->belongsToMany(Module::class, 'privileges', 'module', 'user')->withPivot('consulter', 'modifier', 'ajouter', 'supprimer');
    }
}
