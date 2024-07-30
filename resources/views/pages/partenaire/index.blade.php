@extends('layouts.main')

@section('title', 'Partenaires - ' . config('app.name'))

@section('style')
{{-- <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> --}}

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



                <div class="col-md-8">
                    <div class="card-group">
                        @foreach($partenaires as $multi)

                        <div class="col-md-3 mt-5 mx-auto px-2">
                            <div class="card">
                                <img src="{{asset($multi->image)}}" alt="" >
                            </div> <br>
                            <a href="{{url('partenaires/delete/'.$multi->id)}}" onclick="return confirm('Voulez-vous vraiment supprimer?')" class="btn btn-danger">Supprimer</a>
                        </div>

                        
                        @endforeach
                    </div>


                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            Partenaires
                        </div>

                        <div class="card-body">
                            <form action="{{route('partenaires.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Ajouter vos partenaires <span class="text-c44636">*</span></label>
                                    <input type="file" name="image[]" accept="image/*" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" multiple="">


                                    @error('image')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror

                                </div><br>


                                <button type="submit" class="btn btn-primary">Ajouter des partenaires</button>
                            </form>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@include('partials.footer')
</div>
@endsection

