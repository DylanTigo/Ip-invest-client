<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\PaiementProjetConseilleMail;
use App\Mail\PaiementProjetPorteurMail;
use App\Mail\CreationProjetMail;
use App\Mail\CreationProjetPorteurMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Actualite;
use App\Models\Archive;
use App\Models\Equipe;
use App\Models\ProjectLike;
use App\Models\Projet;
use App\Models\User;


class ProjectController extends Controller
{
    public function index()
    {
        $projets = Projet::latest()->with(['user_data', 'likes'])->get();
        $this->sendResponse($projets, 'All projects');
    }

    public function store(Request $request)
    {
        $logo = $request->file('logo');
        $doc_presentation = $request->file('doc_presentation');
        $medias = $request->has('medias') ? $request->file('medias') : [];
        $membres = $request->has('membres') ? json_decode($request->input('membres')) : [];
        $data = json_decode($request->input('projet'), true);

        $user = User::find($data['user']);

        // Save project
        $data['folder'] = hexdec(uniqid());

        if (!empty($logo)) {
            $filename = 'logo.' . $logo->getClientOriginalExtension();
            $data['logo'] = url('storage/uploads/' . $user->folder . '/projets/' . $data['folder']) . '/' . $filename;
            $logo->storeAs('uploads/' . $user->folder . '/projets/' . $data['folder'] . '/', $filename, ['disk' => 'public']);
        }

        if (!empty($doc_presentation)) {
            $filename = $doc_presentation->getClientOriginalName();
            $data['doc_presentation'] = url('storage/uploads/' . $user->folder . '/projets/' . $data['folder'] . '/documents') . '/' . $filename;
            $doc_presentation->storeAs('uploads/' . $user->folder . '/projets/' . $data['folder'] . '/documents/', $filename, ['disk' => 'public']);
        }

        $projet = Projet::create($data);

        // Save all project medias
        foreach ($medias as $media) {
            $extension = $media->getClientOriginalExtension();

            $data = [
                'projet' => $projet->id,
                'nom' => $media->getClientOriginalName()
            ];

            if (in_array($extension, Archive::getAllowedFiles())) {
                $data['url'] = url('storage/uploads/' . $user->folder . '/projets/' . $projet->folder . '/documents') . '/' . $data['nom'];
                $data['type'] = 'FICHIER';
                $media->storeAs('uploads/' . $user->folder . '/projets/' . $projet->folder . '/documents/', $data['nom'], ['disk' => 'public']);
            } else if (in_array($extension, Archive::getAllowedImages())) {
                $data['url'] = url('storage/uploads/' . $user->folder . '/projets/' . $projet->folder . '/images') . '/' . $data['nom'];
                $data['type'] = 'IMAGE';
                $media->storeAs('uploads/' . $user->folder . '/projets/' . $projet->folder . '/images/', $data['nom'], ['disk' => 'public']);
            } else {
                $data['url'] = url('storage/uploads/' . $user->folder . '/projets/' . $projet->folder . '/videos') . '/' . $data['nom'];
                $data['type'] = 'VIDEO';
                $media->storeAs('uploads/' . $user->folder . '/projets/' . $projet->folder . '/videos/', $data['nom'], ['disk' => 'public']);
            }

            Archive::create($data);
        }

        // Add all members to project
        foreach ($membres as $membre) {
            Equipe::create([
                'projet' => $projet->id,
                'membre' => $membre->membre->id,
                'statut' => $membre->statut
            ]);
        }

        // Retrieve projects informations
        $projet = Projet::with(['user_data', 'membres', 'medias', 'secteur_data', 'investissements'])->where('id', $projet->id)->first();

        try {
            Mail::to($user->email)->queue(new CreationProjetPorteurMail($projet->toArray()));
            Mail::to('info@invest--partners.com')->queue(new CreationProjetMail($projet->toArray()));

            if (!empty($projet->secteur_data->conseiller_data)) {
                Mail::to($projet->secteur_data->conseiller_data->email)->queue(new CreationProjetMail($projet->toArray()));
            }
        } catch (\Throwable $e) {
            return $this->sendResponse($projet, 'Impossible d\'envoyer un mail car l\'email n\'existe pas.');
        }

        return $this->sendResponse($projet, 'Project');
    }

