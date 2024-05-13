<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    table {
        width: 100%;
        border: 1px solid black;
        border-collapse: collapse;
    }
    tr, th, td {
        border: 1px solid black;
    }
    .barang-title {
        font-size: 1.2em;
        font-weight: bold;
    }
    .text-center {
        text-align: center;
    }
</style>
<body>
    <h1 class="text-center">Laporan Penjualan</h1>
    <p class="text-center">Periode : {{ $mulai }} - {{ $akhir }}</p>
    @foreach ($data as $barang)
        <div class="barang-title">{{ $barang->part }} {{ $barang->nama }}</div>
        <p>Total Terjual : {{ $barang->qty_terjual }}</p>
        <p>Total Pendapatan : Rp {{ number_format($barang->pendapatan_total) }}</p>
        <p>Detail :</p>
        @if (count($barang->list_penjualan) > 0)
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Quantity</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barang->list_penjualan as $item)
                    <tr>
                        <td>{{ $item->header->kode }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>Rp {{ number_format($item->harga) }}</td>
                        <td>Rp {{ number_format($item->subtotal) }}</td>
                        <td>{{ $item->created_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center" style="border: 1px solid black;">Tidak ada data penjualan</p>
        @endif
        <br>
    @endforeach
</body>
</html>
