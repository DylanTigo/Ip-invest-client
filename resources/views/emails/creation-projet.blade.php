@extends('emails.template', ['subject' => 'Nouveau projet dans le secteur {{$projet["secteur_data"]["libelle"]}}'])

@section('content')
  <p>Le projet <strong>{{$projet["intitule"]}}</strong> vient d'être soumis par le proteur de projet
    {{$projet['user_data']['nom_complet']}}. Jetez-y un coup d'œil <a
      href="{{ route('projet.details', $projet['id']) }}">{{ route('projet.home', $projet['id']) }}</a>
  </p>
  <p>Cordialement<br />
    <strong>IP Investment SA</strong>
  </p>
  @include('partials.signature')
@endsection
