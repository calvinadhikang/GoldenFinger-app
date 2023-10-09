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

.flex {
    display: flex;
    gap: 50px;
}

.grow {
    flex-grow: 1;
    text-align: center;
}

.box {
    display: inline-block;
}

.rekening {
    border: 1px solid black;
    font-weight: bold;
    padding: 5px;
}
</style>
<body>
    <h2>PT. GOLDENFINGER WHEELS INDONESIA</h2>
    <p><b>JL. Soekarno Hatta RT. 018, Graha Indah, Balikpapan Utara 76123-East Kalimantan</b></p>
    <p style="margin-bottom: 10px">Email: pt.goldenfingerwheelsindonesia@gmail.com</p>

    <h3 class="text-center"><u>TANDA TERIMA</u></h3>
    <p style="margin-bottom: 10px">Kepada Yth. <span class="kepada">PT. BIMA NUSA INTERNASIONAL</span></p>

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
                <td>05/05/2023</td>
                <td>GFLM/INV/2305/004</td>
                <td>PO.BIMA-HO 23050009</td>
                <td class="text-right">674.500.047</td>
            </tr>
            <tr>
                <td colspan="4">Grand Total</td>
                <td class="text-right">674.500.047</td>
            </tr>
        </tbody>
    </table>

    <p style="margin-top: 10px">Balikpapan, 11 Mei 2023</p>
    <br>
    <div class="inline"></div>
    <div class="flex">
        <div class="rekening">
            <p>REKENING PANIN</p>
            <p>an PT.GOLDENFINGER WHEELS INDONESIA</p>
            <p>6205003619</p>
        </div>
        <div class="">
            <p>Diterima Oleh,</p>
        </div>
        <div class="">
            <p>Diserahkan Oleh,</p>
        </div>
    </div>
</body>
</html>
