  <div class="modal fade" role="dialog" id="modalTambah">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Penduduk Meninggal</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('penduduk-meninggal.store') }}" method="POST">
            @csrf
            <div class="form-row">
              <div class="form-group col-md-6">
                @role('rt')
                <label for="rt"><code>*</code> RT</label>
                <input type="text" readonly class="form-control" id="rt" name="rt" value="{{ $rt->nomor }}">
                <input type="text" hidden name="rt_id" value="{{ $rt->id }}">
                @endrole
              </div>
              <div class="form-group col-md-6">
                <label for="penduduk"><code>*</code> Penduduk</label>
                <select name="penduduk_id" id="penduduk" class="form-control select2">
                  <option selected disabled hidden value="">--Pilih Penduduk--</option>
                  @foreach ($penduduk as $item)
                    <option value="{{ $item->id }}">{{ $item->nik }} | {{ $item->nama }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="tanggal_kematian"><code>*</code> Tanggal Kematian</label>
                <input type="date" class="form-control" id="tanggal_kematian" name="tanggal_kematian">
              </div>
              <div class="form-group col-md-6">
                <label for="jam_kematian">Jam Kematian</label>
                <input type="time" class="form-control" id="jam_kematian" name="jam_kematian">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="_kematian">Tempat Kematian</label>
                <input type="text" class="form-control" id="_kematian" name="_kematian">
              </div>
              <div class="form-group col-md-6">
                <label for="sebab_kematian">Sebab Kematian</label>
                <input type="text" class="form-control" id="sebab_kematian" name="sebab_kematian">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="tempat_pemakaman">Tempat Pemakaman</label>
                <input type="text" class="form-control" id="tempat_pemakaman" name="tempat_pemakaman">
              </div>
            </div>

            <div class="form-group text-right mb-0">
              <button type="button" class="btn btn-secondary mr-1" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
