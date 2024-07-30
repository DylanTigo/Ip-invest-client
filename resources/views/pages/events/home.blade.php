@extends('layouts.main')

@section('title', 'Évènements - ' . config('app.name'))

@section('style')
    {{-- <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> --}}

    <!-- Datatable -->
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
        <style>
        .partner-image {
            max-width: 50px; /* Taille maximale des images partenaires */
            height: auto;
            margin: 5px; /* Espacement autour des images */
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
                            <h4 class="mb-sm-0 font-size-18">Évènements</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">Évènements</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-5">
                                    <h4 class="card-title">Liste des différents évenements</h4>
                                    <div class="actions d-flex align-items-center">
                                        @if (auth()->user()->role == 1)
                                            <a href="{{ route('events.add') }}" class="btn btn-sm btn-primary me-2">Nouveau
                                                évenement</a>
                                        @else
                                            @foreach ($privileges as $privilege)
                                                @if ($privilege->module == 8 && $privilege->ajouter == 1)
                                                    <a href="{{ route('events.add') }}"
                                                        class="btn btn-sm btn-primary me-2">Nouveau
                                                        évenement</a>
                                                @endif
                                            @endforeach
                                        @endif
                                        <button class="btn btn-sm btn-primary" onclick="reload()">Actualiser</button>
                                    </div>
                                </div>

                                <table id="datatable" class="table table-bordered align-middle w-100">
                                    <thead>
                                        <tr>
                                            <th>Évenement</th>
                                            <th>Date début</th>
                                            <th>Date fin</th>
                                            <th>Prix</th>
                                            <th>Places restant</th>
                                            <th>Partenaires</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($events as $event)
                                            <tr>
                                                <td>
                                                    <h5 class="font-size-14 mb-1 text-truncated-2 text-capitalize"><a
                                                            href="{{ route('events.show', $event->id) }}"
                                                            class="text-decoration-none">{{ $event->libelle }}</a></h5>
                                                    <p class="text-muted mb-0">{{ $event->lieu }}</p>
                                                </td>
                                                <td>
                                                    <h5 class="font-size-14 mb-1 text-dark">@dateFormat($event->date_debut)
                                                    </h5>
                                                    <p class="text-muted mb-0">@timeFormat($event->heure_debut)</p>
                                                </td>
                                                <td>
                                                    <h5 class="font-size-14 mb-1 text-dark"> {{ $event->date_fin ? dateFormat($event->date_fin) : '' }}
                                                    </h5>
                                                    <p class="text-muted mb-0">{{$event->heure_fin ? timeFormat($event->heure_fin) : ''}}</p>
                                                </td>
                                                <td>
                                                    @if (!empty($event->prix))
                                                        {{$event->prix}} XAF
                                                    @else
                                                        Gratuit
                                                    @endif
                                                </td>
                                                <td>
                                                    <h5 class="font-size-14 mb-1 text-dark">{{$event->places - $event->total_reserve}} /
                                                        {{$event->places}} places</h5>
                                                    <p class="text-muted mb-0">{{$event->total_reserve}} places reservées</p>
                                                </td>
                                                <td>
                                                <ul>
                                                    @foreach($event->partenaires as $partenaire)
                                                    <img src="{{ asset('storage/uploads/partenaires/' . basename($partenaire->image)) }}" alt="Logo du partenaire" class="partner-image">
                                                    @endforeach
                                                </ul>
                                                </td>
                                                <td class="text-center">
                                                    @if (auth()->user()->role == 1)
                                                        <a href="{{ route('events.edit', $event->id) }}"
                                                            class="btn btn-sm btn-warning float-right"><i
                                                                class="bx bx-edit"></i></a>
                                                    @else
                                                        @foreach ($privileges as $privilege)
                                                            @if ($privilege->module == 8 && $privilege->modifier == 1)
                                                                <a href="{{ route('events.edit', $event->id) }}"
                                                                    class="btn btn-sm btn-warning float-right"><i
                                                                        class="bx bx-edit"></i></a>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    <a href="{{ route('events.show', $event->id) }}"
                                                        class="btn btn-sm btn-warning float-right"><i
                                                            class="bx bx-detail"></i></a>
                                                    @if (auth()->user()->role == 1)
                                                        <a href="{{ route('events.delete', $event->id) }}"
                                                            onclick="return confirm('Voulez-vous vraiment supprimer?')"
                                                            class="btn btn-sm btn-danger float-right"><i
                                                                class="bx bx-trash"></i>
                                                        </a>
                                                    @else
                                                        @foreach ($privileges as $privilege)
                                                            @if ($privilege->module == 8 && $privilege->supprimer == 1)
                                                                <a href="{{ route('events.delete', $event->id) }}"
                                                                    onclick="return confirm('Voulez-vous vraiment supprimer?')"
                                                                    class="btn btn-sm btn-danger float-right"><i
                                                                        class="bx bx-trash"></i>
                                                                </a>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->

            </div>
        </div>

        @include('partials.footer')
    </div>


@endsection

@section('script')
    {{-- <script type="text/javascript" src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script> --}}

    <!-- Required datatable js -->
    <script type="text/javascript" src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}">
    </script>

    <!-- Responsive examples -->
    <script type="text/javascript"
        src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <!-- Datatable init js -->
    <script type="text/javascript" src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>

    {{-- <script type="text/javascript" src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script> --}}
@endsection
