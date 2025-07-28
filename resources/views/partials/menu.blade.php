<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 917px;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light"><img src="/logobianco.png" style="width:100%"></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs("admin.home") ? "active" : "" }}" href="{{ route("admin.home") }}">
                        <i class="fas fa-fw fa-tachometer-alt nav-icon">
                        </i>
                        <p>
                            {{ trans('global.dashboard') }}
                        </p>
                    </a>
                </li>
                @can('preventivo_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.preventivos.index") }}" class="nav-link {{ request()->is("admin/preventivos") || request()->is("admin/preventivos/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-file-contract">

                            </i>
                            <p>
                                {{ trans('cruds.preventivo.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('scadenziario_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.scadenziarios.index") }}" class="nav-link {{ request()->is("admin/scadenziarios") || request()->is("admin/scadenziarios/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-calendar-alt">

                            </i>
                            <p>
                                {{ trans('cruds.scadenziario.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('itinerari_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.itineraris.index") }}" class="nav-link {{ request()->is("admin/itineraris") || request()->is("admin/itineraris/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-walking">

                            </i>
                            <p>
                                {{ trans('cruds.itinerari.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('email_standard_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.email-standards.index") }}" class="nav-link {{ request()->is("admin/email-standards") || request()->is("admin/email-standards/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-envelope">

                            </i>
                            <p>
                                {{ trans('cruds.emailStandard.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('servizi_general_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/alloggio-hotels*") ? "menu-open" : "" }} {{ request()->is("admin/aziende-trasportis*") ? "menu-open" : "" }} {{ request()->is("admin/trasportos*") ? "menu-open" : "" }} {{ request()->is("admin/servizio-extras*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/alloggio-hotels*") ? "active" : "" }} {{ request()->is("admin/aziende-trasportis*") ? "active" : "" }} {{ request()->is("admin/trasportos*") ? "active" : "" }} {{ request()->is("admin/servizio-extras*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-edit">

                            </i>
                            <p>
                                {{ trans('cruds.serviziGeneral.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('alloggio_hotel_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.alloggio-hotels.index") }}" class="nav-link {{ request()->is("admin/alloggio-hotels") || request()->is("admin/alloggio-hotels/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-home">

                                        </i>
                                        <p>
                                            {{ trans('cruds.alloggioHotel.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('aziende_trasporti_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.aziende-trasportis.index") }}" class="nav-link {{ request()->is("admin/aziende-trasportis") || request()->is("admin/aziende-trasportis/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-truck-moving">

                                        </i>
                                        <p>
                                            {{ trans('cruds.aziendeTrasporti.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('trasporto_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.trasportos.index") }}" class="nav-link {{ request()->is("admin/trasportos") || request()->is("admin/trasportos/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-car">

                                        </i>
                                        <p>
                                            {{ trans('cruds.trasporto.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('servizio_extra_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.servizio-extras.index") }}" class="nav-link {{ request()->is("admin/servizio-extras") || request()->is("admin/servizio-extras/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-concierge-bell">

                                        </i>
                                        <p>
                                            {{ trans('cruds.servizioExtra.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('anagrafica_parent_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/clientis*") ? "menu-open" : "" }} {{ request()->is("admin/fornitores*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/clientis*") ? "active" : "" }} {{ request()->is("admin/fornitores*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon far fa-address-book">

                            </i>
                            <p>
                                {{ trans('cruds.anagraficaParent.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('clienti_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.clientis.index") }}" class="nav-link {{ request()->is("admin/clientis") || request()->is("admin/clientis/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-address-card">

                                        </i>
                                        <p>
                                            {{ trans('cruds.clienti.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('fornitore_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.fornitores.index") }}" class="nav-link {{ request()->is("admin/fornitores") || request()->is("admin/fornitores/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon far fa-address-card">

                                        </i>
                                        <p>
                                            {{ trans('cruds.fornitore.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('user_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/permissions*") ? "menu-open" : "" }} {{ request()->is("admin/roles*") ? "menu-open" : "" }} {{ request()->is("admin/users*") ? "menu-open" : "" }} {{ request()->is("admin/audit-logs*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/permissions*") ? "active" : "" }} {{ request()->is("admin/roles*") ? "active" : "" }} {{ request()->is("admin/users*") ? "active" : "" }} {{ request()->is("admin/audit-logs*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-users">

                            </i>
                            <p>
                                {{ trans('cruds.userManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('permission_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-unlock-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.permission.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-briefcase">

                                        </i>
                                        <p>
                                            {{ trans('cruds.role.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user">

                                        </i>
                                        <p>
                                            {{ trans('cruds.user.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('audit_log_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.audit-logs.index") }}" class="nav-link {{ request()->is("admin/audit-logs") || request()->is("admin/audit-logs/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-file-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.auditLog.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('settings_dinamici_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.settings-dinamicis.index") }}" class="nav-link {{ request()->is("admin/settings-dinamicis") || request()->is("admin/settings-dinamicis/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-cogs">

                            </i>
                            <p>
                                {{ trans('cruds.settingsDinamici.title') }}
                            </p>
                        </a>
                    </li>
                @endcan

                <li class="nav-item">
                    <a href="{{ route("admin.systemCalendar") }}" class="nav-link {{ request()->is("admin/system-calendar") || request()->is("admin/system-calendar/*") ? "active" : "" }}">
                        <i class="fas fa-fw fa-calendar nav-icon">

                        </i>
                        <p>
                            {{ trans('global.systemCalendar') }}
                        </p>
                    </a>
                </li>
                @can('report_preventivi_per_data')
                    <li class="nav-item has-treeview {{ request()->is("admin/clientis*") ? "menu-open" : "" }} {{ request()->is("admin/report/*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/report*") ? "active" : "" }}" href="#">
                            <i class="fas fa-fw fa-poll nav-icon">
                            </i>
                            <p>
                                Report
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route("admin.report.preventivo.dataCreazione") }}" class="nav-link {{ request()->is("admin/report/preventivo/data_creazione") ? "active" : "" }}">
                                    <i class="fas fa-fw fa-calendar-week nav-icon">
                                    </i>
                                    <p>
                                        Preventivi per data
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                    @can('profile_password_edit')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}" href="{{ route('profile.password.edit') }}">
                                <i class="fa-fw fas fa-key nav-icon">
                                </i>
                                <p>
                                    {{ trans('global.change_password') }}
                                </p>
                            </a>
                        </li>
                    @endcan
                @endif
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                        <p>
                            <i class="fas fa-fw fa-sign-out-alt nav-icon">

                            </i>
                            <p>{{ trans('global.logout') }}</p>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
