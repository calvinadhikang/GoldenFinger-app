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
    <p class="mb-5"><span class="text-primary">Centang di sebelah kanan </span>Barang yang ingin ditambahkan ke Supplier <br> Klik tombol dibawah bila sudah selesai</p>

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
                    <td>
                        Qty: <input type="number" class="input input-bordered input-secondary" style="width: 100px;">
                    </td>
                    <td>Rp {{ number_format($item->subtotal) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <button class="btn btn-secondary">Refresh</button>
    </form>
</div>

<div class="prose">
    <h3>Informasi Pembeli</h3>
</div>
<div class="rounded bg-accent p-4 my-5">
    <form action="">
        @csrf
        <div class="form-control w-full max-w-xs">
            <label class="label">
                <span class="label-text">Nama Customer</span>
            </label>
            <input type="text" placeholder="Type here" class="input input-bordered w-full max-w-xs" />
        </div>
    </form>
</div>
@endsection
