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
    <div class="title"><h2><b>Surat Jalan</b></h2></div>
    <table class="no-border">
        <tr>
            <td>Kepada Yth.</td>
            <td></td>
        </tr>
        <tr>
            <td>Nama : {{ $data->customer->nama }}</td>
            <td>Tanggal : {{ date_format($now, 'd M Y') }}</td>
        </tr>
        <tr>
            <td>No Telp : {{ $data->customer->telp }}</td>
            <td>No PO : {{ $data->po }}</td>
        </tr>
        <tr>
            <td>Alamat : {{ $data->customer->alamat }}</td>
            <td>No SJ : {{ $data->surat_jalan }}</td>
        </tr>
    </table>
    <table class="my-10">
        <tr>
            <th>Nama Barang</th>
            <th colspan="2">Qty</th>
            <th>Keterangan</th>
        </tr>
        @foreach ($data->details as $item)
        <tr>
            <td>{{ $item->nama }}</td>
            <td>{{ $item->qty }}</td>
            <td>SET</td>
            <td></td>
        </tr>
        @endforeach
        <tr>
            <td rowspan="5"></td>
            <td colspan="3">PERHATIAN :</td>
        </tr>
        <tr>
            <td colspan="3">1. Surat Jalan ini merupakan bukti resmi penerimaan barang</td>
        </tr>
        <tr>
            <td colspan="3">2. Surat Jalan ini bukan bukti penjualan</td>
        </tr>
        <tr>
            <td colspan="3">3. Barang yang sudah diterima tidak dapat ditukar/</td>
        </tr>
        <tr>
            <td colspan="3">dikembalikan</td>
        </tr>
    </table>
    <p><b>BARANG SUDAH DITERIMA DALAM KEADAAN BAIK DAN CUKUP Oleh</b></p>
    <p>(Tanda Tangan dan Cap(Stempel) Perusahaan)</p>
    <br>
    <table class="no-border">
        <tr class="no-border">
            <td class="no-border">
                <center>
                    <p>Penerima/Pembeli</p>
                    <div class="ttd" style="border-bottom: 1px solid black;"></div>
                </center>
            </td>
            <td class="no-border">
                <center>
                    <p>Bagian Pengiriman,</p>
                    <div class="ttd" style="border-bottom: 1px solid black;"></div>
                </center>
            </td>
            <td class="no-border">
                <center>
                    <p>Petugas Gudang,</p>
                    <div class="ttd" style="border-bottom: 1px solid black;"></div>
                </center>
            </td>
        </tr>
    </table>
</body>
</html>
