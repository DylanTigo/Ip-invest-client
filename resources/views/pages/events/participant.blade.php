@extends('layouts.main')

@section('title', 'Évenement - ' . config('app.name'))

@section('style')
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" id="bootstrap-style"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" id="bootstrap-style"
        rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        id="bootstrap-style" rel="stylesheet" type="text/css" />

        <style>
        .taille {
            height: 100px;
            width: 100px;
            margin-top:3;
        }
    </style>
@endsection

@section('content')
    @php
        $privileges = DB::table('privileges')
            ->where('user', auth()->user()->id)
            ->get();
    @endphp
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">{{ $event->libelle }}</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item">
                                        <a href="javascript: void(0);">{{ config('app.name') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">Évenement</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-4">
                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h5 class="font-size-15 text-truncate">{{ $event->libelle }}</h5>
                                        <p class="text-muted mb-0 text-truncate">{{ $event->lieu }}</p>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="pt-4 d-flex justify-content-between">
                                            @if (auth()->user()->role == 1)
                                                <div>
                                                    <a href="{{ route('events.edit', $event->id) }}"
                                                        class="btn btn-primary waves-effect waves-light btn-sm">Modifier
                                                        <i class="mdi mdi-arrow-right ms-1"></i></a>
                                                </div>
                                                <div>
                                                    <a href="{{ route('events.delete', $event->id) }}"
                                                        onclick="return confirm('Voulez-vous vraiment supprimer?')"
                                                        class="btn btn-primary waves-effect waves-light btn-sm">Supprimer
                                                        <i class="mdi mdi-trash-can ms-1"></i></a>
                                                </div>
                                            @else
                                                @foreach ($privileges as $privilege)
                                                    @if ($privilege->module == 8 && $privilege->modifier == 1)
                                                        <div>
                                                            <a href="{{ route('events.edit', $event->id) }}"
                                                                class="btn btn-primary waves-effect waves-light btn-sm">Modifier
                                                                <i class="mdi mdi-arrow-right ms-1"></i></a>
                                                        </div>
                                                    @endif
                                                    @if ($privilege->module == 8 && $privilege->supprimer == 1)
                                                        <div>
                                                            <a href="{{ route('events.delete', $event->id) }}"
                                                                onclick="return confirm('Voulez-vous vraiment supprimer?')"
                                                                class="btn btn-primary waves-effect waves-light btn-sm">Supprimer
                                                                <i class="mdi mdi-trash-can ms-1"></i></a>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Informations sur l'evenement</h4>
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Date :</th>
                                                <td>
                                                     @if (!empty($event->date_debut) && !empty($event->heure_debut))
                                                        @dateFormat($event->date_debut) @timeFormat($event->heure_debut)
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (!empty($event->date_fin) && !empty($event->heure_fin))
                                                        @dateFormat($event->date_fin) @timeFormat($event->heure_fin)
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Prix :</th>
                                                <td>
                                                    @if (!empty($event->prix))
                                                        {{$event->prix}} XAF
                                                    @else
                                                        Gratuit
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Places reservées :</th>
                                                <td>{{$event->total_reserve}} places</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Places disponibles :</th>
                                                <td>{{$event->places - $event->total_reserve}} / {{$event->places}} places</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Participants</h4>
                                <div class="table-responsive">
                                    <table id="datatable" class="table align-middle w-100">
                                        <thead>
                                            <tr>
                                                <th scope="col">Nom complet</th>
                                                <th scope="col">Reserver</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($event->participants as $participant)
                                                <tr>
                                                    <th class="text-truncate">
                                                        <p class="mb-0">
                                                            {{ $participant->nom }}
                                                        </p>
                                                        <div class="d-flex gap-2">
                                                            <small>{{ $participant->email }}</small>
                                                            <small>{{ $participant->telephone }}</small>
                                                        </div>
                                                    </th>
                                                    <td style="width: 15%">
                                                        {{$participant->places}} places
                                                    </td>
                                                    <td style="width: 5%" class="text-center">
                                                        <a href="{{ route('events.show.participant', $participant->id) }}"
                                                            class="btn btn-sm btn-warning">
                                                            <i class="bx bx-detail"></i>
                                                        </a>   
                                                    </td>

                                                    <td style="width: 5%" class="text-center">
                                                        <a href="{{ route('events.delete.participant', $participant->id) }}"
                                                            onclick="return confirm('Voulez-vous vraiment supprimer la paticipation de {{ $participant->nom }}?')"
                                                            class="btn btn-sm btn-danger">
                                                            <i class="bx bx-trash"></i>
                                                        </a>
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
                <!-- end row -->
            <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Images</h4>
                                <div class="row row-cols-1 row-cols-md-3 g-4">
                                @if($event->image)
                                    <div class="form-group">
                                        <img src="{{ asset('storage/uploads/events/' . basename($event->image)) }}" alt="Current Image" width="50">
                                    </div>
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Fichier</h4>
                                <div class="row row-cols-1 row-cols-md-3 g-4">
                                @if(isset($event->fichier))
                                    <a href="{{ asset('storage/' . $event->fichier) }}" target="_blank">Voir le fichier PDF</a>
                                @endif
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
               
                <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Partenaires</h4>
                                <div class="row row-cols-1 row-cols-md-3 g-4">
                                    @foreach ($event->partenaires as $partenaire)
                                        <div class="col-md-4 mt-3 mx-auto px-1">
                                            <div class="card">
                                                <img src="{{ asset('storage/uploads/partenaires/' . basename($partenaire->image)) }}" class="taille"
                                                    alt="Image du partenaire">
                                                
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        @include('partials.footer')
    </div>

    
@endsection

@section('script')
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection
