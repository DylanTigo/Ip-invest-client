@extends('layouts.main')

@section('title', 'Projets - ' . config('app.name'))

@section('style')
    {{--
<link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> --}}

    <!-- Datatable -->
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
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
                            <h4 class="mb-sm-0 font-size-18">Projets</h4>

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
                            <div class="actions-start d-flex align-items-center">
                                @if (auth()->user()->role == 1 || auth()->user()->role == 5)
                                    <button id="openMessageModal" class="btn btn-sm btn-primary me-2"
                                        onclick="openMessageModal('{{ route('chat.new', ['sender' => auth()->user()->id, 'receiver' => $projet->secteur_data->conseiller_data->id]) }}')">
                                        Message au conseiller d'investissement
                                        <i class="mdi mdi-email-plus ms-1"></i>
                                    </button>
                                @endif
                                @if (auth()->user()->role == 1 || auth()->user()->role == 2 || auth()->user()->role == 5)
                                    <button id="openMessageModal" class="btn btn-sm btn-primary"
                                        onclick="openMessageModal('{{ route('chat.new', ['sender' => auth()->user()->id, 'receiver' => $projet->user_data->id]) }}')">
                                        Message au porteur du projet
                                        <i class="mdi mdi-email-plus ms-1"></i>
                                    </button>
                                @endif
                            </div>

                            <div class="actions d-flex align-items-center">
                                @if (auth()->user()->role == 1)
                                    @if ($projet->etat == 'ATTENTE_VALIDATION_ADMIN' || $projet->etat == 'ATTENTE_INFO_SUPPL')
                                        <a href="{{ route('projet.admin.validate', $projet->id) }}"
                                            class="btn btn-sm btn-success me-2">Approuver</a>
                                        <a href="{{ route('projet.askinfosupp', $projet->id) }}"
                                            class="btn btn-sm btn-info me-2">Demander info
                                            supple</a>
                                        <a href="{{ route('projet.rejet', $projet->id) }}"
                                            class="btn btn-sm btn-dark me-2">Rejeter</a>
                                    @endif
                                @else
                                    @foreach ($privileges as $privilege)
                                        @if ($privilege->module == 1 && $privilege->modifier == 1)
                                            {{-- @if (auth()->user()->role == 1)
                                                @if ($projet->etat == 'ATTENTE_VALIDATION_ADMIN' || $projet->etat == 'ATTENTE_INFO_SUPPL')
                                                    <a href="{{ route('projet.admin.validate', $projet->id) }}"
                                                        class="btn btn-sm btn-success me-2">Approuver</a>
                                                    <a href="{{ route('projet.askinfosupp', $projet->id) }}"
                                                        class="btn btn-sm btn-info me-2">Demander info
                                                        supple</a>
                                                    <a href="{{ route('projet.rejet', $projet->id) }}"
                                                        class="btn btn-sm btn-dark me-2">Rejeter</a>
                                                @endif
                                            @else --}}
                                                @if ($projet->etat == 'ATTENTE' || $projet->etat == 'ATTENTE_INFO_SUPPL')
                                                    <a href="{{ route('projet.civalidate', $projet->id) }}"
                                                        class="btn btn-sm btn-success me-2">Approuver</a>
                                                    <a href="{{ route('projet.askinfosupp', $projet->id) }}"
                                                        class="btn btn-sm btn-info me-2">Demander info
                                                        supp</a>
                                                    <a href="{{ route('projet.rejet', $projet->id) }}"
                                                        class="btn btn-sm btn-dark me-2">Rejeter</a>
                                                @endif
                                            {{-- @endif --}}
                                        @endif
                                    @endforeach
                                @endif
                                @if (auth()->user()->role == 1)
                                    @if ($projet->etat == 'VALIDE' || $projet->etat == 'COMPLET' || $projet->etat == 'PUBLIE')
                                        <a href="{{ route('projet.edit', $projet->id) }}"
                                            class="btn btn-sm btn-warning me-2">Modifier</a>
                                    @endif
                                @else
                                    @foreach ($privileges as $privilege)
                                        @if ($privilege->module == 1 && $privilege->modifier == 1)
                                            @if ($projet->etat == 'VALIDE' || $projet->etat == 'COMPLET' || $projet->etat == 'PUBLIE')
                                                <a href="{{ route('projet.edit', $projet->id) }}"
                                                    class="btn btn-sm btn-warning me-2">Modifier</a>
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                                @if ($projet->etat == 'PUBLIE')
                                    <a href="{{ route('actualites.home', ['projet', $projet->id]) }}"
                                        class="btn btn-sm btn-info me-2">Actualités</a>
                                    {{-- <a href="{{ route('projet.add') }}" class="btn btn-sm btn-info me-2">Actualités</a>--}}
                                @endif
                                @if (auth()->user()->role == 1)
                                    <a href="{{ route('projet.delete', $projet->id) }}"
                                        onclick="return confirm('Voulez-vous vraiment supprimer?')"
                                        class="btn btn-sm btn-danger me-2">Supprimer</a>
                                @else
                                    @foreach ($privileges as $privilege)
                                        @if ($privilege->module == 1 && $privilege->supprimer == 1)
                                            <a href="{{ route('projet.delete', $projet->id) }}"
                                                onclick="return confirm('Voulez-vous vraiment supprimer?')"
                                                class="btn btn-sm btn-danger me-2">Supprimer</a>
                                        @endif
                                    @endforeach
                                @endif
                                @if (auth()->user()->role == 1 || auth()->user()->role == 2 || auth()->user()->role == 5 )
                                    @if ($projet->etat == 'COMPLET')
                                        <a href="{{ route('projet.publish', $projet->id) }}"
                                            class="btn btn-sm btn-primary me-2">Publier</a>
                                    @endif

                                    @if ($projet->etat == 'PUBLIE' )
                                        <a href="{{ route('projet.cloture', $projet->id) }}"
                                            class="btn btn-sm btn-success me-2">Cloturer</a>
                                    @endif

                                @endif

                                <button class="btn btn-sm btn-primary" onclick="reload()">Actualiser</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Projets</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">Projets</li>
                                </ol>
                            </div>

                <div class="row">
                    <div class="col-lg-7 h-100">
                        <div class="row">
                            <div class="col-lg-12">
                                {{-- <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Apercu</h4>

                                    <div id="overview-chart" class="apex-charts" dir="ltr"></div>
                                </div>
                            </div> --}}
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex mb-5">
                                            <div class="flex-shrink-0 me-4">
                                                <img src="{{ $projet->logo ? $projet->logo : asset('assets/images/projet.jpg') }}"
                                                    alt="" class="avatar-md">
                                            </div>

                                            <div class="d-flex">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <h4 class="text-wrap font-size-16">
                                                        {{ $projet->intitule }}
                                                    </h4>
                                                    <p class="fw-bolder text-primary font-size-15">
                                                        {{ number_format($projet->financement, 0, ',', ' ') }}
                                                        XAF</p>
                                                </div>
                                            </div>
                                        </div>

                                        <ul class="verti-timeline list-unstyled">
                                            <li class="event-list">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex justify-content-start align-items-center">
                                                        <div class="event-timeline-dot align-self-center">
                                                            <i
                                                                class="bx bxs-right-arrow-circle font-size-18 text-primary"></i>
                                                        </div>
                                                        <h5 class="font-size-15 text-primary text-truncate">
                                                            {{ $projet->secteur_data->libelle }} <br />
                                                            <span class="font-size-12 text-muted"><a class="text-muted"
                                                                    href="{{ route('user.profile', $projet->secteur_data->conseiller_data->id) }}">Conseiller:
                                                                    {{ $projet->secteur_data->conseiller_data->nom_complet }}</a></span>
                                                            <h5>
                                                    </div>
                                                    <span class="badge bg-primary p-2">
                                                        @if ($projet->etat == 'VALIDE')
                                                            Paiement effectué
                                                        @else
                                                            {{ $projet->etat_complet }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </li>
                                        </ul>

                                        <hr>

                                        <div class="text-muted">
                                            <strong>
                                                <p>
                                                    <i class="mdi mdi-chevron-right text-primary me-1"></i>
                                                    Crée {{ Carbon\Carbon::parse($projet->created_at)->diffForHumans() }}
                                                </p>
                                                <p>
                                                    <i class="mdi mdi-chevron-right text-primary me-1"></i> Niveau
                                                    d'avancement:
                                                    <span class="text-primary">{{ $projet->avancement_complet }}</span>
                                                </p>
                                                <p>
                                                    <i class="mdi mdi-chevron-right text-primary me-1"></i> Pays
                                                    d'activité:
                                                    <span class="text-primary">{{ $projet->pays_activite }}</span>
                                                </p>
                                                <p>
                                                    <i class="mdi mdi-chevron-right text-primary me-1"></i> Ville
                                                    d'activité:
                                                    <span class="text-primary">{{ $projet->ville_activite }}</span>
                                                </p>
                                            </strong>
                                        </div>

                                        {{-- <div class="row text-center mb-4">
                                        <div class="col-md-6 col-lg-3">
                                            <div>
                                                <p class="text-muted fw-bolder mb-2">Crée</p>
                                                <h6 class="mb-0 text-primary">
                                                    {{ Carbon\Carbon::parse($projet->created_at)->diffForHumans() }}
         </h6>
        </div>
       </div>
       <div class="col-md-6 col-lg-3">
        <div>
         <p class="text-muted fw-bolder mb-2">Niveau d'avancement</p>
         <h6 class="mb-0 text-primary">{{ $projet->avancement_complet }}</h6>
        </div>
       </div>
       <div class="col-md-6 col-lg-3">
        <div>
         <p class="text-muted fw-bolder mb-2">Pays</p>
         <h6 class="mb-0 text-primary">{{ $projet->pays_activite }}</h6>
        </div>
       </div>
       <div class="col-md-6 col-lg-3">
        <div>
         <p class="text-muted fw-bolder mb-2">Ville</p>
         <h6 class="mb-0 text-primary">{{ $projet->ville_activite }}</h6>
        </div>
       </div>
      </div> --}}

                                        <hr>

                                        <div class="text-muted mb-4">
                                            <strong>
                                                <p>
                                                    <i class="mdi mdi-chevron-right text-primary me-1"></i>
                                                    INVESTISSEMENT RECUS :
                                                    <span
                                                        class="text-primary fw-bolder">{{ number_format($total_invest, 0, ',', ' ') }}
                                                        XAF</span>
                                                </p>
                                                <p>
                                                    <i class="mdi mdi-chevron-right text-primary me-1"></i>
                                                    NOMBRE D'INVESTISSEUR :
                                                    <span class="text-primary text-primary">{{ $nber_invest }}</span>
                                                    investisseurs
                                                </p>
                                            </strong>
                                        </div>

                                        <hr>

                                        <div class="row mb-4">
                                            <div class="col-sm-12 col-md-12">
                                                <h5 class="font-size-15 fw-bolder">Description</h5>
                                                <p class="text-muted">{{ $projet->description }}</p>
                                            </div>
                                        </div>

                                        @if ($projet->duree)
                                            <hr>

                                            <div class="text-muted">
                                                <strong>
                                                    <p><i class="mdi mdi-chevron-right text-primary me-1"></i> TAUX DE
                                                        RENTABILITE : <span
                                                            class="text-primary">{{ $projet->taux_rentabilite }}
                                                            %</span> </p>
                                                    <p><i class="mdi mdi-chevron-right text-primary me-1"></i> RESTOUR SUR
                                                        INVESTISSEMENT: <span class="text-primary">{{ $projet->rsi }}
                                                            mois</span>
                                                    </p>
                                                    <p><i class="mdi mdi-chevron-right text-primary me-1"></i> CA
                                                        PREVISIONNEL:
                                                        <span
                                                            class="text-primary">{{ number_format($projet->ca_previsionnel, 0, ',', ' ') }}
                                                            XAF</span>
                                                    </p>
                                                    <p><i class="mdi mdi-chevron-right text-primary me-1"></i> DUREE DU
                                                        PROJET: <span class="text-primary">{{ $projet->duree }}
                                                            mois</span>
                                                    </p>
                                                </strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                @if (count($projet->membres) > 0)
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title mb-4">Membres de l'equipe du projet</h4>

                                            <div class="table-responsive">
                                                <table class="table align-middle">
                                                    <thead>
                                                        <th></th>
                                                        <th>Membre</th>
                                                        <th>Téléphone</th>
                                                        <th>Email</th>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($projet->membres as $item)
                                                            <tr>
                                                                <td>
                                                                    <a target="_blank" href="{{ $item->photo }}">
                                                                        <img src="{{ $item->photo }}"
                                                                            class="rounded-circle avatar-xs"
                                                                            alt="">
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    <h5 class="font-size-14 m-0">
                                                                        <a href="javascript: void(0);"
                                                                            class="text-dark">{{ $item->nom_complet }}</a>
                                                                    </h5>
                                                                    <span
                                                                        class="badge bg-primary bg-soft text-primary font-size-11">{{ $item->pivot->statut }}</span>
                                                                </td>
                                                                <td>
                                                                    {{ $item->telephone }}
                                                                </td>
                                                                <td>
                                                                    {{ $item->email }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="card">
                                        <div class="card-body d-flex justify-content-center align-items-center py-4">
                                            <h4 class="card-title mb-4">Aucune équipe pour ce projet</h4>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 h-100">

                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Porteur de projet</h4>
                                <div class="text-muted fw-bolder mb-4">
                                    <p>
                                        <i class="mdi mdi-chevron-right text-primary me-1"></i>
                                        NOM COMPLET : {{ $projet->user_data->nom_complet }}
                                    </p>
                                    <p>
                                        <i class="mdi mdi-chevron-right text-primary me-1"></i>
                                        TÉLÉPHONE : {{ $projet->user_data->telephone }}
                                    </p>
                                    <p>
                                        <i class="mdi mdi-chevron-right text-primary me-1"></i>
                                        EMAIL : {{ $projet->user_data->email }}
                                    </p>
                                </div>
                            </div>
                        </div>


                        @if (count($docs) > 0 || !empty($projet->user_data->cni))
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Documents du porteur de projet</h4>
                                    <div class="table-responsive">
                                        <div class="table-responsive">
                                            <table class="table align-middle table-hover mb-0">
                                                <tbody>
                                                    @foreach ($docs as $row)
                                                        <tr>
                                                            <td style="width: 10%;">
                                                                <div class="avatar-xs">
                                                                    <span
                                                                        class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-24">
                                                                        <i class="bx bxs-file-doc"></i>
                                                                    </span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <h5 class="font-size-12 text-truncated-2 mb-0"><a
                                                                        target="_blank" download
                                                                        href="{{ $row->document }}"
                                                                        class="text-dark">{{ $row->type }}</a></h5>
                                                            </td>
                                                            <td style="width: 10%;">
                                                                <div class="text-center">
                                                                    <a download target="_blank"
                                                                        href="{{ $row->document }}" class="text-dark"><i
                                                                            class="bx bx-download h4 m-0"></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    @if (!empty($projet->user_data->cni))
                                                        <tr>
                                                            <td style="width: 10%;">
                                                                <div class="avatar-xs">
                                                                    <span
                                                                        class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-24">
                                                                        <i class="bx bxs-file-doc"></i>
                                                                    </span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <h5 class="font-size-12 text-truncated-2 mb-0"><a
                                                                        target="_blank" download
                                                                        href="{{ $projet->user_data->cni }}"
                                                                        class="text-dark">CNI /
                                                                        Passport</a></h5>
                                                            </td>
                                                            <td style="width: 10%;">
                                                                <div class="text-center">
                                                                    <a download target="_blank"
                                                                        href="{{ $projet->user_data->cni }}"
                                                                        class="text-dark"><i
                                                                            class="bx bx-download h4 m-0"></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (!empty($projet->doc_presentation))
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Document presentation</h4>
                                    <div class="table-responsive">
                                        <table class="table align-middle table-hover mb-0">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 10%;">
                                                        <div class="avatar-xs">
                                                            <span
                                                                class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-24">
                                                                <i class="mdi mdi-file"></i>
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <h5 class="font-size-12 text-truncated-2 mb-0"><a download
                                                                target="_blank" href="{{ $projet->doc_presentation }}"
                                                                class="text-dark">Presentation du projet</a></h5>
                                                    </td>
                                                    <td style="width: 10%;">
                                                        <div class="text-center">
                                                            <a download target="_blank"
                                                                href="{{ $projet->doc_presentation }}"
                                                                class="text-dark"><i
                                                                    class="bx bx-download h4 m-0"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <?php
                        $filesPP = $projet->medias->filter(function ($media, $key) {
                            return $media->source == 'PP';
                        });
                        $filesIV = $projet->medias->filter(function ($media, $key) {
                            return $media->source == 'CONSEILLER';
                        });
                        ?>

                        @if (count($filesPP) > 0)
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Fichiers joints de la part du porteur de projet</h4>
                                    <div class="table-responsive">

                                        <div class="accordion" id="accordionExamplePP">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOnePP">
                                                    <button class="accordion-button fw-bolder collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseOnePP"
                                                        aria-expanded="false" aria-controls="collapseOnePP">
                                                        Documents
                                                    </button>
                                                </h2>
                                                <div id="collapseOnePP" class="accordion-collapse collapse"
                                                    aria-labelledby="headingOnePP" data-bs-parent="#accordionExamplePP">
                                                    <div class="accordion-body">
                                                        <table class="table align-middle table-hover mb-0">
                                                            <tbody>
                                                                @foreach ($filesPP as $row)
                                                                    @if ($row->type == 'FICHIER')
                                                                        <tr>
                                                                            <td style="width: 10%;">
                                                                                <div class="avatar-xs">
                                                                                    <span
                                                                                        class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-24">
                                                                                        <i class="bx bxs-file-doc"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <h5
                                                                                    class="font-size-12 text-truncated-2 mb-0">
                                                                                    <a download target="_blank"
                                                                                        href="{{ $row->url }}"
                                                                                        class="text-dark">{{ $row->nom }}</a>
                                                                                </h5>
                                                                            </td>
                                                                            <td style="width: 20%;">
                                                                                <div class="text-center">
                                                                                    <a
                                                                                        href="{{ route('archive.delete.projet', $row->id) }}">
                                                                                        <i
                                                                                            class="bx bx-trash h4 m-0 me-2 text-danger"></i>
                                                                                    </a>
                                                                                    <a download target="_blank"
                                                                                        href="{{ $row->url }}"
                                                                                        class="text-dark">
                                                                                        <i
                                                                                            class="bx bx-download h4 m-0"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingTwoPP">
                                                    <button class="accordion-button fw-bolder collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseTwoPP"
                                                        aria-expanded="false" aria-controls="collapseTwoPP">
                                                        Images
                                                    </button>
                                                </h2>
                                                <div id="collapseTwoPP" class="accordion-collapse collapse"
                                                    aria-labelledby="headingTwoPP" data-bs-parent="#accordionExamplePP">
                                                    <div class="accordion-body">
                                                        <table class="table align-middle table-hover mb-0">
                                                            <tbody>
                                                                @foreach ($filesPP as $row)
                                                                    @if ($row->type == 'IMAGE')
                                                                        <tr>
                                                                            <td style="width: 10%;">
                                                                                <div class="avatar-xs">
                                                                                    <span
                                                                                        class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-24">
                                                                                        <i class="mdi mdi-image"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <h5
                                                                                    class="font-size-12 text-truncated-2 mb-0">
                                                                                    <a download target="_blank"
                                                                                        href="{{ $row->url }}"
                                                                                        class="text-dark">{{ $row->nom }}</a>
                                                                                </h5>
                                                                            </td>
                                                                            <td style="width: 20%;">
                                                                                <div class="text-center">
                                                                                    <a
                                                                                        href="{{ route('archive.delete.projet', $row->id) }}">
                                                                                        <i
                                                                                            class="bx bx-trash h4 m-0 me-2 text-danger"></i>
                                                                                    </a>
                                                                                    <a download target="_blank"
                                                                                        href="{{ $row->url }}"
                                                                                        class="text-dark">
                                                                                        <i
                                                                                            class="bx bx-download h4 m-0"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingThreePP">
                                                    <button class="accordion-button fw-bolder collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseThreePP"
                                                        aria-expanded="false" aria-controls="collapseThreePP">
                                                        Vidéos
                                                    </button>
                                                </h2>
                                                <div id="collapseThreePP" class="accordion-collapse collapse"
                                                    aria-labelledby="headingThreePP" data-bs-parent="#accordionExamplePP">
                                                    <div class="accordion-body">
                                                        <table class="table align-middle table-hover mb-0">
                                                            <tbody>
                                                                @foreach ($filesPP as $row)
                                                                    @if ($row->type == 'VIDEO')
                                                                        <tr>
                                                                            <td style="width: 10%;">
                                                                                <div class="avatar-xs">
                                                                                    <span
                                                                                        class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-24">
                                                                                        <i
                                                                                            class="mdi mdi-play-circle-outline"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <h5
                                                                                    class="font-size-12 text-truncated-2 mb-0">
                                                                                    <a download target="_blank"
                                                                                        href="{{ $row->url }}"
                                                                                        class="text-dark">{{ $row->nom }}</a>
                                                                                </h5>
                                                                            </td>
                                                                            <td style="width: 20%;">
                                                                                <div class="text-center">
                                                                                    <a
                                                                                        href="{{ route('archive.delete.projet', $row->id) }}">
                                                                                        <i
                                                                                            class="bx bx-trash h4 m-0 me-2 text-danger"></i>
                                                                                    </a>
                                                                                    <a download target="_blank"
                                                                                        href="{{ $row->url }}"
                                                                                        class="text-dark">
                                                                                        <i
                                                                                            class="bx bx-download h4 m-0"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
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
                        @endif

                        @if (count($filesIV) > 0)
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Fichiers joints pour l'investisseur</h4>
                                    <div class="table-responsive">

                                        <div class="accordion" id="accordionExampleIV">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOneIV">
                                                    <button class="accordion-button fw-bolder collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseOneIV"
                                                        aria-expanded="false" aria-controls="collapseOneIV">
                                                        Documents
                                                    </button>
                                                </h2>
                                                <div id="collapseOneIV" class="accordion-collapse collapse"
                                                    aria-labelledby="headingOneIV" data-bs-parent="#accordionExampleIV">
                                                    <div class="accordion-body">
                                                        <table class="table align-middle table-hover mb-0">
                                                            <tbody>
                                                                @foreach ($filesIV as $row)
                                                                    @if ($row->type == 'FICHIER')
                                                                        <tr>
                                                                            <td style="width: 10%;">
                                                                                <div class="avatar-xs">
                                                                                    <span
                                                                                        class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-24">
                                                                                        <i class="bx bxs-file-doc"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <h5
                                                                                    class="font-size-12 text-truncated-2 mb-0">
                                                                                    <a download target="_blank"
                                                                                        href="{{ $row->url }}"
                                                                                        class="text-dark">{{ $row->nom }}</a>
                                                                                </h5>
                                                                            </td>
                                                                            <td style="width: 20%;">
                                                                                <div class="text-center">
                                                                                    <a
                                                                                        href="{{ route('archive.delete.projet', $row->id) }}">
                                                                                        <i
                                                                                            class="bx bx-trash h4 m-0 me-2 text-danger"></i>
                                                                                    </a>
                                                                                    <a download target="_blank"
                                                                                        href="{{ $row->url }}"
                                                                                        class="text-dark">
                                                                                        <i
                                                                                            class="bx bx-download h4 m-0"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingTwoIV">
                                                    <button class="accordion-button fw-bolder collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseTwoIV"
                                                        aria-expanded="false" aria-controls="collapseTwoIV">
                                                        Images
                                                    </button>
                                                </h2>
                                                <div id="collapseTwoIV" class="accordion-collapse collapse"
                                                    aria-labelledby="headingTwoIV" data-bs-parent="#accordionExampleIV">
                                                    <div class="accordion-body">
                                                        <table class="table align-middle table-hover mb-0">
                                                            <tbody>
                                                                @foreach ($filesIV as $row)
                                                                    @if ($row->type == 'IMAGE')
                                                                        <tr>
                                                                            <td style="width: 10%;">
                                                                                <div class="avatar-xs">
                                                                                    <span
                                                                                        class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-24">
                                                                                        <i class="mdi mdi-image"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <h5
                                                                                    class="font-size-12 text-truncated-2 mb-0">
                                                                                    <a download target="_blank"
                                                                                        href="{{ $row->url }}"
                                                                                        class="text-dark">{{ $row->nom }}</a>
                                                                                </h5>
                                                                            </td>
                                                                            <td style="width: 20%;">
                                                                                <div class="text-center">
                                                                                    <a
                                                                                        href="{{ route('archive.delete.projet', $row->id) }}">
                                                                                        <i
                                                                                            class="bx bx-trash h4 m-0 me-2 text-danger"></i>
                                                                                    </a>
                                                                                    <a download target="_blank"
                                                                                        href="{{ $row->url }}"
                                                                                        class="text-dark">
                                                                                        <i
                                                                                            class="bx bx-download h4 m-0"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingThreeIV">
                                                    <button class="accordion-button fw-bolder collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseThreeIV"
                                                        aria-expanded="false" aria-controls="collapseThreeIV">
                                                        Vidéos
                                                    </button>
                                                </h2>
                                                <div id="collapseThreeIV" class="accordion-collapse collapse"
                                                    aria-labelledby="headingThreeIV" data-bs-parent="#accordionExampleIV">
                                                    <div class="accordion-body">
                                                        <table class="table align-middle table-hover mb-0">
                                                            <tbody>
                                                                @foreach ($filesIV as $row)
                                                                    @if ($row->type == 'VIDEO')
                                                                        <tr>
                                                                            <td style="width: 10%;">
                                                                                <div class="avatar-xs">
                                                                                    <span
                                                                                        class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-24">
                                                                                        <i
                                                                                            class="mdi mdi-play-circle-outline"></i>
                                                                                    </span>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <h5
                                                                                    class="font-size-12 text-truncated-2 mb-0">
                                                                                    <a download target="_blank"
                                                                                        href="{{ $row->url }}"
                                                                                        class="text-dark">{{ $row->nom }}</a>
                                                                                </h5>
                                                                            </td>
                                                                            <td style="width: 20%;">
                                                                                <div class="text-center">
                                                                                    <a
                                                                                        href="{{ route('archive.delete.projet', $row->id) }}">
                                                                                        <i
                                                                                            class="bx bx-trash h4 m-0 me-2 text-danger"></i>
                                                                                    </a>
                                                                                    <a download target="_blank"
                                                                                        href="{{ $row->url }}"
                                                                                        class="text-dark">
                                                                                        <i
                                                                                            class="bx bx-download h4 m-0"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
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
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @include('partials.footer')
    </div>

    <div id="userMessage" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="userMessageLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form id="userMessageForm" action="" method="POST">
                    @csrf
                    <input type="hidden" name="projet" value="{{ $projet->id }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userMessageLabel">Nouveau message
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group">
                                <label for="autoresize">Votre message</label>
                                <textarea id="autoresize" class="form-control overflow-hidden" name="body" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary waves-effect"
                            data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-sm btn-primary waves-effect waves-light">Envoyer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- crypto dash init js -->
    {{-- <script type="text/javascript" src="{{ asset('assets/js/pages/project-overview.init.js') }}"></script> --}}

    <script type="text/javascript">
        function openMessageModal(url) {
            $('#userMessageForm').attr('action', url);
            new bootstrap.Modal(document.getElementById('userMessage')).show()
        }
    </script>
@endsection
