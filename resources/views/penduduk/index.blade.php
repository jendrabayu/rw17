@extends('layouts.app')

@section('title')
  Penduduk
@endsection

@section('content')
  <div class="section-header">
    <h1>Penduduk</h1>
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
                  href="{{ route('penduduk.index', $all_requests) }}">Semua RT</a>
              </li>
              @foreach ($rt as $id => $nomor)
                <li class="nav-item">
                  <a class="nav-link {{ request()->get('rt') == $id ? 'active' : '' }}"
                    href="{{ route('penduduk.index', array_merge(['rt' => $id], $all_requests)) }}">RT
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
            <h4>Penduduk</h4>
            <div class="card-header-action">
              <button class="btn btn-light btn-icon icon-left" data-toggle="modal" data-target="#filterModal">
                <i class="fas fa-filter"></i> Filter
              </button>
              <x-export-button>
                @foreach ($fileTypes as $type)
                  <a class="dropdown-item"
                    href="{{ route('exports.penduduk', array_merge(['file_type' => $type], request()->all())) }}">{{ Str::upper($type) }}</a>
                @endforeach
              </x-export-button>
              @role('rt')
              <button type="button" class="btn btn-success btn-icon icon-left" data-toggle="modal"
                data-target="#modalImport">
                <i class="fas fa-file-import"></i> Import
              </button>
              <a href="{{ route('penduduk.create') }}" class="btn btn-primary btn-icon icon-left"><i
                  class="fas fa-plus-circle"></i> Tambah
              </a>
              @endrole
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

@section('modals')
  @include('penduduk.modal')
@endsection

@push('scripts')
  {{ $dataTable->scripts() }}
  <script>
    $(function() {
      const tabelPenduduk = window.LaravelDataTables['tabelPenduduk'];
      $('#tabelPenduduk').on('click', '.btn-delete', function() {
        const url = $(this).data('url');
        Swal.fire({
          title: 'Hapus Penduduk?',
          text: 'Penduduk yang sudah dihapus tidak dapat dikembalikan!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Hapus',
          cancelButtonText: 'Batal',
          reverseButtons: true
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
                  title: '<b class="text-success">Success!</b> Penduduk berhasil dihapus',
                })
                tabelPenduduk.ajax.reload();
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
