@extends('template/header')

@section('content')
<div class="prose">
    <h1 class="text-white">Tambah Barang</h1>
</div>
<div class="rounded bg-accent p-4 my-5">
    <div class="flex flex-wrap my-5">
        <div class="form-control w-full">
            <label class="label">
                <span class="label-text text-lg font-bold">Part Number</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" placeholder="B001..." class="input input-bordered w-full" />
        </div>
        <div class="form-control w-full md:w-1/2 md:pe-2">
            <label class="label">
                <span class="label-text text-lg font-bold">Nama Barang</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" placeholder="Ban..." class="input input-bordered w-full" />
        </div>
        <div class="form-control w-full md:w-1/2">
            <label class="label">
                <span class="label-text text-lg font-bold">Harga Jual (Rp)</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="number" placeholder="1000" class="input input-bordered w-full" />
        </div>
    </div>
    <button class="btn btn-base text-white">Tambah</button>
</div>

@endsection
