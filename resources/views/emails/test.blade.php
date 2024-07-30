@extends('emails.template', ['subject' => 'Test Mail'])

@section('content')
    <p><strong>Restez connecté!</strong></p>
    @include('partials.signature')
@endsection
