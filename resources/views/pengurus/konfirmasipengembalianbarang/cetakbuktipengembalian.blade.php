<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Pengembalian Barang</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 40px;
            color: #000;
            font-size: 14px;
        }
        h2, h4 {
            text-align: center;
            margin: 0;
        }
        .section {
            margin-top: 30px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .info-table td {
            padding: 8px;
            vertical-align: top;
        }
        .info-table td.label {
            width: 200px;
            font-weight: bold;
        }
        .signature {
            margin-top: 60px;
            width: 100%;
            display: flex;
            justify-content: space-between;
        }
        .signature div {
            text-align: center;
            width: 30%;
        }
        .footer {
            margin-top: 40px;
            font-style: italic;
            text-align: right;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <h2>Bukti Pengembalian Barang</h2>
    <h4>{{ config('app.name') }}</h4>

    <div class="section">
        <table class="info-table">
            <tr>
                <td class="label">Nama Peminjam</td>
                <td>: {{ $pengembalian->peminjaman->user->name }}</td>
            </tr>
            <tr>
                <td class="label">Nama Barang</td>
                <td>: {{ $pengembalian->peminjaman->barang->nama_barang }}</td>
            </tr>
                <tr>
                <td class="label">Jumlah</td>
                <td>: {{ $pengembalian->jumlah_kembali }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Peminjaman</td>
                <td>: {{ \Carbon\Carbon::parse($pengembalian->tanggal_pinjam)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Pengembalian</td>
                <td>: {{ \Carbon\Carbon::parse($pengembalian->tanggal_kembali)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <td class="label">Status</td>
                <td>: {{ $pengembalian->status }}</td>
            </tr>
        
            <tr>
                <td class="label">Kondisi</td>
                <td>: {{ $pengembalian->kondisi ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Bukti Pengembalian</td>
            
                {{-- {{ asset('storage/' . $pengembalian->bukti) }} --}}
                {{-- <td>:   <img src="{{url('storage/'.$pengembalian->bukti)}}" alt=""></td>
                 --}}
                 {{-- <td>{{url('storage/'.$pengembalian->bukti)}}</td>
                  --}}
                  <td><img src="{{ public_path('storage/' . $pengembalian->bukti) }}" style="width: 200px;">
</td>
            </tr>
        </table>
    </div>

    <div class="signature">
        <div>
            Peminjam<br><br><br><br>
            ( {{ $pengembalian->peminjaman->user->name }} )
        </div>
   
    </div>

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}
    </div>

</body>
</html>
