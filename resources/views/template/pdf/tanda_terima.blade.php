<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
@page {
    width: 21cm;
    padding: 0.4mm;
}

* {
    margin: 0;
    box-sizing: border-box;
}

.text-center {
    text-align: center;
}

.text-right {
    text-align: right;
}

.kepada {
    font-weight: bold;
}

body {
    width: 21cm;
    margin: 0;
    padding: 0.5cm;
}

table {
    border-collapse: collapse;
    width: 19cm;
    border: 1px solid black; /* Single-line border for the entire table */
}

th, td {
    border: 1px solid black; /* Single-line border for cells */
    text-align: center;
}

.flex::after {
    clear: both;
}

.grow {
    flex-grow: 1;
    text-align: center;
}

.box {
    margin-left: 20px;
    float: left;
    width: 20%;
}

.rekening {
    float: left;
    border: 1px solid black;
    font-weight: bold;
    padding: 5px;
    width: 45%;
}
</style>
<body>
    <h2>PT. GOLDENFINGER WHEELS INDONESIA</h2>
    <p><b>JL. Soekarno Hatta RT. 018, Graha Indah, Balikpapan Utara 76123-East Kalimantan</b></p>
    <p style="margin-bottom: 10px">Email: pt.goldenfingerwheelsindonesia@gmail.com</p>

    <h3 class="text-center"><u>TANDA TERIMA</u></h3>
    <p style="margin-bottom: 10px">Kepada Yth. <span class="kepada">{{ $data->customer->nama }}</span></p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Invoice</th>
                <th>No. Invoice</th>
                <th>No. PO</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>{{ date_format($data->created_at, 'd M Y') }}</td>
                <td>{{ $data->kode }}</td>
                <td>{{ $data->po }}</td>
                <td class="text-right">Rp {{ number_format($data->grand_total) }}</td>
            </tr>
            <tr>
                <td colspan="4">Grand Total</td>
                <td class="text-right">Rp {{ number_format($data->grand_total) }}</td>
            </tr>
        </tbody>
    </table>

    <p style="margin-top: 10px">Balikpapan, {{ date_format($now, 'd M Y') }}</p>
    <br>
    <div class="inline"></div>
    <div class="flex">
        <div class="rekening">
            <p>REKENING</p>
            <p>6205003619 (BANK PANIN)</p>
            <p>7810889998 (BCA)</p>
            <p>an PT.GOLDENFINGER WHEELS INDONESIA</p>
        </div>
        <div class="box">
            Diterima Oleh,
        </div>
        <div class="box">
            Diserahkan Oleh,
        </div>
    </div>
</body>
</html>
