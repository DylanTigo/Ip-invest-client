@extends('layouts.main')

@section('title', $title . ' - ' . config('app.name'))

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
        switch ($role->value) {
            case 1:
                $module = 3;
                break;
        
            case 2:
                $module = 4;
                break;
        
            case 3:
                $module = 5;
                break;
        
            case 4:
                $module = 2;
                break;
        
            case 5:
                $module = 3;
                break;
        
            default:
                $module = 3;
                break;
        }
        
    @endphp
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">{{ $title }}</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name') }}</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Utilisateurs</a></li>
                                    <li class="breadcrumb-item active">{{ $title }}</li>
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
                                    <h4 class="card-title">Liste des {{ lcfirst($title) }}</h4>
                                    <div class="actions d-flex align-items-center">
                                        @if (auth()->user()->role == 1)
                                            <a href="{{ route('user.add', $role->value) }}"
                                                class="btn btn-sm btn-primary me-2">Nouveau {{ $role->name }}</a>
                                        @else
                                            @foreach ($privileges as $privilege)
                                                @if ($privilege->module == $module && $privilege->ajouter == 1)
                                                    <a href="{{ route('user.add', $role->value) }}"
                                                        class="btn btn-sm btn-primary me-2">Nouveau {{ $role->name }}</a>
                                                @endif
                                            @endforeach
                                        @endif
                                        <button class="btn btn-sm btn-primary" onclick="reload()">Actualiser</button>
                                    </div>
                                </div>

                                <table id="datatable" class="table table-bordered align-middle w-100">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Utilisateur</th>
                                            {{-- <th>Email</th>
                                            <th style="width: 20%">Téléphone</th> --}}
                                            @if ($role->value == 3 || $role->value == 4)
                                                <th class="text-center">Statut</th>
                                            @endif
                                            @if ($role->value == 4)
                                                <th class="text-center">Profil</th>
                                            @endif
                                            @if ($role->value == 2)
                                                <th>Secteurs d'activités</th>
                                            @endif
                                            <th class="text-center"></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td style="width: 5%" class="text-center"
                                                    @if ($role->value == 2 && count($user->secteurs_data) > 0) rowspan="{{ count($user->secteurs_data) }}" @endif>
                                                    @if (!empty($user->photo))
                                                        <div>
                                                            <img class="rounded-circle avatar-xs" src="{{ $user->photo }}"
                                                                alt="">
                                                        </div>
                                                    @else
                                                        <div class="avatar-xs">
                                                            <span class="avatar-title rounded-circle">
                                                                {{ strtoupper(substr($user->nom, 0, 1)) }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                </td>

                                                <th
                                                    @if ($role->value == 2 && count($user->secteurs_data) > 0) rowspan="{{ count($user->secteurs_data) }}" @endif>
                                                    <a href="{{ route('user.profile', $user->id) }}">{{ $user->nom_complet }}
                                                    </a>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <small>{{ $user->email }}</small>
                                                        <small>{{ $user->telephone }}</small>
                                                    </div>
                                                </th>

                                                {{-- <td style="width: 20%"
                                                    rowspan="{{ $role->value == 2 ? count($user->secteurs_data) : 1 }}">
                                                    {{ $user->email }}
                                                </td>

                                                <td rowspan="{{ $role->value == 2 ? count($user->secteurs_data) : 1 }}">
                                                    {{ $user->telephone }}
                                                </td> --}}

                                                @if ($role->value == 3 || $role->value == 4)
                                                    <td class="text-center text-capitalize">
                                                        <strong>{{ $user->status }}</strong>
                                                    </td>
                                                @endif

                                                @if ($role->value == 4)
                                                    <td class="text-center text-capitalize">
                                                        @if ($user->profil != null)
                                                            <strong>{{ $user->profil_invest->type }}</strong>
                                                        @endif
                                                    </td>
                                                @endif
                                                @if ($role->value == 2)
                                                    <td style="width: 25%">
                                                        @if (count($user->secteurs_data) > 0)
                                                            {{ $user->secteurs_data ? $user->secteurs_data[0]->libelle : '' }}
                                                        @endif
                                                    </td>
                                                @endif

                                                <td @if ($role->value == 2 && count($user->secteurs_data) > 0) rowspan="{{ count($user->secteurs_data) }}" @endif
                                                    class="text-center">
                                                    @if ($role->value == 2 && (auth()->user()->role == 1 || auth()->user()->role == 5))
                                                        <a href="{{ route('chat.view', $user->id) }}"
                                                            class="btn btn-sm btn-info">
                                                            <i class="bx bx-envelope"></i>
                                                        </a>
                                                        <a href="{{ route('user.report', $user->id) }}"
                                                            class="btn btn-sm btn-secondary">
                                                            <i class="bx bx-notepad"></i>
                                                        </a>
                                                    @endif

                                                    @if ($role->value == 3 || $role->value == 4 || $role->value == 2)
                                                        <button id="openMessageModal{{ $user->id }}"
                                                            data-user="{{ $user->nom_complet }}"
                                                            data-url="{{ route('chat.new', ['sender' => auth()->user()->id, 'receiver' => $user->id]) }}"
                                                            class="btn btn-sm btn-info"
                                                            onclick="openMessageModal({{ $user->id }})">
                                                            <i class="mdi mdi-email-plus"></i>
                                                        </button>
                                                    @endif

                                                    @if (auth()->user()->role == 1)
                                                        @if ($role->value == 1 || $role->value == 2 || $role->value == 5 || auth()->user()->role == 1)
                                                            <a href="{{ route('user.edit', $user->id) }}"
                                                                class="btn btn-sm btn-warning"><i
                                                                    class="bx bx-edit"></i></a>
                                                        @endif
                                                        <a href="{{ route('user.delete', $user->id) }}"
                                                            onclick="return confirm('Voulez-vous vraiment supprimer?')"
                                                            class="btn btn-sm btn-danger"><i class="bx bx-trash"></i></a>
                                                    @else
                                                        @foreach ($privileges as $privilege)
                                                            @if ($privilege->module == $module && $privilege->modifier == 1)
                                                                @if ($role->value == 1 || $role->value == 2 || $role->value == 5 || auth()->user()->role == 1)
                                                                    <a href="{{ route('user.edit', $user->id) }}"
                                                                        class="btn btn-sm btn-warning"><i
                                                                            class="bx bx-edit"></i></a>
                                                                @endif
                                                            @endif

                                                            @if ($privilege->module == $module && $privilege->supprimer == 1)
                                                                <a href="{{ route('user.delete', $user->id) }}"
                                                                    onclick="return confirm('Voulez-vous vraiment supprimer?')"
                                                                    class="btn btn-sm btn-danger"><i
                                                                        class="bx bx-trash"></i></a>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </td>
                                            </tr>
                                            @if ($role->value == 2)
                                                @foreach ($user->secteurs_data as $item)
                                                    @if (!$loop->first)
                                                        <tr>
                                                            <td style="max-width: 20% !important">
                                                                {{ $item->libelle }}
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
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
        @include('partials.footer')
    </div>

    <div id="userMessage" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="userMessageLabel" aria-hidden="true">
        <input type="hidden" name="role" value="{{ $role->value }}">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form id="userMessageForm" action="" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="userMessageLabel">Nouveau message à <span
                                id="message-user-name"></span>
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

    <script type="text/javascript">
        function openMessageModal(id) {
            const url = $('#openMessageModal' + id).data('url');
            const user = $('#openMessageModal' + id).data('user');
            $('#userMessageForm').attr('action', url);
            $('#message-user-name').text(user);
            new bootstrap.Modal(document.getElementById('userMessage')).show()
        }
    </script>
@endsection
