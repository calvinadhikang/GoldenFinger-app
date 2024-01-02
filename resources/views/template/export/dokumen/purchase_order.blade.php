<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
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
        <tr></tr>
        <tr>
            <th>Surat Jalan</th>
        </tr>
        <tr>
            <th><b>NO PO : {{ $po->kode }}</b></th>
        </tr>
        <tr></tr>
        <tr>
            <td colspan="7"><b>SHIP TO</b></td>
            <td></td>
            <td colspan="2"><b>SUPPLIER</b></td>
        </tr>
        <tr>
            <td colspan="7"><b>PT.GOLDFINGER WHEELS INDONESIA</b></td>
            <td></td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="7">Jl. Soekarno Hatta KM 6, 5 RT. 18, Kalimantan Timur,</td>
            <td></td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="7">Kota Balikpapan, Indonesia 76126</td>
            <td></td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="7">0812-5309-669 | 0821-5711-887</td>
            <td></td>
            <td colspan="2"></td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td colspan="8"></td>
            <td>DATE :</td>
            <td>{{ date_format($po->created_at, 'd/m/Y') }}</td>
        </tr>
        {{-- Table Start --}}
        <tr>
            <td rowspan="2"><b>NO</b></td>
            <td rowspan="2" colspan="3"><b>ITEM</b></td>
            <td colspan="2"><b>KET</b></td>
            <td rowspan="2" colspan="2"><b>UNIT PRICE</b></td>
            <td rowspan="2" colspan="2"><b>TOTAL</b></td>
        </tr>
        <tr>
            <td><b>QTY</b></td>
            <td><b>UNIT</b></td>
        </tr>
        <?php $ctr = 1; ?>
        @foreach ($po->details as $item)
        <tr>
            <td>{{ $ctr }}</td>
            <td colspan="3">{{ $item->nama }}</td>
            <td>{{ $item->qty }}</td>
            <td>SET</td>
            <td colspan="2">{{ format_decimal($item->harga) }}</td>
            <td colspan="2">{{ format_decimal($item->subtotal) }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="8">TOTAL SUB</td>
            <td>Rp</td>
            <td>{{ format_decimal($po->total) }}</td>
        </tr>
        <tr>
            <td colspan="8">PPN 11%</td>
            <td>Rp</td>
            <td>{{ format_decimal($po->ppn_value) }}</td>
        </tr>
        <tr>
            <td colspan="8">TOTAL</td>
            <td>Rp</td>
            <td>{{ format_decimal($po->grand_total) }}</td>
        </tr>
        <tr>
            <td colspan="10">Comments or Special Instruction</td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td colspan="3"><b>ORDER BY</b></td>
            <td colspan="5"><b>CHECK ADMIN BY</b></td>
            <td colspan="2"><b>APPROVE BY</b></td>
        </tr>
        <tr>
            <td rowspan="2" colspan="3"><b>Eddy Chandra Tjoa</b></td>
            <td rowspan="2" colspan="5"><b>Nadia P.R.Zakni</b></td>
            <td rowspan="2" colspan="2"><b>Hendy Kuncoro</b></td>
        </tr>
    </table>
</body>
</html>
