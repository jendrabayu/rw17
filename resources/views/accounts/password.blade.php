@extends('layouts.app')

@section('title')
  Ubah Password
@endsection

@section('content')
  <div class="section-header">
    <h1>Ubah Password</h1>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-12">
        @include('partials.alerts')
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Ubah Password</h4>
          </div>
          <div class="card-body">
            <form action="{{ route('update_password') }}" method="POST">
              @csrf
              @method('PUT')
              <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="current_password">Password Sekarang <code>(*)</code></label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" id="current_password" name="current_password">
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="password">Password <code>(*)</code></label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" id="password" name="password">
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="password_confirmation">Kondirmasi Password
                  <code>(*)</code></label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div>
              </div>

              <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Ubah Password</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
