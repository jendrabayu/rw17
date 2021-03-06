@extends('layouts.app')

@section('title')
  Edit Penduduk Meninggal
@endsection

@section('content')
  <div class="section-header">
    <div class="section-header-back">
      <a href="{{ route('penduduk-meninggal.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Edit Penduduk Meninggal</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item"><a href="{{ route('penduduk-meninggal.index') }}">Penduduk Meninggal</a></div>
      <div class="breadcrumb-item">Edit Penduduk Meninggal</div>
    </div>
  </div>
  <div class="section-body">
    @include('partials.alerts')

    <div class="row">
      <div class="col-12">
        <div class="card card-primary">
          <div class="card-header">
            <h4>Edit Penduduk Meninggal</h4>
          </div>
          <div class="card-body">
            <form action="{{ route('penduduk-meninggal.update', $pendudukMeninggal->id) }}" method="POST"
              enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="nik"><code>*</code> NIK</label>
                  <input type="text" class="form-control" id="nik" name="nik" maxlength="16"
                    value="{{ $pendudukMeninggal->nik }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="nama"><code>*</code> Nama</label>
                  <input type="text" class="form-control" id="nama" name="nama" maxlength="100"
                    value="{{ $pendudukMeninggal->nama }}">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="tempat_lahir"><code>*</code> Tempat Lahir</label>
                  <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                    value="{{ $pendudukMeninggal->tempat_lahir }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="tanggal_lahir"><code>*</code> Tanggal Lahir</label>
                  <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir"
                    value="{{ $pendudukMeninggal->tanggal_lahir->format('Y-m-d') }}">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="status_perkawinan"><code>*</code> Status Perkawinan</label>
                  <select name="status_perkawinan_id" id="status_perkawinan" class="custom-select">
                    <option selected disabled hidden>--Pilih Status Perkawinan--</option>
                    @foreach ($statusPerkawinan as $id => $nama)
                      <option {{ $pendudukMeninggal->statusPerkawinan->id == $id ? 'selected' : '' }}
                        value="{{ $id }}">
                        {{ $nama }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="pekerjaan"><code>*</code> Pekerjaan</label>
                  <select name="pekerjaan_id" id="pekerjaan" class="form-control select2">
                    <option selected disabled hidden>--Pilih Pekerjaan--</option>
                    @foreach ($pekerjaan as $id => $nama)
                      <option {{ $pendudukMeninggal->pekerjaan->id == $id ? 'selected' : '' }}
                        value="{{ $id }}">
                        {{ $nama }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="jenis_kelamin"><code>*</code> Jenis Kelamin</label>
                  <select name="jenis_kelamin" id="jenis_kelamin" class="custom-select">
                    <option selected disabled hidden>--Pilih Jenis Kelamin--</option>
                    <option {{ $pendudukMeninggal->jenis_kelamin == 'l' ? 'selected' : '' }} value="l">Laki-Laki
                    </option>
                    <option {{ $pendudukMeninggal->jenis_kelamin == 'p' ? 'selected' : '' }} value="p">Perempuan
                    </option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="agama"><code>*</code> Agama</label>
                  <select name="agama_id" id="agama" class="form-control select2">
                    <option selected disabled hidden>--Pilih Agama--</option>
                    @foreach ($agama as $id => $nama)
                      <option {{ $pendudukMeninggal->agama->id == $id ? 'selected' : '' }}
                        value="{{ $id }}">
                        {{ $nama }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="kewarganegaraan"><code>*</code> Kewarganegaraan</label>
                  <select name="kewarganegaraan" id="kewarganegaraan" class="custom-select">
                    <option {{ $pendudukMeninggal->kewarganegaraan === '1' ? 'selected' : '' }} value="1">Warga Negara
                      Indonesia</option>
                    <option {{ $pendudukMeninggal->kewarganegaraan === '2' ? 'selected' : '' }} value="2">Warga Negara
                      Asing</option>
                    <option {{ $pendudukMeninggal->kewarganegaraan === '3' ? 'selected' : '' }} value="3">Dua
                      Kewarganegaraan</option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="pendidikan"><code>*</code> Pendidikan</label>
                  <select name="pendidikan_id" id="pendidikan" class="form-control select2">
                    <option selected disabled hidden>--Pilih Pendidikan--</option>
                    @foreach ($pendidikan as $id => $nama)
                      <option {{ $pendudukMeninggal->pendidikan->id == $id ? 'selected' : '' }}
                        value="{{ $id }}">
                        {{ $nama }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="alamat"><code>*</code> Alamat</label>
                  <textarea class="form-control" name="alamat"
                    id="alamat">{{ $pendudukMeninggal->alamat }}</textarea>
                </div>
                <div class="form-group col-md-6">
                  <label for="tanggal_kematian"><code>*</code> Tanggal Kematian</label>
                  <input type="date" class="form-control" id="tanggal_kematian" name="tanggal_kematian"
                    value="{{ $pendudukMeninggal->tanggal_kematian->format('Y-m-d') }}">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="darah">Golongan Darah</label>
                  <select name="darah_id" id="darah" class="form-control select2">
                    <option selected disabled hidden>--Pilih Golongan Darah--</option>
                    <option value=""></option>
                    @foreach ($darah as $id => $nama)
                      <option {{ $pendudukMeninggal->darah->id == $id ? 'selected' : '' }}
                        value="{{ $id }}">
                        {{ $nama }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="jam_kematian">Jam Kematian</label>
                  <input type="time" class="form-control" id="jam_kematian" name="jam_kematian"
                    value="{{ $pendudukMeninggal->jam_kematian->format('H:i') }}">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="tempat_kematian">Tempat Kematian</label>
                  <input type="text" class="form-control" id="tempat_kematian" name="tempat_kematian"
                    value="{{ $pendudukMeninggal->tempat_kematian }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="sebab_kematian">Sebab Kematian</label>
                  <input type="text" class="form-control" id="sebab_kematian" name="sebab_kematian"
                    value="{{ $pendudukMeninggal->sebab_kematian }}">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="tempat_pemakaman">Tempat Pemakaman</label>
                  <input type="text" class="form-control" id="tempat_pemakaman" name="tempat_pemakaman"
                    value="{{ $pendudukMeninggal->tempat_pemakaman }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="nama_ayah">Nama Ayah</label>
                  <input type="text" class="form-control" name="nama_ayah" id="nama_ayah"
                    value="{{ $pendudukMeninggal->nama_ayah }}">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="nama_ibu">Nama Ibu</label>
                  <input type="text" class="form-control" name="nama_ibu" id="nama_ibu"
                    value="{{ $pendudukMeninggal->nama_ibu }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="foto_ktp">Foto KTP</label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="foto_ktp" name="foto_ktp" accept=".jpg, .jpeg, .png">
                    <label class="custom-file-label" for="foto_ktp">Choose file</label>
                  </div>
                  <small class="form-text text-muted">Ukuran maksimal 1MB, format: JPG,JPEG atau PNG</small>
                </div>
              </div>

              @if ($pendudukMeninggal->foto_ktp)
                <div class="form-group img-thumbnail img__ktp__preview">
                  <img src="{{ Storage::url($pendudukMeninggal->foto_ktp) }}" alt="{{ $pendudukMeninggal->nik }}"
                    class="w-100">
                </div>
              @else
                <div class="form-group img-thumbnail img__ktp__preview d-none">
                  <img class="w-100">
                </div>
              @endif

              <div class="form-group mb-0">
                <button type="submit" class="btn btn-primary btn-block btn-lg">Simpan Perubahan</button>
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
