<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Verifikasi Peminjaman</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            padding: 30px;
            font-size: 14px;
        }

        .header, .footer {
            text-align: center;
            margin-bottom: 20px;
        }

        .footer {
            margin-top: 50px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 8px;
        }

        .barang-table {
            width: 100%;
            border-collapse: collapse;
        }

        .barang-table th, .barang-table td {
            border: 1px solid #000;
            padding: 8px;
        }

        .text-center {
            text-align: center;
        }

        .signature {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }

        .signature div {
            width: 45%;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Bukti Verifikasi Peminjaman Barang</h2>
        <p>{{ \Carbon\Carbon::now()->format('d F Y') }}</p>
    </div>

    <table class="info-table">
        <tr>
            <td><strong>Nama Peminjam</strong></td>
            <td>: {{ $peminjaman->user->name }}</td>
        </tr>
        <tr>
            <td><strong>Tanggal Peminjaman</strong></td>
            <td>: {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d F Y') }}</td>
        </tr>
        <tr>
            <td><strong>Status Verifikasi</strong></td>
            <td>: {{ $peminjaman->status }}</td>
        </tr>
    </table>

    <h4>Detail Barang</h4>
    <table class="barang-table">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Keperluan</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
          
                <tr>
                 
                    <td>{{ $peminjaman->barang->nama_barang }}</td>
                    <td>{{$peminjaman->keperluan}}</td>
                    <td class="text-center">{{ $peminjaman->jumlah_pinjam }}</td>
                    <td>{{ $detail->keterangan ?? '-' }}</td>
                </tr>
           
        </tbody>
    </table>

   

    <div class="footer">
        <p>Dicetak melalui Sistem Peminjaman Barang</p>
    </div>

</body>
</html>
