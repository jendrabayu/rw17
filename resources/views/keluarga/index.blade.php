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
                <a class="nav-link {{ !request()->get('rt') ? 'active' : '' }}" href="{{ route('keluarga.index') }}">
                  Semua RT
                </a>
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

    @include('partials.alerts')

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Keluarga</h4>
            <div class=" card-header-action">
              <x-export-button>
                @foreach ($fileTypes as $type)
                  <a class="dropdown-item"
                    href="{{ route('exports.keluarga', array_merge(['file_type' => $type], request()->all())) }}">{{ Str::upper($type) }}</a>
                @endforeach
              </x-export-button>
              @role('rt')
              <a href="{{ route('keluarga.create') }}" class="btn btn-primary btn-icon icon-left">
                <i class="fas fa-plus-circle"></i> Tambah
              </a>
              @endrole('rt')
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              {{ $dataTable->table(['class' => 'table table-striped table-hover table-borderless w-100']) }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  {{ $dataTable->scripts() }}
  <script>
    $(function() {
      const tabelKeluarga = window.LaravelDataTables['tabelKeluarga'];

      $('#tabelKeluarga').on('click', '.btn-delete', function() {
        const url = $(this).data('url');
        Swal.fire({
          title: 'Hapus Keluarga?',
          text: 'Keluarga yang sudah dihapus tidak dapat dikembalikan!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Hapus',
          cancelButtonText: 'Batal',
          reverseButtons: true,
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url,
              type: 'DELETE',
              data: {
                _token: '{{ csrf_token() }}'
              },
              success: function() {
                Toast.fire({
                  icon: 'success',
                  title: '<b class="text-success">Success!</b> Keluarga berhasil dihapus',
                })
                tabelKeluarga.ajax.reload();
              },
              error: function(error) {
                Toast.fire({
                  icon: 'error',
                  title: `<b class="text-danger">Gagal!</b> [${error.status}] ${error.statusText}`
                })
              }
            });
          }
        });
      });
    });
  </script>
@endpush
