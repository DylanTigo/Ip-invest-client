<!DOCTYPE html>
<html lang="fr">

@extends('emails.template', ['subject' => 'Nouvel investissement sur votre projet {{$projet["intitule"]}}'])

@section('content')
  <p>Cher <strong>{{$projet['user_data']['nom_complet']}}</strong>,</p>
  <p>L'équipe IP Investment SA a le
    plaisir de vous annoncer que pour votre projet <strong>{{$projet["intitule"]}}</strong>, vous avez recu un
    investissement de <strong>{{$investissement['montant']}} XAF</strong>. <br />
    Vous continuerez d'etre informé de tous les avancements dudit projet.
  </p>
  @include('partials.signature')
@endsection
