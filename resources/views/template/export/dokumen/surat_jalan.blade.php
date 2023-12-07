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
            <td colspan="3"></td>
            <th colspan="2">Surat Jalan</th>
        </tr>
        <tr>
            <th colspan="5">Kepada Yth.</th>
        </tr>
        <tr>
            <td>Nama</td>
            <td>: {{ $invoice->customer->nama }}</td>
            <td></td>
            <td>Tanggal</td>
            <td>: {{ date_format($date, 'd M Y') }}</td>
        </tr>
        <tr>
            <td>No Telp</td>
            <td>: {{ $invoice->customer->telp }}</td>
            <td></td>
            <td>No PO</td>
            <td>: {{ $invoice->po }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ $invoice->customer->alamat }}</td>
            <td></td>
            <td>No SJ</td>
            <td>: {{ $invoice->surat_jalan }}</td>
        </tr>
        <tr>
            <td></td>
            <td>  {{ $invoice->customer->kota }}</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="5"></td>
        </tr>
        {{-- Table Starts Here --}}
        <tr>
            <th colspan="2">Nama Barang</th>
            <th>Qty</th>
            <th colspan="2">Keterangan</th>
        </tr>
        @foreach ($invoice->details as $item)
        <tr>
            <td colspan="2">{{ $item->nama }}</td>
            <td>{{ $item->qty }} SET</td>
            <td colspan="2"></td>
        </tr>
        @endforeach
    </table>
</body>
</html>
