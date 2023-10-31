<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
</style>
<body>
    <table>
        <tr>
            <th colspan="5">PT. GOLDFINGER WHEELS INDONESIA</th>
        </tr>
        <tr>
            <th colspan="5">JL. Soekarno Hatta RT.018, Graha Indah, Balikpapan Utara 76123-East Kalimantan</th>
        </tr>
        <tr>
            <th colspan="5">Email : pt.goldenfingerwheelsindonesia@gmail.com</th>
        </tr>
        <tr>
            <th colspan="5">Tanda Terima</th>
        </tr>
        <tr>
            <th colspan="5">Kepada Yth. {{ $invoice->customer->nama }}</th>
        </tr>
        <tr>
            <th>No</th>
            <th>Tanggal Invoice</th>
            <th>No. Invoice</th>
            <th>No. PO</th>
            <th>Total</th>
        </tr>
        <tr>
            <td>1</td>
            <td>{{ date_format($invoice->created_at, 'd M Y') }}</td>
            <td>{{ $invoice->kode }}</td>
            <td>{{ $invoice->po }}</td>
            <td>{{ format_decimal($invoice->grand_total) }}</td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: center">Grand Total</td>
            <td>{{ format_decimal($invoice->grand_total) }}</td>
        </tr>
        <tr>
            <td colspan="5">Balikpapan, {{ date_format($date, 'd M Y') }}</td>
        </tr>
        <tr>
            <td colspan="3" style="font-weight: bold">REKENING PANIN</td>
            <td>Diterima Oleh,</td>
            <td>Diserahkan Oleh,</td>
        </tr>
        <tr>
            <td colspan="3" style="font-weight: bold">an PT.GOLDENFINGER WHEELS INDONESIA</td>
        </tr>
        <tr>
            <td colspan="3" style="font-weight: bold">6205003619</td>
        </tr>
    </table>
</body>
</html>
