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
              <table class="table table-bordered table-striped table-hover table-sm" id="tabelPengguna">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>No. Hp</th>
                    <th>Role</th>
                    <th>RT</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($users as $item)
                    <tr>
                      <td class="text-center">
                        <div class="btn-group btn-group-sm ">
                          <a href="{{ route('users.edit', $item->id) }}" class="btn btn-warning btn-icon">
                            <i class="fas fa-pencil-alt"></i>
                          </a>
                          <button data-url="{{ route('users.destroy', $item->id) }}" type="button"
                            class="btn btn-danger btn-icon btn-delete">
                            <i class="fas fa-trash-alt"></i>
                          </button>
                        </div>
                      </td>
                      <td>{{ $item->name }}</td>
                      <td>{{ $item->username }}</td>
                      <td>{{ $item->email }}</td>
                      <td>{{ $item->no_hp }}</td>
                      <td>{{ $item->role }}</td>
                      <td>{{ $item->rt->nomor }}</td>
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
    $('#tabelPengguna').DataTable({
      language: {
        url: 'https://cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json'
      }
    });

    $('#tabelPengguna').on('click', '.btn-delete', function() {
      const form = $('#form-delete');
      form.prop('action', $(this).data('url'));
      Swal.fire({
        title: 'Hapus Pengguna?',
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
