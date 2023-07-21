@extends('template/header')

@section('content')
<div class="prose">
    <h1 class="text-white">Buat Invoice</h1>
</div>
<div class="mt-5 flex justify-center my-10">
    <ul class="steps w-full">
        <li class="step step-primary">Pilih Barang</li>
        <li class="step step-primary">Konfirmasi</li>
        <li class="step">Simpan</li>
    </ul>
</div>
<div class="prose">
    <h2 class="text-primary font-bold text-3xl">Konfirmasi</h2>
</div>
<div class="rounded bg-accent p-4 my-5">
    <form method="POST">
        @csrf
        <table class="table" id="table">
            <thead>
                <tr>
                    <th class="prose"><h3 class="font-bold">Part Number</h3></th>
                    <th class="prose"><h3 class="font-bold">Nama</h3></th>
                    <th class="prose"><h3 class="font-bold">Harga</h3></th>
                    <th class="prose"><h3 class="font-bold">Jumlah</h3></th>
                    <th class="prose"><h3 class="font-bold">Subtotal</h3></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($barang as $item)
                <tr>
                    <td>{{ $item->part }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>Rp {{ number_format($item->harga) }}</td>
                    <td>{{ number_format($item->qty) }}</td>
                    <td>Rp {{ number_format($item->subtotal) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="prose text-right w-full mt-10">
            Grand Total : <span class="text-2xl font-bold text-primary">Rp {{ number_format($grandTotal) }}</span>
        </div>
    </form>
</div>

<div class="prose">
    <h3>Informasi Customer</h3>
</div>
<div class="rounded bg-accent p-4 my-5">
    <form action="">
        @csrf
        <div class="flex w-full flex-wrap justify-between">
            <div class="w-full md:w-2/5 ">
                <p class="mb-2 font-bold">Nama Customer</p>
                <input type="text" placeholder="Nama Customer..." class="input input-bordered w-full" />
            </div>
            <div class="w-full md:w-2/5 ">
                <p class="mb-2 font-bold">Telp Customer</p>
                <input type="text" placeholder="Alamat Customer..." class="input input-bordered w-full" />
            </div>
            <div class="w-full mt-5">
                <p class="mb-2 font-bold">Alamat Customer</p>
                <textarea name="" class="textarea textarea-bordered w-full" cols="30" rows="2"></textarea>
            </div>
        </div>
        <button class="btn btn-primary mt-5">Buat Transaksi !</button>
    </form>
</div>
@endsection
