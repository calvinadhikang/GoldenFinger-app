<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    .text-center {
        text-align: center;
    }
    table {
        width: 100%;
    }
</style>
<body>
    <h1 class="text-center">Laporan Hutang</h1>
    <p>Periode {{ $mulai }} - {{ $akhir }}</p>
    <br>
    <table class="table-zebra data-table">
        <thead>
            <tr>
                <th><h3 class="font-bold">Kode</h3></th>
                <th><h3 class="font-bold">Vendor</h3></th>
                <th><h3 class="font-bold">Grand Total (Rp)</h3></th>
                <th><h3 class="font-bold">Jatuh Tempo</h3></th>
                <th><h3 class="font-bold">Status Pesanan</h3></th>
            </tr>
        </thead>
        <tbody>
            @if (count($data) > 0)
                @foreach ($data as $item)
                    <?php
                        $class_pesanan = "badge-error";
                        $text_pesanan = "On Process";

                        $class_pembayaran = "badge-error";
                        $text_pembayaran = "Belum Bayar";

                        if ($item->recieved_at) {
                            $class_pesanan = "badge-secondary";
                            $text_pesanan = "Selesai";
                        }

                        if ($item->paid_at) {
                            $class_pembayaran = "badge-secondary";
                            $text_pembayaran = "Selesai";
                        }
                    ?>

                    <tr>
                        <td>{{ $item->kode }}</td>
                        <td>{{ $item->vendor->nama }}</td>
                        <td>Rp {{ format_decimal($item->grand_total) }}</td>
                        <td>{{ date_format(new DateTime($item->jatuh_tempo), 'd M Y') }}</td>
                        <td><span class="badge {{ $class_pesanan }}">{{ $text_pesanan }}</span></td>
                    </tr>
                @endforeach
            @else
            <tr>
                <th class="text-error text-lg text-center" colspan="5">Tidak ada data...</th>
            </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
