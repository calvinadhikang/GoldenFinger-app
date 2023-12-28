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
            <th>PT. GOLDFINGER WHEELS INDONESIA</th>
        </tr>
        <tr>
            <th>JL. Soekarno Hatta RT.018, Graha Indah, Balikpapan Utara 76123-East Kalimantan</th>
        </tr>
        <tr>
            <th>Email : pt.goldenfingerwheelsindonesia@gmail.com</th>
        </tr>
        <tr>
            <td colspan="5"></td>
            <th>Surat Jalan</th>
        </tr>
        <tr>
            <th>Kepada Yth.</th>
        </tr>
        <tr>
            <td>Nama</td>
            <td>: {{ $invoice->customer->nama }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td>Tanggal</td>
            <td>: {{ date_format($date, 'd M Y') }}</td>
        </tr>
        <tr>
            <td>No Telp</td>
            <td>: {{ $invoice->customer->telp }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td>No PO</td>
            <td>: {{ $invoice->po }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ $invoice->customer->alamat }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td>No SJ</td>
            <td>: {{ $invoice->surat_jalan }}</td>
        </tr>
        <tr>
            <td></td>
            <td>{{ $invoice->customer->kota }}</td>
        </tr>
        <tr>
            <td></td>
        </tr>
        {{-- Table Starts Here --}}
        <tr>
            <th colspan="3">Nama Barang</th>
            <th colspan="2">Qty</th>
            <th colspan="2">Keterangan</th>
        </tr>
        @foreach ($invoice->details as $item)
        <tr>
            <td colspan="3">{{ $item->nama }}</td>
            <td>{{ $item->qty }}</td>
            <td>SET</td>
            <td colspan="2"></td>
        </tr>
        @endforeach
        <tr>
            <td colspan="5"></td>
            <td>Perhatian</td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td>1. Surat Jalan ini merupakan bukti resmi penerimaan barang</td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td>2. Surat jalan ini bukan bukti penjualan</td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td>3. Barang yang sudah diterima tidak dapat ditukar.</td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td>dikembalikan</td>
        </tr>
        <tr>
            <td><b><i>BARANG SUDAH DITERIMA DALAM KEADAAN BAIK DAN CUKUP Oleh</i></b></td>
        </tr>
        <tr>
            <td>(Tanda Tangan dan Cap (Stempel) Perusahaan)</td>
        </tr>
        <tr>
            <td>Penerima/Pembeli,</td>
            <td></td>
            <td>Bagian Pengiriman,</td>
            <td></td>
            <td></td>
            <td></td>
            <td>Petugas Gudang,</td>
        </tr>
    </table>
</body>
</html>
