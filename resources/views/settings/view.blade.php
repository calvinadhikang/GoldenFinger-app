@extends('template.header')

@section('content')
<h1 class="text-3xl font-bold">Pengaturan</h1>
<div class="rounded p-4 shadow bg-accent mt-5">
    <div class="grid md:grid-cols-2 items-center">
        <div class="">
            <h1 class="text-lg font-medium">PPN</h1>
            <p class="">Tentukan nilai PPN untuk Invoice dan PO</p>
        </div>
        <form action="" class="flex">
            <input type="text" class="input" value="{{ $ppn }}">
            <button class="ms-2 btn btn-primary">Save</button>
        </form>
    </div>
    <div class="divider"></div>
            <h1 class="text-lg font-medium">Import Data Barang</h1>
            <p class="text-gray-400">Proses import artinya menghapus semua data barang yang sudah ada ! <br> Dan mengganti data dengan yang baru di Upload</p>
            <input type="file" class="file-input file-input-primary w-full max-w-xs mt-5">
    </div>
</div>
@endsection
