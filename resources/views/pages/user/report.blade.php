@extends('layouts.main')

@section('title', 'Reporting - ' . config('app.name'))

@section('style')
@endsection


@section('content')
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Reporting</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name') }}</a>
                                </li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Utilisateurs</a></li>
                                <li class="breadcrumb-item active">Reporting</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Reporting du conseiller {{$user->nom}} {{$user->prenom}}</h4>
                                <div class="actions d-flex align-items-center">
                                    <button class="btn btn-sm btn-primary" onclick="reload()">Actualiser</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="list-group">
                        @forelse($reports as $report)
                        <a href="{{ route('projet.details', $report->element->id) }}"
                            class="list-group-item list-group-item-action" aria-current="true">
                            <h5 class="mb-2">
                                @switch($report->action)
                                @case("CI_VALIDE")
                                Approbation du projet "{{$report->element->intitule}}"
                                @break
                                @case("CI_DEMANDE_INFO_SUP")
                                Demande d'information supplementaire du projet "{{$report->element->intitule}}"
                                @break
                                @case("CI_REJETE")
                                Rejet du projet "{{$report->element->intitule}}"
                                @break
                                @default
                                Modification du projet "{{$report->element->intitule}}"
                                @endswitch
                            </h5>
                            <p class="mt-1"><span class="mdi mdi-clock-outline me-1"></span>
                                {{\Carbon\Carbon::parse($report->date)->format('d F Y à H:i:s')}}</p>
                        </a>
                        @empty
                        <div class="list-group-item list-group-item-action" aria-current="true">
                            <div class="d-flex w-100 justify-content-center">
                                <h5 class="mb-1">Aucune tache effectuée</h5>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>

    @include('partials.footer')
</div>
@endsection

@section('script')
@endsection