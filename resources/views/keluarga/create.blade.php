@extends('layouts.app')

@section('title')
  Tambah Keluarga
@endsection

@section('content')
  <div class="section-header">
    <div class="section-header-back">
      <a href="{{ route('keluarga.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Tambah Keluarga</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item"><a href="{{ route('keluarga.index') }}">Keluarga</a></div>
      <div class="breadcrumb-item">Tambah Keluarga</div>
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
            <h4>Tambah Keluarga</h4>
          </div>
          <div class="card-body">
            <form action="{{ route('keluarga.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="rt">RT <code>(*)</code></label>
                  @role('rt')
                  <input type="text" readonly value="RT {{ $rt->nomor }}" class="form-control">
                  <input type="text" hidden value="{{ $rt->id }}" name="rt_id">
                  @endrole
                  @role('rw')
                  <select name="rt_id" id="rt" class="form-control select2">
                    <option selected hidden value="" disabled>--Pilih RT--</option>
                    @foreach ($rt as $id => $rt)
                      <option {{ old('rt_id') == $id ? 'selected' : '' }} value="{{ $id }}"
                        class="form-control">RT {{ $rt }}
                      </option>
                    @endforeach
                  </select>
                  @endrole
                </div>
                <div class="form-group col-md-6">
                  <label for="nomor">Nomor Kartu Keluarga <code>(*)</code></label>
                  <input type="text" class="form-control" id="nomor" name="nomor" value="{{ old('nomor') ?? '3509' }}"
                    maxlength="16">
                </div>
              </div>

              <div class="form-group">
                <label for="alamat">Alamat <code>(*)</code></label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat') }}">
              </div>

              <div class="form-group">
                <label for="foto_kk">Foto Kartu Keluarga</label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="foto_kk" name="foto_kk" accept=".jpg,.png,.jpeg">
                  <label class="custom-file-label" for="foto_kk">Choose file</label>
                </div>
                <small class="form-text text-muted">Ukuran maksimal 1MB, format: JPG,JPEG dan PNG</small>
              </div>

              <div class="form-group">
                <div class="kk-preview p-1 border d-none">
                  <img class="img-fluid">
                </div>
              </div>

              <div class="form-group">
                <button class="btn btn-primary btn-block" type="submit">Simpan</button>
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
    $('#foto_kk').on('change', function() {
      const file = $(this).get(0).files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function() {
          $('.kk-preview img').attr('src', reader.result);
        }

        reader.readAsDataURL(file);

        $('.kk-preview').removeClass('d-none');

      }
    });
  </script>
@endpush
