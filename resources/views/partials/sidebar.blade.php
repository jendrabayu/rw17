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
  @role('admin')
  <li class="{{ request()->routeIs('users.index') || request()->is('users/*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('users.index') }}" data-toggle="tooltip" data-placement="right"
      title="Kelola Pengguna"><i class="fas fa-tasks"></i>
      <span>Kelola Pengguna</span></a>
  </li>
  @endrole
  <li class="{{ request()->routeIs('rumah.index') || request()->is('rumah/*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('rumah.index') }}" data-toggle="tooltip" data-placement="right"
      title="Kelola Rumah"><i class="fas fa-tasks"></i>
      <span>Kelola Rumah</span>
    </a>
  </li>
  <li class="{{ request()->routeIs('keluarga.index') || request()->is('keluarga/*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('keluarga.index') }}" data-toggle="tooltip" data-placement="right"
      title="Kelola Keluarga"><i class="fas fa-tasks"></i></i>
      <span>Kelola Keluarga</span>
    </a>
  </li>
  <li class="{{ request()->routeIs('penduduk.index') || request()->is('penduduk/*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('penduduk.index') }}" data-toggle="tooltip" data-placement="right"
      title="Kelola Penduduk"><i class="fas fa-tasks"></i>
      <span>Kelola Penduduk</span>
    </a>
  </li>
  <li
    class="{{ request()->routeIs('penduduk-domisili.index') || request()->is('penduduk-domisili/*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('penduduk-domisili.index') }}" data-toggle="tooltip"
      data-placement="right" title="Kelola Penduduk Domisili"><i class="fas fa-tasks"></i>
      <span>Kelola Pend. Domisili</span>
    </a>
  </li>
  <li
    class="{{ request()->routeIs('penduduk-meninggal.index') || request()->is('penduduk-meninggal/*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('penduduk-meninggal.index') }}" data-toggle="tooltip"
      data-placement="right" title="Kelola Penduduk Meninggal"><i class="fas fa-tasks"></i>
      <span>Kelola Pend. Meninggal</span>
    </a>
  </li>
</ul>
