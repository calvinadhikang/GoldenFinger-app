@extends('template/header')

@section('content')
<h1 class="text-2xl font-bold">Tambah Service Vulkanisir</h1>
<div class="text-sm breadcrumbs mb-5 text-slate-300">
    <ul>
        <li><a href="/vservice">Data Service Vulkanisir</a></li>
        <li>Tambah Service Vulkanisir</li>
    </ul>
</div>
<div class="mt-5 flex justify-center my-10">
    <ul class="steps w-full">
        <li class="step step-primary">Pilih Customer</li>
        <li class="step step-primary">Isi Keterangan</li>
        <li class="step step-primary font-medium">Konfirmasi</li>
    </ul>
</div>

<div class="mb-5 mt-10">
    <h2 class="font-bold text-xl">Konfirmasi Service Vulkanisir</h2>
    <p>Pastikan informasi pesanan, dan customer sudah benar.</p>
    <p>Jangan lupa cek ulang data pesanan dan totalnya.</p>
</div>

<h3 class="font-semibold text-xl mb-5">Informasi Customer</h3>
<div class="rounded bg-accent p-4 my-5">
    <div class="flex flex-wrap">
        <div class="form-control w-full md:w-1/2 md:pe-2">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-id-badge me-2"></i>Nama</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" class="input input-bordered w-full " value="{{ $service->customer->nama }}" disabled/>
        </div>
        <div class="form-control w-full md:w-1/2">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-envelope me-2"></i>Email</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="email" class="input input-bordered w-full" value="{{ $service->customer->email }}" disabled/>
        </div>
        <div class="form-control w-full md:w-1/2 md:pe-2">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-location-dot me-2"></i>Alamat</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" class="input input-bordered w-full" value="{{ $service->customer->alamat }}" disabled/>
        </div>
        <div class="form-control w-full md:w-1/2">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-phone me-2"></i>Nomor Telp</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" class="input input-bordered w-full" value="{{ $service->customer->telp }}" disabled/>
        </div>
    </div>
</div>

<h2 class="font-semibold text-xl mb-5">Detail Service</h2>
<div class="rounded bg-accent p-4 my-5 items-center">
    <div class="grid gap-y-3 grid-cols-2">
        <p class="font-medium">Mesin Service</p>
        <p class="text-end">{{ $machine->nama }}</p>
        <p class="font-medium">Perkiraan Waktu Service Selesai</p>
        <p class="text-end">{{ $service->will_finish_at }}</p>
    </div>
    <div class="divider"></div>
    <div class="grid gap-y-3 grid-cols-2">
        <p class="font-medium">Total Harga Service</p>
        <p class="text-end">Rp {{ format_decimal($service->total) }}</p>
        <p class="font-medium">Total Pajak ({{ $service->PPN }})%</p>
        <p class="text-end">Rp {{ format_decimal($service->PPN_value) }}</p>
        <p class="font-medium">Total Biaya</p>
        <p class="text-end text-lg text-primary font-semibold">Rp {{ format_decimal($service->grandTotal) }}</p>
    </div>
</div>

<form method="POST">
    @csrf
    <h2 class="font-semibold text-xl mb-5">Pilih Teknisi</h2>
    <div class="bg-accent p-4 rounded mb-5">
        <select name="teknisi" class="w-full select" required>
            <option value="" selected disabled>Nama Teknisi</option>
            @foreach ($teknisi as $item)
            <option value="{{ $item->id }}">{{ $item->nama }}</option>
            @endforeach
        </select>
    </div>
    <button class="btn btn-primary w-full mb-10 shadow-lg">Buat Pesanan !</button>
</form>
@endsection
