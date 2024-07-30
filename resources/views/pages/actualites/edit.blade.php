@extends('layouts.main')

@section('title', 'Ajouter une actualité - ' . config('app.name'))

<style>
        .text-c44636 {
            color: #c44636;
        }
    </style>
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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name') }}</a>
                                </li>
                                <li class="breadcrumb-item active">Actualités</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Modifier une actualité</h4>


                        <form action="{{ route('actualites.update', [$type, $actualite->id, $idPS]) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="form-group col-md-12 mb-3">
                                    <label>Libelle <span class="text-c44636">*</span></label>
                                    <input type="text" class="form-control" name="libelle" value="{{$actualite->libelle}}" required>

                                </div>

                            

                                <div class="form-group col-md-12 mb-3">
                                    <label for="exampleFormControlTextarea1">Description <span class="text-c44636">*</span></label>
                                    <textarea class="form-control" name="description"  id="summernote">{!! $actualite->description !!}</textarea>
                                </div>

                                <div class="form-group col-md-12 mb-3">
                                    <label>Image</label>
                                    <input type="file" name="image" class="form-control" aria-describedby="emailHelp">


                                    @error('image')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12 mb-3">
                                    <label>Ancienne image :</label>
                                    <img src="{{ URL::to($actualite->image) }}" style="width: 50px; height:50px;" alt="">
                                    <input type="hidden" name="oldimage" value={{ $actualite->image }}>
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