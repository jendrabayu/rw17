@extends('layouts.app')

@section('title')
  Detail Penduduk Domisili
@endsection

@section('content')
  <div class="section-header">
    <div class="section-header-back">
      <a href="{{ route('penduduk-domisili.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Detail Penduduk Domisili</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item"><a href="{{ route('penduduk-domisili.index') }}">Penduduk Domisili</a></div>
      <div class="breadcrumb-item">Detail Penduduk Domisili</div>
    </div>
  </div>
  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Detail Penduduk Domisili</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-sm">
                <tr>
                  <th>NIK</th>
                  <td>{{ $pendudukDomisili->nik }}</td>
                </tr>
                <tr>
                  <th>Nama</th>
                  <td>{{ $pendudukDomisili->nama }}</td>
                </tr>
                <tr>
                  <th>Jenis Kelamin</th>
                  <td>{{ $pendudukDomisili->gender }}</td>
                </tr>
                <tr>
                  <th>Tempat Lahir</th>
                  <td>{{ $pendudukDomisili->tempat_lahir }}</td>
                </tr>
                <tr>
                  <th>Tanggal Lahir</th>
                  <td>{{ $pendudukDomisili->tanggal_lahir }}</td>
                </tr>
                <tr>
                  <th>Agama</th>
                  <td>{{ $pendudukDomisili->agama->nama }}</td>
                </tr>
                <tr>
                  <th>Pekerjaan</th>
                  <td>{{ $pendudukDomisili->pekerjaan->nama }}</td>
                </tr>
                <tr>
                  <th>Status Perkawinan</th>
                  <td>{{ $pendudukDomisili->statusPerkawinan->nama }}</td>
                </tr>
                <tr>
                  <th>Alamat</th>
                  <td>{{ $pendudukDomisili->alamat }}</td>
                </tr>
                <tr>
                  <th>Alamat Asal</th>
                  <td>{{ $pendudukDomisili->alamat_asal }}</td>
                </tr>
                <tr>
                  <th>RT/RW</th>
                  <td>{{ $pendudukDomisili->rt->nomor . '/' . $pendudukDomisili->rt->rw->nomor }}</td>
                </tr>
                <tr>
                  <th>Pendidikan</th>
                  <td>{{ $pendudukDomisili->pendidikan->nama }}</td>
                </tr>
                <tr>
                  <th>Status Hubungan Dalam Keluarga</th>
                  <td>{{ $pendudukDomisili->statusHubunganDalamKeluarga->nama }}</td>
                </tr>
                <tr>
                  <th>Golongan Darah</th>
                  <td>{{ $pendudukDomisili->darah->nama }}</td>
                </tr>
                <tr>
                  <th>Nomor Paspor</th>
                  <td>{{ $pendudukDomisili->no_paspor }}</td>
                </tr>
                <tr>
                  <th>Nomor KITAS/KITAP</th>
                  <td>{{ $pendudukDomisili->no_kitas_kitap }}</td>
                </tr>
                <tr>
                  <th>Nama Ayah</th>
                  <td>{{ $pendudukDomisili->nama_ayah }}</td>
                </tr>
                <tr>
                  <th>Nama Ibu</th>
                  <td>{{ $pendudukDomisili->nama_ibu }}</td>
                </tr>
                <tr>
                  <th>No. Hp/WhatsApp</th>
                  <td>{{ $pendudukDomisili->no_hp }}</td>
                </tr>
                <tr>
                  <th>Email</th>
                  <td>{{ $pendudukDomisili->email }}</td>
                </tr>
                <tr>
                  <th>Foto KTP</th>
                  <td>
                    @if ($pendudukDomisili->foto_ktp)
                      <div class="border p-1">
                        <img class="img-fluid" src="{{ Storage::url($pendudukDomisili->foto_ktp) }}"
                          alt="{{ $pendudukDomisili->nik }}">
                      </div>
                    @endif
                  </td>
                </tr>
              </table>
            </div>
            <p class="text-muted text-right mt-3">Last updated on
              {{ $pendudukDomisili->updated_at->isoFormat('dddd, MMMM D, YYYY h:mm A') }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection