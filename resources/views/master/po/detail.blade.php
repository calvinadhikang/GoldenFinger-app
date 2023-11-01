@extends('template/header')

@section('content')
<h1 class="text-white text-2xl font-bold mb-5">Detail Purhcase Orders</h1>
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
<div class="grid grid-cols-2 gap-x-5">
    <div class="">
        <p class="text-xl font-semibold mb-5">Status Pesanan</p>
        <div class="rounded p-4 bg-accent">
            @if ($po->status_pesanan == 0)
                <div class="text-white bg-error font-semibold text-xl text-center rounded p-3">On Process</div>
                <p class="mt-10 mb-2">Barang pesanan sudah sampai ?</p>
                <button onclick="modal_pesanan.showModal()" class="btn btn-primary">
                    Ya, Sudah Sampai
                </button>
            @else
                <div class="bg-secondary font-semibold text-xl text-center rounded p-3">Barang Sudah Sampai</div>
                <div class="grid grid-cols-2 mt-2">
                    <p>Tanggal Diterima</p>
                    <p class="text-right">{{ date_format(new DateTime($po->recieved_at), 'd M Y H:i') }}</p>
                </div>
            @endif
        </div>
    </div>
    <div class="">
        <p class="text-xl font-semibold mb-5">Status Pembayaran</p>
        <div class="rounded p-4 bg-accent">
            @if ($po->status_pembayaran == 1)
                <div class="bg-secondary font-semibold text-xl text-center rounded p-3">Transaksi Telah Dibayar</div>
            @else
                <div class="text-red-50 bg-error font-semibold text-xl text-center rounded p-3">Belum Bayar</div>
                <p class="text-right">Kurang <span class="font-bold">{{ $daysLeft }}</span> Hari hingga jatuh tempo</p>

                <h1 class="mt-5 mb-2">Pesanan sudah dibayar ?</h1>
                <button class="btn btn-primary" onclick="modal_pembayaran.showModal()">Ya, Sudah Lunas</button>
                <div class="divider"></div>
            @endif
            <div class="grid grid-cols-2 mt-2">
                <p class="">Tanggal Jatuh Tempo</p>
                <p class="text-right">{{ date_format(new DateTime($po->jatuh_tempo), 'd M Y H:i') }}</p>
                @if ($po->status_pembayaran == 1)
                    <p class="">Tanggal Pembayaran</p>
                    <p class="text-right">{{ date_format(new DateTime($po->paid_at), 'd M Y H:i') }}</p>
                @endif
            </div>
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
        <p class="py-4">Pastikan kembali bahwa barang pesanan sudah tiba dan sesuai. <br> Bila sudah, tekan tombol dibawah untuk konfirmasi pembayaran</p>
        <div class="flex gap-x-3">
            <form action="{{ url("/po/pembayaran") }}" method="post">
                @csrf
                <button class="btn btn-primary" name="id" value="{{ $po->id }}">Ya, Sudah Lunas</button>
            </form>
            <form method="dialog">
                <button class="btn btn-outline btn-error">Batal</button>
            </form>
        </div>
    </div>
</dialog>

<dialog id="modal_pesanan" class="modal">
    <div class="modal-box bg-slate-300">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="font-bold text-lg">Konfirmasi Pesanan</h3>
        <p class="mb-4">Bagaimana jumlah Pesanan yang datang ?</p>
        <div class="">
            <form action="{{ url("/po/pesanan") }}" method="POST">
                @csrf
                <div class="grid gap-y-4">
                    <label class="label cursor-pointer font-semibold">
                        <span><i class="fa-solid fa-check"></i> Jumlah Barang Sesuai</span>
                        <input type="radio" name="status" value="0" class="radio border-black checked:bg-secondary"/>
                    </label>
                    <label class="label cursor-pointer font-semibold">
                        <span><i class="fa-solid fa-plus"></i> Jumlah Barang Lebih Banyak</span>
                        <input type="radio" name="status" value="1" class="radio border-black checked:bg-secondary"/>
                    </label>
                    <label class="label cursor-pointer font-semibold">
                        <span><i class="fa-solid fa-minus"></i> Jumlah Barang Kurang</span>
                        <input type="radio" name="status" value="-1" class="radio border-black checked:bg-secondary"/>
                    </label>
                </div>
                <p class="pt-4 pb-2 text-sm text-gray-500">Pastikan telah mengecek pesanan yang datang dengan baik !</p>
                <button class="btn btn-primary" name="id" value="{{ $po->id }}">Ya, Sudah Lunas</button>
            </form>
        </div>
        <form method="dialog" class="mt-2">
            <button class="btn btn-outline btn-error">Batal</button>
        </form>
    </div>
</dialog>
@endsection
