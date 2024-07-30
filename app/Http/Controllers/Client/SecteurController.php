<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Secteur;
use App\Models\User;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SecteurController extends Controller
{
    public function index()
    {
        $secteurs = Secteur::with(['conseiller_data'])->get();
        $users = User::where('role', 2)->get();
        return view('pages.category.home')->with('secteurs', $secteurs)->with('users', $users);
    }

    public function add()
    {
        $secteurs = Secteur::with(['conseiller_data'])->get();
        $users = User::where('role', 2)->get();
        return view('pages.category.add')->with('secteurs', $secteurs)->with('users', $users);
    }

    public function store(Request $request)
    {

        $request->validate(
            [
                'libelle' => 'required|unique:secteurs|max:255',
                'user' => 'required|:secteurs',
                'image' => 'required|mimes:jpg,jpeg,png',
            ],

            [
                'libelle.required' => 'Champ obligatoire!',
                'user.required' => 'Champ obligatoire!',
                'image.required' => 'Image requise!',
            ]
        );

        $secteur_image = $request->file('image');

        $name_gen = hexdec(uniqid());
        $img_ext = strtolower($secteur_image->getClientOriginalExtension());
        $img_name = $name_gen . '.' . $img_ext;
        $up_location = 'images/secteurs/';
        $secteur_image->move($up_location, $img_name);



        // $data = $request->input();
        $data = array();
        $data['slug'] = Str::slug($request->libelle);
        $data['libelle'] = $request->libelle;
        $data['user'] = $request->user;
        $data['photo'] = url($up_location) . '/' . $img_name;



        Secteur::create($data);

        Toastr::success('Secteur ajouté avec succès!', 'Succès');

        return redirect()->intended(route('category.home'));
    }

    public function edit($id)
    {
        $secteur = Secteur::with(['conseiller_data'])->find($id);
        $users = User::where('role', 2)->get();
        return view('pages.category.edit')->with('secteur', $secteur)->with('users', $users);
    }

    public function update($id, Request $request)
    {
        $request->validate(
            [
                'libelle' => 'required|:secteurs',
                'user' => 'required|:secteurs',
            ],

            [
                'libelle.required' => 'Champ obligatoire!',
                'user.required' => 'Champ obligatoire!',
            ]
        );

        $old_image = $request->oldimage;

        $secteur_image = $request->file('image');

        if ($secteur_image) {
            $name_gen = hexdec(uniqid());
            $img_ext = strtolower($secteur_image->getClientOriginalExtension());
            $img_name = $name_gen . '.' . $img_ext;
            $up_location = 'images/secteurs/';
            $secteur_image->move($up_location, $img_name);

            $path = parse_url($old_image);

            File::delete(public_path($path['path']));

            $data = Secteur::find($id);
            $data->libelle = $request->libelle;
            $data->user = $request->user;
            $data->photo = url($up_location) . '/' . $img_name;
            $data->slug = Str::slug($request->libelle);
            $data->save();
        } else {
            $data = Secteur::find($id);
            $data->libelle = $request->libelle;
            $data->user = $request->user;
            $data->slug = Str::slug($request->libelle);
            $data->save();
        }

        Toastr::success('Secteur mis à jour avec succès!', 'Success');

        return redirect()->intended(route('category.home'));
    }

    public function delete($id)
    {
        $secteur = Secteur::find($id);

        if (!empty($secteur->photo)) {
            $path = parse_url($secteur->photo);
            $file = public_path($path['path']);

            if (File::exists($file)) {
                File::delete($file);
            }
        }

        Secteur::find($id)->delete();
        Toastr::success('Secteur supprimé avec succès!', 'Success');

        return redirect()->intended(route('category.home'));
    }

    public function GetUserEdit($user_id)
    {
        $sub = Secteur::where('id', $user_id)->first();
        return response()->json($sub);
    }
}