    public function store2(Request $request)
    {
        $logo = $request->file('logo');
        $doc_presentation = $request->file('doc_presentation');
        $medias = $request->has('medias') ? $request->file('medias') : [];
        $data = json_decode($request->input('projet'), true);

        $user = User::find($data['user']);

        // Save project
        $data['folder'] = hexdec(uniqid());

        if (!empty($logo)) {
            $filename = 'logo.' . $logo->getClientOriginalExtension();
            $data['logo'] = url('storage/uploads/' . $user->folder . '/projets/' . $data['folder']) . '/' . $filename;
            $logo->storeAs('uploads/' . $user->folder . '/projets/' . $data['folder'] . '/', $filename, ['disk' => 'public']);
        }

        if (!empty($doc_presentation)) {
            $filename = $doc_presentation->getClientOriginalName();
            $data['doc_presentation'] = url('storage/uploads/' . $user->folder . '/projets/' . $data['folder'] . '/documents') . '/' . $filename;
            $doc_presentation->storeAs('uploads/' . $user->folder . '/projets/' . $data['folder'] . '/documents/', $filename, ['disk' => 'public']);
        }

        $projet = Projet::create($data);

        // Save all project medias
        foreach ($medias as $media) {
            $extension = $media->getClientOriginalExtension();

            $data = [
                'projet' => $projet->id,
                'nom' => $media->getClientOriginalName()
            ];

            if (in_array($extension, Archive::getAllowedFiles())) {
                $data['url'] = url('storage/uploads/' . $user->folder . '/projets/' . $projet->folder . '/documents') . '/' . $data['nom'];
                $data['type'] = 'FICHIER';
                $media->storeAs('uploads/' . $user->folder . '/projets/' . $projet->folder . '/documents/', $data['nom'], ['disk' => 'public']);
            } else if (in_array($extension, Archive::getAllowedImages())) {
                $data['url'] = url('storage/uploads/' . $user->folder . '/projets/' . $projet->folder . '/images') . '/' . $data['nom'];
                $data['type'] = 'IMAGE';
                $media->storeAs('uploads/' . $user->folder . '/projets/' . $projet->folder . '/images/', $data['nom'], ['disk' => 'public']);
            } else {
                $data['url'] = url('storage/uploads/' . $user->folder . '/projets/' . $projet->folder . '/videos') . '/' . $data['nom'];
                $data['type'] = 'VIDEO';
                $media->storeAs('uploads/' . $user->folder . '/projets/' . $projet->folder . '/videos/', $data['nom'], ['disk' => 'public']);
            }

            Archive::create($data);
        }

        // Retrieve projects informations
        $projet = Projet::with(['user_data', 'membres', 'medias', 'secteur_data', 'investissements'])->where('id', $projet->id)->first();

        try {
            Mail::to($user->email)->queue(new CreationProjetPorteurMail($projet->toArray()));
            Mail::to('info@invest--partners.com')->queue(new CreationProjetMail($projet->toArray()));

            if (!empty($projet->secteur_data->conseiller_data)) {
                Mail::to($projet->secteur_data->conseiller_data->email)->queue(new CreationProjetMail($projet->toArray()));
            }
        } catch (\Throwable $e) {
            return $this->sendResponse($projet, 'Impossible d\'envoyer un mail car l\'email n\'existe pas.');
        }

        return $this->sendResponse($projet, 'Project');
    }

    public function store3($id, Request $request)
    {
        $membre = $request->input('membre');
        $statut = $request->input('statut');

        Equipe::create([
            'projet' => $id,
            'membre' => $membre,
            'statut' => $statut
        ]);

        $projet = Projet::with(['user_data', 'membres', 'medias', 'secteur_data', 'investissements'])->where('id', $id)->first();

        return $this->sendResponse($projet, 'Project');
    }

    public function show($id)
    {
        $projet = Projet::with(['user_data', 'membres', 'medias', 'secteur_data','investissements', 'likes'])->find($id);
        $projet->actualites = Actualite::where('secteur', $projet->secteur)->orWhere('projet', $projet->id)->get();
        return $this->sendResponse($projet, 'Project');
    }

    public function projets($id)
    {
        $projet = Projet::with(['user_data', 'secteur_data','investissements', 'likes'])
            ->where('user', $id)
            ->latest()
            ->get();
        return $this->sendResponse($projet, 'Projects');
    }

    public function valide($id)
    {
        $projet = Projet::with(['user_data', 'secteur_data', 'investissements'])->find($id);
        $projet->etat = 'VALIDE';
        $projet->save();

        try {
            Mail::to($projet->secteur_data->conseiller_data->email)->queue(new PaiementProjetConseilleMail($projet->toArray()));
            Mail::to($projet->user_data->email)->queue(new PaiementProjetPorteurMail($projet->toArray()));
            Mail::to('info@invest--partners.com')->queue(new PaiementProjetConseilleMail($projet->toArray()));
        } catch (\Throwable $e) {
            return $this->sendResponse($projet, 'Impossible d\'envoyer un mail car l\'email n\'existe pas.');
        }

        return $this->sendResponse($projet, 'Project valide');
    }

    public function like($id, $user)
    {
        $likes = ProjectLike::where('user', $user)->where('projet', $id)->get();
        
        if (count($likes) > 0) {
            ProjectLike::where('user', $user)->where('projet', $id)->delete();
            $likes = ProjectLike::where('user', $user)->where('projet', $id)->get();
        } else {
            ProjectLike::create([
                'user' => $user,
                'projet' => $id
            ]);
            $likes = ProjectLike::where('user', $user)->where('projet', $id)->get();
        }

        return $this->sendResponse(['project' => $id, 'like' => $likes], 'Project like');
    }

    public function projetsTown($id, $town, Request $request)
    {
        $projet = Projet::with(['user_data', 'secteur_data','investissements', 'likes'])
            ->where('secteur', $id)
            ->where('ville_activite', 'like', $town)
            ->whereIn('etat', ['PUBLIE', 'CLOTURE'])
            ->latest()
            ->get();
        return $this->sendResponse($projet, 'Projects');
    }
}
