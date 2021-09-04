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
              <h4>Total Pengguna</h4>
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
              <h4>Total Penduduk</h4>
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
              <h4>Total Keluarga</h4>
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
              <h4>Total Rumah</h4>
            </div>
            <div class="card-body">
              {{ $total_rumah }}
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      @include('statistik-penduduk.card')
    </div>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('js/statistik-penduduk.js') }}"></script>
@endpush
