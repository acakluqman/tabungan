<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Transaksi Tabungan</title>
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
        LAPORAN TRANSAKSI TABUNGAN SISWA<br />Periode {{ $periode }}
    </h2>
    <table>
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No.</th>
                <th>Nama Siswa</th>
                <th style="width: 10%; text-align: center;">Tipe</th>
                <th style="width: 10%;">Nominal</th>
                <th>Keterangan</th>
                <th style="width: 15%;">Tanggal Transaksi</th>
                <th>Petugas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tabungan as $key => $row)
                <tr>
                    <td style="text-align: center;">{{ $key + 1 . '.' }}</td>
                    <td>{{ $row->nis }}<br />{{ $row->nama_siswa }}</td>
                    <td style="text-align: center;">{{ $row->tipe == 'debit' ? 'DEBIT' : 'KREDIT' }}</td>
                    <td>{{ 'Rp ' . number_format($row->nominal, 0, '.', '.') }}</td>
                    <td>{{ $row->keterangan ?: '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($row->tgl_transaksi)->isoFormat('D MMM Y HH:mm:ss') }}</td>
                    <td>{{ $row->nama_petugas }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
