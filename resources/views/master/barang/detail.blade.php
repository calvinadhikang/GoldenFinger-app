@extends('template/header')

@section('content')
<div class="prose">
    <h1 class="text-white">Detail Barang</h1>
</div>
<div class="rounded bg-accent p-4 my-5">
    <form method="POST">
        @csrf
        <input type="hidden" value="{{ $barang->id }}" name="id">
        <div class="flex flex-wrap my-5">
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
                <input type="number" placeholder="1000" class="input input-bordered w-full" name="harga" value="{{ $barang->harga }}" required/>
            </div>
        </div>
        <button class="btn btn-primary">Simpan</button>
    </form>

</div>

<h1 class="text-xl font-medium mb-3">Statistik</h1>
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
@endsection
