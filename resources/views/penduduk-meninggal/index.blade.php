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

    @include('partials.alerts')

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Penduduk Meninggal</h4>
            <div class="card-header-action">
              <x-export-button>
                @foreach ($fileTypes as $type)
                  <a class="dropdown-item"
                    href="{{ route('exports.penduduk_meninggal', array_merge(['file_type' => $type], request()->all())) }}">{{ Str::upper($type) }}</a>
                @endforeach
              </x-export-button>
              @role('rt')
              <button class="btn btn-primary btn-icon icon-left" data-toggle="modal" data-target="#modalTambah"><i
                  class="fas fa-plus-circle"></i> Tambah</button>
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
  @include('penduduk-meninggal.modal')
@endsection


@push('scripts')
  {{ $dataTable->scripts() }}
  <script>
    $(function() {
      const tabelPendudukMeninggal = window.LaravelDataTables['tabelPendudukMeninggal'];

      $('#tabelPendudukMeninggal').on('click', '.btn-delete', function() {
        const url = $(this).data('url');
        Swal.fire({
          title: 'Hapus Penduduk Meninggal?',
          text: 'Penduduk Meninggal yang sudah dihapus tidak dapat dikembalikan!',
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
                  title: '<b class="text-success">Success!</b> Penduduk Meninggal berhasil dihapus',
                })
                tabelPendudukMeninggal.ajax.reload();
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
