@extends('template/header')

@section('content')
<?php use Carbon\Carbon; ?>
<div class="prose mb-5">
    <h1 class="text-white">Detail Invoice</h1>
</div>

<p class="text-xl font-semibold">Status Pesanan</p>
@if ($invoice->status == 0)
    <div class="text-red-200 bg-red-600 font-semibold text-xl text-center rounded mt-5 p-3 mb-5">Belum Lunas</div>

    <div class="flex gap-x-5">
        <div class="flex flex-col">
            <h3 class="text-xl font-semibold mb-2">Jatuh Tempo</h3>
            <div class="bg-accent rounded p-4 w-full h-full">
                <p class="text-xl font-semibold mb-2 text-center">{{ $invoice->jatuh_tempo }}</p>
                <hr>
                <p>Kurang <span class="font-bold">{{ $daysLeft }}</span> Hari hingga jatuh tempo</p>
            </div>
        </div>
        <div class="flex flex-col">
            <h3 class="text-xl font-semibold mb-2">Pesanan Sudah Lunas ?</h3>
            <div class="bg-accent rounded p-4 w-full">
                <p>Klik tombol dibawah bila pesanan sudah <span class="text-secondary text-xl font-semibold">Lunas</span></p>
                <form method="post" action="{{ url("/invoice/finish") }}">
                    @csrf
                    <button class="btn btn-sm btn-secondary mt-2" name="id" value="{{ $invoice->id }}">Pesanan, Sudah Lunas !</button>
                </form>
            </div>
        </div>
    </div>
@else
    <div class="text-white bg-secondary font-semibold text-xl text-center rounded mt-5 p-3">Lunas</div>
@endif

<div class="prose mt-5">
    <h3>Informasi Customer</h3>
</div>
<div class="rounded bg-accent p-4 my-5">
    <div class="flex flex-wrap">
        <div class="form-control w-full md:w-1/2 md:pe-2">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-id-badge me-2"></i>Nama</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" class="input input-bordered w-full " value="{{ $invoice->customer->nama }}" disabled/>
        </div>
        <div class="form-control w-full md:w-1/2">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-envelope me-2"></i>Email</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="email" class="input input-bordered w-full" value="{{ $invoice->customer->email }}" disabled/>
        </div>
        <div class="form-control w-full md:w-1/2 md:pe-2">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-location-dot me-2"></i>Alamat</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" class="input input-bordered w-full" value="{{ $invoice->customer->alamat }}" disabled/>
        </div>
        <div class="form-control w-full md:w-1/2">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-phone me-2"></i>Nomor Telp</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" class="input input-bordered w-full" value="{{ $invoice->customer->telp }}" disabled/>
        </div>
    </div>
</div>

<div class="prose">
    <h3>Data Pesanan</h3>
</div>
<div class="rounded bg-accent p-4 my-5">
    <table class="table" id="table">
        <thead>
            <tr>
                <th class="prose"><h3 class="font-bold">Part Number</h3></th>
                <th class="prose"><h3 class="font-bold">Nama</h3></th>
                <th class="prose"><h3 class="font-bold">Harga</h3></th>
                <th class="prose"><h3 class="font-bold">Jumlah</h3></th>
                <th class="prose"><h3 class="font-bold">Subtotal</h3></th>
            </tr>
        </thead>
        <tbody>
        @foreach ($invoice->details as $item)
            <tr>
                <td>{{ $item->part }}</td>
                <td>{{ $item->nama }}</td>
                <td>Rp {{ number_format($item->harga) }}</td>
                <td>{{ number_format($item->qty) }}</td>
                <td>Rp {{ number_format($item->subtotal) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="text-right w-full mt-10">Total Pesanan : <span class="">Rp {{ number_format($invoice->total) }}</span></div>
</div>

@if ($invoice->komisi > 0)
<h3 class="text-xl font-semibold">Komisi</h3>
<div class="rounded bg-accent p-4 my-5">
    <div class="flex gap-4">
        <div class="">
            <p>Penerima Komisi </p>
            <p class="font-semibold">{{ $invoice->contact_person }}</p>
        </div>
        <div class="">
            <p>Jumlah Komisi </p>
            <p class="font-semibold">Rp {{ number_format($invoice->komisi) }}</p>
        </div>
    </div>
</div>
@endif

<h3 class="text-xl font-semibold">Pendapatan</h3>
<div class="rounded bg-accent p-4 my-5">
    <div class="grid grid-cols-2 gap-y-5">
        <div class="">Total Harga</div>
        <div class="text-right">Rp {{ number_format($invoice->total) }}</div>
        <div class="">PPN ({{ $invoice->ppn }}%)</div>
        <div class="text-right">Rp {{ number_format($invoice->grand_total - $invoice->total) }}</div>
        <div class="text-xl font-semibold">Grand Total</div>
        <div class="text-right font-semibold text-xl text-primary">Rp {{ number_format($invoice->grand_total) }}</div>
    </div>
</div>

<h3 class="text-xl font-semibold">Dokumen</h3>
<div class="rounded bg-accent p-4 my-5">
    <div class="flex justify-between">
        <form method="post">
            @csrf
            <button class="btn btn-secondary shadow-lg" name="type" value="invoice"><i class="fa-solid fa-file-pdf"></i>Buat Invoice !</button>
        </form>
        <button class="btn btn-secondary shadow-lg">Buat Surat Jalan !</button>
        <button class="btn btn-secondary shadow-lg">Buat Sesuatu !</button>
        <button class="btn btn-secondary shadow-lg"><i class="fa-solid fa-envelope-open-text"></i></i>Kirim Invoice Ke Customer !</button>
    </div>
</div>

@endsection
