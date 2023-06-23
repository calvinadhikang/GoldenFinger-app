@extends('template/header')

@section('content')
<div class="prose">
    <h1 class="text-white">Buat PO</h1>
</div>
<div class="mt-5 overflow-x-auto grid place-items-center w-full">
    <ul class="steps">
        <li class="step me-5 step-primary">Pilih Barang</li>
        <li class="step me-5">Pilih Distributor</li>
        <li class="step">Konfirmasi</li>
    </ul>
</div>
<div class="rounded bg-accent p-4 my-5">
    <div class="flex flex-wrap my-5">
        <div class="form-control w-full">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-id-badge me-2"></i>Nama</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" placeholder="Joko.." class="input input-bordered w-full" />
        </div>
        <div class="form-control w-full md:w-1/2 md:pe-2">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-key me-2"></i>Password</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" placeholder="Ban..." class="input input-bordered w-full" />
        </div>
        <div class="form-control w-full md:w-1/2">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-phone me-2"></i>Nomor Telp</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" placeholder="081..." class="input input-bordered w-full" />
        </div>
        <div class="form-control w-full">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-dice-d6 me-2"></i>Role</span>
                <span class="label-text-alt"></span>
            </label>
            <select name="" id="" class="input input-bordered w-full">
                <option value="" selected disabled>Pilih Role</option>
                <option value="">Admin</option>
                <option value="">Pembelian</option>
                <option value="">Penjualan</option>
            </select>
        </div>
    </div>
    <button class="btn btn-primary">Tambah</button>
</div>

@endsection
