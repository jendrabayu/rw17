@extends('layouts.app')

@section('title')
  Detail Keluarga
@endsection

@section('content')
  <div class="section-header">
    <div class="section-header-back">
      <a href="{{ url()->previous() }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Detail Keluarga</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item"><a href="{{ route('keluarga.index') }}">Keluarga</a></div>
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
            <h4>Detail Keluarga</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-sm table-striped">
                <tr>
                  <th>Kepala Keluarga</th>
                  <td>
                    @php
                      $kepala_keluarga = $keluarga
                          ->penduduk()
                          ->whereHas('statusHubunganDalamKeluarga', function ($q) {
                              $q->where('nama', 'KEPALA KELUARGA');
                          })
                          ->first();
                    @endphp
                    {{ $kepala_keluarga ? $kepala_keluarga->nama : '' }}
                  </td>
                </tr>
                <tr>
                  <th>Nomor</th>
                  <td>{{ $keluarga->nomor }}</td>
                </tr>
                <tr>
                  <th>RT/RW</th>
                  <td>{{ $keluarga->rt->nomor . '/' . $keluarga->rt->rw->nomor }}</td>
                </tr>
                <tr>
                  <th>Alamat</th>
                  <td>{{ $keluarga->alamat }}</td>
                </tr>
                <tr>
                  <th>Kelurahan</th>
                  <td>SUMBERSARI</td>
                </tr>
                <tr>
                  <th>Kecamatan</th>
                  <td>SUMBERSARI</td>
                </tr>
                <tr>
                  <th>Kabupaten</th>
                  <td>JEMBER</td>
                </tr>
                <tr>
                  <th>Provinsi</th>
                  <td>JAWA TIMUR</td>
                </tr>
                <tr>
                  <th>Foto Kartu Keluarga</th>
                  <td>
                    @if ($keluarga->foto_kk)
                      <div class="border p-1">
                        <img class="img-fluid" src="{{ Storage::url($keluarga->foto_kk) }}"
                          alt="{{ $keluarga->nomor }}">
                      </div>
                    @endif
                  </td>
                </tr>
              </table>
            </div>

            @if ($keluarga->penduduk->count())
              <div class="table-responsive mt-3">
                <table class="table table-sm table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>NIK</th>
                      <th>Nama</th>
                      <th>Tempat Lahir</th>
                      <th>Tanggal Lahir</th>
                      <th>Jenis Kelamin</th>
                      <th>Gol. Darah</th>
                      <th>Agama</th>
                      <th>Status Perkawinan</th>
                      <th>Pekerjaan</th>
                      <th>Pendidikan</th>
                      <th>Kewarganegaraan</th>
                      <th>Status Hubungan Dalam Keluarga</th>
                      <th>No. Paspor</th>
                      <th>No. KITAS/KITAP</th>
                      <th>Nama Ayah</th>
                      <th>Nama Ibu</th>
                      <th>Email</th>
                      <th>No. Hp/WhatsApp</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($keluarga->penduduk as $penduduk)
                      <tr>
                        <td><a href="{{ route('penduduk.show', $penduduk->id) }}">{{ $penduduk->nik }}</a></td>
                        <td>{{ $penduduk->nama }}</td>
                        <td>{{ $penduduk->tempat_lahir }}</td>
                        <td>{{ $penduduk->tanggal_lahir }}</td>
                        <td>{{ $penduduk->gender }}</td>
                        <td>{{ $penduduk->darah->nama }}</td>
                        <td>{{ $penduduk->agama->nama }}</td>
                        <td>{{ $penduduk->statusPerkawinan->nama }}</td>
                        <td>{{ $penduduk->pekerjaan->nama }}</td>
                        <td>{{ $penduduk->pendidikan->nama }}</td>
                        <td>{{ $penduduk->kewarganegaraan_text }}</td>
                        <td>{{ $penduduk->statusHubunganDalamKeluarga->nama }}</td>
                        <td>{{ $penduduk->no_paspor }}</td>
                        <td>{{ $penduduk->no_kitas_kitap }}</td>
                        <td>{{ $penduduk->nama_ayah }}</td>
                        <td>{{ $penduduk->nama_ibu }}</td>
                        <td>{{ $penduduk->email }}</td>
                        <td>{{ $penduduk->no_hp }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @else
              <p class="text-center text-title">~Data penduduk belum tersedia~</p>
            @endif
            <p class="text-muted text-right mt-3">Last updated on
              {{ $keluarga->updated_at->isoFormat('dddd, MMMM D, YYYY h:mm A') }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
