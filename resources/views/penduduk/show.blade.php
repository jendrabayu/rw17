@extends('layouts.app')

@section('title')
  Detail Penduduk
@endsection

@section('content')
  <div class="section-header">
    <div class="section-header-back">
      <a href="{{ url()->previous() }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Detail Penduduk</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item"><a href="{{ route('penduduk.index') }}">Penduduk</a></div>
      <div class="breadcrumb-item">Detail Penduduk</div>
    </div>
  </div>
  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card card-primary">
          <div class="card-header">
            <h4>{{ $penduduk->nama }}</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-sm table-striped table-bordered" id="detail-penduduk-table">
                <tr>
                  <th>Nomor Kartu Keluarga</th>
                  <td>{{ $penduduk->keluarga->nomor }}</td>
                </tr>
                <tr>
                  <th>NIK</th>
                  <td>{{ $penduduk->nik }}</td>
                </tr>
                <tr>
                  <th>Nama Lengkap</th>
                  <td>{{ $penduduk->nama }}</td>
                </tr>
                <tr>
                  <th>Jenis Kelamin</th>
                  <td>{{ $penduduk->jenis_kelamin_text }}</td>
                </tr>
                <tr>
                  <th>Golongan Darah</th>
                  <td>{{ $penduduk->darah->nama }}</td>
                </tr>
                <tr>
                  <th>Alamat</th>
                  <td>{{ $penduduk->keluarga->alamat }}</td>
                </tr>
                <tr>
                  <th>RT / RW</th>
                  <td>{{ $penduduk->keluarga->rt->nomor . '/' . $penduduk->keluarga->rt->rw->nomor }}</td>
                </tr>
                <tr>
                  <th>Tempat Lahir</th>
                  <td>{{ $penduduk->tempat_lahir }}</td>
                </tr>
                <tr>
                  <th>Tanggal Lahir</th>
                  <td>{{ $penduduk->tanggal_lahir->format('d-m-Y') }}</td>
                </tr>
                <tr>
                  <th>Agama</th>
                  <td>{{ $penduduk->agama->nama }}</td>
                </tr>
                <tr>
                  <th>Pendidikan</th>
                  <td>{{ $penduduk->pendidikan->nama }}</td>
                </tr>
                <tr>
                  <th>Pekerjaan</th>
                  <td>{{ $penduduk->pekerjaan->nama }}</td>
                </tr>
                <tr>
                  <th>Status Perkawinan</th>
                  <td>{{ $penduduk->statusPerkawinan->nama }}</td>
                </tr>
                <tr>
                  <th>Status Hubungan Dalam Keluarga</th>
                  <td>{{ $penduduk->statusHubunganDalamKeluarga->nama }}</td>
                </tr>
                <tr>
                  <th>Kewarganegaraan</th>
                  <td>{{ $penduduk->kewarganegaraan_text }}</td>
                </tr>
                <tr>
                  <th>Nomor KITAS / KITAP</th>
                  <td>{{ $penduduk->no_kitas_kitap }}</td>
                </tr>
                <tr>
                  <th>Nomor Paspor</th>
                  <td>{{ $penduduk->no_paspor }}</td>
                </tr>
                <tr>
                  <th>Nama Ayah</th>
                  <td>{{ $penduduk->nama_ayah }}</td>
                </tr>
                <tr>
                  <th>Nama Ibu</th>
                  <td>{{ $penduduk->nama_ibu }}</td>
                </tr>
                <tr>
                  <th>No. Hp / WhatsApp</th>
                  <td>{{ $penduduk->no_hp }}</td>
                </tr>
                <tr>
                  <th>Email</th>
                  <td>{{ $penduduk->email }}</td>
                </tr>
                <tr>
                  <th>Foto KTP</th>
                  <td>
                    @if ($penduduk->foto_ktp)
                      <div class="img-thumbnail"><img class=" w-100"
                          src="{{ Storage::url($penduduk->foto_ktp) }}" alt="{{ $penduduk->nik }}"></div>
                    @endif
                  </td>
                </tr>
              </table>
            </div>
            <p class="text-muted text-right mt-3 mb-0">Terakhir diubah pada
              {{ $penduduk->updated_at->isoFormat('dddd, D MMMM YYYY h:mm A') }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
