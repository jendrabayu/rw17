@extends('layouts.app')

@section('title')
  Edit Penduduk Domisili
@endsection

@section('content')
  <div class="section-header">
    <div class="section-header-back">
      <a href="{{ route('penduduk-domisili.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Edit Penduduk Domisili</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item"><a href="{{ route('penduduk-domisili.index') }}">Penduduk Domisili</a></div>
      <div class="breadcrumb-item">Edit Penduduk Domisili</div>
    </div>
  </div>
  <div class="section-body">
    @include('partials.alerts')

    <div class="row">
      <div class="col-12">
        <div class="card card-primary">
          <div class="card-header">
            <h4>Edit Penduduk Domisili</h4>
          </div>
          <div class="card-body">
            <form action="{{ route('penduduk-domisili.update', $pendudukDomisili->id) }}" method="POST"
              enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="rt"><code>*</code> RT</label>
                  <input type="text" readonly class="form-control" value="RT {{ $rt->nomor }}" id="rt">
                  <input type="hidden" name="rt_id" value="{{ $rt->id }}">
                </div>

                <div class="form-group col-md-6">
                  <label for="nik"><code>*</code> NIK</label>
                  <input type="text" class="form-control" id="nik" name="nik" maxlength="16"
                    value="{{ $pendudukDomisili->nik }}">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="nama"><code>*</code> Nama Lengkap</label>
                  <input type="text" class="form-control" id="nama" name="nama" maxlength="100"
                    value="{{ $pendudukDomisili->nama }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="tempat_lahir"><code>*</code> Tempat Lahir</label>
                  <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                    value="{{ $pendudukDomisili->tempat_lahir }}">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="tanggal_lahir"><code>*</code> Tanggal Lahir</label>
                  <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir"
                    value="{{ $pendudukDomisili->tanggal_lahir->format('Y-m-d') }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="jenis_kelamin"><code>*</code> Jenis Kelamin</label>
                  <select name="jenis_kelamin" id="jenis_kelamin" class="custom-select">
                    <option selected disabled hidden>--Pilih Jenis Kelamin--</option>
                    <option {{ $pendudukDomisili->jenis_kelamin === 'l' ? 'selected' : '' }} value="l">Laki-Laki
                    </option>
                    <option {{ $pendudukDomisili->jenis_kelamin === 'p' ? 'selected' : '' }} value="p">Perempuan
                    </option>
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="agama"><code>*</code> Agama</label>
                  <select name="agama_id" id="agama" class="form-control select2">
                    <option selected disabled hidden>--Pilih Agama--</option>
                    @foreach ($agama as $id => $nama)
                      <option {{ $pendudukDomisili->agama->id === $id ? 'selected' : '' }}
                        value="{{ $id }}">
                        {{ $nama }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="status_perkawinan"><code>*</code> Status Perkawinan</label>
                  <select name="status_perkawinan_id" id="status_perkawinan" class="form-control select2">
                    <option selected disabled hidden>--Pilih Status Perkawinan--</option>
                    @foreach ($statusPerkawinan as $id => $nama)
                      <option {{ $pendudukDomisili->status_perkawinan_id === $id ? 'selected' : '' }}
                        value="{{ $id }}">
                        {{ $nama }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="pekerjaan"><code>*</code> Pekerjaan</label>
                  <select name="pekerjaan_id" id="pekerjaan" class="form-control select2">
                    <option selected disabled hidden>--Pilih Pekerjaan--</option>
                    @foreach ($pekerjaan as $id => $nama)
                      <option {{ $pendudukDomisili->pekerjaan_id === $id ? 'selected' : '' }}
                        value="{{ $id }}">
                        {{ $nama }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="kewarganegaraan"><code>*</code> Kewarganegaraan</label>
                  <select name="kewarganegaraan" id="kewarganegaraan" class="form-control">
                    <option {{ old('kewarganegaraan') === '1' ? 'selected' : '' }} value="1">Warga Negara Indonesia
                    </option>
                    <option {{ old('kewarganegaraan') === '2' ? 'selected' : '' }} value="2">Warga Negara Asing
                    </option>
                    <option {{ old('kewarganegaraan') === '3' ? 'selected' : '' }} value="3">Dua Kewarganegaraan
                    </option>
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="alamat">Alamat <code>*</code></label>
                  <textarea name="alamat" id="alamat" class="form-control">{{ $pendudukDomisili->alamat }}</textarea>
                </div>
                <div class="form-group col-md-6">
                  <label for="rumah">Rumah</label>
                  <select name="rumah_id" id="rumah" class="form-control select2">
                    <option selected disabled hidden>--Pilih Alamat Rumah--</option>
                    @foreach ($rumah as $id => $alamat)
                      <option
                        {{ !is_null($pendudukDomisili->rumah) && $pendudukDomisili->rumah->id === $id ? 'selected' : '' }}
                        value="{{ $id }}">
                        {{ $alamat }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="pendidikan">Pendidikan</label>
                  <select name="pendidikan_id" id="pendidikan" class="form-control select2">
                    <option selected disabled hidden>--Pilih Pendidikan--</option>
                    @foreach ($pendidikan as $id => $nama)
                      <option {{ $pendudukDomisili->pendidikan_id === $id ? 'selected' : '' }}
                        value="{{ $id }}">
                        {{ $nama }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="darah">Golongan Darah</label>
                  <select name="darah_id" id="darah" class="form-control select2">
                    <option selected disabled hidden>--Pilih Golongan Darah--</option>
                    @foreach ($darah as $id => $nama)
                      <option {{ $pendudukDomisili->darah_id === $id ? 'selected' : '' }} value="{{ $id }}">
                        {{ $nama }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="alamat_asal">Alamat Asal</label>
                  <textarea name="alamat_asal" id="alamat_asal"
                    class="form-control">{{ $pendudukDomisili->alamat_asal }}</textarea>
                </div>
                <div class="form-group col-md-6">
                  <label for="no_hp">No. Hp/WhatsApp</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">+62</div>
                    </div>
                    <input type="tel" class="form-control" id="no_hp" name="no_hp"
                      value="{{ $pendudukDomisili->no_hp }}" maxlength="13">
                  </div>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="email">Email</label>
                  <input type="email" name="email" id="email" class="form-control"
                    value="{{ $pendudukDomisili->email }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="foto_ktp">Foto KTP</label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="foto_ktp" accept=".jpg, .jpeg, .png">
                    <label class="custom-file-label" for="foto_ktp">Choose file</label>
                  </div>
                  <small class="form-text text-muted">Ukuran maksimal 1MB, format: JPG,JPEG atau PNG</small>
                </div>
              </div>

              @if ($pendudukDomisili->foto_ktp)
                <div class="form-group img-thumbnail img__ktp__preview">
                  <img src="{{ Storage::url($pendudukDomisili->foto_ktp) }}" alt="{{ $pendudukDomisili->nik }}"
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
