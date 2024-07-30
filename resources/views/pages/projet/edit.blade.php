@extends('layouts.main')

@section('title', 'Projets - ' . config('app.name'))

@section('style')
<!-- dropzone css -->
<link href="{{ asset('assets/libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css" />

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
                        <h4 class="mb-sm-0 font-size-18">Projets</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name') }}</a>
                                </li>
                                <li class="breadcrumb-item active">Projets</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card w-75">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Modifier le projet {{$projet->intitule}}</h4>
                            <form class="row" action="{{ route('projet.update', $projet->id) }}" method="POST"
                                enctype="multipart/form-data">

                                @csrf

                                <div class="form-group col-md-6 mb-3">
                                    <label for="intitule">Intitule</label>
                                    <input id="intitule" name="intitule" type="text"
                                        class="form-control" value="{{$projet->intitule}}">

                                    @error('intitule')
                                        <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label>Secteur d'activité</label>
                                    <select class="form-control" name="secteur">
                                        <option value="">Choisir un secteur d'activité</option>
                                        @foreach ($secteurs as $secteur)
                                            <option @if ($secteur->id == $projet->secteur) selected @endif value="{{$secteur->id}}">{{$secteur->libelle}}</option>
                                        @endforeach
                                    </select>

                                    @error('secteur')
                                        <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-10 mb-3">
                                    <label for="logo">Logo</label>
                                    <input id="logo" name="logo" type="file" class="form-control" value="{{$projet->logo}}">

                                    @error('financement')
                                        <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-2 text-center mb-3">
                                    <label>Logo actuel</label> <br>
                                    <img class="rounded img-fluid" src="{{ URL::to($projet->logo) }}" width="35" alt="{{$projet->intitule}}">
                                </div>

                                <div class="form-group col-md-12 mb-3">
                                    <label for="projectdesc">Description</label>
                                    <textarea class="form-control" name="description"
                                        rows="3">{{$projet->description}}</textarea>
                                    @error('description')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="taux_rentabilite">Besoin de financement (XAF) *</label>
                                    <input id="taux_rentabilite" name="financement" type="text"
                                        class="form-control" value="{{$projet->financement}}">

                                    @error('financement')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="taux_rentabilite">Taux de
                                        rentabilité (%) *</label>
                                    <input id="taux_rentabilite" name="taux_rentabilite" type="text"
                                        class="form-control" value="{{$projet->taux_rentabilite}}">

                                    @error('taux_rentabilite')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="duree">Durée du projet (en mois)
                                        *</label>
                                    <input id="duree" name="duree" type="text" class="form-control"
                                        value="{{$projet->duree}}">

                                    @error('duree')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="delai_recup">Délai de recupération (en
                                        mois) *</label>
                                    <input id="delai_recup" name="delai_recup" type="text" class="form-control"
                                        value="{{$projet->rsi}}">

                                    @error('delai_recup')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12 mb-3">
                                    <label for="ca_previsionnel">Chiffre d'affaires
                                        prévisionnel (XAF) *</label>
                                    <input id="ca_previsionnel" name="ca_previsionnel" type="text" class="form-control"
                                        value="{{$projet->ca_previsionnel}}">

                                    @error('ca_previsionnel')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12 mb-3">
                                    <label>Fichiers joints</label>
                                    <input type="file" name="fichier[]" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" multiple>
                                </div>

                                <div class="d-flex mt-3 justify-content-center">
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </div>
                            </form>



                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
    </div>

    @include('partials.footer')
</div>
@endsection

@section('script')
{{-- <script type="text/javascript" src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script> --}}

<!-- dropzone plugin -->
<script type="text/javascript" src="{{ asset('assets/libs/dropzone/min/dropzone.min.js') }}"></script>
@endsection