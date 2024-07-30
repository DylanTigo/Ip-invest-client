@extends('emails.template', ['subject' => 'Publication de votre projet {{$projet["intitule"]}}'])

@section('content')
  <p>Cher <strong>{{$projet['user_data']['nom_complet']}}</strong>,</p>
  <p>IP Investment SA a le plaisir de vous informer que votre projet est désormais accessible à tous les investisseurs sur
  notre plateforme.<br/>
  Vous pouvez suivre l'évolution de l'investissement directement depuis votre tableau de bord ou contacter un
  conseiller.</p>
  <p><strong><em>Construire Ensemble!</em></strong></p>
  @include('partials.signature')
@endsection
