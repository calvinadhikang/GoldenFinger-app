@extends('template/header')

@section('content')
<div class="rounded bg-accent p-4 my-5">
    <h1>Detail Barang</h1>
    <div class="flex-wrap my-5">
        <div class="form-control w-full max-w-xs">
            <label class="label">
                <span class="label-text">Part Number</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" placeholder="B001..." class="input input-bordered w-full max-w-xs" />
        </div>
        <div class="form-control w-full max-w-xs">
            <label class="label">
                <span class="label-text">Nama Barang</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" placeholder="Ban..." class="input input-bordered w-full max-w-xs" />
        </div>
        <div class="form-control w-full max-w-xs">
            <label class="label">
                <span class="label-text">Harga Jual (Rp)</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="number" placeholder="1000" class="input input-bordered w-full max-w-xs" />
        </div>
    </div>
    <button class="btn btn-primary">Simpan</button>
</div>

@endsection
