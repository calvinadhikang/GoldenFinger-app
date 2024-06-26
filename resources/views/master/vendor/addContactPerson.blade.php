@extends('template/header')

@section('content')
<h1 class="  text-2xl font-bold">Tambah Contact Person Vendor</h1>
<div class="rounded-2xl bg-accent p-4 my-5">
    <form method="POST">
        @csrf
        <div class="flex flex-wrap mb-5">
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text text-lg font-bold">Nama</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="Supplier..." class="input   w-full" name="nama" required/>
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text text-lg font-bold">Telp</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="08..." class="input   w-full" name="telp" required/>
            </div>
        </div>
        <button class="btn btn-primary">Tambah</button>
    </form>
</div>

@endsection
