@extends('template/header')

@section('content')
<h1 class="text-2xl font-bold">Detail Barang</h1>
<div class="text-sm breadcrumbs mb-5 text-slate-300">
    <ul>
        <li><a href="/barang">Data Barang</a></li>
        <li>Tambah Barang</li>
    </ul>
</div>
<div class="rounded bg-accent p-4 my-5">
    <form method="POST">
        @csrf
        <input type="hidden" value="{{ $barang->id }}" name="id">
        <div class="flex flex-wrap mb-5">
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text text-lg font-bold">Part Number</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="B001..." class="input input-bordered w-full" name="part" value="{{ $barang->part }}" required/>
            </div>
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text text-lg font-bold">Nama</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="Ban..." class="input input-bordered w-full" name="nama" value="{{ $barang->nama }}" required/>
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text text-lg font-bold">Harga Jual (Rp)</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="1000" class="input input-bordered w-full harga" name="harga" value="{{ number_format($barang->harga) }}" required/>
            </div>
        </div>
        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
<h1 class="text-xl font-medium my-5">Status Barang</h1>
<div class="bg-accent p-4 rounded grid grid-cols-2 items-center">
    <p class="font-semibold text-xl {{ $barang->deleted_at ? 'text-error' : 'text-secondary' }}">{{ $barang->deleted_at ? 'Terhapus' : 'Tersedia' }}</p>
    <form action="{{ url("/barang/detail/$barang->part/toggle") }}" class="text-right" method="POST">
        @csrf
        <button class="btn {{ $barang->deleted_at ? 'btn-secondary' : 'btn-error' }}">{{ $barang->deleted_at ? 'Aktifkan' : 'Hapus' }}</button>
    </form>
</div>

<h1 class="text-xl font-medium my-5">Statistik</h1>
<div class="flex gap-5">
    <div class="stats shadow bg-accent">
        <div class="stat">
            <div class="stat-title">Jumlah Stok</div>
            <div class="stat-value">{{ $barang->stok }}</div>
            <div class="stat-desc"><a href="{{ url('/po') }}">Tambah Stok</a></div>
        </div>
    </div>
    <div class="stats shadow bg-accent">
        <div class="stat">
            <div class="stat-title">Pembelian Bulan Ini</div>
            <div class="stat-value">0 pcs</div>
            <div class="stat-desc">0% dari bulan lalu</div>
        </div>
    </div>
</div>

<h1 class="text-xl font-medium my-5">Mutasi Stok</h1>
<div class="p-4 rounded bg-accent mb-5">
    @foreach ($barang->mutation as $item)
        <div class="rounded bg-slate-700 bg-opacity-20 rounded-b-none p-2 grid grid-cols-4 border-b border-b-gray-500">
            <div class="">
                <h1 class="text-lg">Qty</h1>
                <h1 class="text-sm">{{ $item->qty }}</h1>
            </div>
            <div class="">
                <h1 class="text-lg">Harga</h1>
                <h1 class="text-sm">{{ format_decimal($item->harga) }}</h1>
            </div>
            <div class="">
                <h1 class="text-lg">Status</h1>
                <h1 class="text-sm badge {{ $item->status == 'masuk' ? 'badge-secondary' : 'badge-warning' }} ">{{ $item->status }}</h1>
            </div>
            <div class="">
                <h1 class="text-lg">Tanggal</h1>
                <h1 class="text-sm">{{ date_format($item->created_at, 'd M Y') }}</h1>
            </div>
        </div>
    @endforeach
</div>
@endsection
