<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand px-5 mb-4">
            <a href="{{ url('/admin/dashboard') }}">
                <img class="w-auto mt-2 center" src="{{ url(GetSetting('site_logo')) }}" style="height: 80px;">
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('/admin/dashboard') }}">
                <img src="{{ url(GetSetting('site_favicon')) }}">
            </a>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-header">{{ trans('admin.Basics') }}</li>
            <li class="{{ ActiveMenu('dashboard', 2) }}">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fire"></i>
                    <span>{{ trans('admin.Dashboard') }} </span>
                </a>
            </li>

            @canany(['status-korban-index', 'kategori-korban-index', 'jenis-hunian-index', 'jenis-bencana-index','jalur-komunikasi-index'])
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-database"></i><span>Master</span></a>
                <ul class="dropdown-menu">

                    @can('status-korban-index')
                    <li class="{{ ActiveSidebar('admin.master.status-korban.index') }}">
                        <a class="nav-link" href="{{ route('admin.master.status-korban.index') }}">Status Korban</a>
                    </li>
                    @endcan

                    @can('kategori-korban-index')
                    <li class="{{ ActiveSidebar('admin.master.kategori-korban.index') }}">
                        <a class="nav-link" href="{{ route('admin.master.kategori-korban.index') }}">Kategori
                            Korban</a>
                    </li>
                    @endcan

                    @can('jenis-hunian-index')
                    <li class="{{ ActiveSidebar('admin.master.jenis-hunian.index') }}">
                        <a class="nav-link" href="{{ route('admin.master.jenis-hunian.index') }}">Jenis Hunian</a>
                    </li>
                    @endcan

                    @can('jenis-bencana-index')
                    <li class="{{ ActiveSidebar('admin.master.jenis-bencana.index') }}">
                        <a class="nav-link" href="{{ route('admin.master.jenis-bencana.index') }}">Jenis Bencana</a>
                    </li>
                    @endcan

                    @can('jalur-komunikasi-index')
                    <li class="{{ ActiveSidebar('admin.master.jalur-komunikasi.index') }}">
                        <a class="nav-link" href="{{ route('admin.master.jalur-komunikasi.index') }}">Jalur
                            Komunikasi</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany

            @canany(['data-bencana-index', 'lokasi-pengungsian-index', 'data-korban-index'])
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-list-ul"></i><span>Data Tanggap Darurat</span></a>
                <ul class="dropdown-menu">

                    @can('data-bencana-index')
                    <li class="{{ ActiveSidebar('admin.data.data-bencana.index') }}">
                        <a class="nav-link" href="{{ route('admin.data.data-bencana.index') }}">
                            Data Bencana
                        </a>
                    </li>
                    @endcan

                    @can('lokasi-pengungsian-index')
                    <li class="{{ ActiveSidebar('admin.data.lokasi-pengungsian.index') }}">
                        <a class="nav-link" href="{{ route('admin.data.lokasi-pengungsian.index') }}">
                            Lokasi Pengungsian
                        </a>
                    </li>
                    @endcan

                    @can('data-korban-index')
                    <li class="{{ ActiveSidebar('admin.data.data-korban.index') }}">
                        <a class="nav-link" href="{{ route('admin.data.data-korban.index') }}">
                            Data Korban
                        </a>
                    </li>
                    @endcan

                </ul>
            </li>
            @endcanany
            @can('pesan-index')
            <li class="{{ ActiveSidebar('admin.data.pesan.index') }}">
                <a class="nav-link" href="{{ route('admin.data.pesan.index') }}">
                    <i class="fas fa-message"></i>
                    Pesan
                </a>
            </li>
            @endcan
            @can('gallery')
            <li class="{{ ActiveSidebar('admin.gallery') }}">
                <a class="nav-link" href="{{ route('admin.gallery') }}">
                    <i class="fas fa-image"></i>
                    <span>Gallery Foto</span>
                </a>
            </li>
            @endcan
            @can('documentation')
            <li class="{{ ActiveSidebar('admin.documentation') }}">
                <a class="nav-link" href="{{ route('admin.documentation') }}">
                    <i class="fas fa-book"></i>
                    <span>Dokumentasi</span>
                </a>
            </li>
            @endcan
            @can('message')
            <li class="{{ ActiveSidebar('admin.message') }}">
                <a class="nav-link" href="{{ route('admin.message') }}">
                    <i class="fas fa-inbox"></i>
                    <span>Kotak Masuk</span>
                </a>
            </li>
            @endcan
            @can('laporan-kejadian-index')
            <li class="{{ ActiveSidebar('admin.laporan-kejadian.index') }}">
                <a class="nav-link" href="{{ route('admin.laporan-kejadian.index') }}">
                    <i class="fas fa-book"></i>
                    <span>Laporan Kejadian</span>
                </a>
            </li>
            @endcan
            @can('user-index')
            <li class="{{ ActiveSidebar('admin.users.index') }}">
                <a class="nav-link" href="{{ route('admin.users.index') }}">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
            </li>
            @endcan
            @can('role-index')
            <li class="{{ ActiveSidebar('admin.roles.index') }}">
                <a class="nav-link" href="{{ route('admin.roles.index') }}">
                    <i class="fas fa-cogs"></i>
                    <span>Roles</span>
                </a>
            </li>
            @endcan
        </ul>
    </aside>
</div>
