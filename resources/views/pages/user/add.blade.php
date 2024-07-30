@extends('layouts.main')

@section('title', 'Ajouter un utilisateur - ' . config('app.name'))

@section('content')



    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Utilisateurs</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">Utilisateurs</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-8 offset-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Ajouter un {{ $role->libelle }}</h4>

                            <form action="{{ route('user.store') }}" method="POST">
                                @csrf

                                <input type="hidden" name="role" value="{{ $role->id }}">

                                <div class="row">
                                    <div class="form-group col-md-12 mb-3">
                                        <label>Civilité</label>
                                        <select class="form-control" name="civilite">
                                            <option value=""> Civilité</option>
                                            <option value="Mr.">Mr.</option>
                                            <option value="Mme.">Mme.</option>
                                            <option value="Mlle.">Mlle.</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6 mb-3">
                                        <label>Nom</label>
                                        <input type="text" class="form-control" name="nom" required>
                                    </div>

                                    <div class="form-group col-md-6 mb-3">
                                        <label>Prenom</label>
                                        <input type="text" class="form-control" name="prenom" required>
                                    </div>

                                    <div class="form-group col-md-6 mb-3">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" required>
                                    </div>

                                    <div class="form-group col-md-6 mb-3">
                                        <label>Téléphone</label>
                                        <input type="text" class="form-control" name="telephone" required>
                                    </div>

                                    <div class="form-group col-md-12 mb-3">
                                        <label>Mot de passe</label>
                                        <input type="password" class="form-control" name="password" required>
                                    </div>

                                    @if ($role->id == 4)
                                        <div class="form-group col-md-12 mb-3">
                                            <label>Profil</label>
                                            <select class="form-control" name="profil">
                                                @foreach ($profil as $item)
                                                    <option value="{{ $item->id }}">{{ $item->type }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    @endif

                                    @if ($role->id == 2)
                                        <div class="form-group col-md-12 mb-3">
                                            <label>Secteur d'activité</label>
                                            <select class="form-control" name="secteur">
                                                @foreach ($secteur as $item)
                                                    <option value="{{ $item->id }}">{{ $item->libelle }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif

                                    @if ($role->id == 3 || $role->id == 4)
                                        <div class="form-group col-md-12 mb-3">
                                            <label>Statut</label>
                                            <select class="form-control" name="status" required>
                                                <option value="PARTICULIER">Particulier</option>
                                                <option value="ENTREPRISE">Entreprise</option>
                                            </select>
                                        </div>
                                    @endif

                                    @if ($role->id == 4)
                                        <div class="form-group col-md-12 mb-3">
                                            <label>Ancienente</label>
                                            <select class="form-control" name="anciennete">
                                                <option selected value="">Aucun</option>
                                                <option value="1">Plus d'un an 6 mois</option>
                                                <option value="-1">Moins d'un an 6 mois</option>
                                            </select>
                                        </div>
                                    @endif

                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary w-md">Enregistrer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')
    </div>
@endsection
