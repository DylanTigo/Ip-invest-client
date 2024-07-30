@extends('layouts.main')

@section('title', 'Modifier un expert - ' . config('app.name'))

@section('style')

    <style>
        .text-c44636 {
            color: #c44636;
        }
    </style>

@endsection

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Experts</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">Experts</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-8 offset-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Modifier les informations de l'expert {{$expert->nom_complet}}</h4>

                            <form action="{{ route('experts.update', $expert->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="form-group col-md-6 mb-3">
                                        <label>Nom complet <span class="text-c44636">*</span></label>
                                        <input type="text" class="form-control" name="nom_complet"
                                            placeholder="Nom & prenom" value="{{$expert->nom_complet}}" required>
                                    </div>
                                    <div class="form-group col-md-6 mb-3">
                                        <label>Occupation <span class="text-c44636">*</span></label>
                                        <input type="text" class="form-control" name="fonction"
                                            placeholder="Occupation" value="{{$expert->fonction}}" >
                                    </div>
                                    <div class="form-group col-md-6 mb-3">
                                        <label>Email <span class="text-c44636">*</span></label>
                                        <input type="email" class="form-control" name="email"
                                            placeholder="Email" value="{{$expert->email}}" required>
                                    </div>
                                    <div class="form-group col-md-6 mb-3">
                                        <label>Téléphone <span class="text-c44636">*</span></label>
                                        <input type="text" class="form-control" name="telephone"
                                            placeholder="Téléphone" value="{{$expert->telephone}}" required>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Description <span class="text-c44636">*</span></label>
                                        <textarea name="description" class="form-control" rows="3" required>{{$expert->description}}</textarea>
                                    </div>

                                    <div class="form-group col-md-12 mb-3">
                                        <label>Nouvelle photo </label>
                                        <input type="file" name="photo" class="form-control" accept="image/*" readonly>
                                    </div>

                                    <div class="form-group col-md-12 mb-3">
                                        <label>Photo actuelle :</label>
                                        <img src="{{ URL::to($expert->photo_url) }}" style="width: 50px; height:50px;" alt="">
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
        @include('partials.footer')
    </div>
@endsection
