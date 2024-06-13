@extends('template/header')

@section('content')
<h1 class="text-2xl font-bold">Tambah Vendor</h1>
<div class="text-sm breadcrumbs mb-5  ">
    <ul>
        <li><a href="/vendors">Data Vendor</a></li>
        <li>Tambah Vendor</li>
    </ul>
</div>
<div class="rounded bg-accent p-4 mb-5">
    <form method="POST">
        @csrf
        <div class="flex flex-wrap mb-5">
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text text-lg font-bold">Nama</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="Supplier..." class="input input-bordered w-full" name="nama" required/>
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text text-lg font-bold">Email</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="vendor@gmail.com" class="input input-bordered w-full" name="email" required/>
            </div>
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text text-lg font-bold">Telp</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="08..." class="input input-bordered w-full" name="telp" required/>
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text text-lg font-bold">Alamat</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="Jalan..." class="input input-bordered w-full" name="alamat" required/>
            </div>
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text text-lg font-bold">Kota</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="Kota..." class="input input-bordered w-full" name="kota" required/>
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text text-lg font-bold">NPWP</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="NPWP..." class="input input-bordered w-full" name="npwp" required/>
            </div>
        </div>
        <button class="btn btn-primary">Tambah</button>
    </form>
</div>

@endsection
