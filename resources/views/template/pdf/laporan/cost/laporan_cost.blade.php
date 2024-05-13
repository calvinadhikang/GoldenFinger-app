<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    .text-center {
        text-align: center;
    }
    table {
        width: 100%;
        border: 1px solid black;
        border-collapse: collapse
    }

    tr, th, td {
        border: 1px solid black;
    }
</style>
<body>
    <h1 class="text-center">Laporan Pengeluaran Operasional</h1>
    <p class="text-center">Periode {{ $mulai }} - {{ $akhir }}</p>
    <br>
    <table>
        <tr>
            <th>Deskripsi</h3></th>
            <th>Total</h3></th>
            <th>Tanggal</h3></th>
        </tr>
        @foreach ($data as $item)
        <tr>
            <td>{{ $item->deskripsi }}</td>
            <td>Rp {{ format_decimal($item->total) }}</td>
            <td>{{ date_format($item->created_at, 'd M Y') }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
