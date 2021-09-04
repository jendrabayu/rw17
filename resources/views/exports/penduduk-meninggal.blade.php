<table>
  <thead>
    <tr>
      <th>No.</th>
      <th>NIK</th>
      <th>Nama</th>
      <th>Tanggal Kematian</th>
      <th>Jam Kematian</th>
      <th>Tempat Kematian</th>
      <th>Sebab Kematian</th>
      <th>Tempat Pemakaman</th>
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
      <th>Nama Ayah</th>
      <th>Nama Ibu</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($penduduk as $i => $penduduk)
      <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $penduduk->nik }}</td>
        <td>{{ $penduduk->nama }}</td>
        <td>{{ $penduduk->tanggal_kematian }}</td>
        <td>{{ $penduduk->jam_kematian }}</td>
        <td>{{ $penduduk->tempat_kematian }}</td>
        <td>{{ $penduduk->sebab_kematian }}</td>
        <td>{{ $penduduk->tempat_pemakaman }}</td>
        <td>{{ $penduduk->tempat_lahir }}</td>
        <td>{{ $penduduk->tanggal_lahir }}</td>
        <td>{{ $penduduk->jenis_kelamin_text }}</td>
        <td>{{ $penduduk->darah->nama }}</td>
        <td>{{ $penduduk->alamat }}</td>
        <td>{{ $penduduk->rt->nomor . '/' . $penduduk->rt->rw->nomor }}</td>
        <td>SUMBERSARI</td>
        <td>SUMBERSARI</td>
        <td>{{ $penduduk->agama->nama }}</td>
        <td>{{ $penduduk->statusPerkawinan->nama }}</td>
        <td>{{ $penduduk->pekerjaan->nama }}</td>
        <td>{{ $penduduk->pendidikan->nama }}</td>
        <td>{{ $penduduk->kewarganegaraan_text }}</td>
        <td>{{ $penduduk->nama_ayah }}</td>
        <td>{{ $penduduk->nama_ibu }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
