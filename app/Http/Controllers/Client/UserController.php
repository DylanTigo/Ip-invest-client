<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\NewInvestorMail;
use App\Models\Investissement;
use App\Models\ProfilInvestisseur;
use App\Models\Projet;
use App\Models\Role;
use App\Models\Secteur;
use App\Models\User;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function administrateur()
    {
        $users = User::where('role', 1)->with(['role_data', 'profil_invest', 'secteurs_data'])->get();
        $role = (object) [
            'name' => 'administrateur',
            'value' => 1
        ];
        return view('pages.user.home')->with('users', $users)->with('role', $role)->with('title', 'Sous-administrateurs');
    }

    public function sous_administrateur()
    {
        $users = User::where('role', 5)->with(['role_data', 'profil_invest', 'secteurs_data'])->get();
        $role = (object) [
            'name' => 'sous-administrateur',
            'value' => 5
        ];
        return view('pages.user.home')->with('users', $users)->with('role', $role)->with('title', 'Sous-administrateurs');
    }

    public function conseille()
    {
        $users = User::where('role', 2)->with(['role_data', 'profil_invest', 'secteurs_data'])->get();
        $role = (object) [
            'name' => 'conseiller',
            'value' => 2
        ];
        return view('pages.user.home')->with('users', $users)->with('role', $role)->with('title', 'Conseillers en investissement');
    }

    public function porteurProjet()
    {
        $users = User::where('role', 3)->with(['role_data', 'profil_invest', 'secteurs_data'])->get();
        $role = (object) [
            'name' => 'porteur projet',
            'value' => 3
        ];
        return view('pages.user.home')->with('users', $users)->with('role', $role)->with('title', 'Porteurs de projet');
    }

    public function investisseur()
    {
        $users = User::where('role', 4)->with(['role_data', 'profil_invest', 'secteurs_data'])->get();
        $role = (object) [
            'name' => 'investisseur',
            'value' => 4
        ];
        return view('pages.user.home')->with('users', $users)->with('role', $role)->with('title', 'Investisseurs');
    }

    public function show($id = null)
    {
        $user = User::with(['secteurs_data'])->find(auth()->user()->id);

        if (!empty($id)) {
            $user = User::with(['secteurs_data'])->find($id);
        }

        if ($user->role == 2) {
            $secteurs = [];
            foreach ($user->secteurs_data as $key => $value) {
                array_push($secteurs, $value->id);
            }

            $projet_wait = Projet::where('etat', 'ATTENTE')->whereIn('secteur', $secteurs)->count();
            $projet_publish = Projet::where('etat', 'PUBLIE')->whereIn('secteur', $secteurs)->count();
            $projet_close = Projet::where('etat', 'CLOTURE')->whereIn('secteur', $secteurs)->count();


            $projets = Projet::with(['secteur_data'])->whereIn('secteur', $secteurs)->get();

            return view('pages.user.profil', compact('user', 'projet_wait', 'projet_publish', 'projet_close', 'projets'));
        }

        if ($user->role == 3) {
            $projets = Projet::with(['secteur_data'])->where('user', $user->id)->get();

            $total = Projet::select(DB::raw('sum(financement) as total_finan'))->where('user', $user->id)->first();

            if (empty($total)) {
                $total = 0;
            } else {
                $total = $total->total_finan;
            }

            return view('pages.user.profil', compact('user', 'total', 'projets'));
        }

        if ($user->role == 4) {
            $projets = Investissement::select(DB::raw('sum(montant) as total_investi, user, projet'))
                ->groupBy('projet')
                ->groupBy('user')
                ->where('user', $user->id)
                ->with(['projet_data'])
                ->get();

            $total = Investissement::select(DB::raw('sum(montant) as total_investi'))
                ->groupBy('projet')
                ->groupBy('user')
                ->where('user', $user->id)
                ->with(['projet_data'])
                ->first();

            if (empty($total)) {
                $total = 0;
            } else {
                $total = $total->total_investi;
            }

            return view('pages.user.profil', compact('user', 'total', 'projets'));
        }
        return view('pages.user.profil')->with('user', $user);
    }

    public function editProfil($id)
    {
        $user = User::find($id);
        return view('pages.user.edit-profil')->with('user', $user);
    }

    public function add($id)
    {
        $role = Role::find($id);
        $profil = ProfilInvestisseur::all();
        $secteur  = Secteur::where('user', NULL)->get();
        return view('pages.user.add')->with('role', $role)->with('profil', $profil)->with('secteur', $secteur);
    }

    public function store(Request $request)
    {
        $data = $request->input();
        $data['folder'] = hexdec(uniqid());
        $pass = $request->password;

        if ($data['role'] == 3 || $data['role'] == 4) {
            $pass = Str::random(8);
        }

        $data['password'] = Hash::make($pass);

        $msgError = 'Utilisateur ajouté avec succès!';

        $user =  User::create($data);

        Secteur::where('id', $request->secteur)->update([
            'user' => $user->id,
        ]);

        if ($user->role == 3 || $user->role == 4) {
            try {
                $mailData = $user->toArray();
                $mailData['pass'] = $pass;
                Mail::to($user->email)->queue(new NewInvestorMail($mailData));
                Toastr::success($msgError, 'Succès');
            } catch (\Throwable $e) {
                $msgError = 'Impossible d\'envoyer un mail car l\'email n\'existe pas!';
                Toastr::warning($msgError, 'Attention');
            }
        } else {
            Toastr::success($msgError, 'Succès');
        }

        return back();
    }

    public function edit($id)
    {
        $user = User::find($id);
        $profil = ProfilInvestisseur::all();
        return view('pages.user.edit')->with('user', $user)->with('profil', $profil);
    }

    public function update($id, Request $request)
    {
        $data = $request->except(['_token', 'password']);

        if ($request->has('password') && !empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }

        User::where('id', $id)->update($data);

        Toastr::success('Utilisateur mis à jour avec succès!', 'Success');

        return redirect()->back();
    }

    public function updateProfile($id, Request $request)
    {
        $data = $request->except(['_token']);
        $photo = $request->file('photo');

        $user = User::find($id);

        // if (!Storage::disk('public')->exists($directory)) {
        //     Storage::disk('public')->makeDirectory($directory);
        // }

        // if (!empty($photo)) {
        //     //$filename = $photo->getClientOriginalName();
        //     $filename = 'photo.' . strtolower($photo->getClientOriginalExtension());
        //     $data['photo'] = url('storage/uploads/' . $user->folder) . '/' . $filename;
        //     $photo->storeAs('uploads/' . $user->folder . '/', $filename, ['disk' => 'public']);
        // }

        // $slider_image = $request->file('image');

        // $name_gen = hexdec(uniqid());
        // $img_ext = strtolower($slider_image->getClientOriginalExtension());
        // $img_name = $name_gen . '.' . $img_ext;
        // $up_location = 'images/slides/';
        // $last_img = $up_location . $img_name;
        // $slider_image->move($up_location, $img_name);

        if (!empty($photo)) {
            $directory = 'uploads/' . $user->folder;
            
            // Vérifier et créer le dossier s'il n'existe pas
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }
            
            $filename = 'photo.' . strtolower($photo->getClientOriginalExtension());
            $data['photo'] = url('storage/' . $directory . '/' . $filename);
            $photo->storeAs($directory, $filename, ['disk' => 'public']);
        }

        if ($request->has('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        Toastr::success('Utilisateur mis à jour avec succès!', 'Success');

        return redirect(route('user.profile'));
    }

    public function updatePassword($id, Request $request)
    {
        $user = User::where('id', $id)->first();

        if (!Hash::check($request->old, $user->password)) {
            Toastr::error('Mot de passe incorrect!', 'Erreur');
            return back();
        }

        $user->password = Hash::make($request->new);
        $user->save();

        Toastr::success('Utilisateur mis à jour avec succès!', 'Success');

        return redirect(route('user.profile'));
    }

    public function delete($id)
    {
        $user = User::find($id);

        if ($user->folder != null) {
            File::deleteDirectory(storage_path('app/public/uploads/') . $user->folder);
        }

        User::find($id)->delete();
        Toastr::success('Utilisateur supprimé avec succès!', 'Success');

        return redirect()->back();
    }

    public function getReport($id)
    {
        $user = User::find($id);
        $json = [];
        $path = storage_path("app/uploads/$user->folder/report.json");

        if (File::exists($path)) {
            $json = json_decode(file_get_contents($path));
            if (empty($json)) {
                $json = [];
            }
        }

        return view('pages.user.report')->with('user', $user)->with('reports', $json);
    }
}
