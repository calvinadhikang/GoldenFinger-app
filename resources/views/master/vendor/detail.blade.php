@extends('template/header')

@section('content')
<div class="prose">
    <h1 class="text-white">Detail Vendor</h1>
</div>
<div class="rounded bg-accent p-4 my-5">
    <form method="POST">
        @csrf
        <input type="hidden" value="{{ $vendor->id }}" name="id">
        <div class="flex flex-wrap my-5">
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text text-lg font-bold">Nama</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" value="{{ $vendor->nama }}" class="input input-bordered w-full" name="nama" required/>
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text text-lg font-bold">Email</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" value="{{ $vendor->email }}" class="input input-bordered w-full" name="email" required/>
            </div>
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text text-lg font-bold">Telp</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" value="{{ $vendor->telp }}" class="input input-bordered w-full" name="telp" required/>
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text text-lg font-bold">Alamat</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" value="{{ $vendor->alamat }}" class="input input-bordered w-full" name="alamat" required/>
            </div>
        </div>
        <button class="btn btn-primary">Simpan</button>
    </form>
</div>

@endsection
