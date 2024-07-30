<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\DocumentFiscaux;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function show($id)
    {
        return $this->sendResponse(User::with(['role_data', 'documents_fiscaux', 'profil_invest'])->find($id), 'User details');
    }

    public function updatePassword($id, Request $request)
    {
        $user = User::find($id);

        if (!empty($user) && !Hash::check($request->old, $user->password)) {
            return $this->sendError('Mot de passe incorrect', null, 401);
        }

        $user->password = Hash::make($request->new);
        $user->save();

        return $this->sendResponse(null, 'Mot de passe modifié');
    }

    public function update($id, Request $request)
    {
        $data = $request->except('password');

        $user = User::find($id);

        if (!empty($request->email)) {
            $emailExist = User::where('email', $request->email)->where('email', '<>', $user->email)->exists();
            if ($emailExist) {
                return $this->sendError("L'email '$request->email' à déjà été utilisé pour un compte. Veuillez fournir une autre adresse mail.", null, 500);
            }
        }

        if (!empty($request->telephone)) {
            $telephoneExist = User::where('telephone', $request->telephone)->where('telephone', '<>', $user->telephone)->exists();
            if ($telephoneExist) {
                return $this->sendError("Le numéro de téléphone '$request->telephone' à déjà été utilisé pour un compte. Veuillez fournir un autre numéro de téléphone.", null, 500);
            }
        }

        User::whereId($id)->update($data);

        return $this->show($id);
    }

    public function deviceToken($id, Request $request)
    {
        $user = User::find($id);
        $user->device_token = $request->device_token;
        $user->save();
        return $this->show($id);
    }

    public function uploadProfilePicture($id, Request $request)
    {
        $photo = $request->file('photo');
        $user = User::find($id);

        if (!empty($photo)) {
            $filename = 'photo.' . strtolower($photo->getClientOriginalExtension());
            $user->photo = url('storage/uploads/' . $user->folder) . '/' . $filename;
            $photo->storeAs('uploads/' . $user->folder . '/', $filename, ['disk' => 'public']);
        }

        $user->save();

        return $this->show($id);
    }

    public function uploadCni($id, Request $request)
    {
        $cni = $request->file('cni');
        $user = User::find($id);

        if (!empty($cni)) {
            $filename = 'cni.' . strtolower($cni->getClientOriginalExtension());
            $user->cni = url('storage/uploads/' . $user->folder) . '/' . $filename;
            $cni->storeAs('uploads/' . $user->folder . '/', $filename, ['disk' => 'public']);
        }

        $user->save();

        return $this->show($id);
    }

    public function uploadDocumentFiscal($id, Request $request)
    {
        $document = $request->file('document');
        $user = User::find($id);
        $exist = DocumentFiscaux::where('type', $request->type)->where('user', $id)->first();

        $data = [
            'type' => $request->type,
            'user' => $id
        ];

        if (!empty($document)) {
            $filename = Str::lower($request->type) . '.' . strtolower($document->getClientOriginalExtension());
            $data['document'] = url('storage/uploads/' . $user->folder . '/doucment_fiscaux') . '/' . $filename;
            $document->storeAs('uploads/' . $user->folder . '/doucment_fiscaux/', $filename, ['disk' => 'public']);
        }

        if (!empty($exist)) {
            $file = substr($exist->document, strrpos($exist->document, '/') + 1);
            Storage::disk('public')->delete('uploads/' . $user->folder . '/doucment_fiscaux/' . $file);
            $exist->document = $data['document'];
            $exist->save();
            return $this->show($id);
        }

        $document = DocumentFiscaux::create($data);

        return $this->show($id);
    }

    public function sendMailInfo(Request $request)
    {
        $data = $request->input();

        try {
            Mail::to('info@invest--partners.com')->queue(new ContactMail($data));
        } catch (\Throwable $e) {
            return $this->sendError('Impossible d\'envoyer un mail car l\'email n\'existe pas.', null, 500);
        }

        return $this->sendResponse(null, 'Mail send');
    }
}