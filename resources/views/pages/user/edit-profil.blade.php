@extends('layouts.main')

@section('title', 'Utilisatuers - ' . config('app.name'))

@section('style')
@endsection


@section('content')
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Modifier votre profil</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">

                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">{{ config('app.name') }}</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Utilisateurs</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Profil</a>
                                </li>
                                <li class="breadcrumb-item active">Modifier</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7">

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Modifier vos informations personnelles</h4>
                            <form action="{{ route('user.profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="role" value="{{ $user->role }}">

                                <div class="row">
                                    <div class="form-group col-md-12 mb-3">
                                        <label class="form-label">Photo de profil</label>
                                        <div class="input-group">
                                            <input type="file" accept="image/*" name="photo" class="form-control" id="user-image">
                                            <label class="input-group-text" for="user-image">Importer</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 mb-3">
                                        <label>Civilité</label>
                                        <select class="form-control" name="civilite">
                                            <option {{empty($user->civilite) ? "selected" : ""}}>Aucun</option>
                                            <option {{$user->civilite == "Mr." ? "selected" : ""}} value="Mr.">Mr.</option>
                                            <option {{$user->civilite == "Mme." ? "selected" : ""}} value="Mme.">Mme.</option>
                                            <option {{$user->civilite == "Mlle." ? "selected" : ""}} value="Mlle.">Mlle.</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 mb-3">
                                        <label>Nom</label>
                                        <input type="text" class="form-control" name="nom" value="{{$user->nom}}"
                                            required>
                                    </div>
                                    <div class="form-group col-md-6 mb-3">
                                        <label>Prenom</label>
                                        <input type="text" class="form-control" name="prenom" value="{{$user->prenom}}">
                                    </div>
                                    <div class="form-group col-md-6 mb-3">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" value="{{$user->email}}"
                                            required>
                                    </div>
                                    <div class="form-group col-md-6 mb-3">
                                        <label>Téléphone</label>
                                        <input type="text" class="form-control" name="telephone"
                                            value="{{$user->telephone}}">
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary w-md">Mettre à jour</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <div class="col-md-5">

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Modifier votre mot de passe</h4>
                            <form action="{{ route('user.profile.update.password', $user->id) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-12 mb-3">
                                        <label>Ancien mot de passe</label>
                                        <input type="password" class="form-control" name="old"
                                            placeholder="Mot de passe" required>
                                    </div>
                                    <div class="form-group col-md-12 mb-3">
                                        <label>Nouveau mot de passe</label>
                                        <input type="password" class="form-control" name="new"
                                            placeholder="Mot de passe" required>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary w-md">Mettre à jour</button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
</div>

@include('partials.footer')
</div>
@endsection

@section('script')
@endsection