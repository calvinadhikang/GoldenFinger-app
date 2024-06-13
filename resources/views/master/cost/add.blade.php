@extends('template/header')

@section('content')
<h1 class="text-2xl font-bold">Tambah Operational Cost</h1>
<div class="text-sm breadcrumbs mb-5  ">
    <ul>
        <li><a href="/customer">Data Operational Cost</a></li>
        <li>Tambah Operational Cost</li>
    </ul>
</div>
<div class="rounded-2xl bg-accent p-4">
    <form method="POST">
        @csrf
        <div class="flex flex-wrap mb-5">
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text text-lg font-bold">Deskripsi</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="Pengeluaran..." class="input   w-full" name="deskripsi" required/>
            </div>
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text text-lg font-bold">Total (Rp)</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="1000" class="input   w-full harga" name="total" required/>
            </div>
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text text-lg font-bold">Tanggal Pengeluaran</span>
                    <span class="label-text-alt">Ubah tanggal pengeluaran bila tanggal pengeluaran bukan hari ini</span>
                </label>
                <input type="date" class="input   w-full" name="tanggal" value="{{ $default }}" required/>
            </div>
        </div>
        <button class="btn btn-primary">Tambah</button>
    </form>
</div>

@endsection
