@extends('layouts.app')

@section('title')
  Keluarga
@endsection

@section('content')
  <div class="section-header">
    <h1>Keluarga</h1>
  </div>

  <div class="section-body">
    @role('rw')
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <ul class="nav nav-pills">
              <li class="nav-item">
                <a class="nav-link {{ !request()->get('rt') ? 'active' : '' }}"
                  href="{{ route('keluarga.index') }}">Semua
                  RT</a>
              </li>
              @foreach ($rt as $id => $nomor)
                <li class="nav-item">
                  <a class="nav-link {{ request()->get('rt') == $nomor ? 'active' : '' }}"
                    href="{{ route('keluarga.index', ['rt' => $id]) }}">RT
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
            <h4>Keluarga</h4>
            <div class=" card-header-action">
              <div class="d-inline mx-1">
                <button class="btn btn-success btn-icon icon-left" type="button" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-file-export"></i> Exports
                </button>
                <div class="dropdown-menu">
                  @foreach ($fileTypes as $type)
                    <a class="dropdown-item"
                      href="{{ route('exports.keluarga', array_merge(['file_type' => $type], request()->all())) }}">{{ Str::upper($type) }}</a>
                  @endforeach
                </div>
              </div>
              <a href="{{ route('keluarga.create') }}" class="btn btn-primary btn-icon icon-left">
                <i class="fas fa-plus-circle"></i> Tambah
              </a>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover table-sm" id="tabelKeluarga">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>No. Kartu Keluarga</th>
                    <th>Kepala Keluarga</th>
                    <th>Jumlah Orang</th>
                    <th>Alamat</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($keluarga as $keluarga)
                    <tr>
                      <td class="text-center">
                        <div class="btn-group btn-group-sm">
                          <a href="{{ route('keluarga.edit', $keluarga->id) }}" class="btn btn-warning btn-icon">
                            <i class="fas fa-pencil-alt"></i>
                          </a>
                          <a href="{{ route('keluarga.show', $keluarga->id) }}" class="btn btn-info btn-icon">
                            <i class="far fa-eye"></i>
                          </a>
                          <button data-url="{{ route('keluarga.destroy', $keluarga->id) }}" type="button"
                            class="btn btn-danger btn-icon btn-delete">
                            <i class="fas fa-trash-alt"></i>
                          </button>
                        </div>
                      </td>
                      <td>{{ $keluarga->nomor }}</td>
                      <td>
                        @if ($keluarga->kepala_keluarga)
                          <a
                            href="{{ route('penduduk.show', $keluarga->kepala_keluarga->id) }}">{{ $keluarga->kepala_keluarga->nama }}</a>
                        @endif
                      </td>
                      <td>{{ $keluarga->penduduk->count() }}</td>
                      <td>{{ $keluarga->alamat }}</td>
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

  <form action="" method="POST" hidden id="form-delete">@csrf @method('DELETE')</form>
@endsection

@push('scripts')
  <script>
    $('#tabelKeluarga').DataTable({
      language: {
        url: 'https://cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json'
      }
    });

    $('#tabelKeluarga').on('click', '.btn-delete', function() {
      const form = $('#form-delete');
      form.prop('action', $(this).data('url'));
      Swal.fire({
        title: 'Hapus Keluarga?',
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
