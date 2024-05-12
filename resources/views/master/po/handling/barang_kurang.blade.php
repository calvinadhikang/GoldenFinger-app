@extends('template/header')

@section('content')
<h1 class="text-white text-2xl font-bold mb-5">Purhcase Orders - Barang Datang Kurang</h1>
<div class="rounded bg-accent p-4 my-5">
    <div class="grid grid-cols-2 gap-y-2">
        <div class="text-xl font-semibold">Kode Transaksi</div>
        <div class="text-right text-lg font-medium">{{ $po->kode }}</div>
        <div class="divider"></div>
        <div class="divider"></div>
        <div class="">Total Harga</div>
        <div class="text-right">Rp {{ number_format($po->total) }}</div>
        <div class="">PPN ({{ $po->ppn }}%)</div>
        <div class="text-right">Rp {{ number_format($po->ppn_value) }}</div>
        <div class="text-xl font-semibold">Grand Total</div>
        <div class="text-right font-semibold text-xl text-primary">Rp {{ number_format($po->grand_total) }}</div>
    </div>
</div>

<h3 class="text-xl font-semibold">Informasi Vendor</h3>
<div class="rounded bg-accent p-4 my-5">
    <div class="flex flex-wrap">
        <div class="form-control w-full md:w-1/2 md:pe-2">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-id-badge me-2"></i>Nama</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" class="input input-bordered w-full " value="{{ $po->vendor->nama }}" disabled/>
        </div>
        <div class="form-control w-full md:w-1/2">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-envelope me-2"></i>Email</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="email" class="input input-bordered w-full" value="{{ $po->vendor->email }}" disabled/>
        </div>
        <div class="form-control w-full md:w-1/2 md:pe-2">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-location-dot me-2"></i>Alamat</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" class="input input-bordered w-full" value="{{ $po->vendor->alamat }}" disabled/>
        </div>
        <div class="form-control w-full md:w-1/2">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-phone me-2"></i>Nomor Telp</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" class="input input-bordered w-full" value="{{ $po->vendor->telp }}" disabled/>
        </div>
    </div>
</div>

<h3 class="text-xl font-semibold">Konfirmasi Data Pesanan</h3>
<form method="POST">
    @csrf
    <div class="rounded bg-accent p-4 my-5">
        <table class="data-table">
            <thead>
                <tr>
                    <th><h3 class="font-bold">Part Number</h3></th>
                    <th><h3 class="font-bold">Nama</h3></th>
                    <th><h3 class="font-bold">Harga</h3></th>
                    <th><h3 class="font-bold">Jumlah Barang Diterima</h3></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($po->details as $item)
                <tr>
                    <td>{{ $item->part }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>Rp {{ number_format($item->harga) }}</td>
                    <td>
                        <input type="hidden" name="id[]" value="{{ $item->id }}">
                        <label class="text-xs text-gray-400">Nilai awal: {{ $item->qty }}</label> <br>
                        <input type="number" class="input input-bordered input-secondary" name="qty[]" value="{{ $item->qty }}">
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="text-right w-full mt-10">Total Pesanan : Rp {{ number_format($po->total) }}</div>
    </div>

    <button class="btn btn-primary btn-block mb-10">Konfirmasi</button>
</form>
@endsection
