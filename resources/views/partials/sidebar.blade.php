<div class="vertical-menu">

    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">

            @php
                $privileges = DB::table('privileges')
                    ->where('user', Auth::user()->id)
                    ->get();
            @endphp

            @if (Auth::user()->role == 1)
                <ul class="metismenu list-unstyled" id="side-menu">
                    <li class="menu-title" key="t-menu">Menu</li>

                    <li>
                        <a href="{{ route('dashboard') }}" class="waves-effect">
                            <i class="bx bx-home-circle"></i>
                            <span key="t-dashboard">Tableaux de bord</span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect" aria-expanded="true">
                            <i class="bx bx-briefcase-alt-2"></i>
                            <span key="t-projects">Projets</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false" style="">
                            <li><a href="{{ route('projet.home') }}" key="t-p-grid">Plateforme</a></li>
                            <li><a href="{{ route('projet.home_ip') }}" key="t-p-list">IP Investment SA</a></li>
                        </ul>
                    </li>


                    <li>
                        <a href="{{ route('investissement.home') }}" class="waves-effect">
                            <i class="mdi mdi-cash-multiple"></i>
                            <span key="t-investment">Investissements</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('events.home') }}" class="waves-effect">
                            <i class="mdi mdi-calendar-multiple-check"></i>
                            <span key="t-evenement">Évènements</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('projet.archives') }}" class="waves-effect">
                            <i class="mdi mdi-content-save-all"></i>
                            <span key="t-archive">Archives</span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-account-group"></i>
                            <span key="t-user">Utilisateurs</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">

                            <li><a href="{{ route('user.sous_administrateur') }}"
                                    key="t-admin">Sous-administrateurs</a></li>
                            <li><a href="{{ route('user.conseiller') }}" key="t-counsellor">Conseillers </a></li>
                            <li><a href="{{ route('user.porteur.projet') }}" key="t-projet-owner">Porteur projets </a>
                            </li>
                            <li><a href="{{ route('user.investisseur') }}" key="t-investisor">Investisseurs </a></li>

                        </ul>
                    </li>

                    <li>
                        <a href="{{ route('transactions.home') }}" class="waves-effect">
                            <i class="mdi mdi-cash"></i>
                            <span key="t-slide">Transactions</span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect" aria-expanded="true">
                            <i class="bx bx-briefcase-alt-2"></i>
                            <span key="t-projects">Newsletters</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('newsletter.home') }}" key="t-newsletter-mail">Mails</a></li>
                            <li><a href="{{ route('newsletter.mails') }}" key="t-newsletter-email">Emails</a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-title" key="t-menu">Paramètrage</li>

                    <li>
                        <a href="{{ route('profil.investisseur.home') }}" class="waves-effect">
                            <i class="mdi mdi-account-cog"></i>
                            <span key="t-profil-investisseur">Profils investisseurs</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('profil.porteur.home') }}" class="waves-effect">
                            <i class="mdi mdi-account-cog"></i>
                            <span key="t-profil-investisseur">Profils des PPs</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('category.home') }}" class="waves-effect">
                            <i class="mdi mdi-domain"></i>
                            <span key="t-categorie">Secteurs d'activités</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('experts.home') }}" class="waves-effect">
                            <i class="mdi mdi-account-group"></i>
                            <span key="t-categorie">Experts</span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-shield-account"></i>
                            <span key="t-user">Privilèges</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('add.writer') }}" key="t-writer">Ajouter un privilège</a></li>
                            <li><a href="{{ route('all.writer') }}" key="t-all_writer">Tous les privilèges</a></li>
                        </ul>
                    </li>

                    <li class="menu-title" key="t-menu">Site</li>

                    <li>
                        <a href="{{ route('slider.home') }}" class="waves-effect">
                            <i class="mdi mdi-cog-box"></i>
                            <span key="t-slide">Slides</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('partenaires.home') }}" class="waves-effect">
                            <i class="mdi mdi-account-switch"></i>
                            <span key="t-partenaire">Partenaires</span>
                        </a>
                    </li>

                </ul>
            @else
                <ul class="metismenu list-unstyled" id="side-menu">
                    <li class="menu-title" key="t-menu">Menu</li>

                    <li>
                        <a href="{{ route('dashboard') }}" class="waves-effect">
                            <i class="bx bx-home-circle"></i>
                            <span key="t-dashboard">Tableaux de bord</span>
                        </a>
                    </li>

                    @foreach ($privileges as $privilege)
                        @if ($privilege->module == 1 && $privilege->consulter == 1)
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect" aria-expanded="true">
                                    <i class="bx bx-briefcase-alt-2"></i>
                                    <span key="t-projects">Projets</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false" style="">
                                    <li><a href="{{ route('projet.home') }}" key="t-p-grid">Plateforme</a></li>
                                    <li><a href="{{ route('projet.home_ip') }}" key="t-p-list">Invest &
                                            Partners</a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if ($privilege->module == 6 && $privilege->consulter == 1)
                            <li>
                                <a href="{{ route('investissement.home') }}" class="waves-effect">
                                    <i class="mdi mdi-cash-multiple"></i>
                                    <span key="t-investment">Investissements</span>
                                </a>
                            </li>
                        @endif


                        @if ($privilege->module == 8 && $privilege->consulter == 1)
                            <li>
                                <a href="{{ route('events.home') }}" class="waves-effect">
                                    <i class="mdi mdi-calendar-multiple-check"></i>
                                    <span key="t-evenement">Évènements</span>
                                </a>
                            </li>
                        @endif

                        @if ($privilege->module == 13 && $privilege->consulter == 1)
                            <li>
                                <a href="{{ route('projet.archives') }}" class="waves-effect">
                                    <i class="mdi mdi-content-save-all"></i>
                                    <span key="t-archive">Archives</span>
                                </a>
                            </li>
                        @endif
                    @endforeach

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-account-group"></i>
                            <span key="t-user">Utilisateurs</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @foreach ($privileges as $privilege)
                                @if ($privilege->module == 3 && $privilege->consulter == 1)
                                    <li><a href="{{ route('user.sous_administrateur') }}"
                                            key="t-admin">Sous-administrateurs</a></li>
                                @endif


                                @if ($privilege->module == 4 && $privilege->consulter == 1)
                                    <li><a href="{{ route('user.conseiller') }}" key="t-counsellor">Conseillers
                                        </a>
                                    </li>
                                @endif

                                @if ($privilege->module == 5 && $privilege->consulter == 1)
                                    <li><a href="{{ route('user.porteur.projet') }}" key="t-projet-owner">Porteur
                                            projets </a></li>
                                @endif

                                @if ($privilege->module == 2 && $privilege->consulter == 1)
                                    <li><a href="{{ route('user.investisseur') }}" key="t-investisor">Investisseurs
                                        </a></li>
                                @endif
                            @endforeach
                        </ul>
                    </li>

                    <li>
                        <a href="{{ route('transactions.home') }}" class="waves-effect">
                            <i class="mdi mdi-cash"></i>
                            <span key="t-slide">Transactions</span>
                        </a>
                    </li>

                    @foreach ($privileges as $privilege)
                        @if ($privilege->module == 15 && $privilege->consulter == 1)
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect" aria-expanded="true">
                                    <i class="bx bx-briefcase-alt-2"></i>
                                    <span key="t-projects">Newsletters</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ route('newsletter.home') }}" key="t-newsletter-mail">Mails</a>
                                    </li>
                                    <li><a href="{{ route('newsletter.mails') }}" key="t-newsletter-email">Emails</a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    @endforeach


                    <li class="menu-title" key="t-menu">Paramètrage</li>

                    @foreach ($privileges as $privilege)
                        @if ($privilege->module == 7 && $privilege->consulter == 1)
                            <li>
                                <a href="{{ route('profil.investisseur.home') }}" class="waves-effect">
                                    <i class="mdi mdi-account-cog"></i>
                                    <span key="t-profil-investisseur">Profils investisseurs</span>
                                </a>
                            </li>
                        @endif

                        @if ($privilege->module == 17 && $privilege->consulter == 1)
                            <li>
                                <a href="{{ route('profil.porteur.home') }}" class="waves-effect">
                                    <i class="mdi mdi-account-cog"></i>
                                    <span key="t-profil-investisseur">Profils des PPs</span>
                                </a>
                            </li>
                        @endif


                        @if ($privilege->module == 11 && $privilege->consulter == 1)
                            <li>
                                <a href="{{ route('category.home') }}" class="waves-effect">
                                    <i class="mdi mdi-domain"></i>
                                    <span key="t-categorie">Secteurs d'activités</span>
                                </a>
                            </li>
                        @endif

                        @if ($privilege->module == 16 && $privilege->consulter == 1)
                            <li>
                                <a href="{{ route('experts.home') }}" class="waves-effect">
                                    <i class="mdi mdi-account-group"></i>
                                    <span key="t-categorie">Experts</span>
                                </a>
                            </li>
                        @endif


                        @if ($privilege->module == 10 && $privilege->consulter == 1)
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="mdi mdi-shield-account"></i>
                                    <span key="t-user">Privilèges</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ route('add.writer') }}" key="t-writer">Ajouter un privilège</a>
                                    </li>
                                    <li><a href="{{ route('all.writer') }}" key="t-all_writer">Tous les
                                            privilèges</a></li>
                                </ul>
                            </li>
                        @endif

                        @if ($privilege->module == 12 && $privilege->consulter == 1)
                            <li class="menu-title" key="t-menu">Site</li>

                            <li>
                                <a href="{{ route('slider.home') }}" class="waves-effect">
                                    <i class="mdi mdi-cog-box"></i>
                                    <span key="t-slide">Slides</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('partenaires.home') }}" class="waves-effect">
                                    <i class="mdi mdi-account-switch"></i>
                                    <span key="t-partenaire">Partenaires</span>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>

            @endif

        </div>
        <!-- Sidebar -->
    </div>
</div>
