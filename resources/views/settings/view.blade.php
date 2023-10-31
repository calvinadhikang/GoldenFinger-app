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
    <h1 class="text-lg font-medium">Export Data Barang</h1>
    <p class="text-gray-400 mb-5">Tekan tombol dibawah untuk Download semua data barang ! <br> Hasil Download dapat digunakan sebagai template untuk Import Barang.</p>
    <form action="{{ url('/settings/download/barang') }}" method="POST">
        @csrf
        <button class="btn btn-primary">Download Excel</button>
    </form>

    <div class="divider"></div>
    <h1 class="text-lg font-medium">Import Data Barang</h1>
    <p class="text-gray-400 mb-5">Proses import artinya menghapus semua data barang yang sudah ada ! <br> Dan mengganti data dengan yang baru di Upload</p>
    <p class="alert alert-info mb-2">Pastikan Export Data Barang terlebih dahulu sebelum melakukan import. Gunakan hasil Export / Download untuk mengimport Data Barang.</p>
    <input type="file" class="file-input file-input-primary w-full max-w-xs">

</div>
@endsection
