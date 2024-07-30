@extends('layouts.main')

@section('title', 'Projets - ' . config('app.name'))

@section('style')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection


@section('content')
@php
$privileges = DB::table('privileges')
->where('user', auth()->user()->id)
->get();
$module = $type == 'IP' ? 1 : ($type == 'AUTRE' ? 5 : 13);
@endphp

<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Projets
                            {{ $type == 'IP' ? 'de Invest & Partners' : ($type == 'AUTRE' ? 'des porteurs de projet' : ' archivés') }}
                        </h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name') }}</a>
                                </li>
                                <li class="breadcrumb-item active">Projets</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Liste des projets par secteur</h4>
                        <div class="actions d-flex align-items-center">
                            @if ($type == 'IP')
                            @if (auth()->user()->role == 1)
                            <a href="{{ route('projet.add') }}" class="btn btn-sm btn-primary me-2">Nouveau
                                projet</a>
                            @else
                            @foreach ($privileges as $privilege)
                            @if ($privilege->module == $module && $privilege->ajouter == 1)
                            <a href="{{ route('projet.add') }}" class="btn btn-sm btn-primary me-2">Nouveau projet</a>
                            @endif
                            @endforeach
                            @endif
                            @endif

                            <button class="btn btn-sm btn-primary" onclick="resetFilters()">Actualiser</button>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Filtrage par date -->
            <form id="filterForm" action="" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <label>Filtrer par Date de Début</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control" placeholder="Start Date"/>
                    </div>
                    <div class="col-md-3">
                        <label>Filtrer par Date de Fin</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control" placeholder="End Date"/>
                    </div>
                    <div class="col-md-3">
                        <label>Filtrer par Statut</label>
                        <select name="status" class="form-select">
                            <option value="">Select Status</option>
                            <option value="" {{ $status=='' ? 'selected':''}}>Tous les statuts</option>
                            <option value="ATTENTE_PAIEMENT" {{ $status=='ATTENTE_PAIEMENT' ? 'selected':''}}>En attente de paiement</option>
                            <option value="COMPLET" {{ $status=='COMPLET' ? 'selected':''}}>Complet</option>
                            <option value="ATTENTE_INFO_SUPPL" {{ $status=='ATTENTE_INFO_SUPPL' ? 'selected':''}}>En attente d'informations supplémentaires</option>
                            <option value="VALIDE" {{ $status=='VALIDE' ? 'selected':''}}>Validé</option>
                            <option value="ATTENTE_VALIDATION_ADMIN" {{ $status=='ATTENTE_VALIDATION_ADMIN' ? 'selected':''}}>En attente de validation administrative</option>
                            <option value="PUBLIE" {{ $status=='PUBLIE' ? 'selected':''}}>Publié</option>
                            <option value="CLOTURE" {{ $status=='CLOTURE' ? 'selected':''}}>Clôturé</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Filtrer par Avancement</label>
                        <select name="avancement" class="form-select">
                            <option value="">Select Avancement</option>
                            <option value="IDEE" {{ $avancement=='IDEE' ? 'selected':''}}>Idée</option>
                            <option value="PROTOTYPE" {{ $avancement=='PROTOTYPE' ? 'selected':''}}>Prototype</option>
                            <option value="SUR_LE_MARCHE" {{ $avancement=='SUR_LE_MARCHE' ? 'selected':''}}>Sur le marché</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <br />
                        <button type="submit" class="btn btn-primary">Filtrer</button>
                        <!-- <button type="button" class="btn btn-secondary" onclick="resetFilters()">Réinitialiser</button> -->
                    </div>
                </div>
            </form>
            <hr>

            @foreach ($secteurs as $secteur)
            @if (count($secteur->projets) > 0)
            <div class="card bg-primary">
                <div class="card-body p-2 d-flex justify-content-between align-items-center text-white">
                    <h4 class="card-title m-0 text-white"><i class="mdi mdi-chevron-right me-1"></i>
                        {{ $secteur->libelle }}
                    </h4>
                    <h4 class="card-title m-0 text-white">{{ count($secteur->projets) }} projet(s)</h4>
                </div>
            </div>
            <div class="row">
                @foreach ($secteur->projets as $projet)
                <div class="col-lg-6 col-xl-4">
                    <div class="card" style="border-radius: 0.75rem; box-shadow: 0 -0.25rem 3.5rem rgb(18 38 63 / 26%); cursor: pointer;" onclick="redirectTo('{{ route('projet.details', ['id' => $projet->id]) }}')">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-4">
                                    <div class="avatar-md">
                                        <span class="avatar-title rounded-circle bg-light text-danger font-size-16">
                                            <a href="{{ route('projet.details', ['id' => $projet->id]) }}">
                                                <img class="rounded-circle avatar-sm" src="{{ $projet->logo ? $projet->logo : asset('assets/images/projet.jpg') }}" alt="" height="30">
                                            </a>
                                        </span>
                                    </div>
                                </div>

                                <div class="flex-grow-1 overflow-hidden">
                                    <h5 class="text-truncate font-size-15">
                                        <a href="{{ route('projet.details', ['id' => $projet->id]) }}" class="text-decoration-none">
                                            {{ $projet->intitule }}
                                        </a>
                                    </h5>
                                    {{-- <p class="font-size-14 fw-bolder">{{$projet->financement}} XAF</p> --}}
                                    <p class="font-size-14 fw-bolder">
                                        {{ number_format($projet->financement, 0, ',', ' ') }} XAF
                                    </p>
                                    <hr>
                                    <div class="text-muted fw-bolder">
                                        {{-- <p>
                                                            <i class="mdi mdi-domain me-1"></i>
                                                            {{ $projet->secteur_data->libelle }}
                                        </p> --}}
                                        <p class="mb-0 text-truncate">
                                            <i class="mdi mdi-lightbulb-multiple me-1"></i>
                                            {{ $projet->avancement_complet }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="px-4 py-3 border-top">
                            <div class="d-flex justify-content-between align-items-center w-100">
                                <div>
                                    <i class="bx bx-calendar me-1"></i> Crée
                                    {{ Carbon\Carbon::parse($projet->created_at)->diffForHumans() }}
                                </div>
                                <span class="badge bg-primary p-2">
                                    {{ $projet->etat_complet }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
            @endforeach
        </div>
    </div>
</div>

@include('partials.footer')
</div>
@endsection

@section('script')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">

$(function() {
    $('input[name="start_date"]').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
            format: 'YYYY-MM-DD'
        }
    });

    $('input[name="end_date"]').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
            format: 'YYYY-MM-DD'
        }
    });
});

    function resetFilters() {
        // Réinitialiser le formulaire
        document.getElementById('filterForm').reset();
        
        // Réinitialiser les valeurs des champs de date de daterangepicker
        $('input[name="start_date"]').daterangepicker('clear');
        $('input[name="end_date"]').daterangepicker('clear');
        
        // Réinitialiser les valeurs des champs de sélection
        $('select[name="status"]').val('');
        $('select[name="avancement"]').val('');
    }

</script>
@endsection