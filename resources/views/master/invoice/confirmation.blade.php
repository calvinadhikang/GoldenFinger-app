@extends('template/header')

@section('content')
<div class="prose">
    <h1 class="text-white">Buat Invoice</h1>
</div>
<div class="mt-5 flex justify-center my-10">
    <ul class="steps w-full">
        <li class="step step-primary"><a href="{{ url('/invoice/add') }}" class="bg-secondary mt-2 rounded-lg p-1 hover:bg-blue-500">Pilih Barang</a></li>
        <li class="step step-primary"><a href="{{ url('/invoice/customer') }}" class="bg-secondary mt-2 rounded-lg p-1 hover:bg-blue-500">Pilih Customer</a></li>
        <li class="step step-primary">Konfirmasi</li>
    </ul>
</div>
<div class="mb-5 mt-10">
    <h2 class="font-bold text-3xl text-primary">Konfirmasi Pesanan</h2>
    <p>Pastikan informasi pesanan, dan customer sudah benar <br> Jangan lupa cek ulang data pesanan dan totalnya</p>
</div>
<div class="prose mt-10">
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
        @foreach ($invoice->list as $item)
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
    <div class="text-right w-full mt-10">
        Grand Total : <span class="text-2xl font-bold text-primary">Rp {{ number_format($invoice->grandTotal) }}</span>
    </div>
</div>

<form method="POST">
    @csrf
    <button class="btn btn-primary w-full mb-10 shadow-lg">Buat Pesanan !</button>
</form>
@endsection
