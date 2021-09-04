<table>
  <thead>
    <tr>
      <th>No.</th>
      <th>NIK</th>
      <th>Nama</th>
      <th>Tempat Lahir</th>
      <th>Tanggal Lahir</th>
      <th>Jenis Kelamin</th>
      <th>Gol. Darah</th>
      <th>Alamat</th>
      <th>Alamat Asal</th>
      <th>RT/RW</th>
      <th>Kelurahan</th>
      <th>Kecamatan</th>
      <th>Agama</th>
      <th>Status Perkawinan</th>
      <th>Pekerjaan</th>
      <th>Pendidikan</th>
      <th>Kewarganegaraan</th>
      <th>Email</th>
      <th>No. Hp/WhatsApp</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($penduduk as $i => $penduduk)
      <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $penduduk->nik }}</td>
        <td>{{ $penduduk->nama }}</td>
        <td>{{ $penduduk->tempat_lahir }}</td>
        <td>{{ $penduduk->tanggal_lahir }}</td>
        <td>{{ $penduduk->jenis_kelamin_text }}</td>
        <td>{{ $penduduk->darah->nama }}</td>
        <td>{{ $penduduk->alamat }}</td>
        <td>{{ $penduduk->alamat_asal }}</td>
        <td>{{ $penduduk->rt->nomor . '/' . $penduduk->rt->rw->nomor }}</td>
        <td>SUMBERSARI</td>
        <td>SUMBERSARI</td>
        <td>{{ $penduduk->agama->nama }}</td>
        <td>{{ $penduduk->statusPerkawinan->nama }}</td>
        <td>{{ $penduduk->pekerjaan->nama }}</td>
        <td>{{ $penduduk->pendidikan->nama }}</td>
        <td>{{ $penduduk->kewarganegaraan_text }}</td>
        <td>{{ $penduduk->email }}</td>
        <td>{{ $penduduk->no_hp }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
