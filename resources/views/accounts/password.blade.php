@extends('layouts.app')

@section('title')
  Ubah Password
@endsection

@section('content')
  <div class="section-header">
    <h1>Ubah Password</h1>
  </div>

  <div class="section-body">
    @include('partials.alerts')

    <div class="row">
      <div class="col-12">
        <div class="card card-primary">
          <div class="card-header">
            <h4>Ubah Password</h4>
          </div>
          <div class="card-body">
            <form action="{{ route('update_password') }}" method="POST">
              @csrf
              @method('PUT')
              <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="current_password"><code>*</code> Password Sekarang</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" id="current_password" name="current_password">
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="password"><code>*</code> Password Baru</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" id="password" name="password">
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="password_confirmation"><code>*</code> Konfirmasi Password Baru
                </label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div>
              </div>

              <div class="form-group mb-0">
                <button type="submit" class="btn btn-primary btn-block btn-lg">Ubah Password</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
