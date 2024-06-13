@extends('template.header')
@section('content')
<h1 class="text-2xl font-bold mb-5">Laporan Hutang</h1>
<div class="bg-accent p-4 rounded-2xl my-5">
    <form action="{{ url('/laporan/hutang') }}" method="GET">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div class="text-medium space-y-2">
                <p>Tanggal Mulai</p>
                <input type="date" name="mulai" class="w-full input  " value="{{ $mulai }}" required>
            </div>
            <div class="text-medium space-y-2">
                <p>Tanggal Akhir</p>
                <input type="date" name="akhir" class="w-full input  " value="{{ $akhir }}" required>
            </div>
        </div>
        <button class="btn btn-secondary btn-block mt-5">Tampilkan Data Laporan</button>
    </form>
</div>
<div class="bg-accent p-4 rounded-2xl">
    @if ($mulai == null)
    <p class="text-center">Pilih tanggal diatas untuk menampilkan laporan</p>
    @else
    <div class="overflow-x-auto mt-5">
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
    </div>
    @endif
</div>
@if ($mulai != null)
<div class="my-5">
    <a href="{{ url("/laporan/hutang/pdf?mulai=$mulai&akhir=$akhir") }}">
        <button class="btn-block btn btn-secondary"><i class="fa-solid fa-file-pdf text-base hover:text-secondary"></i>Buat Laporan PDF</button>
    </a>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const baseURL = '<?= url('/api') ?>'
    const getAnalytics = async() => {
        const response = await fetch(baseURL + '/invoice/sold/items')
        const data = await response.json();

        const ctx = document.getElementById('chart');
        new Chart(ctx, {
            type: 'bar',
            data: {
            labels: data.labels,
            datasets: [{
                label: 'Jumlah Penjualan',
                data: data.qty,
                borderWidth: 1
            }]
            },
            options: {
            scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    getAnalytics();
</script>
@endsection
