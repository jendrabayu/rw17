@extends('layouts.app')

@section('title')
  Detail Rumah
@endsection

@section('content')
  <div class="section-header">
    <div class="section-header-back">
      <a href="{{ url()->previous() }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Detail Rumah</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item"><a href="{{ route('rumah.index') }}">Rumah</a></div>
      <div class="breadcrumb-item">Detail Keluarga</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-12">
        @include('partials.alerts')
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Detail Rumah</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive mb-4">
              <table class="table table-bordered table-sm table-striped">
                <tr>
                  <th>RT / RW</th>
                  <td>{{ $rumah->rt->nomor . '/' . $rumah->rt->rw->nomor }}</td>
                </tr>
                <tr>
                  <th>Alamat</th>
                  <td>{{ $rumah->alamat }}</td>
                </tr>
                <tr>
                  <th>Nomor Rumah</th>
                  <td>{{ $rumah->nomor }}</td>
                </tr>
                <tr>
                  <th>Tipe Bangunan</th>
                  <td>{{ $rumah->tipe_bangunan }}</td>
                </tr>
                <tr>
                  <th>Kontruksi Bangunan</th>
                  <td>{{ $rumah->kontruksi_bangunan }}</td>
                </tr>
                <tr>
                  <th>Keterangan</th>
                  <td>{{ $rumah->keterangan }}</td>
                </tr>
              </table>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-sm table-hover">
                <thead>
                  <tr>
                    <th>No. Kartu Keluarga</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Status Hubungan Dalam Keluarga</th>
                    <th>Status Perkawinan</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($rumah->keluarga as $keluarga)
                    <tr>
                      <td><a href="{{ route('keluarga.show', $keluarga->id) }}">{{ $keluarga->nomor }}</a></td>
                      <td colspan="4"></td>
                      @foreach ($keluarga->penduduk as $penduduk)
                    <tr>
                      <td></td>
                      <td><a href="{{ route('penduduk.show', $penduduk->id) }}">{{ $penduduk->nik }}</a></td>
                      <td>{{ $penduduk->nama }}</td>
                      <td>{{ $penduduk->statusHubunganDalamKeluarga->nama }}</td>
                      <td>{{ $penduduk->statusPerkawinan->nama }}</td>
                    </tr>
                  @endforeach
                  </tr>
                  @endforeach
                </tbody>
              </table>

              <table class="table table-bordered table-striped table-sm table-hover mt-5">
                <thead>
                  <tr>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Status Perkawinan</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($rumah->pendudukDomisili as $pendudukDomisili)
                    <tr>
                      <td><a
                          href="{{ route('penduduk.show', $pendudukDomisili->id) }}">{{ $pendudukDomisili->nik }}</a>
                      </td>
                      <td>{{ $pendudukDomisili->nama }}</td>
                      <td>{{ $pendudukDomisili->statusPerkawinan->nama }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <p class="text-muted text-right mt-3">Terakhir diupdate pada
              {{ $rumah->updated_at->isoFormat('dddd, D MMMM YYYY h:mm A') }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
