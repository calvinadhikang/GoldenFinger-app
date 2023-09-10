@extends('template/header')

@section('content')
<div class="prose">
    <h1 class="text-white">Buat Purhcase Order</h1>
</div>
<div class="mt-5 flex justify-center">
    <ul class="steps w-full">
        <li class="step step-primary"><a href="{{ url('/po/barang') }}">Pilih Barang</a></li>
        <li class="step step-primary">Pilih Customer</li>
        <li class="step step-primary">Konfirmasi</li>
    </ul>
</div>
<div class="mb-5 mt-10">
    <h2 class="font-semibold text-xl">Informasi Vendor</h2>
</div>
<div class="bg-accent rounded p-4 my-5">
    <div class="flex flex-wrap mb-5">
        <div class="form-control w-full md:w-1/2 md:pe-2">
            <label class="label">
                <span class="label-text text-lg font-bold">Nama</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" value="{{ $po->vendor->nama }}" class="input input-bordered w-full" name="nama" required/>
        </div>
        <div class="form-control w-full md:w-1/2">
            <label class="label">
                <span class="label-text text-lg font-bold">Email</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" value="{{ $po->vendor->email }}" class="input input-bordered w-full" name="email" required/>
        </div>
        <div class="form-control w-full md:w-1/2 md:pe-2">
            <label class="label">
                <span class="label-text text-lg font-bold">Telp</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" value="{{ $po->vendor->telp }}" class="input input-bordered w-full" name="telp" required/>
        </div>
        <div class="form-control w-full md:w-1/2">
            <label class="label">
                <span class="label-text text-lg font-bold">Alamat</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" value="{{ $po->vendor->alamat }}" class="input input-bordered w-full" name="alamat" required/>
        </div>
    </div>
</div>

<div class="mb-5">
    <h2 class="font-semibold text-xl">Informasi Barang</h2>
</div>
<div class="rounded bg-accent p-4 my-5">
    <form method="POST">
        @csrf
        <table class="table" id="table">
            <thead>
                <tr>
                    <th class="prose"><h3 class="font-bold">Part Number</h3></th>
                    <th class="prose"><h3 class="font-bold">Nama</h3></th>
                    <th class="prose"><h3 class="font-bold">Stok</h3></th>
                    <th class="prose"><h3 class="font-bold">Quantity Pembelian</h3></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($po->list as $item)
                <tr>
                    <td>{{ $item->part }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->stok }}</td>
                    <th>{{ $item->qty }}</th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </form>
</div>

<div class="mb-5">
    <h2 class="font-semibold text-xl">Informasi PPN</h2>
</div>
<div class="rounded bg-accent p-4 my-5">
    <div class="flex gap-5 mb-5">
        <div class="grow">
            <p class="text-lg font-semibold">PPN :<p>
            <form action="{{ url('/po/confirmation/ppn') }}" method="post">
                @csrf
                <input type="text" class="input input-bordered input-secondary" name="ppn" value="{{ $po->PPN }}"> <button class="btn btn-secondary">Simpan !</button>
            </form>
        </div>
        <div class="grow">
            <p class="text-lg font-semibold mb-2">Pajak</p>
            <p class="text-lg">Rp {{ number_format($po->PPN * $po->total / 100) }}</p>
        </div>
    </div>
</div>

<div class="mb-5">
    <h2 class="font-semibold text-xl">Grand Total</h2>
</div>
<div class="rounded bg-accent p-4 my-5">
    <?php $grandTotal = $po->total + ($po->PPN * $po->total / 100) ?>
    <p class="text-2xl text-primary font-semibold">Rp {{ number_format($grandTotal) }}</p>
</div>

<div class="mb-5">
    <form action="" method="post">
        @csrf
        <button class="btn btn-secondary btn-block">Buat Pesanan !</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
    $(".harga").on("input", function() {
        // Remove commas and non-numeric characters from the input value
        let rawValue = $(this).val().replace(/[^0-9]/g, '');

        // Format the input value with thousand separators
        let formattedValue = Number(rawValue).toLocaleString();

        // Update the input value with the formatted value
        $(this).val(formattedValue);
    });
</script>
@endsection
