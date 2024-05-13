@extends('template.header')
@section('content')
<h1 class="text-2xl font-bold mb-5">Laporan Stok Barang</h1>
<a href="{{ url('/laporan/stok/pdf') }}">
    <button class="my-5 btn-block btn btn-secondary"><i class="fa-solid fa-file-pdf text-base hover:text-secondary"></i>Download Laporan Stok Terbaru</button>
</a>
<div class="bg-accent p-4 rounded">
    <div class="overflow-x-auto">
        <table class="data-table table-zebra">
            <thead>
                <tr>
                    <th><h3 class="font-bold">Part</h3></th>
                    <th><h3 class="font-bold">Nama</h3></th>
                    <th><h3 class="font-bold">Stok</h3></th>
                    <th><h3 class="font-bold">Aksi</h3></th>
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
                        <td>{{ $item->part }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->stok }}</td>
                        <td>
                            <a href="{{ url('/barang/detail/'.$item->part) }}"><button class="btn btn-xs btn-secondary">Detail</button></a>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>

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
