@extends('template/header')

@section('content')
<h1 class="text-2xl font-bold">Detail Paket Penjualan</h1>
<div class="text-sm breadcrumbs mb-5  ">
    <ul>
        <li><a href="/paket">Data Paket</a></li>
        <li>Detail Paket</li>
    </ul>
</div>
<div class="rounded-2xl bg-accent p-4 my-5">
    <form method="POST">
        @csrf
        <div class="flex flex-wrap mb-5">
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text text-lg font-bold">Nama Paket</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="Nama Paket..." class="input   w-full" name="nama" value="{{ $paket->nama }}" required/>
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text text-lg font-bold">Harga Paket</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="1000" class="input   w-full harga" name="harga" value="{{ $paket->harga }}" required/>
            </div>
        </div>
        <button class="btn btn-primary">Simpan</button>
    </form>
</div>

<h1 class="text-lg font-medium my-5">Barang Terjual Dalam Paket</h1>
<div class="p-4 rounded-2xl bg-accent mb-5">
    <table class="table-zebra data-table" id="table">
        <thead>
            <tr>
                <th><h3 class="font-bold">Part</h3></th>
                <th><h3 class="font-bold">Qty</h3></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detail as $item)
            <tr>
                <td>{{ $item->part }}</td>
                <td>{{ $item->qty }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


<div class="flex items-center justify-between">
    <h1 class="text-lg font-medium my-5">Status Paket</h1>
    <div class="badge badge-outline {{ $paket->deleted_at == null ? 'badge-success' : 'badge-error' }}">{{ $paket->deleted_at == null ? 'Aktif' : 'Non-Aktif' }}</div>
</div>
<div class="bg-accent p-4 rounded-2xl">
    <form action="{{ url("/paket/detail/$paket->id/toggle") }}" method="POST">
        @csrf
        <button class="btn btn-block btn-outline {{ $paket->deleted_at == null ? 'btn-error' : 'btn-success' }}">{{ $paket->deleted_at == null ? 'Non-Akifkan Paket' : 'Aktifkan Paket' }}</button>
    </form>
</div>


@endsection
