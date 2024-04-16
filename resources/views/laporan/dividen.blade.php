@extends('template.header')
@section('content')
<h1 class="text-2xl font-bold mb-5">Laporan Dividen</h1>
<div class="bg-accent p-4 rounded my-5">
    <form action="{{ url('/laporan/dividen') }}" method="GET">
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
    <div class="overflow-x-auto mt-5">
        <h1 class="font-medium text-xl">Rincian Cash Flow</h1>
        <div class="divider"></div>
        <div class="grid grid-cols-2 mb-10">
            <p>Pendapatan :</p>
            <p class="text-end text-yellow-100">Rp {{ number_format($pendapatan) }}</p>
            <p>Pengeluaran :</p>
            <p class="text-end text-red-200">- Rp {{ number_format($pengeluaran) }}</p>
            <p>Biaya Operasional :</p>
            <p class="text-end text-red-200">- Rp {{ number_format($cost) }}</p>
            <p>Total Pendapatan Bersih :</p>
            <p class="text-end font-medium text-lg">Rp {{ number_format($bersih) }}</p>
        </div>
        <h1 class="font-medium text-xl">Rincian Pembagian Dividen</h1>
        <div class="divider"></div>
        <table class="data-table table-zebra">
            <thead>
                <tr>
                    <th class="font-bold">Nama</th>
                    <th class="font-bold">Persentase</th>
                    <th class="font-bold">Bagian (Rp)</th>
                    <th class="font-bold">Tanggal Join</th>
                </tr>
            </thead>
            <tbody>
                @if (count($data) <= 0)
                <tr>
                    <td colspan="4" class="text-center text-error">Tidak ada data...</td>
                </tr>
                @else
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->details->nama }}</td>
                            <td>{{ $item->shares }}</td>
                            <td>Rp {{ number_format($bersih / 100 * $item->shares) }}</td>
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
    <a href="{{ url("/laporan/dividen/pdf?mulai=$mulai&akhir=$akhir") }}">
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
