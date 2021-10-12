@extends('layouts.skeleton')

@section('app')
  <div class="main-wrapper">
    <div class="navbar-bg"></div>
    <nav class="navbar navbar-expand-lg main-navbar">
      @include('partials.navbar')
    </nav>
    <div class="main-sidebar">
      <aside id="sidebar-wrapper">
        @include('partials.sidebar')
      </aside>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      <section class="section">
        @yield('content')
      </section>
    </div>
    <footer class="main-footer">
      @include('partials.footer')
    </footer>
  </div>
  <form hidden action="{{ route('logout') }}" method="POST" id="form-logout">@csrf</form>
@endsection
