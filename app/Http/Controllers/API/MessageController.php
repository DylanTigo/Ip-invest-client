<?php

namespace App\Http\Controllers\API;

use App\Events\MessageEvent;
use App\Http\Controllers\Controller;
use App\Mail\InteresseProjetMail;
use App\Models\Archive;
use App\Models\Message;
use App\Models\Projet;
use App\Models\User;
use App\Notifications\MessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    public function show($sender, $receiver)
    {
        Message::makeVu($sender, $receiver);
        $messages = Message::fetchMessage($sender, $receiver);
        return $this->sendResponse($messages, 'Conversation messages');
    }

    public function inbox($sender, $conversation)
    {
        Message::makeSeen($sender, $conversation);
        $messages = Message::getLastestOrderMessageQuery($conversation);
        return $this->sendResponse($messages, 'Conversation messages');
    }

    public function showContact($sender)
    {
        $contacts = Message::getContacts($sender);
        return $this->sendResponse($contacts, 'Contacts');
    }

    public function newConversation($sender, $receiver, Request $request)
    {
        $projet = $request->has('projet') ? $request->projet : null;
        $conversationExist = Message::where('projet', $projet)
            ->where(function ($query) use ($receiver) {
                $query->where('recepteur', $receiver)
                    ->orWhere('envoyeur', $receiver);
            })
            ->where(function ($query) use ($sender) {
                $query->where('envoyeur', $sender)
                    ->orWhere('recepteur', $sender);
            })->first();

        $conversation = Str::uuid();

        if (!empty($conversationExist)) {
            $conversation = $conversationExist->conversation;
        }

        $data = [
            'recepteur' => $receiver,
            'envoyeur' => $sender,
            'conversation' => $conversation,
            'projet' => $request->has('projet') ? $request->projet : null,
            'message' => html_entity_decode(htmlentities(trim($request->input('body'))))
        ];

        $message = Message::create($data);

        if ($request->hasFile('attachement')) {
            $allowed_images = Archive::getAllowedImages();
            $allowed_files  = Archive::getAllowedFiles();
            $allowed        = array_merge($allowed_images, $allowed_files);

            $files = $request->file('attachement');

            foreach ($files as $file) {
                if ($file->getSize() < 150000000) {
                    if (in_array($file->getClientOriginalExtension(), $allowed)) {
                        $attachment_title = $file->getClientOriginalName();
                        $attachment = Str::uuid() . "." . $file->getClientOriginalExtension();
                        $file->storeAs('uploads/message/' . $conversation, $attachment_title, ['disk' => 'public']);
                        $data = [];
                        $data['message'] = $message->id;
                        $data['nom'] = $attachment_title;
                        $data['source'] = 'MESSAGE';
                        $data['type'] = in_array($file->getClientOriginalExtension(), $allowed_images) ? 'IMAGE' : 'FICHIER';
                        $data['url'] = url('storage/uploads/message/' . $conversation) . '/' . $attachment_title;
                        Archive::create($data);
                    } else {
                        return $this->sendError("Certaines extensions de fichiers ne sont pas autorisées !", [], 500);
                    }
                } else {
                    return $this->sendError("La taille de certains fichiers dépasse 150Mo !", [], 500);
                }
            }
        }

        $user = User::find($receiver);

        $user->notify(new MessageNotification($message));

        return $this->sendResponse($message, 'New message');
    }

    public function send($sender, $conversation, $receiver, Request $request)
    {
        $data = [
            'recepteur' => $receiver,
            'envoyeur' => $sender,
            'conversation' => $conversation,
            'projet' => $request->has('projet') ? $request->projet : null,
            'message' => html_entity_decode(htmlentities(trim($request->input('body'))))
        ];

        $message = Message::create($data);

        if ($request->hasFile('attachement')) {
            $allowed_images = Archive::getAllowedImages();
            $allowed_files  = Archive::getAllowedFiles();
            $allowed        = array_merge($allowed_images, $allowed_files);

            $files = $request->file('attachement');

            foreach ($files as $file) {
                if ($file->getSize() < 150000000) {
                    if (in_array($file->getClientOriginalExtension(), $allowed)) {
                        $attachment_title = $file->getClientOriginalName();
                        $attachment = Str::uuid() . "." . $file->getClientOriginalExtension();
                        $file->storeAs('uploads/message/' . $conversation, $attachment_title, ['disk' => 'public']);
                        $data = [];
                        $data['message'] = $message->id;
                        $data['nom'] = $attachment_title;
                        $data['source'] = 'MESSAGE';
                        $data['type'] = in_array($file->getClientOriginalExtension(), $allowed_images) ? 'IMAGE' : 'FICHIER';
                        $data['url'] = url('storage/uploads/message/' . $conversation) . '/' . $attachment_title;
                        Archive::create($data);
                    } else {
                        return $this->sendError("Certaines extensions de fichiers ne sont pas autorisées !", [], 500);
                    }
                } else {
                    return $this->sendError("La taille de certains fichiers dépasse 150Mo !", [], 500);
                }
            }
        }

        $user = User::find($receiver);

        if (!empty($user->device_token)) {
            $user->sendFcmNotification($data['message']);
        }

        try {
            $user->notify(new MessageNotification($message));
        } catch (\Throwable $th) {
        }


        return $this->sendResponse($message, 'New message');
    }

    public function interesse($sender, $receiver, Request $request)
    {
        $projet = $request->has('projet') ? $request->projet : null;
        $conversationExist = Message::where('projet', $projet)
            ->where(function ($query) use ($receiver) {
                $query->where('recepteur', $receiver)
                    ->orWhere('envoyeur', $receiver);
            })
            ->where(function ($query) use ($sender) {
                $query->where('envoyeur', $sender)
                    ->orWhere('recepteur', $sender);
            })->first();


        $conversation = Str::uuid();

        if (!empty($conversationExist)) {
            $conversation = $conversationExist->conversation;
        }

        $data = [
            'recepteur' => $receiver,
            'envoyeur' => $sender,
            'conversation' => $conversation,
            'projet' => $request->projet,
            'message' => html_entity_decode(htmlentities(trim($request->input('body'))))
        ];

        $message = Message::create($data);

        $projet = Projet::with(['secteur_data'])->where('id', $request->projet)->first();
        $invest = User::find($sender);

        $projet->secteur_data->conseiller_data->notify(new MessageNotification($message));

        $user = User::find($receiver);

        $user->notify(new MessageNotification($message));

        try {
            Mail::to($projet->secteur_data->conseiller_data->email)->queue(new InteresseProjetMail($projet->toArray(), $invest->toArray()));
            Mail::to('info@invest--partners.com')->queue(new InteresseProjetMail($projet->toArray(), $invest->toArray()));
        } catch (\Throwable $e) {
            return $this->sendResponse($message, $e->getMessage(), 'Impossible d\'envoyer un mail car l\'email n\'existe pas.');
        }

        return $this->sendResponse($message, 'New message');
    }

    public function seen($sender, $receiver)
    {
        $seen = Message::makeVu($sender, $receiver);
        return $this->sendResponse([], 'Message seen');
    }

    public function notification($sender, Request $request)
    {
        $seen = Message::where('recepteur', $sender)->where('vu', 0)->latest()->limit(5)->get();
        return $this->sendResponse($seen, 'Notification messages');
    }

    public function download($fileName)
    {
        $path = storage_path() . '/app/public/uploads/message/' . $fileName;
        if (file_exists($path)) {
            return response()->download($path, $fileName);
        } else {
            return $this->sendError("Désolé, le fichier n'existe pas dans notre serveur ou a peut-être été supprimé !", [], 500);
        }
    }

    public function deleteChat($conversation)
    {
        Message::deleteConversation($conversation);
        return $this->sendResponse(null, 'Delete conversation');
    }

    public function deleteMessage($id)
    {
        Message::deleteMessage($id);
        return $this->sendResponse(null, 'Delete message');
    }
}
