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
        <div class="card card-primary">
          <div class="card-header">
            <h4>Profil</h4>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-3">
                <div class="img-thumbnail img__profile">
                  <button type="button" id="btnUploadAvatar" class="btn btn-dark"><i
                      class="fas fa-camera"></i></button>
                  <img src="{{ $user->avatar_url }}" class="user__avatar">
                  <input type="file" name="avatar" id="avatar" accept=".jpg, .jpeg, .png" hidden>
                </div>
              </div>
              <div class="col-lg-9">
                <form action="{{ route('update_profile') }}" method="POST">
                  @csrf
                  @method('PUT')
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
                      <input type="text" class="form-control" id="role" value="{{ strtoupper($user->role) }}"
                        disabled>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="name">Nama <code>*</code></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="username">Username <code>*</code></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="username" name="username"
                        value="{{ $user->username }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="email">Email <code>*</code></label>
                    <div class="col-sm-9">
                      <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="no_hp">No. Hp/WhatsApp</label>
                    <div class="col-sm-9">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">+62</div>
                        </div>
                        <input type="tel" class="form-control" id="no_hp" name="no_hp" value="{{ $user->no_hp }}"
                          maxlength="13">
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="alamat">Alamat</label>
                    <div class="col-sm-9">
                      <textarea class="form-control" id="alamat" name="alamat">{{ $user->alamat }}</textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Simpan Perubahan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection


@push('scripts')
  <script>
    $(function() {

      $('#avatar').on('change', function() {
        const file = $(this).get(0).files[0];
        if (file) {
          const formData = new FormData();
          formData.append('_token', '{{ csrf_token() }}');
          formData.append('_method', 'PUT');
          formData.append('avatar', file);
          $.ajax({
            url: '{{ route('update_avatar') }}',
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
              if (data.success) {
                $('.user__avatar').each(function() {
                  $(this).attr('src', data.data.img_url);
                });
                Toast.fire({
                  icon: 'success',
                  title: '<b class="text-success">Success!</b>',
                  text: 'Avatar berhasil diupdate'
                });
              }
            },
            error: function(error) {
              if (error.responseJSON) {
                const keys = Object.keys(error.responseJSON.errors);
                const errors = keys.map((key) => {
                  return error.responseJSON.errors[key].map(error =>
                    `<li>${error.charAt(0).toUpperCase() + error.slice(1)}</li>`).join('');
                }).join('');

                Toast.fire({
                  icon: 'error',
                  title: `<b class="text-danger">Gagal! [${error.status}] ${error.statusText}</b>`,
                  html: `<ul class="list-unstyled">${errors}</ul>`,
                  timer: 5000
                })
              } else {
                Toast.fire({
                  icon: 'error',
                  title: `<b class="text-danger">Gagal!</b> [${error.status}] ${error.statusText}`
                });
              }
            }
          });
        }
      });

      $('#btnUploadAvatar').on('click', function() {
        $('#avatar').click();
      });

    });
  </script>
@endpush
