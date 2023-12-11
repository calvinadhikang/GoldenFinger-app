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
            <td></td>
            <th colspan="7">PT. GOLDFINGER WHEELS INDONESIA</th>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <th colspan="7">JL. Soekarno Hatta RT.018, Graha Indah, Balikpapan Utara 76123-East Kalimantan</th>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <th colspan="7">Telp: 082157118887/08125309669 | Email: pt.goldenfingerwheelsindonesia@gmail.com</th>
            <td></td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <th>Invoice</th>
        </tr>
        <tr>
            <td colspan="4"></td>
            <th colspan="2">Kepada Yth.</th>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">Tanggal</td>
            <td>: {{ date_format($invoice->created_at, 'd M Y') }}</td>
            <th colspan="4"><b>{{ $invoice->customer->nama }}</b></th>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">No INVOICE</td>
            <td>: {{ $invoice->kode }}</td>
            <th colspan="4"><b>NO PO : {{ $invoice->po }}</b></th>
        </tr>
        <tr>
            <td></td>
            <th>No</th>
            <th colspan="2">Keterangan</th>
            <th colspan="2">Qty</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <td></td>
        </tr>
        <?php $ctr = 1; ?>
        @foreach ($invoice->details as $item)
        <tr>
            <td></td>
            <td>{{ $ctr }}</td>
            <td colspan="2">{{ $item->nama }}</td>
            <td>{{ $item->qty }}</td>
            <td>SET</td>
            <td>{{ number_format($item->harga) }}</td>
            <td>{{ number_format($item->subtotal) }}</td>
            <td></td>
        </tr>
        <?php $ctr += 1; ?>
        @endforeach
        <tr>
            <td></td>
            <th colspan="5"><b>TOTAL</b></th>
            <th>Rp</th>
            <th>{{ number_format($invoice->total) }}</th>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <th colspan="5"><b>PPN {{ $invoice->ppn }}%</b></th>
            <th>Rp</th>
            <th>{{ number_format($invoice->ppn_value) }}</th>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <th colspan="5"><b>GRAND TOTAL</b></th>
            <th>Rp</th>
            <th>{{ number_format($invoice->grand_total) }}</th>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="4"><b>Perhatian: Barang yang sudah dibeli tidak bisa ditukar/dikembalikan</b></td>
            <td>Penerima</td>
            <td></td>
            <td>Hormat Kami,</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td style="font-weight: bold" colspan="3">REKENING</td>
        </tr>
        <tr>
            <td></td>
            <td style="font-weight: bold" colspan="3">6205003619 (BANK PANIN)</td>
        </tr>
        <tr>
            <td></td>
            <td style="font-weight: bold" colspan="3">7810889998 (BCA)</td>
        </tr>
        <tr>
            <td></td>
            <td style="font-weight: bold" colspan="3">an PT. GOLDFINGER WHEELS INDONESIA</td>
            <td></td>
            <td></td>
            <td></td>
            <td>NADIA</td>
            <td></td>
        </tr>
    </table>
</body>
</html>
