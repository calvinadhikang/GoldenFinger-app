@extends('template/header')

@section('content')
<h1 class="text-2xl font-bold">Detail Service Vulkanisir</h1>
<div class="text-sm breadcrumbs mb-5 text-slate-300">
    <ul>
        <li><a href="/vservice">Data Service Vulkanisir</a></li>
        <li>Detail Service Vulkanisir</li>
    </ul>
</div>
<div class="flex items-center justify-between">
    <h1 class="font-medium text-xl">Status Service</h1>
    <div class="text-end p-2 rounded-lg">
        @if ($service_status == 'Canceled')
        <span class="badge badge-error font-medium">{{ $service_status }}</span>
        @elseif ($service_status == 'Finished')
        <span class="badge badge-success font-medium">{{ $service_status }}</span>
        @elseif ($service_status == 'Pickup')
        <span class="badge badge-secondary font-medium">{{ $service_status }}</span>
        @else
        <span class="badge badge-neutral font-medium">{{ $service_status }}</span>
        @endif
    </div>
</div>
<div class="bg-accent p-4 rounded my-5">
    @if ($service_status == 'Pickup')
    <form method="POST" class="space-y-2" action="{{ url("/vservice/finish") }}">
        @csrf
        <label class="font-medium">Nama Pengambil</label>
        <input type="text" class="input input-bordered w-full" name="taken_by" required>
        <button class="btn btn-primary" name="service_id" value="{{ $service->id }}">Simpan!</button>
    </form>
    @elseif ($service_status == 'Canceled')
    <p class="text-error mb-2">Dibatalkan oleh : <span class="font-medium">{{ $service->teknisi->nama }}</span></p>
    <textarea readonly class="textarea w-full" cols="2" rows="2">{{ $service->cancel_reason }}</textarea>
    @elseif ($service_status == 'Finished')
    <p>Pesanan sudah diambil oleh : <span class="font-medium">{{ $service->taken_by }}</span></p>
    @else
    <p class="font-medium text-lg mb-5">Untuk membatalkan pesanan tulis form dibawah!</p>
    <form method="POST" class="space-y-2" action="{{ url("/vservice/cancel") }}">
        @csrf
        <label class="font-medium">Alasan pembatalan</label>
        <textarea type="text" class="textarea textarea-error w-full" name="cancel_reason" required></textarea>
        <label class="font-medium">Password User</label>
        <input type="password" class="w-full input input-error" name="password">
        <button class="btn btn-error" name="service_id" value="{{ $service->id }}">Batalkan!</button>
    </form>
    @endif
</div>

<h1 class="font-medium text-xl">Detail Service</h1>
<div class="rounded bg-accent p-4 my-5">
    <div class="grid gap-y-3 grid-cols-2">
        <p class="font-medium">Nama Teknisi</p>
        <p class="text-end">{{ $service->teknisi->nama }}</p>
        <p class="font-medium">Mesin Service</p>
        <p class="text-end">{{ $service->machine->nama }}</p>
        <p class="font-medium">Perkiraan Waktu Service Selesai</p>
        <p class="text-end">{{ $service->will_finish_at }}</p>
        <p class="font-medium">Total Biaya Service (Termasuk Pajak)</p>
        <p class="text-end text-lg text-primary font-semibold">Rp {{ format_decimal($service->harga) }}</p>
    </div>
</div>

<h1 class="font-medium text-xl">Detail Customer</h1>
<div class="bg-accent p-4 rounded my-5">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
        <div class="form-control">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-id-badge me-2"></i>Nama</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" class="input input-bordered w-full " value="{{ $service->customer->nama }}" disabled/>
        </div>
        <div class="form-control">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-envelope me-2"></i>Email</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="email" class="input input-bordered w-full" value="{{ $service->customer->email }}" disabled/>
        </div>
        <div class="form-control">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-location-dot me-2"></i>Alamat</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" class="input input-bordered w-full" value="{{ $service->customer->alamat }}" disabled/>
        </div>
        <div class="form-control">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-phone me-2"></i>Nomor Telp</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" class="input input-bordered w-full" value="{{ $service->customer->telp }}" disabled/>
        </div>
    </div>
</div>
@endsection
