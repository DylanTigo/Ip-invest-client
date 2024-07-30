@extends('layouts.main')

@section('title', 'Ajouter un profil investisseur - ' . config('app.name'))

@section('content')



    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Profil investisseur</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">Profil investisseur</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-8 offset-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Ajouter un profil</h4>

                            <form id="profilInvestisseurForm" action="{{ route('profil.investisseur.store') }}"
                                method="POST">
                                @csrf


                                <div class="row">
                                    <div class="form-group col-md-12 mb-3">
                                        <label>Type</label>
                                        <select class="form-control" name="type">
                                            <option value="IGOLIDE" selected>IGOLIDE</option>
                                            <option value="SANJASAWA">SANJASAWA</option>
                                            <option value="SAMAKAKA">SAMAKAKA</option>
                                            <option value="ERE">ERE</option>
                                        </select>

                                        @error('type')
                                            <span class="text-danger"> {{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-12 mb-3">
                                        <label>Montant minimal</label>
                                        <input type="number" class="form-control" name="montant_min" min="1"
                                            value="1" placeholder="0 XAF">

                                        @error('montant_min')
                                            <span class="text-danger"> {{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-12 mb-3">
                                        <label>Montant maximal</label>
                                        <input type="number" class="form-control" name="montant_max" min="1"
                                            placeholder="0 XAF">
                                    </div>
                                    <div class="form-group col-md-12 mb-3">
                                        <label>Montant abonnement</label>
                                        <input type="number" class="form-control" name="frais_abonnement"
                                            placeholder="0 XAF">

                                        @error('frais_abonnement')
                                            <span class="text-danger"> {{ $message }}</span>
                                        @enderror
                                    </div>
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

        @include('partials.footer')
    </div>
@endsection
