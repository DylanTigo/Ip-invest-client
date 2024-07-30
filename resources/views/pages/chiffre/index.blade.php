@extends('admin.admin_master')

@section('admin')

<div class="py-12">

    <div class="container">
        <div class="row">

            

            <div class="col-md-12">
                <div class="card">

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{session('success')}}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif


                    <div class="row">
                        <label for="exampleInputEmail1">Titre Principal</label>

                        <div class="col-md-9">
                            <div class="form-group">
                                
                                <input type="text" name="titreprinc" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" value="{{ $chiffres->titreprinc }}">
        
        
                                @error('titreprinc')
                                <span class="text-danger"> {{ $message }}</span>
                                @enderror
        
                            </div>
                        </div>

                        <div class="col-md-3">
                            <a href="{{ url('chiffre/titreprinc/edit/')}}" class="btn btn-info">Edit</a>
                        </div>
                    </div>


                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" width="5%">SL </th>
                                <th scope="col" width="15%">Title</th>
                                <th scope="col" width="25%">Description</th>
                                <th scope="col" width="15%">Image</th>
                                <th scope="col" width="15%"></th>
                            </tr>
                        </thead>

                        <tbody>
                            @php($i = 1)
                            
                            <tr>
                                <th scope="row">{{$i++}}</th>
                                <td>{{$chiffres->title}}</td>
                                <td style="word-break: break-all;">{{$chiffres->description}}</td>
                                <td><img src="{{asset($chiffres->image)}}" style="height:50px; width: 50px;"></td> 
                                
                                <td>
                                    <a href="{{ url('chiffre/edit/'.$chiffres->id)}}" class="btn btn-info">Edit</a>
                                    
                                </td>
                            </tr>

                        </tbody>
                    </table>

                </div>
            </div>

            
        </div>
    </div>




</div>

@endsection