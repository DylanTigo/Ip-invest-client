<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'recepteur', 'envoyeur', 'conversation', 'message', 'piece_jointe', 'projet'
    ];

    public static function fetchMessage($sender, $receiver)
    {
        return Message::where('recepteur', $sender)->orWhere('envoyeur', $sender)->latest()->with(['attachements', 'sender', 'receiver'])->get();
        return (new self)->fetchMessagesQuery($sender, $receiver)->orderBy('created_at', 'asc')->get();
    }

    public function fetchMessagesQuery($sender, $receiver)
    {
        return Message::where('recepteur', $receiver)->where('envoyeur', $sender)
            ->orWhere('recepteur', $sender)->where('envoyeur', $receiver);
    }

    public static function makeVu($sender, $receiver)
    {
        Message::where('recepteur', $sender)
            ->where('envoyeur', $receiver)
            ->where('vu', 0)
            ->update(['vu' => 1]);
    }

    public static function makeSeen($sender, $conversation)
    {
        $messages = Message::where('recepteur', $sender)
            ->where('conversation', $conversation)
            ->where('vu', 0)->get();

        foreach ($messages as $value) {
            $value->vu = 1;
            $value->save();
        }
    }

    public function getLastMessageQuery($sender, $receiver)
    {
        return $this->fetchMessagesQuery($sender, $receiver)->latest()->first();
    }

    public static function getLastestOrderMessageQuery($conversation)
    {
        return Message::where('conversation', $conversation)
            ->latest()
            ->with(['attachements', 'sender', 'receiver', 'projet_data'])
            ->get();
    }

    public static function getLastestMessageQuery($conversation)
    {
        return Message::where('conversation', $conversation)
            ->latestReverse()
            ->with(['attachements', 'sender', 'receiver'])
            ->get();
    }

    public static function countUnvuMessages($sender, $conversation)
    {
        return Message::where('recepteur', $sender)->where('conversation', $conversation)->where('vu', 0)->count();
    }

    public static function getContacts($sender)
    {
        $contacts = [];

        $conversations = DB::table('messages')
            ->latest()
            ->select('conversation')
            ->distinct()
            ->where('envoyeur', $sender)
            ->orWhere('recepteur', $sender)->get();

        foreach ($conversations as $item) {
            $contact = Message::where('conversation', $item->conversation)
                ->latest()
                ->first();
            $contact->not_seen = Message::where('conversation', $item->conversation)
                ->where('vu', 0)
                ->where('recepteur', $sender)
                ->count();
                
            $contact->sender_data = User::find($contact->envoyeur);

            if ($contact->envoyeur != $sender) {
                $contact->recepteur = $contact->envoyeur;
            }

            $contact->envoyeur = (int) $sender;
            $contact->recepteur = User::find($contact->recepteur);

            if (!empty($contact->projet)) {
                $contact->projet = Projet::find($contact->projet);
            }

            array_push($contacts, $contact);
        }

        $collection = collect($contacts);

        $sorted = $collection->sortByDesc('created_at');

        $sorted->values()->all();

        return $sorted->values();
    }

    public static function deleteConversation($conversation)
    {
        Message::where('conversation', $conversation)->get();
        $path = storage_path('app/public/messages/' . $conversation);
        if (File::exists($path)) {
            File::deleteDirectory($path);
        }
    }

    public static function deleteMessage($message)
    {
        $files = Archive::where('message', $message)->get();
        $toDelete = Message::where('id', $message)->where('vu', 0)->first();

        foreach ($files as $file) {
            $path = storage_path("app/public/messages/$toDelete->conversation/$file->nom");
            if (File::exists($path)) {
                File::delete($path);
            }
            $file->delete();
        }
        $toDelete->delete();
    }

    public function attachements()
    {
        return $this->hasMany(Archive::class, 'message', 'id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'envoyeur', 'id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'recepteur', 'id');
    }

    public function projet_data()
    {
        return $this->belongsTo(Projet::class, 'projet', 'id');
    }

    public function scopeLatestReverse($query)
    {
        return $query->orderBy('created_at', 'ASC');
    }
}
