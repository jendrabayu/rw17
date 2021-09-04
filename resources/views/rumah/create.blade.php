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
        <div class="card">
          <div class="card-header">
            <h4>Tambah Rumah</h4>
          </div>

          <div class="card-body">
            <form action="{{ route('rumah.store') }}" method="POST">
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
                      <option value="{{ $id }}" class="form-control">RT {{ $rt }}</option>
                    @endforeach
                  </select>
                  @endrole
                </div>
                <div class="form-group col-md-6">
                  <label for="keluarga">Nomor Kartu Keluarga <code>(*)</code></label>
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
                  <label for="alamat">Alamat <code>(*)</code></label>
                  <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat') }}">
                </div>

                <div class="form-group col-md-6">
                  <label for="nomor">Nomor Rumah <code>(*)</code></label>
                  <input type="text" class="form-control" id="nomor" name="nomor" value="{{ old('nomor') }}">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="tipe_bangunan">Tipe Bangunan</label>
                  <input type="text" class="form-control" id="tipe_bangunan" name="tipe_bangunan"
                    value="{{ old('tipe_bangunan') }}">
                </div>

                <div class="form-group col-md-6">
                  <label for="penggunaan_bangunan">Penggunaan Bangunan</label>
                  <input type="text" class="form-control" id="penggunaan_bangunan" name="penggunaan_bangunan"
                    value="{{ old('penggunaan_bangunan') }}">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="kontruksi_bangunan">Kontruksi Bangunan</label>
                  <input type="text" class="form-control" id="kontruksi_bangunan" name="kontruksi_bangunan"
                    value="{{ old('kontruksi_bangunan') }}">
                </div>

                <div class="form-group col-md-6">
                  <label for="keterangan">Keterangan</label>
                  <input type="text" class="form-control" id="keterangan" name="keterangan"
                    value="{{ old('keterangan') }}">
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
          console.log(error)
        }
      })

    });
  </script>
@endpush
