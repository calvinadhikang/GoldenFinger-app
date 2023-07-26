@extends('template/header')

@section('content')
<div class="prose">
    <h1 class="text-white">Buat Invoice</h1>
</div>
<div class="mt-5 flex justify-center">
    <ul class="steps w-full">
        <li class="step step-primary"><a href="{{ url('/invoice/add') }}">Pilih Barang</a></li>
        <li class="step"><a href="{{ url('/invoice/customer') }}">Pilih Customer</a></li>
        <li class="step">Konfirmasi</li>
    </ul>
</div>
<div class="mb-5 mt-10">
    <h2 class="text-primary font-bold text-3xl">Pilih Barang</h2>
    <p><span class="text-primary">Centang di sebelah kanan </span>Barang yang ingin ditambahkan ke <b>Invoice</b> <br> Klik tombol dibawah bila sudah selesai</p>
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
                    <th class="prose"><h3 class="font-bold">Quantity</h3></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($barang as $item)
                <tr>
                    <td>{{ $item->part }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>Rp {{ number_format($item->harga) }}</td>
                    <td>
                        <input type="number" class="input input-bordered input-secondary" name="qty[]" value="{{ $item->qty }}">
                        <input type="hidden" name="id[]" value="{{ $item->id }}">
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <button class="btn btn-secondary">Selanjutnya</button>
    </form>
</div>
@endsection
