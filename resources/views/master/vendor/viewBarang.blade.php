@extends('template/header')

@section('content')
<h1 class="text-2xl font-bold">Tambah Barang di Supply Vendor</h1>
<div class="mt-5 flex justify-center">
    <ul class="steps w-full">
        <li class="step step-primary font-medium hover:underline">Pilih Barang</li>
        <li class="step">Harga</li>
        <li class="step">Simpan</li>
    </ul>
</div>
<div class="mb-5 mt-10">
    <h2 class="font-bold text-3xl">Pilih Barang</h2>
    <p>Centang barang yang di supply oleh Vendor</p>
</div>
<div class="rounded bg-accent p-4 my-5">
    <form method="POST">
        @csrf
        <table class="data-table table-zebra">
            <thead>
                <tr>
                    <th class="prose"><h3 class="font-bold">Part Number</h3></th>
                    <th class="prose"><h3 class="font-bold">Nama</h3></th>
                    <th class="prose"><h3 class="font-bold">Tambah</h3></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($barang as $item)
                <tr>
                    <td>{{ $item->part }}</td>
                    <td>{{ $item->nama }}</td>
                    <td><input type="checkbox" class="checkbox" name="barang[]" value="{{ $item->part }}" {{ $item->checked ? 'checked' : '' }}></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <button class="btn btn-primary">Selanjutnya</button>
    </form>
</div>



@endsection
