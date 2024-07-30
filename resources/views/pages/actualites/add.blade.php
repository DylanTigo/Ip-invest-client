@extends('layouts.main')

@section('title', 'Ajouter une actualité - ' . config('app.name'))

@section('style')
<link href="https://cdn.jsdelivr.net/npm/summernote@latest/dist/summernote-bs4.min.css" rel="stylesheet">

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
                        <h4 class="mb-sm-0 font-size-18">Actualités</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name') }}</a></li>
                                <li class="breadcrumb-item active">Actualités</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Ajouter une actualité</h4>

                        @php
                            if($type == 'secteur'){
                                $choice = true;
                            }
                            else{
                                $choice = false;
                            }
                        @endphp

                        {{-- @json($projet) --}}

                        <form action="{{ (isset($choice) && $choice == true) ? route('actualites.store', [$type, $secteur->id]) : route('actualites.store', [$type, $projet->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="form-group col-md-12 mb-3">
                                    <label>Libelle <span class="text-c44636">*</span></label>
                                    <input type="text" class="form-control" name="libelle" required>
                                    @error('libelle')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12 mb-3">
                                    <label for="exampleFormControlTextarea1">Description <span class="text-c44636">*</span></label>
                                    <textarea class="form-control" name="description" id="exampleFormControlTextarea1"></textarea>
                                </div>

                                <div class="form-group col-md-12 mb-3">
                                    <label>Image <span class="text-c44636">*</span></label>
                                    <input type="file" name="image" class="form-control" aria-describedby="emailHelp">
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

@section('script')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/min/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@latest/dist/summernote-bs4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#exampleFormControlTextarea1').summernote({
            placeholder: "Écrire une courte description...",
            tabsize: 2,
            height: 100,
        });
    });
</script>
@endsection
