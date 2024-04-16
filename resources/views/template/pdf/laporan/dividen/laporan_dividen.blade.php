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
    <h1 class="text-center">Laporan Dividen</h1>
    <p>Periode {{ $mulai }} - {{ $akhir }}</p>
    <br>
    <h1 class="font-medium text-xl">Rincian Cash Flow</h1>
    <div class="divider"></div>
    <div class="grid grid-cols-2 mb-10">
        <p>Pendapatan :</p>
        <p class="text-end text-yellow-100">Rp {{ number_format($pendapatan) }}</p>
        <p>Pengeluaran :</p>
        <p class="text-end text-red-200">- Rp {{ number_format($pengeluaran) }}</p>
        <p>Biaya Operasional :</p>
        <p class="text-end text-red-200">- Rp {{ number_format($cost) }}</p>
        <p>Total Pendapatan Bersih :</p>
        <p class="text-end font-medium text-lg">Rp {{ number_format($bersih) }}</p>
    </div>
    <h1 class="font-medium text-xl">Rincian Pembagian Dividen</h1>
    <div class="divider"></div>
    <table class="data-table table-zebra">
        <thead>
            <tr>
                <th class="font-bold">Nama</th>
                <th class="font-bold">Persentase</th>
                <th class="font-bold">Bagian (Rp)</th>
                <th class="font-bold">Tanggal Join</th>
            </tr>
        </thead>
        <tbody>
            @if (count($data) <= 0)
            <tr>
                <td colspan="4" class="text-center text-error">Tidak ada data...</td>
            </tr>
            @else
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->details->nama }}</td>
                        <td>{{ $item->shares }}</td>
                        <td>Rp {{ number_format($bersih / 100 * $item->shares) }}</td>
                        <td>{{ date_format($item->created_at, 'd M Y') }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</body>
</html>
