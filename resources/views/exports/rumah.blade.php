<table>
  <thead>
    <tr>
      <th>No.</th>
      <th>Alamat</th>
      <th>Nomor Rumah</th>
      <th>Penggunaan Bangunan</th>
      <th>Keterangan</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($rumah as $i => $rumah)
      <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $rumah->alamat }}</td>
        <td>{{ $rumah->nomor }}</td>
        <td>{{ $rumah->penggunaanBangunan->nama }}</td>
        <td>{{ $rumah->keterangan }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
