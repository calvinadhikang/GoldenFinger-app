@extends('template/header')

@section('content')
<div class="prose mb-5">
    <h1 class="text-white">Detail Purhcase Orders</h1>
</div>

<dialog id="modal_pembayaran" class="modal">
    <div class="modal-box bg-slate-300">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="font-bold text-lg">Pelunasan Pesanan</h3>
        <p class="py-4">Pastikan kembali bahwa barang pesanan sudah tiba dan sesuai. <br> Bila sudah, tekan tombol dibawah untuk konfirmasi pembayaran</p>
        <div class="flex gap-x-3">
            <form action="{{ url("/po/confirmation/pembayaran") }}" method="post">
                @csrf
                <button class="btn btn-primary" name="id" value="{{ $po->id }}">Ya, Sudah Lunas</button>
            </form>
            <form method="dialog">
                <button class="btn btn-outline btn-error">Batal</button>
            </form>
        </div>
    </div>
</dialog>

<div class="grid grid-cols-2 gap-x-10">
    <div class="">
        <p class="text-xl font-semibold mb-5">Status Pesanan</p>
        <div class="rounded p-4 bg-accent">
            @if ($po->status_pesanan == 0)
                <div class="text-white bg-error font-semibold text-xl text-center rounded p-3">Process</div>
                <p class="mt-10">Barang pesanan sudah sampai ?</p>
                <a href="{{ url("/po/confirmation/pesanan/$po->id") }}" class="btn btn-primary">
                    Ya, Sudah Sampai
                </a>
            @else
                <div class="bg-secondary font-semibold text-xl text-center rounded p-3">Barang Sudah Sampai</div>
            @endif
        </div>
    </div>
    <div class="">
        <p class="text-xl font-semibold mb-5">Status Pembayaran</p>
        <div class="rounded p-4 bg-accent">
            @if ($po->status_pembayaran == 0)
                <div class="text-red-50 bg-error font-semibold text-xl text-center rounded p-3">Belum Bayar</div>

                <div class="grid grid-cols-2 mt-10">
                    <p class="text-lg font-semibold">Tanggal Jatuh Tempo</p>
                    <p class="text-lg font-semibold text-right">{{ $po->jatuh_tempo }}</p>
                </div>
                <hr>
                <p>Kurang <span class="font-bold">{{ $daysLeft }}</span> Hari hingga jatuh tempo</p>

                <button class="btn btn-primary" onclick="modal_pembayaran.showModal()">Ya, Sudah Lunas</button>
            @else
                <div class="bg-secondary font-semibold text-xl text-center rounded p-3">Transaksi Telah Dibayar</div>
                <div class="grid grid-cols-2 mt-10">
                    <p class="text-lg font-semibold">Tanggal Jatuh Tempo</p>
                    <p class="text-lg font-semibold text-right">{{ $po->jatuh_tempo }}</p>
                </div>
            @endif
        </div>
    </div>
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
        @foreach ($po->details as $item)
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
    <div class="text-right w-full mt-10">Total Pesanan : <span class="">Rp {{ number_format($po->total) }}</span></div>
</div>

<h3 class="text-xl font-semibold">Rincian Harga</h3>
<div class="rounded bg-accent p-4 my-5">
    <div class="grid grid-cols-2 gap-y-5">
        <div class="">Total Harga</div>
        <div class="text-right">Rp {{ number_format($po->total) }}</div>
        <div class="">PPN ({{ $po->ppn }}%)</div>
        <div class="text-right">Rp {{ number_format($po->grand_total - $po->total) }}</div>
        <div class="text-xl font-semibold">Grand Total</div>
        <div class="text-right font-semibold text-xl text-primary">Rp {{ number_format($po->grand_total) }}</div>
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
