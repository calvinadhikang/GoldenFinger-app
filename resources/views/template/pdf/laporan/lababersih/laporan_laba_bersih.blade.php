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
        border-collapse: collapse;
    }
    tr, th, td {
        border: 1px solid black;
    }
    h4 {
        padding: 0;
    }
</style>
<body>
    <h1 class="text-center">Laporan Laba Bersih</h1>
    <p class="text-center">Periode {{ $mulai }} - {{ $akhir }}</p>
    <h4>Pendapatan Bersih Penjualan: Rp {{ number_format($total) }}</h4>
    <p>Pendapatan setelah dihitung dengan selisih harga pembelian dan harga penjualan</p>
    <table>
        <thead>
            <tr>
                <th>Invoice</th>
                <th>Part Number</th>
                <th>Qty</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Pendapatan per 1 barang</th>
                <th>Pendapatan Total</th>
                <th>Tanggal Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @if (count($data) <= 0)
                <tr>
                    <th class="text-error" colspan="8">Tidak ada Data...</th>
                </tr>
            @else
                @foreach ($data as $item)
                <tr>
                    <td>{{ $item->invoice->kode }}</td>
                    <td>{{ $item->part }}</td>
                    <td>{{ number_format($item->qty) }}</td>
                    <td>Rp {{ number_format($item->harga_beli) }}</td>
                    <td>Rp {{ number_format($item->harga_jual) }}</td>
                    <td>Rp {{ number_format($item->profit_each) }}</td>
                    <td>Rp {{ number_format($item->profit_total) }}</td>
                    <td>{{ date_format(new DateTime($item->created_at), 'd M Y') }}</td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</body>
</html>
