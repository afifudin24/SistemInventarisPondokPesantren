<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Riwayat Peminjaman Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 20px;
            color: #000;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #444;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #eee;
        }
        .footer {
            text-align: right;
            margin-top: 50px;
            font-style: italic;
        }
        .textnormal{
            font-style: normal;
            text-transform: capitalize;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <h2>Riwayat Peminjaman Barang</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
           
                <th>Nama Peminjam</th>
                <th>Nama Barang</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Keperluan</th>
                <th>Status Peminjaman</th>
                <th>Status Pengembalian</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($peminjaman as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
              
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->barang->nama_barang }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') }}</td>
                <td>{{ $item->keperluan ?? '-' }}</td>
                <td>{{ ucfirst($item->status) }}</td>
                <td>{{ ucfirst($item->pengembalian->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}
            <br>
            <br>
        <p class="textnormal">
            {{Auth::user()->name}}
        </p>
    </div>

  
</body>
</html>
