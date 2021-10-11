@extends('layouts.app')

@section('title')
  Log Aktivitas Pengguna
@endsection

@section('content')
  <div class="section-header">
    <h1>Log Aktivitas Pengguna</h1>
  </div>

  <div class="section-body">
    @include('partials.alerts')

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Log Aktivitas Pengguna</h4>
            <div class="card-header-action">

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
      const tabelRumah = window.LaravelDataTables['tabelRumah'];

      $('#tabelRumah').on('click', '.btn-delete', function() {
        const url = $(this).data('url');
        Swal.fire({
          title: 'Hapus Rumah?',
          text: 'Rumah yang sudah dihapus tidak dapat dikembalikan!',
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
                  title: '<b class="text-success">Success!</b> Rumah berhasil dihapus',
                })
                tabelRumah.ajax.reload();
              },
              error: function(error) {
                Toast.fire({
                  icon: 'error',
                  title: `<b class="text-danger">Gagal!</b> [${error.status}] ${error.statusText}`
                });
              }
            });
          }
        });
      });
    });
  </script>
@endpush
