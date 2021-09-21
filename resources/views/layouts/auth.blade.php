@extends('layouts.skeleton')

@section('app')

  <section class="section">
    <div class="d-flex flex-wrap align-items-stretch">
      <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
        <div class="p-4 m-3">
          @yield('content')
        </div>
      </div>
      <div
        class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom"
        data-background="{{ asset('assets/img/gapura_rw17.jpg') }}">
        <div class="absolute-bottom-left index-2">
          <div class="text-light p-5 pb-2">
            <div class="mb-5 pb-3">
              <h1 class="mb-2 display-4 font-weight-bold">
                @php
                  $time = date('H');
                  $timezone = date('e');
                  if ($time < '12') {
                      echo 'Selamat Pagi';
                  } elseif ($time >= '12' && $time < '17') {
                      echo 'Selamat Siang';
                  } elseif ($time >= '17' && $time < '19') {
                      echo 'Selamat Sore';
                  } elseif ($time >= '19') {
                      echo 'Selamat Malam';
                  }
                @endphp
              </h1>
              <h5 class="font-weight-normal text-muted-transparent">Jember, Indonesia</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
