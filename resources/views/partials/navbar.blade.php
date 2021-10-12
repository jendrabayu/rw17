@php
$user = auth()->user();
@endphp

<form class="form-inline mr-auto">
  <ul class="navbar-nav mr-3">
    <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
  </ul>
</form>

<ul class="navbar-nav navbar-right">
  <li class="dropdown"><a href="#" data-toggle="dropdown"
      class="nav-link dropdown-toggle nav-link-lg nav-link-user">
      <img alt="image" src="{{ $user->avatar_url }}" class="rounded-circle mr-1 user__avatar">
      <div class="d-sm-none d-lg-inline-block"> {{ greeting(Str::words($user->name, 2, '')) }}
      </div>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
      <a href="{{ route('profile') }}" class="dropdown-item has-icon">
        <i class="far fa-user"></i> Profil
      </a>
      <a href="{{ route('password') }}" class="dropdown-item has-icon">
        <i class="fas fa-key"></i> Ubah Password
      </a>
      <a href="javascript:;" class="dropdown-item has-icon text-danger btn-logout">
        <i class="fas fa-sign-out-alt"></i> Logout
      </a>
    </div>
  </li>
</ul>
