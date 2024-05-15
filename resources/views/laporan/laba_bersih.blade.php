@extends('template.header')
@section('content')
<h1 class="text-2xl font-bold mb-5">Laporan Laba Bersih</h1>
<div class="bg-accent p-4 rounded my-5">
    <form method="GET">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div class="text-medium space-y-2">
                <p>Tanggal Mulai</p>
                <input type="date" name="mulai" class="w-full input input-bordered" value="{{ $mulai }}" required>
            </div>
            <div class="text-medium space-y-2">
                <p>Tanggal Akhir</p>
                <input type="date" name="akhir" class="w-full input input-bordered" value="{{ $akhir }}" required>
            </div>
        </div>
        <button class="btn btn-secondary btn-block mt-5">Tampilkan Data Laporan</button>
    </form>
</div>
<div class="bg-accent p-4 rounded">
    @if ($mulai == null)
        <p class="text-center">Pilih tanggal diatas untuk menampilkan laporan</p>
    @else
        <div class="grid grid-cols-2 text-xl font-bold mb-10">
            <p>Laba Bersih :</p>
            <p class="text-right text-primary">Rp {{ number_format(900000) }}</p>
        </div>

        <div class="font-medium text-lg">Detail Transaksi</div>
        <div class="overflow-x-auto">
            <table class="data-table table-zebra">
                <thead>
                    <tr>
                        <th><h3 class="font-bold">Kode</h3></th>
                        <th><h3 class="font-bold">Part Number</h3></th>
                        <th><h3 class="font-bold">Harga Jual</h3></th>
                        <th><h3 class="font-bold">Harga Beli</h3></th>
                        <th><h3 class="font-bold">Profit</h3></th>
                        <th><h3 class="font-bold">Qty Penjualan</h3></th>
                        <th><h3 class="font-bold">Profit Total</h3></th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @if (count($data) <= 0)
                        <tr>
                            <th class="text-error text-lg" colspan="7">Tidak ada Data...</th>
                        </tr>
                    @else --}}
                        <tr>
                            <td>GFLM/INV/2405/001</td>
                            <td>LIButyl</td>
                            <td>Rp 500,000</td>
                            <td>Rp 300,000</td>
                            <td>Rp 200,000</td>
                            <td>3 SET</td>
                            <td>Rp 600,000</td>
                        </tr>
                        <tr>
                            <td>GFLM/INV/2405/002</td>
                            <td>B750R16</td>
                            <td>Rp 450,000</td>
                            <td>Rp 300,000</td>
                            <td>Rp 150,000</td>
                            <td>2 SET</td>
                            <td>Rp 300,000</td>
                        </tr>
                        {{-- @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->kode }}</td>
                            <td>{{ $item->customer->nama }}</td>
                            <td>Rp {{ number_format($item->total) }}</td>
                            <td>{{ date_format($item->created_at, 'd M Y') }}</td>
                            <td>
                                {{ date_format(new DateTime($item->jatuh_tempo), 'd M Y') }}
                            </td>
                        </tr>
                        @endforeach
                    @endif --}}
                </tbody>
            </table>
        </div>
    @endif
</div>
@if ($mulai != null)
<div class="my-5">
    <a href="{{ url("/laporan/pendapatan/pdf?mulai=$mulai&akhir=$akhir") }}">
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
