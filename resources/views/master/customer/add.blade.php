@extends('template/header')

@section('content')
<h1 class="text-2xl font-bold">Tambah Customer</h1>
<div class="text-sm breadcrumbs mb-5 text-slate-300">
    <ul>
        <li><a href="/customer">Data Customer</a></li>
        <li>Tambah Customer</li>
    </ul>
</div>
<div class="rounded bg-accent p-4 mb-5">
    <form method="POST">
        @csrf
        <div class="flex flex-wrap my-5">
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text text-lg font-bold"><i class="fa-solid fa-id-badge me-2"></i>Nama</span>
                    <span class="label-text-alt text-error">@error('nama') {{ $message }}  @enderror</span>
                </label>
                <input type="text" placeholder="Nama..." class="input input-bordered w-full" name="nama" value="{{ old('nama') }}" />
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text text-lg font-bold"><i class="fa-solid fa-envelope me-2"></i>Email</span>
                    <span class="label-text-alt text-error">@error('email') {{ $message }}  @enderror</span>
                </label>
                <input type="email" placeholder="...@..." class="input input-bordered w-full" name="email" value="{{ old('email') }}" />
            </div>
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text text-lg font-bold"><i class="fa-solid fa-location-dot me-2"></i>Alamat</span>
                    <span class="label-text-alt text-error">@error('alamat') {{ $message }}  @enderror</span>
                </label>
                <input type="text" placeholder="Jalan..." class="input input-bordered w-full" name="alamat" value="{{ old('alamat') }}" />
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text text-lg font-bold"><i class="fa-solid fa-phone me-2"></i>Nomor Telp</span>
                    <span class="label-text-alt text-error">@error('telp') {{ $message }}  @enderror</span>
                </label>
                <input type="text" placeholder="081..." class="input input-bordered w-full" name="telp" value="{{ old('telp') }}" />
            </div>
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text text-lg font-bold"><i class="fa-solid fa-city me-2"></i>Kota</span>
                    <span class="label-text-alt text-error">@error('kota') {{ $message }}  @enderror</span>
                </label>
                <input type="text" placeholder="Kota..." class="input input-bordered w-full" name="kota" value="{{ old('kota') }}" />
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text text-lg font-bold"><i class="fa-solid fa-barcode me-2"></i>NPWP</span>
                    <span class="label-text-alt">@error('NPWP') {{ $message }}  @enderror</span>
                </label>
                <input type="text" placeholder="001.002.003" class="input input-bordered w-full" name="NPWP" value="{{ old('NPWP') }}" />
            </div>
        </div>
        <button class="btn btn-primary">Tambah</button>
    </form>
</div>

@endsection
