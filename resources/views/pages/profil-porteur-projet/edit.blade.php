@extends('layouts.main')

@section('title', 'Modifier un profil porteur de projet - ' . config('app.name'))

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
                            <h4 class="mb-sm-0 font-size-18">Profil porteur de projet</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">Profil porteur de projet</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-8 offset-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Modifier un profil</h4>

                            <form action="{{ route('profil.porteur.update', $profil->type) }}" method="POST">
                                @csrf


                                <div class="row">
                                    <div class="form-group col-md-6 mb-3">
                                        <label>Type</label>
                                        <select class="form-control" name="type">
                                            <option {{ $profil->type == 'PARTICULIER' ? 'selected' : '' }}>Particulier
                                            </option>
                                            <option {{ $profil->type == 'ENTREPRISE' ? 'selected' : '' }}>Entreprise
                                            </option>
                                        </select>

                                        @error('type')
                                            <span class="text-danger"> {{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Montant <span class="text-c44636">*</span></label>
                                        <input required type="number" class="form-control" name="montant"
                                            value={{ $profil->montant }}>

                                        @error('montant')
                                            <span class="text-danger"> {{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary w-md">Modifier</button>
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
