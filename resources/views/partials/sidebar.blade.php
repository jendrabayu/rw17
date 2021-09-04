@php
$dashboardRoute = auth()
    ->user()
    ->hasRole('rw')
    ? 'rw.dashboard'
    : 'rt.dashboard';
@endphp

<div class="sidebar-brand">
  <a href="{{ route($dashboardRoute) }}">RW 17</a>
</div>
<div class="sidebar-brand sidebar-brand-sm">
  <a href="{{ route($dashboardRoute) }}">17</a>
</div>
<ul class="sidebar-menu">
  <li class="menu-header">Dashboard</li>
  <li class="{{ request()->routeIs($dashboardRoute) ? 'active' : '' }}">
    <a class="nav-link" href="{{ route($dashboardRoute) }}"><i class="fas fa-fire"></i> <span>Dashboard</span></a>
  </li>
  <li class="menu-header">Menu Utama</li>
  @role('rw')
  <li class="{{ request()->routeIs('rw.users.index') || request()->is('rw/users/*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('rw.users.index') }}"><i class="fas fa-user-shield"></i>
      <span>Pengguna</span></a>
  </li>
  @endrole

  <li class="{{ request()->routeIs('keluarga.index') || request()->is('keluarga/*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('keluarga.index') }}"><i class="fas fa-person-booth"></i>
      <span>Keluarga</span></a>
  </li>
  <li class="{{ request()->routeIs('penduduk.index') || request()->is('penduduk/*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('penduduk.index') }}"><i class="fas fa-users"></i> <span>Penduduk</span></a>
  </li>
  <li class="{{ request()->routeIs('rumah.index') || request()->is('rumah/*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('rumah.index') }}"><i class="fas fa-home"></i> <span>Rumah</span></a>
  </li>
  <li
    class="{{ request()->routeIs('penduduk-meninggal.index') || request()->is('penduduk-meninggal/*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('penduduk-meninggal.index') }}"><i class="fas fa-book-dead"></i>
      <span>Penduduk
        Meninggal</span></a>
  </li>
  <li
    class="{{ request()->routeIs('penduduk-domisili.index') || request()->is('penduduk-domisili/*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('penduduk-domisili.index') }}"><i class="fas fa-users"></i> <span>Penduduk
        Domisili</span></a>
  </li>
</ul>

<div class="mt-4 mb-4 p-3 hide-sidebar-mini">
  <a href="/" class="btn btn-primary btn-lg btn-block btn-icon-split">
    <i class="fas fa-rocket"></i> Home Page
  </a>
</div>
