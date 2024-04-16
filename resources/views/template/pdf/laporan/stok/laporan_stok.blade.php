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
    <h1 class="text-center">Laporan Stok - {{ $tanggal }}</h1>
    @foreach ($barangs as $barang)
    <div class="barang-title">{{ $barang->part }} {{ $barang->nama }}</div>
    <p>Stok Sekarang : {{ $barang->stok }}</p>
    <p>Detail Mutasi Stok :</p>
    @if (count($barang->mutation) > 0)
    <table>
        <thead>
            <tr>
                <th>Status</th>
                <th>Quantity</th>
                <th>Kode Transaksi</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barang->mutation as $item)
            <tr>
                <td>{{ $item->status }}</td>
                <td>{{ $item->qty }}</td>
                <td>{{ $item->trans_kode }}</td>
                <td>{{ $item->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p class="text-center" style="border: 1px solid black;">Tidak ada data mutasi</p>
    @endif
    <br>
    @endforeach
</body>
</html>
