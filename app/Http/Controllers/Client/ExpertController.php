<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Expert;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\File;

class ExpertController extends Controller
{
    public function index()
    {
        $experts = Expert::all();
        return view('pages.experts.home', compact('experts'));
    }

    public function add()
    {
        return view('pages.experts.add');
    }

    public function store(Request $request)
    {
        $data = array();

        if ($request->has('photo')) {
            $facture = $request->file('photo');
            $fileExt = strtolower($facture->getClientOriginalExtension());
            $data['photo'] = hexdec(uniqid()) . '.' . $fileExt;
            $data['photo_url'] = url('storage/uploads/experts/'.$data['photo']);
            $facture->storeAs('uploads/experts/', $data['photo'], ['disk' => 'public']);
        }

        $data['nom_complet'] = $request->nom_complet;
        $data['description'] = $request->description;
        $data['fonction'] = $request->fonction;
        $data['telephone'] = $request->telephone;
        $data['email'] = $request->email;

        Expert::create($data);

        Toastr::success('Expert ajouté avec succès!', 'Succès');

        return redirect()->intended(route('experts.home'));
    }

    public function edit($id)
    {
        $expert = Expert::find($id);
        return view('pages.experts.edit', compact('expert'));
    }

    public function update(Request $request, $id)
    {
        $data = Expert::find($id);

        $form = [
            'nom_complet' => $request->nom_complet,
            'description' => $request->description,
            'fonction' => $request->fonction,
            'telephone' => $request->telephone,
            'email' => $request->email,
        ];

        if ($request->has('photo')) {
            File::delete(storage_path('app/public/uploads/experts/' . $data->photo));
            $facture = $request->file('photo');
            $fileExt = strtolower($facture->getClientOriginalExtension());
            $data['photo'] = hexdec(uniqid()) . '.' . $fileExt;
            $data['photo_url'] = url('storage/uploads/experts/'.$data['photo']);
            $facture->storeAs('uploads/experts/', $data['photo'], ['disk' => 'public']);
        }

        $data->update($form);

        return redirect()->intended(route('experts.home'));
    }

    public function delete($id)
    {
        $expert = Expert::find($id);

        File::delete(storage_path('app/public/uploads/experts/' . $expert->photo));

        Expert::find($id)->delete();

        Toastr::success('Expert supprimé avec succès!', 'Success');

        return back();
    }
}
