@extends('template.header')
@section('content')
<h1 class="text-2xl font-bold mb-5">Laporan Pengeluaran Operasional</h1>
<div class="bg-accent p-4 rounded-2xl my-5">
    <form action="{{ url('/laporan/cost') }}" method="GET">
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
    <div class="overflow-x-auto">
        <table class="data-table table-zebra">
            <thead>
                <tr>
                    <th><h3 class="font-bold">Deskripsi</h3></th>
                    <th><h3 class="font-bold">Total</h3></th>
                    <th><h3 class="font-bold">Tanggal</h3></th>
                </tr>
            </thead>
            <tbody>
            @if (count($data) <= 0)
                <tr>
                    <th class="text-error text-lg" colspan="5">Tidak ada data...</th>
                </tr>
            @else
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->deskripsi }}</td>
                        <td>Rp {{ format_decimal($item->total) }}</td>
                        <td>{{ date_format($item->created_at, 'd M Y') }}</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
    @endif
</div>
@if ($mulai != null)
<div class="my-5">
    <a href="{{ url("/laporan/cost/pdf?mulai=$mulai&akhir=$akhir") }}">
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
