<table>
  <thead>
    <tr>
      <th>No.</th>
      <th>No. Kartu Keluarga</th>
      <th>NIK</th>
      <th>Nama</th>
      <th>Tempat Lahir</th>
      <th>Tanggal Lahir</th>
      <th>Jenis Kelamin</th>
      <th>Gol. Darah</th>
      <th>Alamat</th>
      <th>RT/RW</th>
      <th>Kelurahan</th>
      <th>Kecamatan</th>
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
    @foreach ($penduduk as $i => $penduduk)
      <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $penduduk->keluarga->nomor }}</td>
        <td>{{ $penduduk->nik }}</td>
        <td>{{ $penduduk->nama }}</td>
        <td>{{ $penduduk->tempat_lahir }}</td>
        <td>{{ $penduduk->tanggal_lahir }}</td>
        <td>{{ $penduduk->jenis_kelamin_text }}</td>
        <td>{{ $penduduk->darah->nama }}</td>
        <td>{{ $penduduk->keluarga->alamat }}</td>
        <td>{{ $penduduk->keluarga->rt->nomor . '/' . $penduduk->keluarga->rt->rw->nomor }}</td>
        <td>SUMBERSARI</td>
        <td>SUMBERSARI</td>
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
