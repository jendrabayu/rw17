@extends('layouts.skeleton')

@section('title')
  Welcome
@endsection

@section('app')

  <div class="section">
    <div class="container">
      <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-12 col-md-6">
          <div class="card">
            <div class="card-body py-5">
              <div class="logo">
                <img class="img-fluid"
                  src="https://upload.wikimedia.org/wikipedia/commons/a/a3/Lambang-kabupaten-jember.png" alt="" srcset="">
              </div>
              <h1 class="text-center">RW 017</h1>
              <p style="font-size: 1.1rem" class="text-center">Kelurahan Sumbersari, Kecamatan Sumbersari, Kabupaten
                Jember</p>
              @if (!auth()->check())
                <a class="btn btn-outline-primary btn-block" href="{{ route('login') }}">Masuk</a>
              @else
                @php
                  $dashboardRoute = auth()
                      ->user()
                      ->hasRole('rw')
                      ? 'rw.dashboard'
                      : 'rt.dashboard';
                @endphp
                <a class="btn btn-primary btn-block btn-icon icon-left mb-2" href="{{ route($dashboardRoute) }}"><i
                    class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a class="btn btn-danger btn-block btn-icon icon-left" href="javascript;" id="btn-logout"><i
                    class="fas fa-sign-out-alt"></i>
                  Logout</a>
              @endif
              <footer class="mt-4 text-center">
                &copy; {{ date('Y') }} <div class="bullet"></div> By <a target="_blank"
                  href="https://github.com/jendrabayu" rel="noreferrer">Jendra
                  Bayu Nugraha</a>
              </footer>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <form action="{{ route('logout') }}" method="POST" id="form-logout">@csrf</form>
@endsection

@push('styles')
  <style>
    .logo {
      text-align: center;
      margin-bottom: 25px;
    }

    .logo img {
      max-width: 150px;
    }

  </style>
@endpush
