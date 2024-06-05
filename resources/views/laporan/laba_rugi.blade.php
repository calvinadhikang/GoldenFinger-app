@extends('template.header')
@section('content')
<h1 class="text-2xl font-bold mb-5">Laporan Laba Rugi</h1>
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
            <p class="text-right text-primary">Rp {{ number_format($totalLabaRugi) }}</p>
        </div>
        <div class="overflow-x-auto">
            <table class="table">
                <thead></thead>
                <tbody>
                    <tr>
                        <th class="text-lg" colspan="2">Pendapatan</th>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Pendapatan Kotor</td>
                        <td>Rp {{ number_format($totalPendapatanKotor) }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Biaya Modal</td>
                        <td>Rp {{ number_format($totalPendapatanKotor - $totalPendapatanBersih) }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Pendapatan Bersih</td>
                        <td></td>
                        <td>Rp {{ number_format($totalPendapatanBersih) }}</td>
                    </tr>
                    {{--  --}}
                    <tr>
                        <th class="text-lg" colspan="2">Biaya</th>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Biaya Operasional</td>
                        <td>Rp {{ number_format($totalOperationalCost) }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Total Biaya</td>
                        <td></td>
                        <td>Rp {{ number_format($totalOperationalCost) }}</td>
                    </tr>
                    {{--  --}}
                    <tr>
                        <th class="text-lg" colspan="2">Laba / Rugi</th>
                        <td>Rp {{ number_format($totalLabaRugi) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif
</div>
@if ($mulai != null)
<div class="my-5">
    <a href="{{ url("/laporan/laba_rugi/pdf?mulai=$mulai&akhir=$akhir") }}">
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
