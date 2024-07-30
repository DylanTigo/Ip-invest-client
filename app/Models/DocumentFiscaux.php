<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentFiscaux extends Model
{
    use HasFactory;

    protected $table = 'documents_fiscaux';

    protected $fillable = [
        'type',
        'document',
        'user'
    ];

    public function user_data(){
        return $this->belongsTo(User::class, 'user', 'id');
    }
}
