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
        width: 200px;
    }
    .text-right {
        text-align: right;
    }
    </style>
</head>
<body>
    <div class="title"><h2><b>Faktur Pajak</b></h2></div>
    <table>
        <tr>
            <td colspan="3">Kode dan Nomor Seri Faktur Pajak :</td>
        </tr>
        <tr>
            <td colspan="3">Pengusaha Kena Pajak</td>
        </tr>
        <tr>
            <td colspan="3">
                <p>Nama : PT. GOLDFINGER WHEELS INDONESIA</p>
                <p>Alamat : Jl. Soekarno Hatta KM 6,5 RT.018 Balikpapan 76123 - East Kalimantan</p>
                <p>NPWP : 90.895.028.0-729.000</p>
            </td>
        </tr>
        <tr>
            <td colspan="3">Pembeli Barang Kena Pajak / Penerima Jasa Kena Pajak</td>
        </tr>
        <tr>
            <td colspan="3">
                <p>Nama : {{ $data->customer->nama }}</p>
                <p>Alamat : {{ $data->customer->alamat }}</p>
                <p>NPWP : {{ $data->customer->NPWP }}</p>
            </td>
        </tr>
        <tr>
            <td>No.</td>
            <td>Nama Barang Kena Pajak / Jasa Kena Pajak</td>
            <td>Harga Jual/Penggantian/Uang Muka/Termin</td>
        </tr>
        <?php $no = 1; ?>
        @foreach ($data->details as $item)
        <tr>
            <td>{{ $no }}</td>
            <td>
                <div class="">{{ $item->nama }}</div>
                <div class="">Rp {{ number_format($item->harga) }} x {{ $item->qty }}</div>
            </td>
            <td class="text-right">{{ number_format($item->subtotal) }}</td>
        </tr>
        <?php $no += 1; ?>
        @endforeach
        <tr>
            <td colspan="2">Harga Jual / Penggantian</td>
            <td class="text-right">{{ number_format($data->total) }}</td>
        </tr>
        <tr>
            <td colspan="2">Dikurangi Potongan Harga</td>
            <td class="text-right">0</td>
        </tr>
        <tr>
            <td colspan="2">Dikurangi Uang Muka</td>
            <td class="text-right">0</td>
        </tr>
        <tr>
            <td colspan="2">Dasar Pengenaan Pajak</td>
            <td class="text-right">{{ number_format($data->total) }}</td>
        </tr>
        <tr>
            <td colspan="2">Total PPN</td>
            <td class="text-right">{{ number_format($data->ppn_value) }}</td>
        </tr>
        <tr>
            <td colspan="2">Total PPnBM (Pajak Penjualan Barang Mewah)</td>
            <td class="text-right">0</td>
        </tr>
    </table>
    <p>Sesuai dengan ketentuan yang berlaku, Direktorat Jendral Pajak mengatur bahwa Faktur Pajak ini telah ditandatangani secara elektronik sehingga tidak diperlukan tanda tangan basah pada Faktur Pajak ini.</p>
    <br><br>
    <div class="mt-10">
        <p>KOTA BALIKPAPAN, {{ date_format($now, 'd M Y') }}</p>
        <br>
        <br>
        <br>
        <p>HENDY KUNCORO</p>
    </div>
</body>
</html>
