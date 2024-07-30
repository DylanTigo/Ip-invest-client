@extends('emails.template', ['subject' => 'Nouveau message reçu'])

@section('content')
  <p>Un message concernant le projet <strong>{{$proj["intitule"]}}</strong> vient d'être envoyé par l'admin
    {{$rec['nom']}}. Jetez-y un coup d'œil.
  <p>Cordialement<br />
    <strong>IP Investment SA</strong>
  </p>
  @include('partials.signature')
@endsection