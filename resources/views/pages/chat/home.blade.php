@extends('layouts.main')

@section('title', 'Messagerie - ' . config('app.name'))

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
                            <h4 class="mb-sm-0 font-size-18">Messagerie</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name') }}</a>
                                    </li>
                                    <li class="breadcrumb-item"><a
                                            href="javascript: void(0);">{{ $sender->nom . ' ' . $sender->prenom }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">Messagerie</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="d-lg-flex mb-4">
                    <div class="chat-leftsidebar shadow-lg rounded me-lg-4" style="height: fit-content;">
                        <div class="card mb-0">
                            <div class="px-3 py-4">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 align-self-center me-3">
                                        @if (!empty($sender->photo))
                                            <div>
                                                <img class="rounded-circle avatar-xs" src="{{ $sender->photo }}"
                                                    alt="">
                                            </div>
                                        @else
                                            <div class="avatar-xs">
                                                <span class="avatar-title rounded-circle">
                                                    {{ strtoupper(substr($sender->nom, 0, 1)) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex-grow-1">
                                        <h5 class="font-size-15 mb-1">{{ $sender->nom . ' ' . $sender->prenom }}</h5>
                                        <p class="text-muted mb-0"><i
                                                class="mdi mdi-circle text-success align-middle me-1"></i>
                                            En ligne</p>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="px-3 py-4">
                            <button class="btn btn-primary btn-rounded w-100 btn-block" type="button">Nouvelle
                                conversation</button>
                        </div> --}}

                            <div class="chat-leftsidebar-nav bg-white">
                                <ul class="list-unstyled chat-list" data-simplebar style="max-height: 40rem;">
                                    @if (!empty($contacts))
                                        @foreach ($contacts as $key => $contact)
                                            <li class="{{ $conversation == $contact->conversation ? 'active' : '' }}">
                                                <a
                                                    href="{{ route('chat.conversation', ['id' => $contact->recepteur->id, 'conversation' => $contact->conversation]) }}">
                                                    <div class="d-flex">
                                                        <div class="me-3">
                                                            @if (!empty($contact->recepteur->photo))
                                                                <img class="rounded-circle avatar-xs"
                                                                    src="{{ $contact->recepteur->photo }}" alt="">
                                                            @else
                                                                <div class="avatar-xs">
                                                                    <span class="avatar-title rounded-circle">
                                                                        {{ strtoupper(substr($contact->recepteur->nom, 0, 1)) }}
                                                                    </span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <div>
                                                                <h5
                                                                    class="text-truncate font-size-14 d-flex justify-content-between align-items-center mb-1">
                                                                    <span>{{ $contact->recepteur->nom_complet }}</span>
                                                                    <span><i
                                                                            class="mdi {{ $contact->vu == 1
                                                                                ? " mdi-email-open
                                                                                                                                                                                                                                                                                                                                                                                                                                                            text-success"
                                                                                : 'mdi-email text-danger' }}
                                                                font-size-16"></i></span>
                                                                </h5>
                                                                <p class="text-truncate mb-0 text-primary fw-bolder">
                                                                    {{ $contact->projet ? $contact->projet->intitule : 'Renseignements' }}
                                                                </p>
                                                                <p
                                                                    class="text-truncate small mb-0 {{ $contact->vu == 1
                                                                        ? ''
                                                                        : "
                                                                                                                                                                                                                                                                                                                                                                                                            fw-bolder" }}">
                                                                    {{ $contact->message }}</p>
                                                            </div>
                                                            <div
                                                                class="font-size-10 mt-2 {{ $contact->vu == 1 ? '' : ' fw-bolder' }}">
                                                                {{ \Carbon\Carbon::parse($contact->created_at)->diffForHumans() }}
                                                            </div>
                                                        </div>

                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="w-100 user-chat">
                        <div class="card">
                            @if (!empty($messages))
                                <div class="p-4 border-bottom ">
                                    <div class="row">
                                        <div class="col-md-10">
                                            @if (!empty($projet))
                                                <h5 class="font-size-15 mb-1 text-truncate-2">{{ $projet->intitule }}</h5>
                                            @else
                                                <h5 class="font-size-15 mb-1">Renseignements</h5>
                                            @endif
                                            @if (!empty($receiver))
                                                <p class="text-muted mb-0">
                                                    {{ $receiver->nom_complet }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="col-md">
                                            <ul class="list-inline user-chat-nav text-end mb-0">
                                                <li class="list-inline-item  d-none d-sm-inline-block">
                                                    <div class="dropdown">
                                                        <button class="btn nav-btn dropdown-toggle" type="button"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="mdi mdi-menu-open"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            @if (!empty($projet))
                                                                <a class="dropdown-item"
                                                                    href="{{ route('projet.details', $projet->id) }}">Voir
                                                                    le
                                                                    projet</a>
                                                            @endif
                                                            <a class="dropdown-item"
                                                                href="{{ route('user.profile', $receiver->id) }}">Voir le
                                                                profil
                                                                de
                                                                {{ $receiver->nom_complet }}</a>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <div class="chat-conversation p-3">
                                        <ul class="list-unstyled mb-0 px-3" id="chat-message" data-simplebar
                                            style="height: 486px;">
                                            @foreach ($messages as $key => $message)
                                                @if ($message->envoyeur == auth()->user()->id)
                                                    <li class="w-50 float-end d-flex justify-content-end">
                                                        <div class="conversation-list">
                                                            @if ($message->vu == 0)
                                                                <div class="dropdown dropdown-left">
                                                                    <a class="dropdown-toggle" href="javascript:void(0)"
                                                                        role="button" data-bs-toggle="dropdown"
                                                                        aria-haspopup="true" aria-expanded="false">
                                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                                    </a>
                                                                    <div class="dropdown-menu">
                                                                        @if (auth()->user()->role == 1)
                                                                            <a class="dropdown-item"
                                                                                href="{{ route('chat.delete', $message->id) }}">Supprimer
                                                                                le
                                                                                message</a>
                                                                        @else
                                                                            @foreach ($privileges as $privilege)
                                                                                @if ($privilege->module == 9 && $privilege->supprimer == 1)
                                                                                    <a class="dropdown-item"
                                                                                        href="{{ route('chat.delete', $message->id) }}">Supprimer
                                                                                        le
                                                                                        message</a>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="ctext-wrap bg-primary">
                                                                <div class="conversation-name text-white">Vous</div>
                                                                <p class="text-white">
                                                                    {{ $message->message }}
                                                                </p>
                                                                @if (count($message->attachements) > 0)
                                                                    <div
                                                                        class="d-flex justify-content-start align-items-center flex-wrap mb-3">
                                                                        @foreach ($message->attachements as $key => $file)
                                                                            <a target="_blank" href="{{ $file->url }}"
                                                                                style='max-width: 15rem; cursor: pointer'
                                                                                title="Télécharger le fichier"
                                                                                class='badge bg-white text-primary badge-pill me-2 mb-2 p-2 overflow-hidden text-truncate font-size-12'>
                                                                                <i
                                                                                    class='mdi mdi-file-document-outline me-1'></i>
                                                                                {{ $file->nom }}
                                                                            </a>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                                <p class="chat-time mb-0 text-white"><i
                                                                        class="bx bx-time-five align-middle me-1"></i>
                                                                    {{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @else
                                                    <li class="w-50 float-start">
                                                        <div class="conversation-list">
                                                            <div class="ctext-wrap">
                                                                <div class="conversation-name">
                                                                    <a class="text-decoration-none"
                                                                        href="{{ route('user.profile', $message->sender->id) }}">
                                                                        {{ $message->sender->nom_complet }}
                                                                    </a>
                                                                </div>
                                                                <p>
                                                                    {{ $message->message }}
                                                                </p>
                                                                @if (count($message->attachements) > 0)
                                                                    <div
                                                                        class="d-flex justify-content-start align-items-center flex-wrap mb-3">
                                                                        @foreach ($message->attachements as $key => $file)
                                                                            <a target="_blank" href="{{ $file->url }}"
                                                                                style='max-width: 15rem; cursor: pointer'
                                                                                title="Télécharger le fichier"
                                                                                class='badge bg-primary text-white badge-pill me-2 mb-2 p-2 overflow-hidden text-truncate font-size-12'>
                                                                                <i
                                                                                    class='mdi mdi-file-document-outline me-1'></i>
                                                                                {{ $file->nom }}
                                                                            </a>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                                <p class="chat-time mb-0"><i
                                                                        class="bx bx-time-five align-middle me-1"></i>
                                                                    {{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="p-3 chat-input-section">
                                        <div class="d-flex justify-content-start align-items-center flex-wrap mb-3"
                                            id="chat-file-view"></div>
                                        <form onsubmit="submitChat(event)"
                                            action="{{ route('chat.send', ['sender' => auth()->user()->id, 'conversation' => $conversation, 'receiver' => $receiver->id]) }}"
                                            method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col">
                                                    <div class="position-relative">
                                                        <input type="hidden" name="projet"
                                                            value="{{ !empty($projet) ? $projet->id : '' }}">
                                                        <textarea id="autoresize" name="body" class="form-control overflow-hidden" placeholder="Votre message..."
                                                            rows="4"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-auto d-flex align-items-center flex-column">
                                                    <label for="chat-file-input"
                                                        class="btn btn-primary btn-rounded chat-send w-md waves-effect waves-light btn-sm">
                                                        <input type="file" id="chat-file-input" class="d-none"
                                                            multiple onchange="changeMedia(event)">
                                                        <span class="d-none d-sm-inline-block me-2"> Fichier</span>
                                                        <i class="mdi mdi-file-document-outline"></i>
                                                    </label>

                                                    @if (auth()->user()->role == 1)
                                                        <button type="submit"
                                                            class="btn btn-primary btn-rounded chat-send w-md mt-2 waves-effect waves-light btn-sm"><span
                                                                class="d-none d-sm-inline-block me-2">Envoyer</span> <i
                                                                class="mdi mdi-send"></i></button>
                                                    @else
                                                        @foreach ($privileges as $privilege)
                                                            @if ($privilege->module == 9 && $privilege->ajouter == 1)
                                                                <button type="submit"
                                                                    class="btn btn-primary btn-rounded chat-send w-md mt-2 waves-effect waves-light btn-sm"><span
                                                                        class="d-none d-sm-inline-block me-2">Envoyer</span>
                                                                    <i class="mdi mdi-send"></i></button>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <div class="py-5 d-flex justify-content-center align-items-center flex-column">
                                    @if (empty($contacts))
                                        <h4 class="mb-sm-0 font-size-15">Aucune conversation pour l'instant</h4>
                                    @else
                                        <h4 class="mb-sm-0 font-size-15">Sélectionnez une conversation</h4>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
                <!-- end row -->

            </div>
        </div>

        @include('partials.footer')
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        var medias = [];
        const simpleBar = new SimpleBar(document.getElementById('chat-message'));

        setTimeout(scrollToBottom, 1000);

        function scrollToBottom() {
            simpleBar.getScrollElement().scrollTo(0, simpleBar.getScrollElement().scrollHeight);
        }

        function removeFileInArray(file) {
            medias = medias.filter((ele) => {
                return ele.name !== file;
            });
            loadViewMedias(medias);
        }

        function fileExist(media) {
            let exist = false;
            medias.forEach(file => {
                if (file.name === media.name) {
                    exist = true;
                }
            });

            return exist;
        }

        function changeMedia(e) {
            let files = [...e.target.files];
            files = files.filter((ele) => {
                return !fileExist(ele);
            });
            medias = [...medias, ...files];
            loadViewMedias(medias);
        };

        function loadViewMedias(files) {
            $('#chat-file-view').empty();
            files.forEach(file => {
                $('#chat-file-view').append(`
                <span style='max-width: 20rem; cursor: not-allowed' onclick="removeFileInArray('${file?.name}')" title="Retirer le fichier"
                    class='badge bg-primary text-white badge-pill me-2 mb-2 p-2 overflow-hidden text-truncate font-size-12'>
                    <i class='mdi mdi-file-document-outline me-1'></i>
                        ${file?.name}
                </span>
            `)
            });
        };

        function objectifyForm(formArray) {
            var returnArray = {};
            for (var i = 0; i < formArray.length; i++) {
                returnArray[formArray[i]['name']] = formArray[i]['value'];
            }
            return returnArray;
        };

        function submitChat(e) {
            let data = objectifyForm($(e.target).serializeArray());
            let formData = new FormData();

            if (data?.projet) {
                formData.append('projet', data?.projet);
            }

            for (const media of medias) {
                formData.append('attachement[]', media);
            }

            formData.append('body', data?.body);

            $.ajax({
                url: $(e.target).attr('action'),
                type: $(e.target).attr('method'),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                encode: true,
                success: function(data) {
                    reload();
                },
                error: function(xhr, err) {
                    alert('Error');
                }
            });

            e.preventDefault();
        };

        $(document).ready(function() {
            loadViewMedias([]);
        });
    </script>
@endsection
