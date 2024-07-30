@extends('layouts.main')

@section('title', 'Tableaux de bord - ' . config('app.name'))

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Tableaux de bord</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">Tableaux de bord</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    @if (auth()->user()->role == 1)
                        <div class="col-lg-4">
                            <div class="card" style="cursor: pointer"
                                onclick="redirectTo('{{ route('user.investisseur') }}')">
                                <div class="card-body">
                                    <div class="mb-4 d-flex align-items-center">
                                        <i class="mdi mdi-account-circle text-primary h1 me-3"></i>
                                        <div class="flex-grow-1 d-flex align-items-center">
                                            <h4 class="h3"> <a href="{{ route('user.investisseur') }}"
                                                    class="text-muted">Investisseurs</a></h4>
                                        </div>
                                    </div>

                                    <div class="text-muted font-size-15 fw-bolder">
                                        <p>
                                            <i class="mdi mdi-chevron-right text-primary me-1"></i> <span
                                                class="text-primary">@moneyFormat($investisseurs->count())</span>
                                            investisseurs
                                            inscrits
                                        </p>
                                        <p>
                                            <i class="mdi mdi-chevron-right text-primary me-1"></i> <span
                                                class="text-primary">@moneyFormat($investissement)</span> déjà
                                            investis
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card" style="cursor: pointer"
                                onclick="redirectTo('{{ route('user.porteur.projet') }}')">
                                <div class="card-body">
                                    <div class="mb-4 d-flex align-items-center">
                                        <i class="mdi mdi-account-circle text-success h1 me-3"></i>
                                        <div class="flex-grow-1 d-flex align-items-center">
                                            <h4 class="h3"> <a href="{{ route('user.porteur.projet') }}"
                                                    class="text-muted">Porteurs de projets</a></h4>
                                        </div>
                                    </div>
                                    <div class="text-muted font-size-15 fw-bolder">
                                        <p>
                                            <i class="mdi mdi-chevron-right text-success me-1"></i> <span
                                                class="text-success">@moneyFormat($porteurs->count())</span> porteurs
                                            de
                                            projets
                                            inscrits
                                        </p>
                                        <p>
                                            <i class="mdi mdi-chevron-right text-success me-1"></i> Besoin d'un
                                            financement
                                            de
                                            <span class="text-success"> @moneyFormat($besoinFinancement)</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card" style="cursor: pointer"
                                onclick="redirectTo('{{ route('user.conseiller') }}')">
                                <div class="card-body">
                                    <div class="mb-4 d-flex align-items-center">
                                        <i class="mdi mdi-account-circle text-warning h1 me-3"></i>
                                        <div class="flex-grow-1 d-flex align-items-center">
                                            <h4 class="h3"> <a href="{{ route('user.conseiller') }}"
                                                    class="text-muted">Conseillers</a></h4>
                                        </div>
                                    </div>
                                    <div class="text-muted font-size-15 fw-bolder">
                                        <p>
                                            <i class="mdi mdi-chevron-right text-warning me-1"></i> <span
                                                class="text-warning">{{$conseiller->count()}}</span>
                                            conseillers
                                        </p>
                                        <p>
                                            <i class="mdi mdi-chevron-right text-primary me-1"></i> <span
                                                class="text-warning">{{$secteurCouv->count()}}</span>
                                            secteurs
                                            couverts
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        @foreach ($privileges as $privilege)
                            @if ($privilege->module == 2 && $privilege->consulter == 1)
                                <div class="col-lg-4">
                                    <div class="card" style="cursor: pointer"
                                        onclick="redirectTo('{{ route('user.investisseur') }}')">
                                        <div class="card-body">
                                            <div class="mb-4 d-flex align-items-center">
                                                <i class="mdi mdi-account-circle text-primary h1 me-3"></i>
                                                <div class="flex-grow-1 d-flex align-items-center">
                                                    <h4 class="h3"> <a href="{{ route('user.investisseur') }}"
                                                            class="text-muted">Investisseurs</a></h4>
                                                </div>
                                            </div>

                                            <div class="text-muted font-size-15 fw-bolder">
                                                <p>
                                                    <i class="mdi mdi-chevron-right text-primary me-1"></i> <span
                                                        class="text-primary">@moneyFormat($investisseurs->count())</span>
                                                    investisseurs
                                                    inscrits
                                                </p>
                                                <p>
                                                    <i class="mdi mdi-chevron-right text-primary me-1"></i> <span
                                                        class="text-primary">@moneyFormat($investissement) </span> déjà
                                                    investis
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($privilege->module == 5 && $privilege->consulter == 1)
                                <div class="col-lg-4">
                                    <div class="card" style="cursor: pointer"
                                        onclick="redirectTo('{{ route('user.porteur.projet') }}')">
                                        <div class="card-body">
                                            <div class="mb-4 d-flex align-items-center">
                                                <i class="mdi mdi-account-circle text-success h1 me-3"></i>
                                                <div class="flex-grow-1 d-flex align-items-center">
                                                    <h4 class="h3"> <a href="{{ route('user.porteur.projet') }}"
                                                            class="text-muted">Porteurs de projets</a></h4>
                                                </div>
                                            </div>
                                            <div class="text-muted font-size-15 fw-bolder">
                                                <p>
                                                    <i class="mdi mdi-chevron-right text-success me-1"></i> <span
                                                        class="text-success">@moneyFormat($porteurs->count())</span>
                                                    porteurs
                                                    de
                                                    projets
                                                    inscrits
                                                </p>
                                                <p>
                                                    <i class="mdi mdi-chevron-right text-success me-1"></i> Besoin d'un
                                                    financement
                                                    de
                                                    <span class="text-success"> @moneyFormat($besoinFinancement)
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($privilege->module == 4 && $privilege->consulter == 1)
                                <div class="col-lg-4">
                                    <div class="card" style="cursor: pointer"
                                        onclick="redirectTo('{{ route('user.conseiller') }}')">
                                        <div class="card-body">
                                            <div class="mb-4 d-flex align-items-center">
                                                <i class="mdi mdi-account-circle text-warning h1 me-3"></i>
                                                <div class="flex-grow-1 d-flex align-items-center">
                                                    <h3 class="h3"> <a href="{{ route('user.conseiller') }}"
                                                            class="text-muted">Conseillers</a></h3>
                                                </div>
                                            </div>
                                            <div class="text-muted font-size-15 fw-bolder">
                                                <p>
                                                    <i class="mdi mdi-chevron-right text-warning me-1"></i> <span
                                                        class="text-warning">{{$conseiller->count()}}</span>
                                                    conseillers
                                                </p>
                                                <p>
                                                    <i class="mdi mdi-chevron-right text-primary me-1"></i> <span
                                                        class="text-warning">{{$secteurCouv->count()}}</span>
                                                    secteurs
                                                    couverts
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-4 d-flex align-items-center">
                                    <i class="bx bx-briefcase-alt-2 text-primary h1 me-3"></i>
                                    <h3 class="h3 flex-grow-1">
                                        @numberFormat($nbProjets->count()) projet(s) enregistré(s)
                                    </h3>
                                </div>
                                {{-- <h4 class="h4" class="card-title d-flex align-items-center gap-3 mb-4">
                                    <i class="bx bx-briefcase-alt-2 text-primary h1"></i>
                                    @numberFormat($nbProjets->count()) projets enregistrés
                                </h4> --}}

                                <div class="accordion mb-3" id="accordion-global-project">
                                    <div class="accordion-item bg-white">
                                        <div class="accordion-header" id="heading-global-project">
                                            <div role="button" class="accordion-button collapsed fw-medium" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse-global-project"
                                                aria-expanded="false" aria-controls="collapse-global-project">
                                                <h5 class="font-size-14 fw-bolder">
                                                    Statistique par plateforme
                                                </h5>
                                            </div>
                                        </div>

                                        <div id="collapse-global-project" class="accordion-collapse collapse"
                                            aria-labelledby="heading-global-project"
                                            data-bs-parent="#accordion-global-project">
                                            <div class="accordion-body">
                                                <div class="row text-center">
                                                    <div class="col-6">
                                                        <div>
                                                            <strong>
                                                                <p
                                                                    class="text-muted text-truncate mb-2 font-weight-bold text-uppercase">
                                                                    <a href="{{ route('projet.home_ip') }}"
                                                                        class="text-muted">
                                                                        IP INVESTMENT SA</a>
                                                                </p>
                                                            </strong>
                                                            <h5 class="mb-0 text-primary">@numberFormat($ip)</h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div>
                                                            <strong>
                                                                <p
                                                                    class="text-muted text-truncate mb-2 font-weight-bold text-uppercase">
                                                                    <a href="{{ route('projet.home') }}"
                                                                        class="text-muted">PLATEFORME</a>
                                                                </p>
                                                            </strong>
                                                            <h5 class="mb-0 text-primary">@numberFormat($autres)</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion mb-3" id="accordion-state-project">
                                    <div class="accordion-item bg-white">
                                        <div class="accordion-header" id="heading-state-project">
                                            <div role="button" class="accordion-button collapsed fw-medium" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse-state-project"
                                                aria-expanded="false" aria-controls="collapse-state-project">
                                                <h5 class="font-size-14 fw-bolder">
                                                    Statistique des projects par état
                                                </h5>
                                            </div>
                                        </div>

                                        <div id="collapse-state-project" class="accordion-collapse collapse"
                                            aria-labelledby="heading-state-project"
                                            data-bs-parent="#accordion-state-project">
                                            <div class="accordion-body">
                                                <div class="row table-responsive">
                                                    <table class="table align-middle">
                                                        <tbody>
                                                            @foreach ($etat as $item)
                                                                @switch($item->etat)
                                                                    @case('ATTENTE')
                                                                        <tr>
                                                                            <th>
                                                                                <a class="text-decoration-none"
                                                                                    href="{{ route('projet.home_etat', $item->etat) }}">En
                                                                                    attente</a>
                                                                            </th>
                                                                            <td class="text-center" style="width: 10%">
                                                                                <strong>{{ $item->total_etat }}</strong>
                                                                            </td>
                                                                        </tr>
                                                                    @break

                                                                    @case('VALIDE')
                                                                        <tr>
                                                                            <th>
                                                                                <a class="text-decoration-none"
                                                                                    href="{{ route('projet.home_etat', $item->etat) }}">Validé</a>
                                                                            </th>
                                                                            <td class="text-center bg-info" style="width: 10%">
                                                                                <strong>{{ $item->total_etat }}</strong>
                                                                            </td>
                                                                        </tr>
                                                                    @break

                                                                    @case('ATTENTE_PAIEMENT')
                                                                        <tr>
                                                                            <th>
                                                                                <a class="text-decoration-none"
                                                                                    href="{{ route('projet.home_etat', $item->etat) }}">En
                                                                                    attente paiement des frais
                                                                            <td class="text-center bg-secondary"
                                                                                style="width: 10%">
                                                                                <strong>{{ $item->total_etat }}</strong>
                                                                            </td>
                                                                        </tr>
                                                                    @break

                                                                    @case('ATTENTE_INFO_SUPPL')
                                                                        <tr>
                                                                            <th>
                                                                                <a class="text-decoration-none"
                                                                                    href="{{ route('projet.home_etat', $item->etat) }}">En
                                                                                    attente d'infos supplementaires</a>
                                                                            </th>
                                                                            <td class="text-center bg-warning" style="width: 10%">
                                                                                <strong>{{ $item->total_etat }}</strong>
                                                                            </td>
                                                                        </tr>
                                                                    @break

                                                                    @case('ATTENTE_VALIDATION_ADMIN')
                                                                        <tr>
                                                                            <th>
                                                                                <a class="text-decoration-none"
                                                                                    href="{{ route('projet.home_etat', $item->etat) }}">En
                                                                                    attente validation de l'administration</a>
                                                                            </th>
                                                                            <td class="text-center bg-warning" style="width: 10%">
                                                                                <strong>{{ $item->total_etat }}</strong>
                                                                            </td>
                                                                        </tr>
                                                                    @break

                                                                    @case('COMPLET')
                                                                        <tr>
                                                                            <th>
                                                                                <a class="text-decoration-none"
                                                                                    href="{{ route('projet.home_etat', $item->etat) }}">Complet</a>
                                                                            </th>
                                                                            <td class="text-center bg-success" style="width: 10%">
                                                                                <strong>{{ $item->total_etat }}</strong>
                                                                            </td>
                                                                        </tr>
                                                                    @break

                                                                    @case('PUBLIE')
                                                                        <tr>
                                                                            <th>
                                                                                <a class="text-decoration-none"
                                                                                    href="{{ route('projet.home_etat', $item->etat) }}">Publié</a>
                                                                            </th>
                                                                            <td class="text-center" style="width: 10%">
                                                                                <strong>{{ $item->total_etat }}</strong>
                                                                            </td>
                                                                        </tr>
                                                                    @break

                                                                    @case('CLOTURE')
                                                                        <tr>
                                                                            <th>
                                                                                <a class="text-decoration-none"
                                                                                    href="{{ route('projet.home_etat', $item->etat) }}">Cloturé</a>
                                                                            </th>
                                                                            <td class="text-center bg-success" style="width: 10%">
                                                                                <strong>{{ $item->total_etat }}</strong>
                                                                            </td>
                                                                        </tr>
                                                                    @break

                                                                    @default
                                                                        <tr>
                                                                            <th>
                                                                                <a class="text-decoration-none"
                                                                                    href="{{ route('projet.home_etat', $item->etat) }}">Rejeté</a>
                                                                            </th>
                                                                            <td class="text-center bg-danger" style="width: 10%">
                                                                                <strong>{{ $item->total_etat }}</strong>
                                                                            </td>
                                                                        </tr>
                                                                @endswitch
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion mb-3" id="accordion-secteur-project">
                                    <div class="accordion-item bg-white">
                                        <div class="accordion-header" id="heading-secteur-project">
                                            <div role="button" class="accordion-button collapsed fw-medium" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse-secteur-project"
                                                aria-expanded="false" aria-controls="collapse-secteur-project">
                                                <h5 class="font-size-14 fw-bolder">
                                                    Statistique des projets par secteur
                                                    d'activité
                                                </h5>
                                            </div>
                                        </div>

                                        <div id="collapse-secteur-project" class="accordion-collapse collapse"
                                            aria-labelledby="heading-secteur-project"
                                            data-bs-parent="#accordion-secteur-project">
                                            <div class="accordion-body">
                                                <div class="row table-responsive">
                                                    <table class="table align-middle">
                                                        <tbody>
                                                            @foreach ($secteur as $secteurItem)
                                                                <tr>
                                                                    <th>
                                                                        <a class="text-decoration-none"
                                                                            href="{{ route('projet.home_secteur', $secteurItem->id) }}">{{ $secteurItem->libelle }}</a>
                                                                    </th>
                                                                    <td class="text-center" style="width: 10%">
                                                                        <strong>{{ count($secteurItem->projets) }}</strong>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Statistique des projets par pays</h4>
                                @foreach ($pays as $key => $item)
                                    <div class="accordion mb-3" id="accordion-{{ $key }}">
                                        <div class="accordion-item">
                                            <div class="accordion-header" id="heading-{{ $key }}">
                                                <div class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapse-{{ $key }}" aria-expanded="false"
                                                    aria-controls="collapse-{{ $key }}">
                                                    <h5 class="font-size-14 fw-bolder">
                                                        {{ $item->pays_activite }} ({{ $item->total_projets }} projet(s))
                                                    </h5>
                                                </div>
                                            </div>

                                            <div id="collapse-{{ $key }}" class="accordion-collapse collapse"
                                                aria-labelledby="heading-{{ $key }}"
                                                data-bs-parent="#accordion-{{ $key }}">
                                                <div class="accordion-body">
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <tbody>
                                                                @foreach ($item->villes as $item2)
                                                                    <tr>
                                                                        <th><a class="text-decoration-none"
                                                                                href="{{ route('projet.home_ville', $item2->ville_activite) }}">{{ $item2->ville_activite }}</a>
                                                                        </th>
                                                                        <td class="text-end">
                                                                            <strong>{{ $item2->total_ville_projet }}</strong>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
