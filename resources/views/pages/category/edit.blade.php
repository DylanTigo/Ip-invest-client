@extends('layouts.main')

@section('title', 'Modifier un secteur - ' . config('app.name'))

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
                        <h4 class="card-title mb-4">Modifier un secteur</h4>

                        <form action="{{ route('category.update', $secteur->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="old_image" value={{$secteur->image}}>

                            <div class="row">
                                <div class="form-group col-md-12 mb-3">
                                    <label>Libelle <span class="text-c44636">*</span></label>
                                    <input type="text" class="form-control" name="libelle"
                                        value="{{$secteur->libelle}}">

                                    @error('libelle')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12 mb-3">
                                    <label>Spécialiste <span class="text-c44636">*</span></label>
                                    <select class="form-control" name="user">
                                        @foreach ($users as $user)
                                        <option value="{{ $user->id }}" <?php if($user->id == $secteur->user){
                                            echo "selected";}?>>{{ $user->nom_complet }}</option>
                                        @endforeach
                                    </select>

                                    @error('user')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror

                                </div>

                                <div class="form-group col-md-12 mb-3">
                                    <label>Image </label>
                                    <input type="file" class="form-control" id="exampleFormControlFile1"
                                        name="image">

                                    @error('image')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12 mb-3">
                                    <label>Ancienne image</label>
                                    <img src="{{ URL::to($secteur->photo) }}" style="width: 50px; height:50px;" alt="{{$secteur->libelle}}">
                                    <input type="hidden" name="oldimage" value={{ $secteur->photo }}>
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