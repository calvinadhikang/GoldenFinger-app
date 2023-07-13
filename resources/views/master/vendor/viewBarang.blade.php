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
    <div class="flex flex-wrap items-center mb-5">
        <div class="prose ms-2">
            <h2 class="text-primary text-center">Pilih Barang</h2>
        </div>
    </div>
    <form method="POST">
        @csrf
        <div class="">
            @foreach ($barang as $item)
                <div class="flex mb-2 border-b border-secondary border-opacity-50 p-2">
                    <div class="grow prose">
                        <h3>{{ $item->nama }}</h3>
                        {{ $item->part }}
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" class="checkbox" name="barang[]" value="{{ $item->id }}">
                    </div>
                </div>
            @endforeach
        </div>
        <button class="btn btn-secondary">Selanjutnya</button>
    </form>
</div>



@endsection
