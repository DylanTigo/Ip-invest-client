<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'type',
        'url',
        'source',
        'projet',
        'message',
        'actualite'
    ];

    public static function getAllowedFiles()
    {
        return ['pdf', 'doc', 'docx', 'pptx', 'ppt', 'xls', 'xlsx', 'txt', 'zip', 'rar', '7z'];
    }

    public static function getAllowedImages()
    {
        return ['png', 'jpg', 'jpeg', 'gif', '.ico', '.psd', '.tif', '.webp'];
    }

    public static function getAllowedVideos()
    {
        return ['mp4', 'avi', 'mkv', 'm4v', 'mpg', 'mpeg', 'mov', '3gp'];
    }

    public function message_data()
    {
        return $this->belongsTo(Message::class, 'message', 'id');
    }

    public function projet_data()
    {
        return $this->belongsTo(Projet::class, 'projet', 'id');
    }

    public function actualite_data()
    {
        return $this->belongsTo(Actualite::class, 'actualite', 'id');
    }
}
