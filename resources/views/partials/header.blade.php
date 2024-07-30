<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box d-flex align-items-center p-0">
                <a href="{{ route('dashboard') }}" class="font-weight-bold font-size-18">
                    <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="70">
                    IP Investment SA
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" onclick="goBack()">
                <i class="fa fa-fw fa-arrow-alt-circle-left"></i> Retour en arrière
            </button>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" onclick="reload()">
                <i class="mdi mdi-refresh"></i> Actualiser la page
            </button>
        </div>

        <div class="d-flex">

            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="bx bx-fullscreen"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect"
                    onclick="redirectTo('{{ route('chat.home') }}')">
                    <span class="badge bg-danger rounded-pill"
                        id="noti">{{ auth()->user()->unreadNotifications->count() }}</span>
                    <i class="bx bx-envelope"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect"
                    id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="bx bx-bell bx-tada"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user"
                        src="{{ auth()->user()->photo ? auth()->user()->photo : asset('assets/images/profil.jpg') }}"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ auth()->user()->nom }}
                        {{ auth()->user()->prenom }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="{{ route('user.profile', ['id' => null]) }}"><i
                            class="bx bx-user font-size-16 align-middle me-1"></i> <span
                            key="t-profile">Profil</span></a>
                    <a class="dropdown-item" href="{{ route('chat.home') }}"><i
                            class="bx bx-user font-size-16 align-middle me-1"></i> <span
                            key="t-profile">Messagerie</span></a>
                    {{-- <a class="dropdown-item d-block" href="#"><i
                            class="bx bx-wrench font-size-16 align-middle me-1"></i> <span
                            key="t-settings">Paramètres</span></a> --}}
                    <div class="dropdown-divider"></div>
                    @if (Auth::user()->role == 1)
                        <a class="dropdown-item d-block" href="{{ route('add.writer') }}">
                            <i class="bx bx-wrench font-size-16 align-middle me-1"></i>
                            <span key="t-settings">
                                Ajouter
                                privilèges</span></a>
                        <div class="dropdown-divider"></div>
                    @endif

                    <a class="dropdown-item text-danger" href="{{ route('auth.logout') }}"><i
                            class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span
                            key="t-logout">Déconnexion</span></a>
                </div>
            </div>
        </div>
    </div>
</header>
