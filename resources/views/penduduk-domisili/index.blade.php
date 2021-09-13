@extends('layouts.app')

@section('title')
  Penduduk Domisili
@endsection

@section('content')
  <div class="section-header">
    <h1>Penduduk Domisili</h1>
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
                  href="{{ route('penduduk-domisili.index', $all_requests) }}">Semua RT</a>
              </li>
              @foreach ($rt as $id => $nomor)
                <li class="nav-item">
                  <a class="nav-link {{ request()->get('rt') == $id ? 'active' : '' }}"
                    href="{{ route('penduduk-domisili.index', array_merge(['rt' => $id], $all_requests)) }}">RT
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
            <h4>Penduduk Domisili</h4>
            <div class="card-header-action">
              <div class="d-inline mx-1">
                <button class="btn btn-success btn-icon icon-left" type="button" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false"><i class="fas fa-file-export"></i>
                  Exports</button>
                <div class="dropdown-menu">
                  @foreach ($fileTypes as $type)
                    <a class="dropdown-item"
                      href="{{ route('exports.penduduk_domisili', array_merge(['file_type' => $type], request()->all())) }}">{{ Str::upper($type) }}</a>
                  @endforeach
                </div>
              </div>
              <a href="{{ route('penduduk-domisili.create') }}" class="btn btn-primary btn-icon icon-left"><i
                  class="fas fa-plus-circle"></i> Tambah</a>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover table-sm" id="tabelPendudukDomisili">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Usia</th>
                    <th>Agama</th>
                    <th>Pekerjaan</th>
                    <th>Status Perkawinan</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($pendudukDomisili as $penduduk)
                    <tr>
                      <td class="text-center">
                        <div class="btn-group btn-group-sm">
                          <a href="{{ route('penduduk-domisili.edit', $penduduk->id) }}"
                            class="btn btn-warning btn-icon">
                            <i class="fas fa-pencil-alt"></i>
                          </a>
                          <a href="{{ route('penduduk-domisili.show', $penduduk->id) }}" class="btn btn-info btn-icon">
                            <i class="far fa-eye"></i>
                          </a>
                          <button data-url="{{ route('penduduk-domisili.destroy', $penduduk->id) }}" type="button"
                            class="btn btn-danger btn-icon btn-delete">
                            <i class="fas fa-trash-alt"></i>
                          </button>
                        </div>
                      </td>
                      <td>{{ $penduduk->nik }}</td>
                      <td>{{ $penduduk->nama }}</td>
                      <td>{{ $penduduk->jenis_kelamin_text }}</td>
                      <td>{{ $penduduk->tempat_lahir }}</td>
                      <td>{{ $penduduk->tanggal_lahir }}</td>
                      <td>{{ $penduduk->usia }}</td>
                      <td>{{ $penduduk->agama->nama }}</td>
                      <td>{{ $penduduk->pekerjaan->nama }}</td>
                      <td>{{ $penduduk->statusPerkawinan->nama }}</td>
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


@push('scripts')
  <script>
    $('#tabelPendudukDomisili').DataTable({
      language: {
        url: 'https://cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json'
      }
    });

    $('#tabelPendudukDomisili').on('click', '.btn-delete', function() {
      const form = $('#form-delete');
      form.prop('action', $(this).data('url'));
      Swal.fire({
        title: 'Hapus Penduduk Domisili?',
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
  </script>
@endpush
