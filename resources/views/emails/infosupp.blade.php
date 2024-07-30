@extends('emails.template', ['subject' => '{{$data["objet"]}}'])

@section('content')
  <p>{!!$data['message']!!}</p>

  <p>Cordialement, <br />
    <strong>{{Auth()->user()->nom}} {{Auth()->user()->prenom}}</strong>
  </p>
  @include('partials.signature')
@endsection
