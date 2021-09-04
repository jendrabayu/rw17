@extends('layouts.app')

@section('title')
  Edit Pengguna
@endsection

@section('content')
  <div class="section-header">
    <div class="section-header-back">
      <a href="{{ route('rw.users.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Edit Pengguna</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item"><a href="{{ route('rw.users.index') }}">Pengguna</a></div>
      <div class="breadcrumb-item">Edit Pengguna</div>
    </div>
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
            <h4>Edit Pengguna</h4>
          </div>
          <div class="card-body">
            <form action="{{ route('rw.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="name">Nama Lengkap <code>(*)</code></label>
                  <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="username">Username <code>(*)</code></label>
                  <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="email">Email <code>(*)</code></label>
                  <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="role">Role <code>(*)</code></label>
                  <select class="form-control" name="role" id="role">
                    <option selected disabled hidden>--Pilih Role--</option>
                    @foreach ($roles as $id => $role)
                      <option {{ $user->role === $role ? 'selected' : '' }} value="{{ $id }}">
                        {{ $role }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="rt">RT <code>(*)</code></label>
                  <select class="form-control" name="rt_id" id="rt">
                    <option selected disabled hidden>--Pilih RT--</option>
                    @foreach ($rt as $id => $rt)
                      <option {{ $user->rt->id === $id ? 'selected' : '' }} value="{{ $id }}">
                        RT {{ $rt }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="password">Password</label>
                  <input type="text" class="form-control" id="password" name="password">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="no_hp">No. Hp/Whatsapp</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">+62</div>
                    </div>
                    <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ $user->no_hp }}">
                  </div>
                </div>

                <div class="form-group col-md-6">
                  <label for="alamat">Alamat</label>
                  <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $user->alamat }}">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="avatar">Avatar</label>
                  <div class="img-preview p-1 border">
                    <button type="button" class="btn btn-icon btn-dark btn-upload-avatar"><i
                        class="fas fa-camera"></i></button>
                    <img class="img-fluid" src="{{ $user->avatar_url }}">
                    <input type="file" name="avatar" id="avatar" accept=".jpg, .jpeg, .png" hidden>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <button class="btn btn-primary btn-block" type="submit">Simpan Perubahan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('styles')
  <style>
    .img-preview {
      max-width: 250px;
      min-width: 100px;
      height: auto;
      position: relative
    }

    .img-preview .btn-upload-avatar {
      position: absolute;
      top: 0.25rem;
      right: 0.25rem;
      border-radius: 0;
    }

  </style>
@endpush

@push('scripts')
  <script>
    $('#avatar').on('change', function() {
      const file = $(this).get(0).files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function() {
          $('.img-preview img').attr('src', reader.result);
        }

        reader.readAsDataURL(file);
      }
    });

    $('.btn-upload-avatar').on('click', function() {
      $('#avatar').trigger('click');
    });
  </script>
@endpush