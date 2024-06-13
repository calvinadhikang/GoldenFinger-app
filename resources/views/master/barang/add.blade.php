@extends('template/header')

@section('content')
<h1 class="text-2xl font-bold">Tambah Barang</h1>
<div class="text-sm breadcrumbs mb-5">
    <ul>
        <li><a href="/barang">Data Barang</a></li>
        <li>Tambah Barang</li>
    </ul>
</div>
<div class="rounded bg-accent p-4 my-5">
    <form method="POST">
        @csrf
        <div class="flex flex-wrap mb-5">
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text text-lg font-bold">Part Number</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="B001..." class="input w-full" name="part" required/>
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text text-lg font-bold">Nama</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="Nama Barang..." class="input w-full" name="nama" required/>
            </div>
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text text-lg font-bold">Harga Jual (Rp)</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="1000" class="input w-full harga" name="harga" required/>
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text text-lg font-bold">Stok Minimum</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="number" placeholder="Ban..." value="10" class="input w-full" name="batas" required/>
            </div>
        </div>
        <div class="my-5 space-y-2">
            <div class="label-text text-lg font-bold">Deskripsi Barang</div>
            <textarea name="description" class="textarea w-full" rows="5"></textarea>
        </div>
        <button class="btn btn-primary">Tambah</button>
    </form>
</div>

@endsection
