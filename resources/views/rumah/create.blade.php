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
    <div class="row">
      <div class="col-12">
        @include('partials.alerts')
      </div>
    </div>

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
                  <label for="rt">RT <code>*</code></label>
                  @role('rt')
                  <input type="text" readonly value="RT {{ $rt->nomor }}" class="form-control">
                  <input type="text" hidden value="{{ ltrim($rt->id, '0') }}" name="rt_id">
                  @endrole
                  @role('rw')
                  <select name="rt_id" id="rt" class="custom-select">
                    <option selected hidden value="" disabled>--Pilih RT--</option>
                    @foreach ($rt as $id => $rt)
                      <option value="{{ $id }}" class="form-control">RT {{ ltrim($rt, '0') }}</option>
                    @endforeach
                  </select>
                  @endrole
                </div>
                <div class="form-group col-md-6">
                  <label for="keluarga">Nomor Kartu Keluarga</label>
                  <select name="keluarga_id[]" id="keluarga" class="form-control select2" @role('rw') disabled @endrole
                    multiple>
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
                  <label for="penduduk_domisili">Penduduk Domisili</label>
                  <select name="penduduk_domisili_id[]" id="penduduk_domisili" class="form-control select2" @role('rw')
                    disabled @endrole multiple>
                    @role('rt')
                    @foreach ($pendudukDomisili as $id => $nama)
                      <option value="{{ $id }}">{{ $nama }}</option>
                    @endforeach
                    @endrole
                  </select>
                </div>

                <div class="form-group col-md-6">
                  <label for="alamat">Alamat <code>*</code></label>
                  <textarea class="form-control" id="alamat" name="alamat"> {{ old('alamat') }}</textarea>
                </div>

              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="nomor">Nomor Rumah <code>*</code></label>
                  <input type="text" class="form-control" id="nomor" name="nomor" value="{{ old('nomor') }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="tipe_bangunan">Tipe Bangunan</label>
                  <input type="text" class="form-control" id="tipe_bangunan" name="tipe_bangunan"
                    value="{{ old('tipe_bangunan') }}">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="penggunaan_bangunan">Penggunaan Bangunan</label>
                  <input type="text" class="form-control" id="penggunaan_bangunan" name="penggunaan_bangunan"
                    value="{{ old('penggunaan_bangunan') }}">
                </div>

                <div class="form-group col-md-6">
                  <label for="kontruksi_bangunan">Kontruksi Bangunan</label>
                  <input type="text" class="form-control" id="kontruksi_bangunan" name="kontruksi_bangunan"
                    value="{{ old('kontruksi_bangunan') }}">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="keterangan">Keterangan</label>
                  <input type="text" class="form-control" id="keterangan" name="keterangan"
                    value="{{ old('keterangan') }}">
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


@push('scripts')
  <script>
    $('#rt').on('change', function(e) {
      const rtId = e.target.value;
      $.ajax({
        url: '/ajax/keluarga/' + rtId,
        type: 'get',
        success: function(data) {
          $('#keluarga').empty();
          $.each(data, function(i, v) {
            $('#keluarga').append(`<option value="${v.id}">${v.nomor}</option>`);
          });
          $('#keluarga').removeAttr('disabled');
        },
        error: function(error) {
          Toast.fire({
            icon: 'error',
            title: `<b class="text-danger">Gagal!</b> [${error.status}] ${error.statusText}`
          });
        }
      });

      $.ajax({
        url: '/ajax/penduduk-domisili/' + rtId,
        type: 'get',
        success: function(data) {
          $('#penduduk_domisili').empty();
          $.each(data, function(i, v) {
            $('#penduduk_domisili').append(`<option value="${v.id}">${v.nama}</option>`);
          });
          $('#penduduk_domisili').removeAttr('disabled');
        },
        error: function(error) {
          Toast.fire({
            icon: 'error',
            title: `<b class="text-danger">Gagal!</b> [${error.status}] ${error.statusText}`
          });
        }
      });

    });
  </script>
@endpush
