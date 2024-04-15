@extends('template/header')

@section('content')
<h1 class="text-2xl font-bold">Detail Mesin Vulkanisir</h1>
<div class="text-sm breadcrumbs mb-5 text-slate-300">
    <ul>
        <li><a href="/machine">Data Mesin Vulkanisir</a></li>
        <li>Detail Mesin Vulkanisir</li>
    </ul>
</div>
<div class="rounded bg-accent p-4 my-5">
    <form method="POST">
        @csrf
        <div class="flex flex-wrap gap-y-2 mb-5">
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text text-lg font-bold">Nama Mesin</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="B001..." class="input input-bordered w-full" name="nama" value="{{ $machine->nama }}" required/>
            </div>
        </div>
        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
<h1 class="my-5 font-medium text-xl">Status Mesin</h1>
<div class="rounded p-4 bg-accent mb-5">
    <button class="btn btn-block {{ $machine->service_id ? 'btn-error' : 'btn-secondary' }}">{{ $machine->service_id ? 'Digunakan' : 'Tidak Digunakan' }}</button>
    @if ($machine->service_id != null)
        <h1 class="mt-5 text-lg font-medium">Detail Pengguna</h1>
        <div class="grid grid-cols-2 gap-5 mt-2">
            <p>Nama Customer :</p>
            <p class="text-right">asd</p>
        </div>
    @endif
</div>
@endsection
