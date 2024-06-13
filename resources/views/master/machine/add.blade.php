@extends('template/header')

@section('content')
<h1 class="text-2xl font-bold">Tambah Mesin Vulkanisir</h1>
<div class="text-sm breadcrumbs mb-5  ">
    <ul>
        <li><a href="/machine">Data Mesin Vulkanisir</a></li>
        <li>Tambah Mesin Vulkanisir</li>
    </ul>
</div>
<div class="rounded-2xl bg-accent p-4 my-5">
    <form method="POST">
        @csrf
        <div class="flex flex-wrap mb-5">
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text text-lg font-bold">Nama Mesin</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="M001" class="input   w-full" name="nama" required/>
            </div>
        </div>
        <button class="btn btn-primary">Tambah</button>
    </form>
</div>

@endsection
