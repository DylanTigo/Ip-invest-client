<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Membre;
use App\Models\User;
use Illuminate\Http\Request;

class MembreController extends Controller
{
    public function store(Request $request)
    {
        $photo = $request->file('photo');
        $cni = $request->file('cni');
        $data = $request->input();

        $user = User::find($data['user']);

        if (!empty($photo)) {
            $filename = hexdec(uniqid()) . '.' . strtolower($photo->getClientOriginalExtension());
            $data['photo'] = url('storage/uploads/'.$user->folder.'/membres/') . '/' . $filename;
            $photo->storeAs('uploads/'.$user->folder.'/membres/', $filename, ['disk' => 'public']);
        }

        if (!empty($cni)) {
            $filename = hexdec(uniqid()) . '.' . strtolower($cni->getClientOriginalExtension());
            $data['cni'] = url('storage/uploads/'.$user->folder.'/membres/') . '/' . $filename;
            $cni->storeAs('uploads/'.$user->folder.'/membres/', $filename, ['disk' => 'public']);
        }
        
        $membre = Membre::create($data);

        return $this->sendResponse($membre, 'Membre created');
    }

    public function index($id)
    {
        $membres = Membre::where('user', $id)->get();
        return $this->sendResponse($membres, 'All members');
    }

    public function show($id)
    {
        $membre = Membre::find($id);
        $this->sendResponse($membre, 'Member');
    }

    public function delete($id)
    {
        $membre = Membre::find($id);
        $membre->delete();
        $this->sendResponse([], 'Member delete');
    }
}
