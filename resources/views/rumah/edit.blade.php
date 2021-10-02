@extends('layouts.app')

@section('title')
  Edit Rumah
@endsection

@section('content')
  <div class="section-header">
    <div class="section-header-back">
      <a href="{{ route('rumah.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Edit Rumah</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item"><a href="{{ route('rumah.index') }}">Rumah</a></div>
      <div class="breadcrumb-item">Edit Rumah</div>
    </div>
  </div>

  <div class="section-body">
    @include('partials.alerts')

    <div class="row">
      <div class="col-12">
        <div class="card card-primary">
          <div class="card-header">
            <h4>Edit Rumah</h4>
          </div>
          <div class="card-body">
            <form action="{{ route('rumah.update', $rumah->id) }}" method="POST">
              @csrf
              @method('PUT')
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="rt"><code>*</code> RT</label>
                  <input type="text" readonly value="{{ $rt->nomor }}" class="form-control" id="rt">
                  <input type="hidden" name="rt_id" value="{{ $rt->id }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="alamat"><code>*</code> Alamat </label>
                  <textarea class="form-control" id="alamat" name="alamat">{{ $rumah->alamat }}</textarea>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="nomor"><code>*</code> Nomor Rumah </label>
                  <input type="text" class="form-control" id="nomor" name="nomor" value="{{ $rumah->nomor }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="penggunaan_bangunan"><code>*</code> Penggunaan Bangunan</label>
                  <select name="penggunaan_bangunan_id" id="penggunaan_bangunan" class="form-control select2">
                    <option selected hidden disabled>--Pilih Penggunaan Bangunan--</option>
                    @foreach ($penggunaanBangunan as $id => $nama)
                      <option {{ $rumah->penggunaanBangunan->id === $id ? 'selected' : '' }}
                        value="{{ $id }}">
                        {{ $nama }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="keluarga">Keluarga</label>
                  <select name="keluarga_id[]" id="keluarga" class="form-control select2" multiple>
                    @foreach ($keluarga as $id => $nama)
                      <option {{ !is_null($rumah->keluarga->where('id', $id)->first()) ? 'selected' : '' }}
                        value="{{ $id }}">{{ $nama }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="penduduk_domisili">Penduduk Domisili</label>
                  <select name="penduduk_domisili_id[]" id="penduduk_domisili" class="form-control select2" multiple>
                    @foreach ($pendudukDomisili as $id => $nama)
                      <option {{ !is_null($rumah->pendudukDomisili->where('id', $id)->first()) ? 'selected' : '' }}
                        value="{{ $id }}">
                        {{ $nama }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="keterangan">Keterangan</label>
                  <input type="text" class="form-control" id="keterangan" name="keterangan"
                    value="{{ $rumah->keterangan }}">
                </div>
              </div>

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
