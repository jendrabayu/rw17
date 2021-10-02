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
    @include('partials.alerts')

    <div class="row">
      <div class="col-12">
        <div class="card card-primary">
          <div class="card-header">
            <h4>Tambah Penduduk</h4>
          </div>
          <div class="card-body">
            <form action="{{ route('penduduk.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="rt"><code>*</code> RT</label>
                  <input type="text" readonly class="form-control" value="{{ $rt->nomor }}" id="rt">
                  <input type="hidden" name="rt_id" value="{{ $rt->id }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="keluarga"><code>*</code> Nomor Kartu Keluarga</label>
                  <select name="keluarga_id" id="keluarga" class="form-control select2">
                    <option selected disabled hidden>--Pilih No. Kartu Keluarga--</option>
                    @foreach ($keluarga as $id => $nomor)
                      <option {{ (int) old('keluarga_id') === $id ? 'selected' : '' }} value="{{ $id }}">
                        {{ $nomor }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="nik"><code>*</code> NIK</label>
                  <input type="text" class="form-control" id="nik" name="nik" maxlength="16"
                    value="{{ old('nik') ? old('nik') : '3509' }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="nama"><code>*</code> Nama Lengkap</label>
                  <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="tempat_lahir"> <code>*</code> Tempat Lahir</label>
                  <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                    value="{{ old('tempat_lahir') }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="tanggal_lahir"> <code>*</code> Tanggal Lahir</label>
                  <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir"
                    value="{{ old('tanggal_lahir') }}">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="jenis_kelamin"><code>*</code> Jenis Kelamin</label>
                  <select name="jenis_kelamin" id="jenis_kelamin" class="custom-select">
                    <option selected disabled hidden>--Pilih Jenis Kelamin--</option>
                    <option {{ old('jenis_kelamin') === 'l' ? 'selected' : '' }} value="l">Laki-Laki</option>
                    <option {{ old('jenis_kelamin') === 'p' ? 'selected' : '' }} value="p">Perempuan</option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="agama"> <code>*</code> Agama</label>
                  <select name="agama_id" id="agama" class="form-control select2">
                    <option selected disabled hidden>--Pilih Agama--</option>
                    @foreach ($agama as $id => $nama)
                      <option {{ (int) old('agama_id') === $id ? 'selected' : '' }} value="{{ $id }}">
                        {{ $nama }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="status_perkawinan"><code>*</code> Status Perkawinan</label>
                  <select name="status_perkawinan_id" id="status_perkawinan" class="custom-select">
                    <option selected disabled hidden>--Pilih Status Perkawinan--</option>
                    @foreach ($statusPerkawinan as $id => $nama)
                      <option {{ (int) old('status_perkawinan_id') === $id ? 'selected' : '' }}
                        value="{{ $id }}">
                        {{ $nama }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="pekerjaan"><code>*</code> Pekerjaan</label>
                  <select name="pekerjaan_id" id="pekerjaan" class="form-control select2">
                    <option selected disabled hidden>--Pilih Pekerjaan--</option>
                    @foreach ($pekerjaan as $id => $nama)
                      <option {{ (int) old('pekerjaan_id') === $id ? 'selected' : '' }} value="{{ $id }}">
                        {{ $nama }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="kewarganegaraan"><code>*</code> Kewarganegaraan</label>
                  <select name="kewarganegaraan" id="kewarganegaraan" class="custom-select">
                    <option {{ old('kewarganegaraan') === '1' ? 'selected' : '' }} selected value="1">Warga Negara
                      Indonesia
                    </option>
                    <option {{ old('kewarganegaraan') === '2' ? 'selected' : '' }} value="2">Warga Negara Asing
                    </option>
                    <option {{ old('kewarganegaraan') === '3' ? 'selected' : '' }} value="3">Dua Kewarganegaraan
                    </option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="status_hubungan_dalam_keluarga"><code>*</code> Status Hubungan Dalam Keluarga</label>
                  <select name="status_hubungan_dalam_keluarga_id" id="status_hubungan_dalam_keluarga"
                    class="form-control select2">
                    <option selected disabled hidden>--Pilih Status Hubungan Dalam Keluarga--</option>
                    @foreach ($statusHubunganDalamKeluarga as $id => $nama)
                      <option {{ (int) old('status_hubungan_dalam_keluarga_id') === $id ? 'selected' : '' }}
                        value="{{ $id }}">{{ $nama }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="pendidikan"><code>*</code> Pendidikan</label>
                  <select name="pendidikan_id" id="pendidikan" class="form-control select2">
                    <option selected disabled hidden>--Pilih Pendidikan--</option>
                    @foreach ($pendidikan as $id => $nama)
                      <option {{ (int) old('pendidikan_id') === $id ? 'selected' : '' }} value="{{ $id }}">
                        {{ $nama }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="darah">Golongan Darah</label>
                  <select name="darah_id" id="darah" class="form-control select2">
                    <option selected disabled hidden>--Pilih Golongan Darah--</option>
                    <option value="">Kosongkan</option>
                    @foreach ($darah as $id => $nama)
                      <option {{ (int) old('darah_id') === $id ? 'selected' : '' }} value="{{ $id }}">
                        {{ $nama }}
                      </option>
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
                  <label for="no_kitas_kitap">Nomor KITAS / KITAP</label>
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
                  <label for="no_hp">No. Hp / WhatsApp</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">+62</div>
                    </div>
                    <input type="tel" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
                      maxlength="15">
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="email">Email</label>
                  <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                </div>
              </div>

              <div class="form-group">
                <label for="foto_ktp">Foto KTP</label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="foto_ktp" accept=".jpg, .jpeg, .png" name="foto_ktp">
                  <label class="custom-file-label" for="foto_ktp">Choose file</label>
                </div>
                <small class="form-text text-muted">Ukuran maksimal 1MB, format: JPG,JPEG atau PNG</small>
              </div>

              <div class="form-group img-thumbnail img__ktp__preview d-none">
                <img class="w-100">
              </div>

              <div class="form-group mb-0">
                <button type="submit" class="btn btn-primary btn-block btn-lg">Simpan</button>
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
          $('.img__ktp__preview img').attr('src', reader.result);
        }
        reader.readAsDataURL(file);
        $('.img__ktp__preview').removeClass('d-none');
      }
    });
  </script>
@endpush
