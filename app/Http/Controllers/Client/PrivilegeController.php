<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Privilege;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class PrivilegeController extends Controller
{
    public function InsertWriter()
    {
        $users = User::whereIn('role', [1, 2, 5])->with(['role_data'])->get();
        $modules = Module::all();
        return view('pages.privilege.insert', compact('users', 'modules'));
    }

    public function StoreWriter(Request $request)
    {
        $privilege = Privilege::where('user', $request->user)->where('module', $request->module)->first();

        if (empty($privilege)) {
            $privilege = new Privilege();
            $privilege->user = $request->user;
            $privilege->module = $request->module;
        }

        $privilege->consulter = $request->consulter;
        $privilege->modifier = $request->modifier;
        $privilege->ajouter = $request->ajouter;
        $privilege->supprimer = $request->supprimer;

        $privilege->save();

        Toastr::success('Privilège ajouté avec succès!', 'Succès');
        return back();
    }

    public function AllWriter()
    {
        $users = User::whereIn('role', [1, 2, 5])->latest()->with(['role_data', 'modules'])->get();
        return view('pages.privilege.index', compact('users'));
    }

    public function EditWriter($id)
    {
        $privilege = Privilege::with(['user_data', 'module_data'])->find($id);
        return view('pages.privilege.edit')->with('privilege', $privilege);
    }

    public function UpdateWriter($privilege, Request $request)
    {
        $data = Privilege::find($privilege);
        $data->consulter = $request->consulter;
        $data->modifier = $request->modifier;
        $data->ajouter = $request->ajouter;
        $data->supprimer = $request->supprimer;

        $data->save();

        Toastr::success('Privilège modifié avec succès!', 'Succès');
        return redirect()->route('all.writer');
    }

    public function DeleteWriter($privilege)
    {
        Privilege::find($privilege)->delete();
        Toastr::success('Privilège supprimé avec succès!', 'Succès');
        return redirect()->back();
    }
}
