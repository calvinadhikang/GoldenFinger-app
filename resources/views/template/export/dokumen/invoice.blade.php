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
            <th colspan="6">PT. GOLDFINGER WHEELS INDONESIA</th>
        </tr>
        <tr>
            <th colspan="6">JL. Soekarno Hatta RT.018, Graha Indah, Balikpapan Utara 76123-East Kalimantan</th>
        </tr>
        <tr>
            <th colspan="6">Telp: 082157118887/08125309669 | Email: pt.goldenfingerwheelsindonesia@gmail.com</th>
        </tr>
        <tr>
            <th>Invoice</th>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <th colspan="4">Kepada Yth.</th>
        </tr>
        <tr>
            <td>Tgl</td>
            <td>:{{ date_format($invoice->created_at, 'd M Y') }}</td>
            <th colspan="4">{{ $invoice->customer->nama }}</th>
        </tr>
        <tr>
            <td>No</td>
            <td>INVOICE: {{ $invoice->kode }}</td>
            <th colspan="4">NO PO: {{ $invoice->po }}</th>
        </tr>
        <tr>
            <th>No</th>
            <th>Keterangan</th>
            <th colspan="2">Qty</th>
            <th>Harga</th>
            <th>Jumlah</th>
        </tr>
        <?php $ctr = 1; ?>
        @foreach ($invoice->details as $item)
        <tr>
            <td>{{ $ctr }}</td>
            <td>{{ $item->nama }}</td>
            <td>{{ $item->qty }}</td>
            <td>SET</td>
            <td>{{ number_format($item->harga) }}</td>
            <td>{{ number_format($item->subtotal) }}</td>
        </tr>
        <?php $ctr += 1; ?>
        @endforeach
        <tr>
            <th colspan="4">TOTAL</th>
            <th>Rp</th>
            <th>{{ number_format($invoice->total) }}</th>
        </tr>
        <tr>
            <th colspan="4">PPN {{ $invoice->ppn }}%</th>
            <th>Rp</th>
            <th>{{ number_format($invoice->ppn_value) }}</th>
        </tr>
        <tr>
            <th colspan="4">GRAND TOTAL</th>
            <th>Rp</th>
            <th>{{ number_format($invoice->grand_total) }}</th>
        </tr>

        <tr>
            <td colspan="6"><b>Perhatian: Barang yang sudah dibeli tidak bisa ditukar/dikembalikan</b></td>
        </tr>
        <tr>
            <td style="font-weight: bold" colspan="2">REKENING PANIN</td>
            <td></td>
            <td>Penerima,</td>
            <td></td>
            <td>Hormat Kami,</td>
        </tr>
        <tr>
            <td style="font-weight: bold">6205003619</td>
        </tr>
        <tr>
            <td style="font-weight: bold">an PT.GOLDENFINGER WHEELS INDONESIA</td>
        </tr>
    </table>
</body>
</html>
