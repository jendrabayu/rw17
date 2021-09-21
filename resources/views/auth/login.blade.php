@extends('layouts.auth')

@section('title')
  Login
@endsection

@section('content')
  <img src="{{ asset('assets/img/lambang_kab_jember.png') }}" alt="Logo Kabupaten Jember" width="80"
    class="mb-5 mt-2">
  <h4 class="text-dark font-weight-normal">Selamat datang di <span class="font-weight-bold">RW 17</span></h4>
  <p class="text-muted">Sebelum memulai, Anda harus login atau mendaftar ke RW jika Anda belum memiliki akun.</p>
  <form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="form-group">
      <label for="username">Username atau alamat email</label>
      <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username"
        tabindex="1" required autofocus>
      @error('username')
        <div class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </div>
      @enderror
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"
        tabindex="2" required>
      @error('password')
        <div class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </div>
      @enderror
    </div>

    <div class="form-group">
      <div class="custom-control custom-checkbox">
        <input type="checkbox" {{ old('remember') ? 'checked' : '' }} name="remember" class="custom-control-input"
          tabindex="3" id="remember-me">
        <label class="custom-control-label" for="remember-me">Ingat Saya</label>
      </div>
    </div>

    <div class="form-group text-right">
      @if (Route::has('password.request'))
        <a class="float-left mt-3" href="{{ route('password.request') }}">
          Forgot Password?
        </a>
      @endif
      <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right btn-block" tabindex="4">
        Login <i class="fas fa-sign-in-alt"></i>
      </button>
    </div>

    @if (Route::has('register'))
      <div class="mt-5 text-center">
        Don't have an account? <a href="{{ route('register') }}">Create One</a>
      </div>
    @endif
  </form>

  <div class="text-center mt-5 text-small">
    Copyright &copy; RW 17. Dibuat dengan 💙 by Jendra
  </div>
@endsection
