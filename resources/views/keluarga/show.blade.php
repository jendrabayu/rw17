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
        <div class="card card-primary">
          <div class="card-header">
            <h4> {{ $keluarga->kepala_keluarga ? 'Keluarga ' . $keluarga->kepala_keluarga->nama : 'Detail Keluarga' }}
            </h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-sm">
                <tr>
                  <th>Kepala Keluarga</th>
                  <td>
                    {{ $keluarga->kepala_keluarga ? $keluarga->kepala_keluarga->nama : '' }}
                  </td>
                </tr>
                <tr>
                  <th>No. Kartu Keluarga</th>
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
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-sm">
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
                      <td>{{ $penduduk->nik }}</td>
                      <td>{{ $penduduk->nama }}</td>
                      <td>{{ $penduduk->tempat_lahir }}</td>
                      <td>{{ $penduduk->tanggal_lahir }}</td>
                      <td>{{ $penduduk->jenis_kelamin_text }}</td>
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
            <p class="text-muted text-right mt-3 mb-0">Terakhir diubah pada
              {{ $keluarga->updated_at->isoFormat('dddd, D MMMM YYYY h:mm A') }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
