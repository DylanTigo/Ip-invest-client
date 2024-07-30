@extends('layouts.main')

@section('title', 'Ajouter un secteur - ' . config('app.name'))

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
                        <h4 class="mb-sm-0 font-size-18">Secteur d'activités</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name') }}</a>
                                </li>
                                <li class="breadcrumb-item active">Secteur d'activités</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Ajouter un secteur</h4>

                        <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="form-group col-md-12 mb-3">
                                    <label>Libelle <span class="text-c44636">*</span></label>
                                    <input type="text" class="form-control" name="libelle" placeholder="Libelle">

                                    @error('libelle')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12 mb-3">
                                    <label>Spécialiste <span class="text-c44636">*</span></label>
                                    <select class="form-control" name="user">
                                        @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->nom_complet }}</option>
                                        @endforeach
                                    </select>

                                    @error('user')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror

                                </div>
                                <div class="form-group col-md-12 mb-3">
                                    <label>Image <span class="text-c44636">*</span></label>
                                    <input type="file" name="image" class="form-control" 
                                        aria-describedby="emailHelp">


                                    @error('image')
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