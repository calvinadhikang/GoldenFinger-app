@extends('template/header')

@section('content')
    <h1 class="text-2xl font-bold">Dashboard</h1>
    <div class="grid grid-cols-2 md:grid-cols-3 mt-5 gap-5 mb-10">
        <a class="stats shadow bg-accent hover:bg-accent/50" href="{{ url('/dashboard/invoice/paid') }}">
            <div class="stat shadow bg-accents">
                <div class="stat-title">Pendapatan Bulan Ini</div>
                <div class="stat-value" id="invoice-paid">0</div>
                <div class="stat-desc">Jumlah Invoice yang sudah lunas</div>
            </div>
        </a>
        <a class="stats shadow bg-accent hover:bg-accent/50" href="{{ url('/dashboard/barang/minimum') }}">
            <div class="stat">
                <div class="stat-title">Total Barang Stok Minim</div>
                <div class="stat-value" id="minimum">0</div>
                <div class="stat-desc">Jumlah Barang dengan stok minim</div>
            </div>
        </a>
        <a class="stats shadow bg-accent hover:bg-accent/50" href="{{ url('/dashboard/po/unpaid') }}">
            <div class="stat">
                <div class="stat-title">Total PO Belum Lunas</div>
                <div class="stat-value" id="po-due">0</div>
                <div class="stat-desc" id="po-total">Total Hutang Rp 0</div>
            </div>
        </a>
        <a class="stats shadow bg-accent hover:bg-accent/50" href="{{ url('/cost') }}">
            <div class="stat">
                <div class="stat-title">Biaya Operasional Bulan Ini</div>
                <div class="stat-value" id="cost">0</div>
                <div class="stat-desc"></div>
            </div>
        </a>
        <a class="stats shadow bg-accent hover:bg-accent/50" href="{{ url('/po') }}">
            <div class="stat">
                <div class="stat-title">Biaya Pembelian Bulan Ini</div>
                <div class="stat-value" id="po">0</div>
                <div class="stat-desc"></div>
            </div>
        </a>
        <a class="stats shadow bg-accent hover:bg-accent/50" href="{{ url('/dashboard/invoice/overdue') }}">
            <div class="stat">
                <div class="stat-title">Invoice Jatuh Tempo</div>
                <div class="stat-value" id="invoice-overdue">0</div>
                <div class="stat-desc">Total Piutang: <span id="invoice-overdue-count"></span></div>
            </div>
        </a>
    </div>

    <h1 class="text-2xl font-bold mb-5">Grafik Perusahaan</h1>
    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 mb-5">
        <div class="p-4 bg-accent rounded w-full mb-10">
            <h1 class="text-lg font-medium">Total Penjualan Barang Tahun Ini</h1>
            <canvas id="chart-penjualan"></canvas>
        </div>
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
        data.count > 0 && $('#minimum').addClass('text-error')
    }

    const getPOJatuhTempo = async () => {
        const response = await fetch(baseURL + '/po/due');
        const data = await response.json();

        $('#po-due').html(data.count);
        $('#po-total').html(`Total Hutang: Rp ${data.total.toLocaleString()}`)
    }

    const getOverdueInvoice = async() => {
        const response = await fetch(baseURL + '/invoice/overdue')
        const data = await response.json();

        $('#invoice-overdue').html(`${data.total.toLocaleString()}`);
        $('#invoice-overdue-count').html(`Rp ${data.total_count.toLocaleString()}`);
    }

    const getPaidInvoiceThisMonth = async() => {
        const response = await fetch(baseURL + '/invoice/paid/monthly')
        const data = await response.json();

        $('#invoice-paid').html(`Rp ${data.total.toLocaleString()}`);
    }

    const getPOThisMonth = async() => {
        const response = await fetch(baseURL + '/po/monthly')
        const data = await response.json();
        console.log(data)

        $('#po').html(`Rp ${data.data.total.toLocaleString()}`);
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
                customCanvasBackgroundColor: {
                    color: 'lightGreen',
                },
                responsive: true,
                scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
        });
    }

    getCost()
    getMinimumBarang()
    getPOJatuhTempo()
    getPaidInvoiceThisMonth()
    getAnalytics()
    getPOThisMonth()
    getOverdueInvoice()
</script>
@endsection
