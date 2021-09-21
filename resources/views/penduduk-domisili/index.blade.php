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
              {{ $dataTable->table(['class' => 'table table-striped table-hover table-borderless w-100']) }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <form action="" id="form-delete" hidden method="POST">@csrf @method('DELETE')</form>
@endsection


@push('scripts')
  {{ $dataTable->scripts() }}
  <script>
    $(function() {
      const tabelPendudukDomisili = window.LaravelDataTables['tabelPendudukDomisili'];

      $('#tabelPendudukDomisili').on('click', '.btn-delete', function() {
        const url = $(this).data('url');
        Swal.fire({
          title: 'Hapus Penduduk Domisili?',
          text: 'Penduduk Domisili yang sudah dihapus tidak dapat dikembalikan!',
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
                  title: '<b class="text-success">Success!</b> Pengguna berhasil dihapus',
                })
                tabelPendudukDomisili.ajax.reload();
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
