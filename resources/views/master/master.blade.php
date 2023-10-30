@extends('template/header')

@section('content')
    <h1 class="text-xl font-medium">Dashboard</h1>
    <div class="flex flex-wrap justify-start mt-5 gap-5 mb-10">
        <a class="stats flex-grow shadow bg-accent hover:bg-accent/50" href="{{ url('/invoice') }}">
            <div class="stat shadow bg-accents">
                <div class="stat-title">Pendapatan Bulan Ini</div>
                <div class="stat-value" id="invoice"></div>
                <div class="stat-desc"></div>
            </div>
        </a>
        <a class="stats flex-grow shadow bg-accent hover:bg-accent/50" href="{{ url('/barang') }}">
            <div class="stat">
                <div class="stat-title">Total Barang Stok Minim</div>
                <div class="stat-value text-error" id="minimum">0</div>
                <div class="stat-desc"></div>
            </div>
        </a>
        <a class="stats flex-grow shadow bg-accent hover:bg-accent/50" href="{{ url('/invoice') }}">
            <div class="stat">
                <div class="stat-title">Total PO Belum Lunas</div>
                <div class="stat-value" id="po-due">0</div>
                <div class="stat-desc" id="po-total"></div>
            </div>
        </a>
        <a class="stats flex-grow shadow bg-accent hover:bg-accent/50" href="{{ url('/cost') }}">
            <div class="stat">
                <div class="stat-title">Biaya Operasional Bulan Ini</div>
                <div class="stat-value" id="cost">0</div>
                <div class="stat-desc"></div>
            </div>
        </a>
    </div>

    <h1 class="text-xl font-medium mb-5">Total Penjualan Barang Tahun Ini</h1>
    <div class="p-4 bg-white rounded text-base-100 bg-opacity-80">
        <canvas id="chart-penjualan"></canvas>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const baseURL = '<?= url('/api') ?>'
    const getCost = async () => {
        const response = await fetch(baseURL + '/cost/monthly');
        const data = await response.json();

        $('#cost').html(`Rp ${data.total.toLocaleString()}`)
    }

    const getMinimumBarang = async () => {
        const response = await fetch(baseURL + '/barang/minimum');
        const data = await response.json();

        $('#minimum').html(data.count)
    }

    const getPOJatuhTempo = async () => {
        const response = await fetch(baseURL + '/po/due');
        const data = await response.json();

        $('#po-due').html(data.count);
        $('#po-total').html(`Total Hutang: Rp ${data.total.toLocaleString()}`)
    }

    const getPaidInvoiceThisMonth = async() => {
        const response = await fetch(baseURL + '/invoice/paid/monthly')
        const data = await response.json();

        console.log(data);
        $('#invoice').html(`Rp ${data.total.toLocaleString()}`);
    }

    const getAnalytics = async() => {
        const response = await fetch(baseURL + '/invoice/sold/items')
        const data = await response.json();

        const ctx = document.getElementById('chart-penjualan');
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

    const generateChart = async(labels, qtys) => {

    }

    getCost()
    getMinimumBarang()
    getPOJatuhTempo()
    getPaidInvoiceThisMonth()
    getAnalytics()
</script>
@endsection
