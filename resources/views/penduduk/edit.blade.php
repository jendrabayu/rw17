@extends('layouts.app')

@section('title')
  Edit Penduduk
@endsection

@section('content')
  <div class="section-header">
    <div class="section-header-back">
      <a href="{{ route('penduduk.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Edit Penduduk</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item"><a href="{{ route('penduduk.index') }}">Penduduk</a></div>
      <div class="breadcrumb-item">Edit Penduduk</div>
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
        <div class="card card-primary">
          <div class="card-header">
            <h4>Edit Penduduk</h4>
          </div>
          <div class="card-body">
            <form action="{{ route('penduduk.update', $penduduk->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="rt">RT <code>*</code></label>
                  @role('rt')
                  <input type="text" class="form-control" value="RT {{ ltrim($rt->nomor, '0') }}" id="rt" disabled>
                  <input type="text" name="rt_id" value="{{ $rt->id }}" hidden>
                  @endrole
                  @role('rw')
                  <select name="rt_id" id="rt" class="custom-select">
                    <option selected disabled hidden>--Pilih RT--</option>
                    @foreach ($rt as $id => $nomor)
                      <option {{ $penduduk->keluarga->rt->id === $id ? 'selected' : '' }} value="{{ $id }}">
                        RT {{ ltrim($nomor, '0') }}
                      </option>
                    @endforeach
                  </select>
                  @endrole
                </div>
                <div class="form-group col-md-6">
                  <label for="keluarga">Nomor Kartu Keluarga <code>*</code></label>
                  <select name="keluarga_id" id="keluarga" class="form-control select2">
                    @role('rw')
                    @foreach ($penduduk->keluarga->rt->keluarga->pluck('nomor', 'id') as $id => $nomor)
                      <option {{ $penduduk->keluarga->id === $id ? 'selected' : '' }} value="{{ $id }}">
                        {{ $nomor }}
                      </option>
                    @endforeach
                    @endrole
                    @role('rt')
                    @foreach ($keluarga as $id => $nomor)
                      <option {{ $penduduk->keluarga->id == $id ? 'selected' : '' }} value="{{ $id }}">
                        {{ $nomor }}
                      </option>
                    @endforeach
                    @endrole
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="nik">NIK <code>*</code></label>
                  <input type="text" class="form-control" id="nik" name="nik" maxlength="16"
                    value="{{ $penduduk->nik }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="nama">Nama Lengkap <code>*</code></label>
                  <input type="text" class="form-control" id="nama" name="nama" value="{{ $penduduk->nama }}">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="tempat_lahir">Tempat Lahir <code>*</code></label>
                  <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                    value="{{ $penduduk->tempat_lahir }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="tanggal_lahir">Tanggal Lahir <code>*</code></label>
                  <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir"
                    value="{{ $penduduk->tanggal_lahir->format('Y-m-d') }}">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="status_perkawinan">Status Perkawinan <code>*</code></label>
                  <select name="status_perkawinan_id" id="status_perkawinan" class="custom-select">
                    <option selected disabled hidden>--Pilih Status Perkawinan--</option>
                    @foreach ($statusPerkawinan as $id => $nama)
                      <option {{ $penduduk->statusPerkawinan->id === $id ? 'selected' : '' }}
                        value="{{ $id }}">
                        {{ $nama }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="pekerjaan">Pekerjaan <code>*</code></label>
                  <select name="pekerjaan_id" id="pekerjaan" class="form-control select2">
                    <option selected disabled hidden>--Pilih Pekerjaan--</option>
                    @foreach ($pekerjaan as $id => $nama)
                      <option {{ $penduduk->pekerjaan->id === $id ? 'selected' : '' }} value="{{ $id }}">
                        {{ $nama }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="jenis_kelamin">Jenis Kelamin <code>*</code></label>
                  <select name="jenis_kelamin" id="jenis_kelamin" class="custom-select">
                    <option selected disabled hidden>--Pilih Jenis Kelamin--</option>
                    <option {{ $penduduk->jenis_kelamin === 'l' ? 'selected' : '' }} value="l">Laki-Laki</option>
                    <option {{ $penduduk->jenis_kelamin === 'p' ? 'selected' : '' }} value="p">Perempuan</option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="agama">Agama <code>*</code></label>
                  <select name="agama_id" id="agama" class="form-control select2">
                    <option selected disabled hidden>--Pilih Agama--</option>
                    @foreach ($agama as $id => $nama)
                      <option {{ $penduduk->agama->id === $id ? 'selected' : '' }} value="{{ $id }}">
                        {{ $nama }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="kewarganegaraan">Kewarganegaraan <code>*</code></label>
                  <select name="kewarganegaraan" id="kewarganegaraan" class="custom-select">
                    <option selected value="1">Warga Negara Indonesia</option>
                    <option value="2">Warga Negara Asing</option>
                    <option value="3">Dua Kewarganegaraan</option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="status_hubungan_dalam_keluarga">Status Hubungan Dalam Keluarga <code>*</code></label>
                  <select name="status_hubungan_dalam_keluarga_id" id="status_hubungan_dalam_keluarga"
                    class="form-control select2">
                    <option selected disabled hidden>--Pilih Status Hubungan Dalam Keluarga--</option>
                    @foreach ($statusHubunganDalamKeluarga as $id => $nama)
                      <option {{ $penduduk->statusHubunganDalamKeluarga->id === $id ? 'selected' : '' }}
                        value="{{ $id }}">{{ $nama }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="pendidikan">Pendidikan <code>*</code></label>
                  <select name="pendidikan_id" id="pendidikan" class="form-control select2">
                    <option selected disabled hidden>--Pilih Pendidikan--</option>
                    @foreach ($pendidikan as $id => $nama)
                      <option {{ $penduduk->pendidikan->id === $id ? 'selected' : '' }} value="{{ $id }}">
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
                      <option {{ $penduduk->darah->id === $id ? 'selected' : '' }} value="{{ $id }}">
                        {{ $nama }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="no_paspor">Nomor Paspor</label>
                  <input type="text" class="form-control" name="no_paspor" id="no_paspor"
                    value="{{ $penduduk->no_paspor }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="no_kitas_kitap">Nomor KITAS / KITAP</label>
                  <input type="text" class="form-control" name="no_kitas_kitap" id="no_kitas_kitap"
                    value="{{ $penduduk->no_kitas_kitap }}">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="nama_ayah">Nama Ayah</label>
                  <input type="text" class="form-control" name="nama_ayah" id="nama_ayah"
                    value="{{ $penduduk->nama_ayah }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="nama_ibu">Nama Ibu</label>
                  <input type="text" class="form-control" name="nama_ibu" id="nama_ibu"
                    value="{{ $penduduk->nama_ibu }}">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="no_hp">No. Hp / WhatsApp</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">+62</div>
                    </div>
                    <input type="tel" class="form-control" id="no_hp" name="no_hp" value="{{ $penduduk->no_hp }}"
                      maxlength="15">
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="email">Email</label>
                  <input type="email" name="email" id="email" class="form-control" value="{{ $penduduk->email }}">
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

              @if ($penduduk->foto_ktp)
                <div class="form-group img-thumbnail img__ktp__preview">
                  <img src="{{ Storage::url($penduduk->foto_ktp) }}" alt="{{ $penduduk->nik }}"
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

    $('#rt').on('change', function(e) {
      const rtId = e.target.value;
      $.ajax({
        url: '/ajax/keluarga/' + rtId,
        type: 'get',
        success: function(data) {
          $('#keluarga').empty();
          $('#keluarga').append('<option selected disabled hidden>--Pilih No. Kartu Keluarga--</option>');
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
