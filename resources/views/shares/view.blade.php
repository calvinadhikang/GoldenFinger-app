@extends('template.header')
@section('content')
<h1 class="text-xl font-semibold mb-5">Data Shareholders</h1>
<div class="bg-accent p-4 rounded mb-5">
    <div class="flex justify-end mb-5">
        <button class="btn btn-primary">Ubah Porsi Saham</button>
    </div>
    <table id="table">
        <thead>
            <tr>
                <th class="font-bold">Nama</th>
                <th class="font-bold">Persentase</th>
                <th class="font-bold">Tanggal Join</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->details->nama }}</td>
                    <td>{{ $item->shares }}</td>
                    <td>{{ date_format($item->created_at, 'd M Y') }}</td>
                </tr>
                @endforeach
        </tbody>
    </table>
</div>
<h1 class="text-xl font-semibold mb-5">Grafik Shares</h1>
<div class="bg-white bg-opacity-80 p-4 rounded mb-5">
    <canvas id="chart-shares"></canvas>
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
