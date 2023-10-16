@extends('template/header')

@section('content')
<div class="prose">
    <h1>Tambah Barang di Supply Vendor</h1>
</div>
<div class="mt-5 flex justify-center">
    <ul class="steps w-full">
        <li class="step step-primary">Pilih Barang</a></li>
        <li class="step step-primary">Harga</li>
        <li class="step">Simpan</li>
    </ul>
</div>
<div class="rounded bg-accent p-4 my-5">
    <div class="flex flex-wrap items-center mb-5">
        <a href="/vendors/add/barang"><i class="fas fa-long-arrow-left"></i></a>
        <div class="prose ms-5">
            <h2 class="text-primary text-center">Harga Beli Tiap Barang</h2>
        </div>
    </div>
    <form method="POST">
        @csrf
        <div class="mb-5">
            @foreach ($barang as $item)
                <div class="flex mb-2 border-b border-secondary border-opacity-50 p-2">
                    <div class="grow prose">
                        <h3>{{ $item->nama }}</h3>
                        {{ $item->part }}
                    </div>
                    <div class="flex flex-wrap items-center">
                        <div class="me-2">Rp</div><input type="text" class="input input-info harga" min="1" name="harga[]" required>
                    </div>
                </div>
            @endforeach
        </div>
        <p class="text-blue-400 font-bold">Pastikan semua Harga sudah terisi</p>
        <button class="btn btn-primary">Simpan</button>
    </form>
</div>



@endsection
