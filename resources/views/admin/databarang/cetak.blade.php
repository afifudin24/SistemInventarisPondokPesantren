<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Data Barang</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; vertical-align: top; }
        th { background-color: #f2f2f2; }
        .notes { margin: 0; padding-left: 15px; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Laporan Data Barang</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Catatan Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barangs as $index => $barang)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $barang->kode_barang }}</td>
                    <td>{{ $barang->nama_barang }}</td>
                    <td>
                        @if($barang->catatan && count($barang->catatan) > 0)
                            <ul class="notes">
                                @foreach($barang->catatan as $catatan)
                                    <li>{{ $catatan->keterangan }} ({{ $catatan->kondisi }})</li>
                                @endforeach
                            </ul>
                        @else
                            <em>Tidak ada catatan</em>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>