@extends('template/header')

@section('content')
    <h1 class="text-xl font-medium">Dashboard</h1>
    <div class="grid grid-rows-1 grid-cols-2 lg:grid-cols-4 mt-5 gap-5 mb-10">
        <a class="stats shadow bg-accent hover:bg-accent/50" href="{{ url('/invoice') }}">
            <div class="stat shadow bg-accents">
                <div class="stat-title">Pendapatan Bulan Ini</div>
                <div class="stat-value">Rp 89,400</div>
                <div class="stat-desc">21% dari bulan lalu</div>
            </div>
        </a>
        <a class="stats shadow bg-accent hover:bg-accent/50" href="{{ url('/barang') }}">
            <div class="stat">
                <div class="stat-title">Total Barang Stok Minim</div>
                <div class="stat-value">0</div>
                <div class="stat-desc">21% dari bulan lalu</div>
            </div>
        </a>
        <a class="stats shadow bg-accent hover:bg-accent/50" href="{{ url('/invoice') }}">
            <div class="stat">
                <div class="stat-title">Total Vendor Jatuh Tempo</div>
                <div class="stat-value">0</div>
                <div class="stat-desc">21% dari bulan lalu</div>
            </div>
        </a>
        <a class="stats shadow bg-accent hover:bg-accent/50" href="{{ url('/cost') }}">
            <div class="stat">
                <div class="stat-title">Pengeluaran Bulan Ini</div>
                <div class="stat-value" id="cost">0</div>
                <div class="stat-desc">21% dari bulan lalu</div>
            </div>
        </a>
    </div>

    <h1 class="text-xl font-medium">Analytics</h1>
    <div class="">

    </div>

<script>
    const baseURL = '<?= url('/api') ?>'
    const getCost = async () => {
        const response = await fetch(baseURL + '/cost/monthly');
        const data = await response.json();

        $('#cost').html(`Rp ${data.total.toLocaleString()}`)
    }

    getCost()
</script>
@endsection
