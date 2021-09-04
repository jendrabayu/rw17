@extends('layouts.app')

@section('title')
  Profil
@endsection

@section('content')
  <div class="section-header">
    <h1>Profil</h1>
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
            <h4>Profil</h4>
          </div>
          <div class="card-body">
            <form action="{{ route('update_profile') }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="row">
                <div class="col-lg-3">
                  <div class="img-preview p-1 border mb-4 mb-lg-0">
                    <button type="button" class="btn btn-icon btn-dark btn-upload-avatar"><i
                        class="fas fa-camera"></i></button>
                    <img class="img-fluid" src="{{ $user->avatar_url }}">
                    <input type="file" name="avatar" id="avatar" accept=".jpg, .jpeg, .png" hidden>
                  </div>
                </div>
                <div class="col-lg-9">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="rt_rw">RT/RW</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="rt_rw"
                        value="{{ $user->rt->nomor . '/' . $user->rt->rw->nomor }}" disabled>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="role">Role</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="role" value="{{ strtoupper($user->role) }}" disabled>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="name">Nama Lengkap <code>(*)</code></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="username">Username <code>(*)</code></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="username" name="username"
                        value="{{ $user->username }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="email">Email <code>(*)</code></label>
                    <div class="col-sm-9">
                      <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="no_hp">No. Hp/Whatsapp</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ $user->no_hp }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="alamat">Alamat</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $user->alamat }}">
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan</button>
                  </div>
                </div>
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
      width: 100%;
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
