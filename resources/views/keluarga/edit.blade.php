@extends('layouts.app')

@section('title')
  Edit Keluarga
@endsection

@section('content')
  <div class="section-header">
    <div class="section-header-back">
      <a href="{{ route('keluarga.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Edit Keluarga</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item"><a href="{{ route('keluarga.index') }}">Keluarga</a></div>
      <div class="breadcrumb-item">Edit Keluarga</div>
    </div>
  </div>

  <div class="section-body">
    @include('partials.alerts')

    <div class="row">
      <div class="col-12">
        <div class="card card-primary">
          <div class="card-header">
            <h4>Edit Keluarga</h4>
          </div>

          <div class="card-body">
            <form action="{{ route('keluarga.update', $keluarga->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="rt"><code>*</code> RT</label>
                  <input type="text" readonly value="{{ $rt->nomor }}" class="form-control" id="rt">
                  <input type="hidden" value="{{ $rt->id }}" name="rt_id">
                </div>
                <div class="form-group col-md-6">
                  <label for="nomor"><code>*</code> Nomor Kartu Keluarga</label>
                  <input type="text" class="form-control" id="nomor" name="nomor" value="{{ $keluarga->nomor }}"
                    maxlength="16">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="alamat"><code>*</code> Alamat</label>
                  <textarea class="form-control" id="alamat" name="alamat">{{ $keluarga->alamat }}</textarea>
                </div>
                <div class="form-group col-md-6">
                  <label for="rumah">Rumah</label>
                  <select name="rumah_id" id="rumah" class="form-control select2">
                    @php
                      $myHouse = $keluarga->rumah->first();
                    @endphp
                    <option selected disabled hidden>--Pilih Rumah--</option>
                    @foreach ($rumah as $id => $alamat)
                      <option {{ !is_null($myHouse) && $myHouse->id === $id ? 'selected' : '' }}
                        value="{{ $id }}">{{ $alamat }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="foto_kk">Foto Kartu Keluarga</label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="foto_kk" name="foto_kk" accept=".jpg,.png,.jpeg">
                    <label class="custom-file-label" for="foto_kk">Choose file</label>
                  </div>
                  <small class="form-text text-muted">Ukuran maksimal 1MB, format: JPG,JPEG dan PNG</small>
                </div>
              </div>

              @if ($keluarga->foto_kk)
                <div class="form-group img__kk__preview img-thumbnail">
                  <img src="{{ Storage::url($keluarga->foto_kk) }}" alt="{{ $keluarga->nomor }}"
                    class="w-100">
                </div>
              @else
                <div class="form-group img__kk__preview img-thumbnail d-none">
                  <img class="w-100">
                </div>
              @endif

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
    $('#foto_kk').on('change', function() {
      const file = $(this).get(0).files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function() {
          $('.img__kk__preview img').attr('src', reader.result);
        }
        reader.readAsDataURL(file);

        $('.img__kk__preview').removeClass('d-none');
      }
    });
  </script>
@endpush
