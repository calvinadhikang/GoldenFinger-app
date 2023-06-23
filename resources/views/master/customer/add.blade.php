@extends('template/header')

@section('content')
<div class="prose">
    <h1 class="text-white">Tambah Customer</h1>
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
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-location-dot me-2"></i>Alamat</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" placeholder="Jalan..." class="input input-bordered w-full" />
        </div>
        <div class="form-control w-full md:w-1/2">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-phone me-2"></i>Nomor Telp</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" placeholder="081..." class="input input-bordered w-full" />
        </div>
    </div>
    <button class="btn btn-primary">Tambah</button>
</div>

@endsection
