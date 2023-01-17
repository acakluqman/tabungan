<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 12px;
        }

        table {
            /* font-family: arial, sans-serif; */
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center;">
        LAPORAN TRANSAKSI<br />Periode {{ $periode }}
    </h2>
    <table>
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No.</th>
                <th>Nama Siswa</th>
                <th>Pembayaran</th>
                <th>Total Tagihan</th>
                <th>Jumlah Bayar</th>
                <th>Tanggal Transaksi</th>
                <th>Petugas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi as $key => $tx)
                <tr>
                    <td style="text-align: center;">{{ $key + 1 . '.' }}</td>
                    <td>{{ $tx->nis }}<br />{{ $tx->nama_siswa }}</td>
                    <td>{{ $tx->nama_tagihan }}</td>
                    <td>{{ 'Rp ' . number_format($tx->total_tagihan, 0, '.', '.') }}</td>
                    <td>{{ 'Rp ' . number_format($tx->total_bayar, 0, '.', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($tx->tgl_transaksi)->isoFormat('D MMM Y HH:mm:ss') }}</td>
                    <td>{{ $tx->nama_petugas }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
