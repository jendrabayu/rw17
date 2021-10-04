@extends('layouts.app')

@section('title')
  Edit Pengguna
@endsection

@section('content')
  <div class="section-header">
    <div class="section-header-back">
      <a href="{{ route('users.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Edit Pengguna</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item"><a href="{{ route('users.index') }}">Pengguna</a></div>
      <div class="breadcrumb-item">Edit Pengguna</div>
    </div>
  </div>
  <div class="section-body">
    @include('partials.alerts')

    <div class="row">
      <div class="col-12">
        <div class="card card-primary">
          <div class="card-header">
            <h4>Edit Pengguna</h4>
          </div>
          <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="name"><code>*</code> Nama Lengkap</label>
                  <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="username"><code>*</code> Username</label>
                  <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="email"><code>*</code> Email</label>
                  <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="role"><code>*</code> Role</label>
                  <select class="custom-select" name="role" id="role">
                    <option selected disabled hidden>--Pilih Role--</option>
                    @foreach ($roles as $id => $role)
                      <option {{ $user->role === $role ? 'selected' : '' }} value="{{ $id }}">
                        {{ Str::upper($role) }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="rt"><code>*</code> RT</label>
                  <select class="form-control select2" name="rt_id" id="rt">
                    <option selected disabled hidden>--Pilih RT--</option>
                    @foreach ($rt as $id => $rt)
                      <option {{ $user->rt->id === $id ? 'selected' : '' }} value="{{ $id }}">
                        RT {{ ltrim($rt, '0') }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" id="password" name="password">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="no_hp">No. Hp/WhatsApp</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">+62</div>
                    </div>
                    <input type="tel" class="form-control" id="no_hp" name="no_hp" value="{{ $user->no_hp }}"
                      maxlength="13">
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="alamat">Alamat</label>
                  <textarea name="alamat" id="alamat" class="form-control">{{ $user->alamat }}</textarea>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="avatar">Avatar</label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="avatar" name="avatar" accept=".jpg, .jpeg, .png">
                    <label class="custom-file-label" for="avatar">Choose file</label>
                  </div>
                  <small class="form-text text-muted">Ukuran maksimal 1MB, format: JPG,JPEG atau PNG</small>

                  <div class="img__preview mt-3">
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="img-thumbnail">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <button class="btn btn-primary btn-block btn-lg" type="submit">Simpan Perubahan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection


@push('scripts')
  <script>
    $('#avatar').on('change', function() {
      const file = $(this).get(0).files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function() {
          $('.img__preview img').attr('src', reader.result);
        }

        reader.readAsDataURL(file);
      }
    });
  </script>
@endpush
