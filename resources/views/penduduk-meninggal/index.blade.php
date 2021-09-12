@extends('layouts.app')

@section('title')
  Penduduk Meninggal
@endsection

@section('content')
  <div class="section-header">
    <h1>Penduduk Meninggal</h1>
  </div>
  <div class="section-body">
    @role('rw')
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <ul class="nav nav-pills">
              @php
                $all_requests = request()->all();
                unset($all_requests['rt']);
              @endphp
              <li class="nav-item">
                <a class="nav-link {{ !request()->has('rt') ? 'active' : '' }}"
                  href="{{ route('penduduk-meninggal.index', $all_requests) }}">Semua RT</a>
              </li>
              @foreach ($rt as $id => $nomor)
                <li class="nav-item">
                  <a class="nav-link {{ request()->get('rt') == $id ? 'active' : '' }}"
                    href="{{ route('penduduk-meninggal.index', array_merge(['rt' => $id], $all_requests)) }}">RT
                    {{ ltrim($nomor, '0') }}</a>
                </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
    @endrole

    <div class="row">
      <div class="col-12">
        @include('partials.alerts')
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Penduduk Meninggal</h4>
            <div class="card-header-action">
              <div class="d-inline mx-1">
                <button class="btn btn-success btn-icon icon-left" type="button" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false"><i class="fas fa-file-export"></i>
                  Exports</button>
                <div class="dropdown-menu">
                  @php
                    $exportFormats = ['PDF', 'XLSX', 'CSV', 'XLS'];
                  @endphp
                  @foreach ($exportFormats as $format)
                    <a class="dropdown-item"
                      href="{{ route('exports.penduduk_meninggal', array_merge(['format' => $format], request()->all())) }}">{{ $format }}</a>
                  @endforeach
                </div>
              </div>
              <button class="btn btn-primary btn-icon icon-left" data-toggle="modal" data-target="#modalTambah"><i
                  class="fas fa-plus-circle"></i> Tambah</button>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover table-sm" id="tabelPendudukMeninggal">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Tanggal Kematian</th>
                    <th>Jam Kematian</th>
                    <th>Tempat Kematian</th>
                    <th>Sebab Kematian</th>
                    <th>Tempat Pemakaman</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($pendudukMeninggal as $item)
                    <tr>
                      <td class="text-center">
                        <div class="btn-group btn-group-sm">
                          <a href="{{ route('penduduk-meninggal.edit', $item->id) }}" class="btn btn-warning btn-icon">
                            <i class="fas fa-pencil-alt"></i>
                          </a>
                          <a href="{{ route('penduduk-meninggal.show', $item->id) }}" class="btn btn-info btn-icon">
                            <i class="far fa-eye"></i>
                          </a>
                          <button data-url="{{ route('penduduk-meninggal.destroy', $item->id) }}" type="button"
                            class="btn btn-danger btn-icon btn-delete">
                            <i class="fas fa-trash-alt"></i>
                          </button>
                        </div>
                      </td>
                      <td>{{ $item->nik }}</td>
                      <td>{{ $item->nama }}</td>
                      <td>{{ $item->tanggal_kematian }}</td>
                      <td>{{ $item->jam_kematian }}</td>
                      <td>{{ $item->tempat_kematian }}</td>
                      <td>{{ $item->sebab_kematian }}</td>
                      <td>{{ $item->tempat_pemakaman }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <form action="" id="form-delete" hidden method="POST">@csrf @method('DELETE')</form>
@endsection

@section('modals')
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
                <label for="rt">RT <code>*</code></label>
                <input type="text" class="form-control" id="rt" name="rt" value="RT {{ $rt->nomor }}" disabled>
                <input type="text" hidden name="rt_id" value="{{ $rt->id }}">
                @endrole

                @role('rw')
                <label for="rt">RT <code>*</code></label>
                <select name="rt_id" id="rt" class="custom-select">
                  <option selected disabled hidden value="">--Pilih RT--</option>
                  @foreach ($rt as $id => $nomor)
                    <option value="{{ $id }}">RT {{ ltrim($nomor, '0') }}</option>
                  @endforeach
                </select>
                @endrole
              </div>
              <div class="form-group col-md-6">
                <label for="penduduk">Penduduk <code>*</code></label>
                @role('rt')
                <select name="penduduk_id" id="penduduk" class="form-control select2">
                  <option selected disabled hidden value="">--Pilih Penduduk--</option>
                  @foreach ($penduduk as $item)
                    <option value="{{ $item->id }}">{{ $item->nik }} | {{ $item->nama }}</option>
                  @endforeach
                </select>
                @endrole

                @role('rw')
                <select name="penduduk_id" id="penduduk" class="form-control select2" disabled>
                </select>
                @endrole
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="tanggal_kematian">Tanggal Kematian <code>*</code></label>
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
@endsection


@push('scripts')
  <script>
    $('#tabelPendudukMeninggal').DataTable({
      language: {
        url: 'https://cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json'
      }
    });

    $('#tabelPendudukMeninggal').on('click', '.btn-delete', function() {
      const form = $('#form-delete');
      form.prop('action', $(this).data('url'));
      Swal.fire({
        title: 'Hapus Penduduk Meninggal?',
        text: 'Data yang sudah dihapus tidak dapat dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#47597E',
        cancelButtonColor: '#cdd3d8',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',
        reverseButtons: true,
      }).then((result) => {
        if (result.isConfirmed) {
          form.trigger('submit');
        }
      });
    });

    $('#rt').on('change', function(e) {
      const rtId = e.target.value;
      $.ajax({
        url: '/ajax/penduduk/' + rtId,
        type: 'get',
        success: function(data) {
          $('#penduduk').empty();
          $('#penduduk').append('<option selected disabled hidden>--Pilih Penduduk--</option>');

          $.each(data, function(i, v) {
            $('#penduduk').append(`<option value="${v.id}">${v.nik} | ${v.nama}</option>`);
          });
          $('#penduduk').removeAttr('disabled');
        },
        error: function(error) {
          console.log(error)
        }
      })

    });
  </script>
@endpush
