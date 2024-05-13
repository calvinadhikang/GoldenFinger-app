<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
    @page {
        size: A4;
    }
    * {
        box-sizing: border-box;
        margin: 0;
    }
    body {
        padding: 5px;
    }
    .title {
        text-align: center;
        margin-top: 15px;
        margin-bottom: 15px;
    }
    .flex {
        width: 100%;
        display: flex;
    }
    .flex-between {
        justify-content: space-between;
    }
    .flex-grow {
        flex: 1 0 0;
    }
    .my-10 {
        margin-top: 10px;
        margin-bottom: 10px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    tr, td, th {
        border: 1px solid black;
    }
    .no-border {
        border: none;
    }
    .no-border * {
        border: none
    }
    #rekening {
        border: 1px solid black;
        padding: 1px;
    }
    .ttd {
        height: 100px;
        width: 100px;
        margin: auto;
    }
    .text-right {
        text-align: right;
    }
    </style>
</head>
<body>
    <h3>PT. GOLDFINGER WHEELS INDONESIA</h3>
    <div class="">
        <b>Jl. Soekarno Hatta KM 6,5 RT.018 Balikpapan 76123 - East Kalimantan</b>
    </div>
    <div class="">
        <b>Telp : 082157118887/08125309669 | Email : pt.goldfingerwheelsindonesia@gmail.com</b>
    </div>
    <div class="title"><h4><b>INVOICE</b></h4></div>
    <table class="no-border">
        <tr>
            <td></td>
            <td>Kepada Yth.</td>
        </tr>
        <tr>
            <td>Tgl : {{ date_format($data->created_at, 'd M Y') }}</td>
            <td><b>{{ $data->customer->nama }}</b></td>
        </tr>
        <tr>
            <td>No Invoice : {{ $data->kode }}</td>
            <td><b>No PO : {{ $data->po }}</b></td>
        </tr>
    </table>
    <table class="my-10">
        <tr>
            <th>No</th>
            <th>Keterangan</th>
            <th colspan="2">Qty</th>
            <th>Harga</th>
            <th>Jumlah</th>
        </tr>
        <?php $no = 1; ?>
        @foreach ($data->details as $item)
        <tr>
            <td><center>{{ $no }}</center></td>
            <td>{{ $item->nama }}</td>
            <td>{{ $item->qty }}</td>
            <td>SET</td>
            <td>{{ number_format($item->harga) }}</td>
            <td>{{ number_format($item->subtotal) }}</td>
        </tr>
        <?php $no += 1; ?>
        @endforeach
        <tr>
            <th colspan="4">TOTAL</th>
            <td colspan="2">
                <table class="no-border">
                    <tr>
                        <td>Rp</td>
                        <td class="text-right">{{ number_format($data->total) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <th colspan="4">PPN {{ $data->ppn }}%</th>
            <td colspan="2">
                <table class="no-border">
                    <tr>
                        <td>Rp</td>
                        <td class="text-right">{{ number_format($data->ppn_value) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <th colspan="4">GRAND TOTAL</th>
            <td colspan="2">
                <table class="no-border">
                    <tr>
                        <td>Rp</td>
                        <td class="text-right">{{ number_format($data->grand_total) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <p>Perhatian: Barang yang sudah dibeli tidak bisa ditukar/dikembalikan</p>
    <table class="no-border">
        <tr class="no-border">
            <td class="no-border">
                <div id="rekening">
                    <p><b>REKENING PANIN</b></p>
                    <p><b>6205003619</b></p>
                    <p><b>an PT. GOLDFINGER WHEELS INDONESIA</b></p>
                </div>
            </td>
            <td class="no-border">
                <center>
                    <p>Penerima,</p>
                    <div class="ttd" style="border-bottom: 1px solid black;"></div>
                </center>
            </td>
            <td class="no-border">
                <center>
                    <p>Hormat Kami,</p>
                    <div class="ttd" style="border-bottom: 1px solid black;"></div>
                </center>
            </td>
        </tr>
    </table>
</body>
</html>
