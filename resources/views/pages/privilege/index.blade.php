@extends('layouts.main')

@section('title', ' Privilèges - ' . config('app.name'))

@section('style')
    <!-- Datatable -->
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" id="bootstrap-style"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" id="bootstrap-style"
        rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        id="bootstrap-style" rel="stylesheet" type="text/css" />
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
                            <h4 class="mb-sm-0 font-size-18">Privileges</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name') }}</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Privileges</a></li>
                                    <li class="breadcrumb-item active">Privileges</li>
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
                                    <h4 class="card-title">Liste des Privilèges</h4>
                                    <div class="actions d-flex align-items-center">
                                        <a class="btn btn-sm btn-primary me-2" href="{{ route('add.writer') }}">Nouveau
                                            Privilège</a>
                                        <button class="btn btn-sm btn-primary" onclick="reload()">Actualiser</button>
                                    </div>
                                </div>

                                <table id="datatable" class="table table-bordered align-middle w-100">
                                    <thead>
                                        <tr>
                                            <th style="width: 20%">Utilisateur</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($users as $key => $user)
                                            <tr>
                                                <td>{{ $user->nom_complet }}</td>
                                                <td>
                                                    <table class="table table-bordered align-middle w-100">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 15%">Module</th>
                                                                <th style="width: 50%">Privilèges</th>
                                                                <th class="text-center" style="width: 10%"></th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            @foreach ($user->modules as $module)
                                                                <tr>
                                                                    <th>
                                                                        {{ $module->module }}
                                                                    </th>
                                                                    <td>
                                                                        @if ($module->pivot->consulter == 1)
                                                                            <span class="badge bg-info me-2 p-2">
                                                                                Consulter
                                                                            </span>
                                                                        @endif

                                                                        @if ($module->pivot->modifier == 1)
                                                                            <span class="badge bg-warning me-2 p-2">
                                                                                Modifier
                                                                            </span>
                                                                        @endif

                                                                        @if ($module->pivot->ajouter == 1)
                                                                            <span class="badge bg-success me-2 p-2">
                                                                                Ajouter
                                                                            </span>
                                                                        @endif

                                                                        @if ($module->pivot->supprimer == 1)
                                                                            <span class="badge bg-danger p-2">
                                                                                Supprimer
                                                                            </span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-center">
                                                                        @if (auth()->user()->role == 1 || auth()->user()->role == 5)
                                                                            <a href="{{ route('edit.writer', $module->pivot->id) }}"
                                                                                class="btn btn-sm btn-warning">
                                                                                <i class="bx bx-edit"></i>
                                                                            </a>
                                                                            <a href="{{ route('delete.writer', $module->pivot->id) }}"
                                                                                onclick="return confirm('Voulez-vous vraiment supprimer?')"
                                                                                class="btn btn-sm btn-danger">
                                                                                <i class="bx bx-trash"></i>
                                                                            </a>
                                                                        @else
                                                                            @foreach ($privileges as $privilege)
                                                                                @if ($privilege->module == 10 && $privilege->modifier == 1)
                                                                                    <a href="{{ route('edit.writer', $module->pivot->id) }}"
                                                                                        class="btn btn-sm btn-warning">
                                                                                        <i class="bx bx-edit"></i>
                                                                                    </a>
                                                                                @endif
                                                                                @if ($privilege->module == 10 && $privilege->supprimer == 1)
                                                                                    <a href="{{ route('delete.writer', $module->pivot->id) }}"
                                                                                        onclick="return confirm('Voulez-vous vraiment supprimer?')"
                                                                                        class="btn btn-sm btn-danger">
                                                                                        <i class="bx bx-trash"></i>
                                                                                    </a>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
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

        @include('partials.footer')
    </div>
@endsection

@section('script')
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
@endsection
