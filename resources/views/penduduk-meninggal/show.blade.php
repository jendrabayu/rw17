@extends('layouts.app')

@section('title')
  Detail Penduduk Meninggal
@endsection

@section('content')
  <div class="section-header">
    <div class="section-header-back">
      <a href="{{ url()->previous() }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Detail Penduduk Meninggal</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item"><a href="{{ route('penduduk-meninggal.index') }}">Penduduk Meninggal</a></div>
      <div class="breadcrumb-item">Detail Penduduk Meninggal</div>
    </div>
  </div>
  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card card-primary">
          <div class="card-header">
            <h4>Detail Penduduk Meninggal</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-sm table-striped table-bordered" id="detail-penduduk-table">
                <tr>
                  <th>NIK</th>
                  <td>{{ $pendudukMeninggal->nik }}</td>
                </tr>
                <tr>
                  <th>Nama</th>
                  <td>{{ $pendudukMeninggal->nama }}</td>
                </tr>
                <tr>
                  <th>Tanggal Kematian</th>
                  <td>{{ $pendudukMeninggal->tanggal_kematian->format('d-m-Y') }}</td>
                </tr>
                <tr>
                  <th>Jam Kematian</th>
                  <td>{{ $pendudukMeninggal->jam_kematian->format('H:i') }}</td>
                </tr>
                <tr>
                  <th>Tempat Kematian</th>
                  <td>{{ $pendudukMeninggal->tempat_kematian }}</td>
                </tr>
                <tr>
                  <th>Sebab Kematian</th>
                  <td>{{ $pendudukMeninggal->sebab_kematian }}</td>
                </tr>
                <tr>
                  <th>Tempat Pemakaman</th>
                  <td>{{ $pendudukMeninggal->tempat_pemakaman }}</td>
                </tr>
                <tr>
                  <th>Jenis Kelamin</th>
                  <td>{{ $pendudukMeninggal->jenis_kelamin_text }}</td>
                </tr>
                <tr>
                  <th>Golongan Darah</th>
                  <td>{{ $pendudukMeninggal->darah->nama }}</td>
                </tr>
                <tr>
                  <th>Alamat</th>
                  <td>{{ $pendudukMeninggal->alamat }}</td>
                </tr>
                <tr>
                  <th>RT / RW</th>
                  <td>{{ $pendudukMeninggal->rt->nomor . '/' . $pendudukMeninggal->rt->rw->nomor }}
                  </td>
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
                  <th>Tempat Lahir</th>
                  <td>{{ $pendudukMeninggal->tempat_lahir }}</td>
                </tr>
                <tr>
                  <th>Tanggal Lahir</th>
                  <td>{{ $pendudukMeninggal->tanggal_lahir->format('d-m-Y') }}</td>
                </tr>
                <tr>
                  <th>Agama</th>
                  <td>{{ $pendudukMeninggal->agama->nama }}</td>
                </tr>
                <tr>
                  <th>Pendidikan</th>
                  <td>{{ $pendudukMeninggal->pendidikan->nama }}</td>
                </tr>
                <tr>
                  <th>Pekerjaan</th>
                  <td>{{ $pendudukMeninggal->pekerjaan->nama }}</td>
                </tr>
                <tr>
                  <th>Status Perkawinan</th>
                  <td>{{ $pendudukMeninggal->statusPerkawinan->nama }}</td>
                </tr>
                <tr>
                  <th>Kewarganegaraan</th>
                  <td>{{ $pendudukMeninggal->kewarganegaraan_text }}</td>
                </tr>
                <tr>
                  <th>Nama Ayah</th>
                  <td>{{ $pendudukMeninggal->nama_ayah }}</td>
                </tr>
                <tr>
                  <th>Nama Ibu</th>
                  <td>{{ $pendudukMeninggal->nama_ibu }}</td>
                </tr>
                <tr>
                  <th>Foto KTP</th>
                  <td>
                    @if ($pendudukMeninggal->foto_ktp)
                      <div class="img-thumbnail">
                        <img class="w-100" src="{{ Storage::url($pendudukMeninggal->foto_ktp) }}"
                          alt="{{ $pendudukMeninggal->nik }}">
                      </div>
                    @endif
                  </td>
                </tr>
              </table>
            </div>
            <p class="text-muted text-right mt-3">Last updated on
              {{ $pendudukMeninggal->updated_at->isoFormat('dddd, MMMM D, YYYY h:mm A') }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
