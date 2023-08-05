@extends('template/header')

@section('content')
<div class="prose">
    <h1 class="text-white">Tambah Operational Cost</h1>
</div>
<div class="rounded bg-accent p-4 my-5">
    <form method="POST">
        @csrf
        <div class="flex flex-wrap my-5">
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text text-lg font-bold">Deskripsi</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="Pengeluaran..." class="input input-bordered w-full" name="deskripsi" required/>
            </div>
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text text-lg font-bold">Total (Rp)</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="number" placeholder="1000" class="input input-bordered w-full" name="total" required/>
            </div>
        </div>
        <button class="btn btn-primary">Tambah</button>
    </form>
</div>

@endsection
