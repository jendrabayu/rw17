@extends('layouts.app')

@section('title')
  Pengguna
@endsection

@section('content')
  <div class="section-header">
    <h1>Pengguna</h1>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <ul class="nav nav-pills">
              <li class="nav-item">
                <a class="nav-link {{ !request()->get('role') ? 'active' : '' }}"
                  href="{{ route('users.index') }}">Semua
                  Pengguna</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ request()->get('role') == 'rw' ? 'active' : '' }}"
                  href="{{ route('users.index', ['role' => 'rw']) }}">Pengguna RW</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ request()->get('role') == 'rt' ? 'active' : '' }}"
                  href="{{ route('users.index', ['role' => 'rt']) }}">Pengguna RT</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        @include('partials.alerts')
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Pengguna</h4>
            <div class=" card-header-action">
              <a href="{{ route('users.create') }}" class="btn btn-primary btn-icon icon-left">
                <i class="fas fa-plus-circle"></i> Tambah
              </a>
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
      const tabelPengguna = window.LaravelDataTables['tabelPengguna'];

      $('#tabelPengguna').on('click', '.btn-delete', function() {
        const url = $(this).data('url');
        Swal.fire({
          title: 'Hapus Pengguna?',
          text: 'Pengguna yang sudah dihapus tidak dapat dikembalikan!',
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
                tabelPengguna.ajax.reload();
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
