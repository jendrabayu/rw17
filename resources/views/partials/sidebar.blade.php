<div class="sidebar-brand">
  <a href="{{ route('home') }}">RW 17</a>
</div>
<div class="sidebar-brand sidebar-brand-sm">
  <a href="{{ route('home') }}">17</a>
</div>
<ul class="sidebar-menu">
  <li class="menu-header">Dashboard</li>
  <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('home') }}" data-toggle="tooltip" data-placement="right"
      title="Dashboard"><i class="fas fa-fire"></i>
      <span>Dashboard</span>
    </a>
  </li>
  <li class="menu-header">Menu Utama</li>
  <li class="{{ request()->routeIs('user_logs') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('user_logs') }}" data-toggle="tooltip" data-placement="right"
      title="Log Aktivitas Pengguna">
      <i class="fas fa-history"></i>
      <span>Activity Log</span>
    </a>
  </li>
  @role('admin')
  <li class="{{ request()->routeIs('users.index') || request()->is('users/*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('users.index') }}" data-toggle="tooltip" data-placement="right"
      title="Kelola Pengguna"><i class="fas fa-tasks"></i>
      <span>Kelola Pengguna</span></a>
  </li>
  @endrole
  <li class="{{ request()->routeIs('rumah.index') || request()->is('rumah/*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('rumah.index') }}" data-toggle="tooltip" data-placement="right"
    title="@role('rt') Kelola Rumah @else Rumah @endrole">
      <i class="fas fa-tasks"></i>
    <span>@role('rt') Kelola Rumah @else Rumah @endrole</span>
    </a>
  </li>
  <li class="{{ request()->routeIs('keluarga.index') || request()->is('keluarga/*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('keluarga.index') }}" data-toggle="tooltip" data-placement="right"
    title="@role('rt') Kelola Keluarga @else Keluarga @endrole">
      <i class="fas fa-tasks"></i></i>
    <span>@role('rt') Kelola Keluarga @else Keluarga @endrole </span>
    </a>
  </li>
  <li class="{{ request()->routeIs('penduduk.index') || request()->is('penduduk/*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('penduduk.index') }}" data-toggle="tooltip" data-placement="right"
    title="@role('rt') Kelola Penduduk @else Penduduk @endrole">
      <i class="fas fa-tasks"></i>
    <span>@role('rt') Kelola Penduduk @else Penduduk @endrole </span>
    </a>
  </li>
  <li
    class="{{ request()->routeIs('penduduk-domisili.index') || request()->is('penduduk-domisili/*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('penduduk-domisili.index') }}" data-toggle="tooltip"
    data-placement="right" title="@role('rt') Kelola Penduduk Domisili @else Penduduk Domisili @endrole">
      <i class="fas fa-tasks"></i>
    <span>@role('rt') Kelola Pend. Domisili @else Penduduk Domisili @endrole</span>
    </a>
  </li>
  <li
    class="{{ request()->routeIs('penduduk-meninggal.index') || request()->is('penduduk-meninggal/*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('penduduk-meninggal.index') }}" data-toggle="tooltip"
    data-placement="right" title="@role('rt') Kelola Penduduk Meninggal @else Penduduk Meninggal @endrole">
      <i class="fas fa-tasks"></i>
    <span>@role('rt') Kelola Pend. Meninggal @else Penduduk Meninggal @endrole</span>
    </a>
  </li>
  <div class="mt-3 mb-3 p-3 hide-sidebar-mini">
    <a href="javascript:;" class="btn btn-outline-danger btn-lg btn-block btn-icon-split btn-logout"
      data-toggle="tooltip" data-placement="right" title="Logout Akun">
      <i class="fas fa-sign-out-alt"></i> Logout
    </a>
  </div>
</ul>
