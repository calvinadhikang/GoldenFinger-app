@extends('template/header')

@section('content')
<h1 class="text-white text-2xl font-bold">Detail Purhcase Orders</h1>
<div class="text-sm breadcrumbs mb-5 text-slate-300">
    <ul>
        <li><a href="/po">Data Purchase Order</a></li>
        <li>Buat Purchase Order</li>
    </ul>
</div>
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

@if ($po->deleted_at)
<h3 class="text-xl font-semibold text-secondary">Aktifkan Transaksi Purchase Order</h3>
<div class="rounded bg-accent p-4 my-5">
    <p>Status Purchase Order saat ini adalah <span class="text-error font-semibold">Tidak Aktif</span> <br>
    Untuk mengaktifkan kembali Purchase Order silahkan isi password dibawah dan tekan tombol</p>
    <form method="POST" action="{{ url("/po/detail/$po->id/restore") }}">
        @csrf
        <p class="text-sm mt-2">Password</p>
        <div class="flex items-center gap-x-2">
            <input type="password" name="password" class="input input-secondary" required>
            <button class="btn btn-secondary">Aktifkan Purchase Order</button>
        </div>
    </form>
</div>
@endif

<div class="grid grid-cols-2 gap-x-5">
    <div class="">
        <p class="text-xl font-semibold mb-5">Status Pesanan</p>
        <div class="rounded p-4 bg-accent">
            @if ($po->recieved_at == null)
                <div class="text-white bg-error font-semibold text-xl text-center rounded p-3">On Process</div>
                @if ($po->deleted_by == null)
                    <p class="mt-10 mb-2">Barang pesanan sudah sampai / Perlu mengganti jumlah pesanan ?</p>
                    <button onclick="modal_pesanan.showModal()" class="btn btn-primary">
                        Ya, Update Data
                    </button>
                @endif
            @else
                <div class="bg-secondary font-semibold text-xl text-center rounded p-3">Barang Sudah Sampai</div>
                <div class="grid grid-cols-2 mt-2">
                    <p>Tanggal Diterima</p>
                    <p class="text-right">{{ date_format(new DateTime($po->recieved_at), 'd M Y H:i') }}</p>
                    <p>Diterima Oleh</p>
                    <p class="text-right">{{ $recieved_name }}</p>
                </div>
            @endif
        </div>
    </div>
    <div class="">
        <p class="text-xl font-semibold mb-5">Status Pembayaran</p>
        <div class="rounded p-4 bg-accent">
            @if ($po->paid_at)
                <div class="bg-secondary font-semibold text-xl text-center rounded p-3">Transaksi Telah Dibayar</div>
            @else
                <div class="text-red-50 bg-error font-semibold text-xl text-center rounded p-3">Belum Bayar</div>
                <p class="text-right">Kurang <span class="font-bold">{{ $daysLeft }}</span> Hari hingga jatuh tempo</p>

                @if ($po->deleted_by == null)
                    <h1 class="mt-5 mb-2">Pesanan sudah dibayar ?</h1>
                    <button class="btn btn-primary" onclick="modal_pembayaran.showModal()">Ya, Sudah Lunas</button>
                    <div class="divider"></div>
                @endif
            @endif
            <div class="grid grid-cols-2 mt-2">
                <p class="">Tanggal Jatuh Tempo</p>
                <p class="text-right">{{ date_format(new DateTime($po->jatuh_tempo), 'd M Y H:i') }}</p>
                @if ($po->paid_at)
                    <p class="">Tanggal Pembayaran</p>
                    <p class="text-right">{{ date_format(new DateTime($po->paid_at), 'd M Y H:i') }}</p>
                    <p>Metode Pembayaran</p>
                    <p class="text-right">{{ $po->paid_method }}</p>
                    <p>Kode Pembayaran</p>
                    <p class="text-right">{{ $po->paid_code }}</p>
                    <p>Terkonfirmasi Oleh</p>
                    <p class="text-right">{{ $paid_name }}</p>
                    @endif
            </div>
        </div>
    </div>
</div>

<div class="prose mt-5">
    <h3>Informasi Vendor</h3>
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

