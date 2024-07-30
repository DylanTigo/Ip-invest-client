@extends('admin.admin_master')

@section('admin')

<div class="col-lg-12">
    <div class="card card-default">
        <div class="card-header card-header-border-bottom">
            <h2>Create Slider</h2>
        </div>
        <div class="card-body">
            <form action="{{route('update.chiffre', $chiffre->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="exampleFormControlInput1">Title</label>
                    <input type="text" class="form-control" name="title" id="exampleFormControlInput1"
                    value={{ $chiffre->title }}>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Description</label>
                    <textarea class="form-control" name="description" id="exampleFormControlTextarea1"
                        rows="3">{{ $chiffre->description }}</textarea>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="exampleInputName1">News Image Upload</label>
                        <input type="file" class="form-control-file" id="exampleFormControlFile1" name="image">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputName1">Old Image</label>
                        <img src="{{ URL::to($chiffre->image) }}" style="width: 70px; height:50px;" alt="">
                        <input type="hidden" name="oldimage" value={{ $chiffre->image }}>
                    </div>

                </div>
                <div class="form-footer pt-4 pt-5 mt-4 border-top">
                    <button type="submit" class="btn btn-primary btn-default">Update</button>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection