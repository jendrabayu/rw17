@extends('layouts.auth')

@section('title')
  Login
@endsection

@section('content')
  <div class="card card-primary">
    <div class="card-header">
      <h4>Login</h4>
    </div>

    <div class="card-body">
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
          <label for="username">Username atau Email</label>
          <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username"
            tabindex="1" required autofocus>
          @error('username')
            <div class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>

        <div class="form-group">
          <div class="d-block">
            <label for="password" class="control-label">Password</label>
            <div class="float-right">
              @if (Route::has('password.request'))
                <a class="text-small" href="{{ route('password.request') }}">
                  Forgot Password?
                </a>
              @endif
            </div>
          </div>
          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
            name="password" tabindex="2" required>
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
            <label class="custom-control-label" for="remember-me">Remember Me</label>
          </div>
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
            Login
          </button>
        </div>
      </form>
    </div>
  </div>

  @if (Route::has('register'))
    <div class="mt-5 text-muted text-center">
      Don't have an account? <a href="{{ route('register') }}">Create One</a>
    </div>
  @endif

@endsection
