@extends('template/header')

@section('content')
<h1 class="text-2xl font-bold">Tambah Barang</h1>
<div class="rounded bg-accent p-4 my-5">
    <form method="POST">
        @csrf
        <div class="flex flex-wrap my-5">
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text text-lg font-bold">Nama Kategori</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="Ban Luar..." class="input input-bordered w-full" name="nama" required/>
            </div>
        </div>
        <button class="btn btn-primary">Tambah</button>
    </form>
</div>

@endsection
