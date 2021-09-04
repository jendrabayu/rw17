  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nomor Kartu Keluarga</th>
        <th>Nama Kepala Keluarga</th>
        <th>Jumlah Orang</th>
        <th>Alamat</th>
        <th>RT/RW</th>
        <th>Kelurahan</th>
        <th>Kecamatan</th>
        <th>Kabupaten</th>
        <th>Provinsi</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($keluarga as $i => $keluarga)
        <tr>
          <td>{{ ++$i }}</td>
          <td>{{ $keluarga->nomor }}</td>
          <td>
            @php
              $kepala_keluarga = $keluarga
                  ->penduduk()
                  ->whereHas('statusHubunganDalamKeluarga', function ($q) {
                      $q->where('nama', 'KEPALA KELUARGA');
                  })
                  ->first();
              $kepala_keluarga = $kepala_keluarga ? $kepala_keluarga->nama : '';
            @endphp
            {{ $kepala_keluarga }}
          </td>
          <td>{{ $keluarga->penduduk->count() }}</td>
          <td>{{ $keluarga->alamat }}</td>
          <td>{{ $keluarga->rt->nomor . '/' . $keluarga->rt->rw->nomor }}</td>
          <td>SUMBERSARI</td>
          <td>SUMBERSARI</td>
          <td>JEMBER</td>
          <td>JAWA TIMUR</td>
        </tr>
      @endforeach
    </tbody>
  </table>
