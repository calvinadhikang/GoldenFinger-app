@extends('template/header')

@section('content')
<div class="prose">
    <h1>Tambah Barang di Supply Vendor</h1>
</div>
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
                    <th>Part Number</th>
                    <th>Nama</th>
                    <th>Tambah</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($barang as $item)
                <tr>
                    <td>{{ $item->part }}</td>
                    <td>{{ $item->nama }}</td>
                    <td><input type="checkbox" class="checkbox" name="barang[]" value="{{ $item->id }}"></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <button class="btn btn-secondary">Selanjutnya</button>
    </form>
</div>



@endsection
