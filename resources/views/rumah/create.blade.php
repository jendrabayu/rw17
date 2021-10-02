@extends('layouts.app')

@section('title')
  Tambah Rumah
@endsection

@section('content')
  <div class="section-header">
    <div class="section-header-back">
      <a href="{{ route('rumah.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Tambah Rumah</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item"><a href="{{ route('rumah.index') }}">Rumah</a></div>
      <div class="breadcrumb-item">Tambah Rumah</div>
    </div>
  </div>

  <div class="section-body">
    @include('partials.alerts')

    <div class="row">
      <div class="col-12">
        <div class="card card-primary">
          <div class="card-header">
            <h4>Tambah Rumah</h4>
          </div>
          <div class="card-body">
            <form action="{{ route('rumah.store') }}" method="POST">
              @csrf
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="rt"><code>*</code> RT</label>
                  <input type="text" readonly value="{{ $rt->nomor }}" class="form-control">
                  <input type="hidden" name="rt_id" value="{{ $rt->id }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="alamat"><code>*</code> Alamat</label>
                  <textarea class="form-control" id="alamat" name="alamat"> {{ old('alamat') }}</textarea>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="nomor"><code>*</code> Nomor Rumah</label>
                  <input type="text" class="form-control" id="nomor" name="nomor" value="{{ old('nomor') }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="penggunaan_bangunan"><code>*</code> Penggunaan Bangunan</label>
                  <select name="penggunaan_bangunan_id" id="penggunaan_bangunan" class="form-control select2">
                    <option selected hidden disabled>--Pilih Penggunaan Bangunan--</option>
                    @foreach ($penggunaanBangunan as $id => $nama)
                      <option {{ old('penggunaan_bangunan_id') == $id ? 'selected' : '' }} value="{{ $id }}">
                        {{ $nama }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="keluarga">Keluarga</label>
                  <select name="keluarga_id[]" id="keluarga" class="form-control select2" multiple>
                    @foreach ($keluarga as $id => $nomor)
                      <option {{ old('keluarga_id') && in_array($id, old('keluarga_id')) ? 'selected' : '' }}
                        value="{{ $id }}">{{ $nomor }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="penduduk_domisili">Penduduk Domisili</label>
                  <select name="penduduk_domisili_id[]" id="penduduk_domisili" class="form-control select2" multiple>
                    @foreach ($pendudukDomisili as $id => $nama)
                      <option
                        {{ old('penduduk_domisili_id') && in_array($id, old('penduduk_domisili_id')) ? 'selected' : '' }}
                        value="{{ $id }}">{{ $nama }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="keterangan">Keterangan</label>
                  <textarea class="form-control" id="keterangan"
                    name="keterangan"> {{ old('keterangan') }}</textarea>
                </div>
              </div>

              <div class="form-group mb-0">
                <button class="btn btn-primary btn-block btn-lg" type="submit">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
