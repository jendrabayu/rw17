<div class="modal fade" id="filterModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Filter Penduduk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('penduduk.index') }}" method="GET" id="filter-form">

          <div class="form-row">
            <div class="form-group col-lg-6">
              <label for="agama">Agama</label>
              <select name="agama" id="agama" class="form-control select2">
                <option selected hidden disabled value="">--Pilih Agama--</option>
                @foreach ($agama as $id => $nama)
                  <option {{ request()->get('agama') == $id ? 'selected' : '' }} value="{{ $id }}">
                    {{ $nama }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-lg-6">
              <label for="pekerjaan">Pekerjaan</label>
              <select name="pekerjaan" id="pekerjaan" class="form-control select2">
                <option selected hidden disabled value="">--Pilih Pekerjaan--</option>
                @foreach ($pekerjaan as $id => $nama)
                  <option {{ request()->get('pekerjaan') == $id ? 'selected' : '' }} value="{{ $id }}">
                    {{ $nama }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-lg-6">
              <label for="darah">Gol. Darah</label>
              <select name="darah" id="darah" class="form-control select2">
                <option selected hidden disabled value="">--Pilih Gol. Darah--</option>
                @foreach ($darah as $id => $nama)
                  <option {{ request()->get('darah') == $id ? 'selected' : '' }} value="{{ $id }}">
                    {{ $nama }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-lg-6">
              <label for="pendidikan">Pendidikan</label>
              <select name="pendidikan" id="pendidikan" class="form-control select2">
                <option selected hidden disabled value="">--Pilih Pendidikan--</option>
                @foreach ($pendidikan as $id => $nama)
                  <option {{ request()->get('pendidikan') == $id ? 'selected' : '' }} value="{{ $id }}">
                    {{ $nama }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-lg-6">
              <label for="status_perkawinan">Status Perkawinan</label>
              <select name="status_perkawinan" id="status_perkawinan" class="custom-select">
                <option selected hidden disabled value="">--Pilih Status Perkawinan--</option>
                @foreach ($statusPerkawinan as $id => $nama)
                  <option {{ request()->get('status_perkawinan') == $id ? 'selected' : '' }}
                    value="{{ $id }}">
                    {{ $nama }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-lg-6">
              <label for="status_hubungan_dalam_keluarga">Status Hubungan Dalam Keluarga</label>
              <select name="status_hubungan_dalam_keluarga" id="status_hubungan_dalam_keluarga"
                class="form-control select2">
                <option selected hidden disabled value="">--Pilih Status Hubungan Dalam Keluarga--</option>
                @foreach ($statusHubunganDalamKeluarga as $id => $nama)
                  <option {{ request()->get('status_hubungan_dalam_keluarga') == $id ? 'selected' : '' }}
                    value="{{ $id }}">{{ $nama }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-lg-6">
              <label for="jenis_kelamin">Jenis Kelamin</label>
              <select name="jenis_kelamin" id="jenis_kelamin" class="custom-select">
                <option selected disabled hidden value="">--Pilih Jenis Kelamin--</option>
                <option {{ request()->get('jenis_kelamin') == 'l' ? 'selected' : '' }} value="l">Laki-Laki</option>
                <option {{ request()->get('jenis_kelamin') == 'p' ? 'selected' : '' }} value="p">Perempuan</option>
              </select>
            </div>
            <div class="form-group col-lg-6">
              <label>Rentang Usia</label>
              <div class="form-row">
                <div class="col-6">
                  <input type="number" id="age_min" name="age_min" class="form-control mr-2" min="1" max="150"
                    placeholder="Min" maxlength="3" value="{{ request()->get('age_min') }}">
                </div>
                <div class="col-6">
                  <input type="number" id="age_max" name="age_max" class="form-control" min="1" max="150"
                    placeholder="Max" maxlength="3" value="{{ request('age_max') }}" disabled>
                </div>
              </div>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-lg-6">
              <button class="btn btn-outline-primary btn-block btn-icon icon-left" type="button" id="btnResetFilter">
                <i class="fas fa-trash-restore-alt"></i> Reset Filter
              </button>
            </div>
          </div>

          <div class="form-group mb-0 text-right">
            <button type="button" class="btn btn-secondary mr-1" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Terapkan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalImport" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Impor Penduduk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-light" role="alert">
          Lihat persyaratan struktur data <strong><a target="_blank"
              href="https://docs.google.com/spreadsheets/d/1vuwvKnicy-WzHWznI6B_hQrk08D-6NeNE88UGCYbl8I/edit?usp=sharing">disini.</a></strong>
        </div>
        <form action="{{ route('import_penduduk') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="file_penduduk">File Penduduk</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="file_penduduk" name="file_penduduk"
                accept=".xlsx, .scv, .xls">
              <label class="custom-file-label" for="file_penduduk">Choose file</label>
            </div>
            <small class="form-text text-muted">Ukuran maksimal 3MB, format: XLSX, CSV dan XLS</small>
          </div>

          <div class="form-group text-right mb-0">
            <button type="button" class="btn btn-secondary mr-1" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@push('scripts')
  <script>
    $('input#age_min').on('input', function(e) {
      if (e.target.value.length) {
        $('input#age_max').removeAttr('disabled');
      } else {
        $('input#age_max').attr('disabled', true);
      }
    });

    $('#btnResetFilter').on('click', function(e) {
      $('select#agama').val(null).trigger('change');
      $('select#pekerjaan').val(null).trigger('change');
      $('select#darah').val(null).trigger('change');
      $('select#pendidikan').val(null).trigger('change');
      $('select#status_perkawinan').val(null).trigger('change');
      $('select#status_hubungan_dalam_keluarga').val(null).trigger('change');
      $('select#jenis_kelamin').val(null).trigger('change');
      $('input#age_min').val(null);
      $('input#age_max').val(null);
    });
  </script>
@endpush
