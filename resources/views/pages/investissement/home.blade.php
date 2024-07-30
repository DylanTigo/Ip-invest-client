@extends('layouts.main')

@section('title', 'Investissements - ' . config('app.name'))

@section('style')
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
    @endphp
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Investissements</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">Investissements</li>
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
                                    <h4 class="card-title">Liste des différents investissements</h4>
                                    <div class="actions d-flex align-items-center">
                                        @if (auth()->user()->role == 1)
                                            <a href="{{ route('investissement.add') }}"
                                                class="btn btn-sm btn-primary me-2">Nouvel
                                                investissement</a>
                                        @else
                                            @foreach ($privileges as $privilege)
                                                @if ($privilege->module == 6 && $privilege->ajouter == 1)
                                                    <a href="{{ route('investissement.add') }}"
                                                        class="btn btn-sm btn-primary me-2">Nouvel
                                                        investissement</a>
                                                @endif
                                            @endforeach
                                        @endif
                                        <button class="btn btn-sm btn-primary" onclick="reload()">Actualiser</button>
                                    </div>
                                </div>

                                <table id="datatable" class="table table-bordered align-middle w-100">
                                    <thead>
                                        <tr>
                                            <th>Nom de l'investisseur</th>
                                            <th>Projet</th>
                                            <th>Montant investi</th>
                                            <th>Date versement</th>
                                            <th>Facture</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($investissements as $investissement)
                                            <tr>
                                                <td>
                                                    <strong>{{ $investissement->user_data->nom_complet }}</strong>
                                                </td>
                                                <td style="width: 25%">
                                                    <span
                                                        class="text-truncated-2">{{ $investissement->projet_data->intitule }}</span>
                                                </td>
                                                <td>{{ number_format($investissement->montant, 0, ',', ' ') }} XAF</td>
                                                <td>@dateFormat($investissement->date_versement)</td>
                                                <td>
                                                    <a download href="{{ $investissement->facture_versement }}"
                                                        target="_blank">
                                                        <span class="badge bg-primary p-2">
                                                            Télécharger
                                                        </span>
                                                    </a>
                                                </td>
                                                <td>
                                                    @if (auth()->user()->role == 1)
                                                        <a href="{{ route('investissement.edit', $investissement->id) }}"
                                                            class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
                                                        <a href="{{ route('investissement.delete', $investissement->id) }}"
                                                            onclick="return confirm('Voulez-vous vraiment supprimer?')"
                                                            class="btn btn-sm btn-danger"><i class="bx bx-trash"></i></a>
                                                    @else
                                                        @foreach ($privileges as $privilege)
                                                            @if ($privilege->module == 6 && $privilege->modifier == 1)
                                                                <a href="{{ route('investissement.edit', $investissement->id) }}"
                                                                    class="btn btn-sm btn-warning"><i
                                                                        class="bx bx-edit"></i></a>
                                                            @endif

                                                            @if ($privilege->module == 6 && $privilege->supprimer == 1)
                                                                <a href="{{ route('investissement.delete', $investissement->id) }}"
                                                                    onclick="return confirm('Voulez-vous vraiment supprimer?')"
                                                                    class="btn btn-sm btn-danger"><i
                                                                        class="bx bx-trash"></i></a>
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
