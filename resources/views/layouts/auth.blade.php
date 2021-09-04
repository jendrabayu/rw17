@extends('layouts.skeleton')

@section('app')
  <section class="section">
    <div class="container mt-5">
      <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
          <div class="login-brand">
            <img src="https://upload.wikimedia.org/wikipedia/commons/a/a3/Lambang-kabupaten-jember.png" alt="logo"
              width="100">
          </div>
          @yield('content')
          <div class="simple-footer">
            Copyright &copy; Jendra Bayu Nugraha {{ date('Y') }}
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
