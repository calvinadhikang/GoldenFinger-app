@extends('template.header')

@section('content')
<h1 class="text-2xl font-bold">Pengaturan</h1>
<div class="rounded p-4 shadow bg-accent my-5">
    <div class="grid md:grid-cols-2 items-center">
        <div class="">
            <h1 class="text-lg font-medium">PPN</h1>
            <p class="">Tentukan nilai PPN untuk Invoice dan PO</p>
        </div>
        <form action="" class="flex justify-end">
            <input type="text" class="input" value="{{ $ppn }}">
            <button class="ms-2 btn btn-primary">Save</button>
        </form>
    </div>

    <div class="divider"></div>
    <div class="grid md:grid-cols-2">
        <div class="">
            <h1 class="text-lg font-medium">Export Data Barang</h1>
            <p class="text-gray-400">Tekan tombol dibawah untuk Download semua data barang ! <br> Hasil Download dapat digunakan sebagai template untuk Import Barang.</p>
        </div>
        <div class="flex justify-end">
            <a href="{{ url('/settings/download/barang') }}"><button class="btn btn-primary">Download Excel</button></a>
        </div>
    </div>

    <div class="divider"></div>
    <h1 class="text-lg font-medium mb-2">Import Data Barang</h1>
    <p class="alert alert-info">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        Pastikan Export Data Barang terlebih dahulu sebelum melakukan import. Gunakan hasil Export / Download untuk mengimport Data Barang.
    </p>
    <div class="grid md:grid-cols-2 mt-5">
        <p class="text-gray-400">Import artinya menghapus semua data barang yang sudah ada !<br> Dan mengganti data dengan yang baru di Upload</p>
        <form class="flex justify-end gap-2" action="{{ route('upload.barang') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" class="file-input file-input-primary w-full max-w-xs" required>
            <button class="btn btn-primary">Import</button>
        </form>
    </div>
</div>
@endsection
