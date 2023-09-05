@extends('template/header')

@section('content')
<?php use Carbon\Carbon; ?>
<div class="prose">
    <h1 class="text-white">Detail Invoice</h1>
</div>

@if ($invoice->status == 0)
    <div class="text-red-800 bg-red-400 font-semibold text-xl text-center rounded mt-5 p-3">Belum Lunas</div>

    <?php
    // Get the current date and time
    $currentDate = Carbon::now();
    // Calculate the difference in days
    $daysLeft = $currentDate->diffInDays($invoice->jatuh_tempo);
    ?>
    <h3 class="text-xl font-semibold">Jatuh Tempo</h3>
    <div class="bg-accent rounded p-4 w-full">
        <p>{{ $invoice->jatuh_tempo }}</p>
        <p class="">Kurang <span class="font-bold">{{ $daysLeft }}</span> Hari hingga jatuh tempo</p>
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
    <div>PPN ({{ $invoice->ppn }}%) : <span class="">Rp {{ number_format($invoice->total - $invoice->grand_total) }}</span></div>
    <div>Grand Total : <span class="text-2xl font-bold text-primary">Rp {{ number_format($invoice->total) }}</span></div>
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
