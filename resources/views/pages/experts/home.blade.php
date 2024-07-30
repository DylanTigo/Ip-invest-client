@extends('layouts.main')

@section('title', 'Experts - ' . config('app.name'))

@section('style')
    <meta name="_token" content="{{ csrf_token() }}" />
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
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
                            <h4 class="mb-sm-0 font-size-18">Experts</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">Experts</li>
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
                                    <h4 class="card-title">Liste des experts</h4>
                                    <div class="actions d-flex align-items-center">
                                        @if (auth()->user()->role == 1)
                                            <a href="{{ route('experts.add') }}" class="btn btn-sm btn-primary me-2">Nouveau
                                                expert</a>
                                        @else
                                            @foreach ($privileges as $privilege)
                                                @if ($privilege->module == 17 && $privilege->ajouter == 1)
                                                    <a href="{{ route('experts.add') }}"
                                                        class="btn btn-sm btn-primary me-2">Nouveau expert</a>
                                                @endif
                                            @endforeach
                                        @endif
                                        <button class="btn btn-sm btn-primary" onclick="reload()">Actualiser</button>
                                    </div>
                                </div>

                                <table id="datatable" class="table table-bordered align-middle w-100">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%"></th>
                                            <th>Expert</th>
                                            <th>Email</th>
                                            <th>Télephone</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($experts as $expert)
                                            <tr>
                                                <td>
                                                    @if (!empty($expert->photo))
                                                        <div>
                                                            <img class="rounded-circle avatar-xs"
                                                                src="{{ $expert->photo_url }}" alt="">
                                                        </div>
                                                    @else
                                                        <div class="avatar-xs">
                                                            <span class="avatar-title rounded-circle">
                                                                {{ strtoupper(substr($expert->nom_complet, 0, 1)) }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <h5 class="font-size-14 mb-1 text-truncated-2 text-capitalize">
                                                        {{ $expert->nom_complet }}
                                                    </h5>
                                                    <p class="text-muted mb-0">{{ $expert->fonction }}</p>
                                                </td>
                                                <td>{{ $expert->email ?? 'Aucun' }}</td>
                                                <td>{{ $expert->telephone ?? 'Aucun' }}</td>
                                                <td class="text-center">
                                                    @if (auth()->user()->role == 1)
                                                        <a href="{{ route('experts.edit', $expert->id) }}"
                                                            class="btn btn-sm btn-warning"><i class="bx bx-edit"></i>
                                                        </a>
                                                        <a href="{{ route('experts.delete', $expert->id) }}"
                                                            onclick="return confirm('Voulez-vous vraiment supprimer cet expert?')"
                                                            class="btn btn-sm btn-danger"><i class="bx bx-trash"></i>
                                                        </a>
                                                    @else
                                                        @foreach ($privileges as $privilege)
                                                            @if ($privilege->module == 17 && $privilege->modifier == 1)
                                                                <a href="{{ route('experts.edit', $expert->id) }}"
                                                                    class="btn btn-sm btn-warning"><i
                                                                        class="bx bx-edit"></i>
                                                                </a>
                                                            @endif

                                                            @if ($privilege->module == 17 && $privilege->supprimer == 1)
                                                                <a href="{{ route('experts.delete', $expert->id) }}"
                                                                    onclick="return confirm('Voulez-vous vraiment supprimer cet expert?')"
                                                                    class="btn btn-sm btn-danger"><i
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
    <script type="text/javascript" src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}">
    </script>

    <script type="text/javascript"
        src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection
