@extends('layouts.app')

@section('title')
  Tambah Penduduk
@endsection

@section('content')
  <div class="section-header">
    <div class="section-header-back">
      <a href="{{ route('penduduk.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Tambah Penduduk</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item"><a href="{{ route('penduduk.index') }}">Penduduk</a></div>
      <div class="breadcrumb-item">Tambah Penduduk</div>
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
            <h4>Tambah Penduduk</h4>
          </div>
          <div class="card-body">
            <form action="{{ route('penduduk.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="rt">RT <code>(*)</code></label>
                  @role('rt')
                  <input type="text" class="form-control" value="RT {{ $rt->nomor }}" id="rt" disabled>
                  <input type="text" name="rt_id" value="{{ $rt->id }}" hidden>
                  @endrole
                  @role('rw')
                  <select name="rt_id" id="rt" class="form-control select2">
                    <option selected disabled hidden>--Pilih RT--</option>
                    @foreach ($rt as $id => $nomor)
                      <option value="{{ $id }}">RT {{ $nomor }}</option>
                    @endforeach
                  </select>
                  @endrole
                </div>
                <div class="form-group col-md-6">
                  <label for="keluarga">Nomor Kartu Keluarga <code>(*)</code></label>
                  <select name="keluarga_id" id="keluarga" class="form-control select2" @role('rw') disabled @endrole>
                    <option selected disabled hidden>--Pilih Nomor KK--</option>
                    @role('rt')
                    @foreach ($keluarga as $id => $nomor)
                      <option {{ old('keluarga_id') == $id ? 'selected' : '' }} value="{{ $id }}">
                        {{ $nomor }}</option>
                    @endforeach
                    @endrole
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="nik">NIK <code>(*)</code></label>
                  <input type="text" class="form-control" id="nik" name="nik" maxlength="16"
                    value="{{ old('nik') ? old('nik') : '3509' }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="nama">Nama Lengkap <code>(*)</code></label>
                  <input type="text" class="form-control" id="nama" name="nama" maxlength="100"
                    value="{{ old('nama') }}">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="tempat_lahir">Tempat Lahir <code>(*)</code></label>
                  <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                    value="{{ old('tempat_lahir') }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="tanggal_lahir">Tanggal Lahir <code>(*)</code></label>
                  <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir"
                    value="{{ old('tanggal_lahir') }}">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="jenis_kelamin">Jenis Kelamin <code>(*)</code></label>
                  <select name="jenis_kelamin" id="jenis_kelamin" class="form-control select2">
                    <option selected disabled hidden>--Pilih Jenis Kelamin--</option>
                    <option {{ old('jenis_kelamin') == 'l' ? 'selected' : '' }} value="l">Laki-Laki</option>
                    <option {{ old('jenis_kelamin') == 'p' ? 'selected' : '' }} value="p">Perempuan</option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="agama">Agama <code>(*)</code></label>
                  <select name="agama_id" id="agama" class="form-control select2">
                    <option selected disabled hidden>--Pilih Agama--</option>
                    @foreach ($agama as $id => $nama)
                      <option {{ old('agama_id') == $id ? 'selected' : '' }} value="{{ $id }}">
                        {{ $nama }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="status_perkawinan">Status Perkawinan <code>(*)</code></label>
                  <select name="status_perkawinan_id" id="status_perkawinan" class="form-control select2">
                    <option selected disabled hidden>--Pilih Status Perkawinan--</option>
                    @foreach ($statusPerkawinan as $id => $nama)
                      <option {{ old('status_perkawinan_id') == $id ? 'selected' : '' }} value="{{ $id }}">
                        {{ $nama }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="pekerjaan">Pekerjaan <code>(*)</code></label>
                  <select name="pekerjaan_id" id="pekerjaan" class="form-control select2">
                    <option selected disabled hidden>--Pilih Pekerjaan--</option>
                    @foreach ($pekerjaan as $id => $nama)
                      <option {{ old('pekerjaan_id') == $id ? 'selected' : '' }} value="{{ $id }}">
                        {{ $nama }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="kewarganegaraan">Kewarganegaraan <code>(*)</code></label>
                  <select name="kewarganegaraan" id="kewarganegaraan" class="form-control select2">
                    <option {{ old('kewarganegaraan') == 1 ? 'selected' : '' }} selected value="1">Warga Negara
                      Indonesia
                    </option>
                    <option {{ old('kewarganegaraan') == 2 ? 'selected' : '' }} value="2">Warga Negara Asing</option>
                    <option {{ old('kewarganegaraan') == 3 ? 'selected' : '' }} value="3">Dua Kewarganegaraan</option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="status_hubungan_dalam_keluarga">Status Hubungan Dalam Keluarga <code>(*)</code></label>
                  <select name="status_hubungan_dalam_keluarga_id" id="status_hubungan_dalam_keluarga"
                    class="form-control select2">
                    <option selected disabled hidden>--Pilih Status Hubungan Dalam Keluarga--</option>
                    @foreach ($statusHubunganDalamKeluarga as $id => $nama)
                      <option {{ old('status_hubungan_dalam_keluarga_id') == $id ? 'selected' : '' }}
                        value="{{ $id }}">{{ $nama }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="pendidikan">Pendidikan <code>(*)</code></label>
                  <select name="pendidikan_id" id="pendidikan" class="form-control select2">
                    <option selected disabled hidden>--Pilih Pendidikan--</option>
                    @foreach ($pendidikan as $id => $nama)
                      <option {{ old('pendidikan_id') == $id ? 'selected' : '' }} value="{{ $id }}">
                        {{ $nama }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="darah">Golongan Darah</label>
                  <select name="darah_id" id="darah" class="form-control select2">
                    <option selected disabled hidden>--Pilih Golongan Darah--</option>
                    <option value="">Kosongkan</option>
                    @foreach ($darah as $id => $nama)
                      <option {{ old('darah_id') == $id ? 'selected' : '' }} value="{{ $id }}">
                        {{ $nama }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="no_paspor">Nomor Paspor</label>
                  <input type="text" class="form-control" name="no_paspor" id="no_paspor"
                    value="{{ old('no_paspor') }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="no_kitas_kitap">Nomor KITAS/KITAP</label>
                  <input type="text" class="form-control" name="no_kitas_kitap" id="no_kitas_kitap"
                    value="{{ old('no_kitas_kitap') }}">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="nama_ayah">Nama Ayah</label>
                  <input type="text" class="form-control" name="nama_ayah" id="nama_ayah"
                    value="{{ old('nama_ayah') }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="nama_ibu">Nama Ibu</label>
                  <input type="text" class="form-control" name="nama_ibu" id="nama_ibu"
                    value="{{ old('nama_ibu') }}">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="no_hp">No. Hp/WhatsApp</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">+62</div>
                    </div>
                    <input type="tel" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
                      maxlength="13">
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="email">Email</label>
                  <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}"
                    maxlength="50">
                </div>
              </div>

              <div class="form-group">
                <label for="foto_ktp">Foto KTP</label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="foto_ktp" accept=".jpg, .jpeg, .png" name="foto_ktp">
                  <label class="custom-file-label" for="foto_ktp">Choose file</label>
                </div>
                <small class="form-text text-muted">Ukuran maksimal 1MB, format: JPG,JPEG dan PNG</small>
              </div>

              <div class="form-group">
                <div class="ktp-preview p-1 border d-none">
                  <img class="img-fluid">
                </div>
              </div>

              <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Simpan</button>
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
    $('#foto_ktp').on('change', function() {
      const file = $(this).get(0).files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function() {
          $('.ktp-preview img').attr('src', reader.result);
        }
        reader.readAsDataURL(file);
        $('.ktp-preview').removeClass('d-none');
      }
    });

    $('#rt').on('change', function(e) {
      const rtId = e.target.value;
      $.ajax({
        url: '/ajax/keluarga/' + rtId,
        type: 'get',
        success: function(data) {
          $('#keluarga').empty();
          $('#keluarga').append('<option selected disabled hidden>--Pilih Nomor KK--</option>');
          $.each(data, function(i, v) {
            $('#keluarga').append(`<option value="${v.id}">${v.nomor}</option>`);
          });
          $('#keluarga').removeAttr('disabled');
        },
        error: function(error) {
          console.log(error)
        }
      })

    });
  </script>
@endpush
