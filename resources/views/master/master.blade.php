@extends('template/header')

@section('content')
    <h1 class="text-xl font-medium">Dashboard</h1>
    <div class="grid grid-rows-1 grid-cols-2 md:grid-cols-4 mt-5 gap-5 mb-10">
        <div class="stats shadow bg-accent">
            <div class="stat">
                <div class="stat-title">Pendapatan Bulan Ini</div>
                <div class="stat-value">Rp 89,400</div>
                <div class="stat-desc">21% dari bulan lalu</div>
            </div>
        </div>
        <div class="stats shadow bg-accent">
            <div class="stat">
                <div class="stat-title">Total Barang Stok Minim</div>
                <div class="stat-value">0</div>
                <div class="stat-desc">21% dari bulan lalu</div>
            </div>
        </div>
        <div class="stats shadow bg-accent">
            <div class="stat">
                <div class="stat-title">Total Vendor Jatuh Tempo</div>
                <div class="stat-value">0</div>
                <div class="stat-desc">21% dari bulan lalu</div>
            </div>
        </div>
        <div class="stats shadow bg-accent">
            <div class="stat">
                <div class="stat-title">Pengeluaran Bulan Ini</div>
                <div class="stat-value">0</div>
                <div class="stat-desc">21% dari bulan lalu</div>
            </div>
        </div>
    </div>

    <h1 class="text-xl font-medium">Analytics</h1>
    <div class="">

    </div>
@endsection
