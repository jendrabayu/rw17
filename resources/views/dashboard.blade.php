@extends('layouts.app')

@section('title')
  Dashboard
@endsection

@section('content')
  <div class="section-header">
    <h1>Dashboard</h1>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-primary">
            <i class="fas fa-user-shield"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Pengguna</h4>
            </div>
            <div class="card-body">
              {{ $total_pengguna }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-danger">
            <i class="fas fa-users"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Penduduk</h4>
            </div>
            <div class="card-body">
              {{ $total_penduduk }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-warning">
            <i class="fas fa-person-booth"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Keluarga</h4>
            </div>
            <div class="card-body">
              {{ $total_keluarga }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-success">
            <i class="fas fa-home"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Rumah</h4>
            </div>
            <div class="card-body">
              {{ $total_rumah }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-info">
            <i class="fas fa-users"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Penduduk Domisili</h4>
            </div>
            <div class="card-body">
              {{ $total_penduduk_domisili }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-dark">
            <i class="fas fa-users"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Penduduk Meninggal</h4>
            </div>
            <div class="card-body">
              {{ $total_penduduk_meninggal }}
            </div>
          </div>
        </div>
      </div>
    </div>

    @role('rw')
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <ul class="nav nav-pills">
              <li class="nav-item">
                <a class="nav-link {{ !request()->has('rt') ? 'active' : '' }}" href="{{ route('home') }}">Semua
                  RT</a>
              </li>
              @foreach ($rt as $id => $nomor)
                <li class="nav-item">
                  <a class="nav-link {{ request()->get('rt') == $id ? 'active' : '' }}"
                    href="{{ route('home', ['rt' => $id]) }}">RT {{ ltrim($nomor, '0') }}</a>
                </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
    @endrole

    <div class="row">
      @include('statistik-penduduk.card')
    </div>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('js/statistik-penduduk.js') }}"></script>
@endpush
