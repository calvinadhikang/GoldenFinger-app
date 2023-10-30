@extends('template/header')

@section('content')
<div class="prose mb-5">
    <h1 class="text-white">Detail Invoice</h1>
</div>

<p class="text-xl font-semibold">Status Pembayaran</p>
<div class="p-4 rounded bg-accent">
    @if ($invoice->status == 0)
        <div class="text-red-200 bg-red-600 font-semibold text-xl text-center rounded mt-5 p-3 mb-5">Belum Lunas</div>
    @else
        <div class="text-white bg-secondary font-semibold text-xl text-center rounded mt-5 p-3">Lunas</div>
    @endif

    <div class="grid grid-cols-2 mt-10">
        <p class="text-lg font-semibold">Tanggal Jatuh Tempo</p>
        <p class="text-lg font-semibold text-right">{{ $invoice->jatuh_tempo }}</p>
    </div>
    @if ($invoice->status == 0)
        <p class="text-right">Kurang <span class="font-bold text-lg">{{ $daysLeft }}</span> Hari hingga jatuh tempo</p>
    @endif

    @if ($invoice->status == 0)
        <div class="divider"></div>
        <div class="grid grid-cols-2">
            <div class="">
                <h3 class="text-xl font-semibold">Pesanan Sudah Lunas ?</h3>
                <p>Klik tombol dibawah bila pesanan sudah <span class="text-secondary text-xl font-semibold">Lunas</span></p>
            </div>
            <button class="btn btn-primary mt-2" onclick="modal_pembayaran.showModal()">Pesanan, Sudah Lunas !</button>
        </div>
    @endif
</div>

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

<h3 class="text-xl font-semibold">Pendapatan</h3>
<div class="rounded bg-accent p-4 my-5">
    <div class="grid grid-cols-2 gap-y-2">
        <div class="">Total Harga</div>
        <div class="text-right">Rp {{ number_format($invoice->total) }}</div>
        <div class="">PPN ({{ $invoice->ppn }}%)</div>
        <div class="text-right">Rp {{ number_format($invoice->ppn_value) }}</div>
        <div class="text-xl font-semibold">Grand Total</div>
        <div class="text-right font-semibold text-xl text-primary">Rp {{ number_format($invoice->grand_total) }}</div>
    </div>
</div>

@if ($invoice->komisi > 0)
<h3 class="text-xl font-semibold">Komisi</h3>
<div class="rounded bg-accent p-4 my-5">
    <div class="grid grid-cols-2 gap-4">
        <div class="">
            <p>Penerima Komisi </p>
            <p class="text-lg font-semibold">{{ $invoice->contact_person }}</p>
        </div>
        <div class="">
            <p>Jumlah Komisi </p>
            <p class="text-lg font-semibold">Rp {{ number_format($invoice->komisi) }}</p>
        </div>
    </div>
    <div class="divider"></div>
    <div class="mt-5 grid grid-cols-2">
        <div class="">Grand Total</div>
        <div class="text-right">Rp {{ number_format($invoice->grand_total) }}</div>
        <div class="">Komisi</div>
        <div class="text-right">- Rp {{ number_format($invoice->komisi) }}</div>
        <div class="text-xl font-semibold">Total Pendapatan - Komisi</div>
        <div class="text-right font-semibold text-xl text-primary">Rp {{ number_format($invoice->grand_total - $invoice->komisi) }}</div>
    </div>
</div>
@endif

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

<dialog id="modal_pembayaran" class="modal">
    <div class="modal-box bg-slate-300">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="font-bold text-lg">Pelunasan Pesanan</h3>
        <p class="py-4">Pastikan kembali bahwa pesanan sudah dibayar oleh customer. <br> Bila sudah yakin, tekan tombol dibawah</p>
        <div class="flex gap-x-3">
            <form method="post" action="{{ url("/invoice/finish") }}">
                @csrf
                <button class="btn btn-primary" name="id" value="{{ $invoice->id }}">Ya, Sudah Lunas !</button>
            </form>
            <form method="dialog">
                <button class="btn btn-outline btn-error">Batal</button>
            </form>
        </div>
    </div>
</dialog>
@endsection
