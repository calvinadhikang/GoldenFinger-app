@extends('template.header')
@section('content')
<h1 class="text-xl font-semibold mb-5">Data Shares</h1>
<div class="p-4 bg-accent rounded mb-5">
    <div class="grid grid-cols-2">
        <p class="">Total Penjualan:</p>
        <p class="text-right font-medium">Rp {{ number_format($dataPenjualan->total) }}</p>

        <p class="">Total Biaya Operasional</p>
        <p class="text-right font-medium">Rp {{ number_format($operasional->total) }}</p>

        <p class="">Total Pendapatan Bersih</p>
        <p class="text-right text-lg font-medium">Rp {{ number_format($pendapatanBersih) }}</p>

        <div class="divider"></div>
        <div class="divider"></div>
        <p class="">Total Shares Anda</p>
        <p class="text-right font-semibold">{{ number_format($user->shares) }} %</p>
        <p class="text-lg">Perkiraan Total Pendapatan Anda dari Shares</p>
        <p class="text-right text-lg font-medium text-primary">Rp {{ number_format($user->shares_value) }}</p>
    </div>
</div>

<h1 class="text-xl font-semibold mb-5">Grafik Shares</h1>
<div class="bg-white bg-opacity-80 p-4 rounded mb-5">
    <canvas id="chart-shares"></canvas>
</div>

<h1 class="text-xl font-semibold mb-5">Data Shareholders</h1>
<div class="bg-accent p-4 rounded mb-5">
    <div class="flex justify-end mb-5">
        <a href="{{ url('/shares/configure') }}" class="btn btn-primary">Ubah Porsi Saham</a>
    </div>
    <table id="table" class="table-zebra">
        <thead>
            <tr>
                <th class="font-bold">Nama</th>
                <th class="font-bold">Persentase</th>
                <th class="font-bold">Bagian (Rp)</th>
                <th class="font-bold">Tanggal Join</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->details->nama }}</td>
                    <td>{{ $item->shares }}</td>
                    <td>Rp {{ number_format($dataPenjualan->total / 100 * $item->shares) }}</td>
                    <td>{{ date_format($item->created_at, 'd M Y') }}</td>
                </tr>
                @endforeach
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const baseURL = '<?= url('/api') ?>'

const getAnalytics = async() => {
    const response = await fetch(baseURL + '/shares')
    const data = await response.json();
    console.log(data);

    const ctx = document.getElementById('chart-shares');
    new Chart(ctx, {
        type: 'pie',
        data: {
        labels: data.karyawan,
        datasets: [{
            label: 'Jumlah Shares',
            data: data.shares,
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