<h3 class="text-xl font-semibold">Data Pesanan</h3>
<div class="rounded bg-accent p-4 my-5">
    <table class="table-zebra data-table">
        <thead>
            <tr>
                <th><h3 class="font-bold">Part Number</h3></th>
                <th><h3 class="font-bold">Nama</h3></th>
                <th><h3 class="font-bold">Harga</h3></th>
                <th><h3 class="font-bold">Jumlah</h3></th>
                <th><h3 class="font-bold">Subtotal</h3></th>
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

<h3 class="text-xl font-semibold">Buat Excel</h3>
<div class="rounded bg-accent p-4 my-5">
    <div class="flex justify-between">
        <a href="{{ url("po/detail/$po->id/dokumen/purchase_order") }}" class="btn btn-success shadow-lg"><i class="fa-solid fa-file-excel"></i>Purchase Order</a>
    </div>
</div>

@if (!$po->deleted_at)
<h3 class="text-xl font-semibold text-error">Hapus Transaksi Purchase Order</h3>
<div class="rounded bg-accent p-4 my-5 text-error">
    <p>Untuk menghapus transaksi Purchase Order, masukan password dan tekan tombol dibawah</p>
    <form method="POST" action="{{ url("/po/detail/$po->id/delete") }}">
        @csrf
        <p class="text-sm mt-2">Masukan alasan penghapusan</p>
        <input type="text" class="input input-error w-full" name="reason" required>
        <p class="text-sm mt-2">Password</p>
        <div class="flex items-center gap-x-2">
            <input type="password" name="password" class="input input-error">
            <button class="btn btn-error">Hapus Purchase Order</button>
        </div>
    </form>
</div>
@endif

<dialog id="modal_pembayaran" class="modal">
    <div class="modal-box bg-slate-700 text-white">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="font-bold text-lg">Pelunasan Pesanan</h3>
        <p class="py-4">Pastikan kembali bahwa barang pesanan sudah tiba dan sesuai. <br> Bila sudah, tekan tombol dibawah untuk konfirmasi pembayaran</p>
        <div>
            <form action="{{ url("/po/pembayaran") }}" method="post">
                @csrf
                <div class="mb-4">
                    <p>Metode Pembayaran</p>
                    <select class="select w-full" name="paid_method" required>
                        <option value="" selected disabled>Pilih Metode</option>
                        <option value="cash">Cash</option>
                        <option value="transfer">Transfer</option>
                    </select>
                </div>
                <div class="mb-4">
                    <p>Kode Pembayaran</p>
                    <p class="text-sm text-gray-400 mb-2">Isi dengan '-' bila cash.</p>
                    <input type="text" name="paid_code" class="input w-full" required>
                </div>
                <div class="">
                    <p class="mb-2 text-sm">Masukan password anda : </p>
                    <div class="flex w-full gap-x-2">
                        <input type="password" name="password" class="input input-primary w-full" required>
                        <button class="btn btn-primary" name="id" value="{{ $po->id }}">Ya, Sudah Lunas</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</dialog>

<dialog id="modal_pesanan" class="modal">
    <div class="modal-box bg-slate-700 text-white">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="font-bold text-lg">Konfirmasi Pesanan</h3>
        <p>Bagaimana jumlah Pesanan yang datang ?</p>
        <p>Pastikan telah mengecek pesanan yang datang dengan baik !</p>
        <div class="flex flex-col gap-2 mt-5">
            <form action="{{ url("/po/pesanan") }}" method="POST">
                @csrf
                <select name="status" class="select w-full" required>
                    <option value="" disabled selected>Pilih Jumlah Barang</option>
                    <option value="0">Jumlah Barang Sesuai</option>
                    <option value="-1">Jumlah Barang Kurang/Lebih</option>
                </select>
                <p class="mt-4">Masukan password</p>
                <div class="flex gap-x-2">
                    <input type="password" class="input w-full" name="password" required>
                    <button class="btn btn-primary" name="id" value="{{ $po->id }}">Konfirmasi</button>
                </div>
            </form>
        </div>
    </div>
</dialog>
@endsection
