@extends('template/header')

@section('content')
<h1 class="text-2xl font-bold">Tambah Service Vulkanisir</h1>
<div class="text-sm breadcrumbs mb-5  ">
    <ul>
        <li><a href="/vservice">Data Service Vulkanisir</a></li>
        <li>Tambah Service Vulkanisir</li>
    </ul>
</div>
<div class="mt-5 flex justify-center my-10">
    <ul class="steps w-full">
        <li class="step step-primary"><a class="hover:link" href="/vservice/customer">Pilih Customer</a></li>
        <li class="step step-primary font-medium">Isi Keterangan</li>
        <li class="step">Konfirmasi</li>
    </ul>
</div>

<div class="rounded-2xl bg-accent p-4 my-5">
    <form method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-5">
            <div class="form-control">
                <label class="label">
                    <span class="label-text text-lg font-bold">Nama Produk</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" class="input   w-full" name="nama" required/>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text text-lg font-bold">Harga</span>
                    <span class="label-text-alt">Harga sudah termasuk PPN</span>
                </label>
                <input type="text" class="harga input   w-full" name="harga" required/>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text text-lg font-bold">Tanggal Selesai</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="datetime-local" placeholder="M001" class="input   w-full" name="tanggal" required/>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text text-lg font-bold">Pilih Mesin Vulkanisir</span>
                    <span class="label-text-alt"></span>
                </label>
                <select name="machine" class="select select-bordered" required>
                    <option value="" selected disabled>Pilih Mesin Vulkanisir</option>
                    @foreach ($machines as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button class="btn btn-primary">Konfirmasi</button>
    </form>
</div>

@endsection
