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
    }
</style>
<body>
    <h1 class="text-center">Laporan Pendapatan</h1>
    <p>Periode {{ $mulai }} - {{ $akhir }}</p>
    <br>
    <table class="data-table table-zebra">
        <thead>
            <tr>
                <th><h3 class="font-bold">Kode</h3></th>
                <th><h3 class="font-bold">Customer</h3></th>
                <th><h3 class="font-bold">Grand Total (Rp)</h3></th>
                <th><h3 class="font-bold">Tanggal Pesanan</h3></th>
                <th><h3 class="font-bold">Jatuh Tempo</h3></th>
            </tr>
        </thead>
        <tbody>
            @if (count($data) <= 0)
                <tr>
                    <th class="text-error text-lg" colspan="5">Tidak ada Data...</th>
                </tr>
            @else
                @foreach ($data as $item)
                <tr>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->customer->nama }}</td>
                    <td>Rp {{ number_format($item->total) }}</td>
                    <td>{{ date_format($item->created_at, 'd M Y') }}</td>
                    <td>
                        {{ date_format(new DateTime($item->jatuh_tempo), 'd M Y') }}
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</body>
</html>
