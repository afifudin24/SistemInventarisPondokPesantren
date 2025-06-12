<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <title>Rekap Transaksi</title>
        <style>
            body {
                font-family: sans-serif;
                font-size: 12px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            th,
            td {
                border: 1px solid #000;
                padding: 6px;
                text-align: left;
            }

            th {
                background-color: #eee;
            }
        </style>
    </head>

    <body>
        <h2>Rekap Transaksi</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis</th>
                    <th>Barang</th>
                    <th>Tanggal</th>
                    <th>Catatan</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksis as $i => $transaksi)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ ucfirst($transaksi->jenis) }}</td>
                        <td>{{ $transaksi->barang->nama_barang }}</td>
                        <td>{{ $transaksi->tanggal }}</td>
                        <td>{{ $transaksi->catatan }}</td>
                        <td>{{ $transaksi->jumlah }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>

</html>
