@extends('template/header')

@section('content')
<h1 class="text-2xl font-bold">Tambah Barang di Supply Vendor</h1>
<div class="mt-5 flex justify-center">
    <ul class="steps w-full">
        <li class="step step-primary"><a class="hover:underline" href="{{ url("/vendors/add/barang/".Session::get('vendor_barang_id'))}}">Pilih Barang</a></li>
        <li class="step step-primary font-medium">Harga</li>
        <li class="step">Simpan</li>
    </ul>
</div>
<div class="mb-5 mt-10">
    <h2 class="font-bold text-3xl">Harga Beli Barang</h2>
    <p>Input data harga beli tiap barang.</p>
</div>
<div class="rounded bg-accent p-4 my-5">
    <form method="POST">
        @csrf
        <div class="mb-5">
            @foreach ($barang as $item)
                <div class="flex mb-2 border-b border-secondary border-opacity-50 p-2">
                    <div class="grow">
                        <h3>{{ $item->nama }}</h3>
                        {{ $item->part }}
                        @if ($item->harga <= 0)
                            <div class="badge badge-secondary">Data Baru</div>
                        @endif
                    </div>
                    <div class="flex flex-wrap items-center">
                        <div class="me-2">Rp</div><input type="text" class="input input-info harga" min="1" name="harga[]" required value="{{ $item->harga }}">
                    </div>
                </div>
            @endforeach
        </div>
        <p class="text-secondary font-medium">Pastikan semua Harga sudah terisi</p>
        <button class="btn btn-primary">Simpan</button>
    </form>
</div>



@endsection
