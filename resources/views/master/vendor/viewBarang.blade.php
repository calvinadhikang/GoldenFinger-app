@extends('template/header')

@section('content')
<h1 class="text-2xl font-bold">Tambah Barang di Supply Vendor</h1>
<div class="mt-5 flex justify-center">
    <ul class="steps w-full">
        <li class="step step-primary">Pilih Barang</li>
        <li class="step">Harga</li>
        <li class="step">Simpan</li>
    </ul>
</div>
<div class="rounded bg-accent p-4 my-5">
    <h2 class="text-primary font-bold text-3xl">Pilih Barang</h2>
    <p class="mb-5"><span class="text-primary">Centang di sebelah kanan </span>Barang yang ingin ditambahkan ke Supplier <br> Klik tombol dibawah bila sudah selesai</p>
    <form method="POST">
        @csrf
        <table class="table" id="table">
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
                    <td><input type="checkbox" class="checkbox" name="barang[]" value="{{ $item->part }}"></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <button class="btn btn-secondary">Selanjutnya</button>
    </form>
</div>



@endsection
