@extends('layouts.main')

@section('title', 'Nouvelle newsletter')

@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Newsletter</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item">
                                        <a href="javascript: void(0);">{{ config('app.name') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">Newsletter</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-8 offset-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Ajouter une newsletter</h4>

                            <form action="{{ route('newsletter.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="form-group col-md-12 mb-3">
                                        <label>Titre</label>
                                        <input type="text" class="form-control" name="titre" required>
                                    </div>

                                    <div class="form-group col-md-12 mb-3">
                                        <label for="exampleFormControlTextarea1">Message</label>
                                        <textarea class="form-control" name="mail" id="summernote"></textarea>
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
