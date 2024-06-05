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
        padding-top: 2px;
        padding-bottom: 2px;
        margin: 0;
    }
</style>
<body>
    <h1 class="text-center">Laporan Laba Rugi</h1>
    <p class="text-center">Periode {{ $mulai }} - {{ $akhir }}</p>
    <h4>Total Laba Rugi: Rp {{ number_format($totalLabaRugi) }}</h4>
    <br>
    <table>
        <tr>
            <td class="text-lg" colspan="3"><h4>Pendapatan</h4></td>
        </tr>
        <tr>
            <td>Pendapatan Kotor</td>
            <td>Rp {{ number_format($totalPendapatanKotor) }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Biaya Modal</td>
            <td>Rp {{ number_format($totalPendapatanKotor - $totalPendapatanBersih) }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Pendapatan Bersih</td>
            <td></td>
            <td>Rp {{ number_format($totalPendapatanBersih) }}</td>
        </tr>
        {{--  --}}
        <tr>
            <td class="text-lg" colspan="3"><h4>Biaya</h4></td>
        </tr>
        <tr>
            <td>Biaya Operasional</td>
            <td>Rp {{ number_format($totalOperationalCost) }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Total Biaya</td>
            <td></td>
            <td>Rp {{ number_format($totalOperationalCost) }}</td>
        </tr>
        {{--  --}}
        <tr>
            <td class="text-lg" colspan="2"><h4>Laba / Rugi</h4></td>
            <td>Rp {{ number_format($totalLabaRugi) }}</td>
        </tr>
    </table>
</body>
</html>
