<table>
  <thead>
    <tr>
      <th>No.</th>
      <th>Alamat</th>
      <th>Nomor Rumah</th>
      <th>Nomor Kartu Keluarga</th>
      <th>Tipe Bangunan</th>
      <th>Penggunaan Bangunan</th>
      <th>Kontruksi Bangunan</th>
      <th>Keterangan</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($rumah as $i => $rumah)
      <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $rumah->alamat }}</td>
        <td>{{ $rumah->nomor }}</td>
        <td>
          @foreach ($rumah->keluarga as $i => $keluarga)
            {{ $keluarga->nomor }}
            @if ($i < $rumah->keluarga->count() - 1)
              <br>
            @endif
          @endforeach
        </td>
        <td>{{ $rumah->tipe_bangunan }}</td>
        <td>{{ $rumah->penggunaan_bangunan }}</td>
        <td>{{ $rumah->kontruksi_bangunan }}</td>
        <td>{{ $rumah->keterangan }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
