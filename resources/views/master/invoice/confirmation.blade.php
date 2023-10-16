@extends('template/header')

@section('content')
<div class="prose">
    <h1 class="text-white">Buat Invoice</h1>
</div>
<div class="mt-5 flex justify-center my-10">
    <ul class="steps w-full">
        <li class="step step-primary"><a href="{{ url('/invoice/add') }}" class="bg-secondary mt-2 rounded-lg p-1 hover:bg-blue-500">Pilih Barang</a></li>
        <li class="step step-primary"><a href="{{ url('/invoice/customer') }}" class="bg-secondary mt-2 rounded-lg p-1 hover:bg-blue-500">Pilih Customer</a></li>
        <li class="step step-primary">Konfirmasi</li>
    </ul>
</div>
<div class="mb-5 mt-10">
    <h2 class="font-bold text-3xl text-primary">Konfirmasi Pesanan</h2>
    <p>Pastikan informasi pesanan, dan customer sudah benar <br> Jangan lupa cek ulang data pesanan dan totalnya</p>
</div>
<div class="prose mt-10">
    <h3>Informasi Customer</h3>
</div>
<div class="rounded bg-accent p-4 my-5">
    <div class="flex flex-wrap">
        <div class="form-control w-full md:w-1/2 md:pe-2">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-id-badge me-2"></i>Nama</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" class="input input-bordered w-full " value="{{ $invoice->customer->nama }}" disabled/>
        </div>
        <div class="form-control w-full md:w-1/2">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-envelope me-2"></i>Email</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="email" class="input input-bordered w-full" value="{{ $invoice->customer->email }}" disabled/>
        </div>
        <div class="form-control w-full md:w-1/2 md:pe-2">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-location-dot me-2"></i>Alamat</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" class="input input-bordered w-full" value="{{ $invoice->customer->alamat }}" disabled/>
        </div>
        <div class="form-control w-full md:w-1/2">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-phone me-2"></i>Nomor Telp</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" class="input input-bordered w-full" value="{{ $invoice->customer->telp }}" disabled/>
        </div>
    </div>
</div>

<div class="prose">
    <h3>Data Pesanan</h3>
</div>
<div class="rounded bg-accent p-4 my-5">
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
        @foreach ($invoice->list as $item)
            <tr>
                <td>{{ $item->part }}</td>
                <td>{{ $item->nama }}</td>
                <td>Rp {{ format_decimal($item->harga) }}</td>
                <td>{{ format_decimal($item->qty) }}</td>
                <td>Rp {{ format_decimal($item->subtotal) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="text-right w-full mt-10">
        Grand Total : <span class="text-2xl font-bold text-primary">Rp {{ format_decimal($invoice->grandTotal) }}</span>
    </div>
</div>

<form method="POST">
    @csrf
    <div class="flex gap-10 items-center mb-2 h-10">
        <span class="text-xl font-semibold">Dapat Komisi ? </span>
        <input type="checkbox" name="komisi" class="toggle" id="komisiCheck" checked>
    </div>
    <div class="rounded bg-accent p-4 mb-5">
        <div class="flex mb-2">
            <div id="komisiStatus" class="text-2xl font-bold text-secondary w-full">Dapat Komisi</div>
        </div>

        <div class="flex space-x-4" id="komisi-input">
            <div class="w-full">
                <p class="font-semibold">Jumlah Komisi</p>
                <div class="mt-2">
                    <input type="number" class="input input-bordered input-secondary w-full" name="komisiJumlah" value="0" id="komisi">
                </div>
            </div>
            <div class="w-full">
                <p class="font-semibold">Nama Penerima Komisi</p>
                <div class="mt-2">
                    <input type="text" class="input input-bordered input-secondary w-full" name="komisiPenerima">
                </div>
            </div>
        </div>
    </div>

    <p class="text-xl font-semibold mb-2">Jatuh Tempo</p>
    <div class="rounded bg-accent p-4 mb-5">
        <input type="date" class="rounded p-2 w-full text-black border border-secondary leading-tight" name="jatuhTempo">
    </div>

    <button class="btn btn-primary w-full mb-10 shadow-lg">Buat Pesanan !</button>
</form>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
$('#komisiCheck').on('click', function() {
    let checkedStatus = $(this).prop('checked');
    if (checkedStatus) {
        $('#komisiStatus').html("Dapat Komisi");
        $('#komisiStatus').addClass("text-secondary");
        $('#komisiStatus').removeClass("text-error");

        $('#komisi-input').show();
    }else{
        $('#komisiStatus').html("Tidak Dapat Komisi");
        $('#komisiStatus').addClass("text-error");
        $('#komisiStatus').removeClass("text-secondary");
        $('#komisi-input').hide();

    }
})

$("#komisi").on("input", function() {
    // Remove commas and non-numeric characters from the input value
    let rawValue = $(this).val().replace(/[^0-9]/g, '');

    // Format the input value with thousand separators
    let formattedValue = Number(rawValue).toLocaleString();

    // Update the input value with the formatted value
    $(this).val(formattedValue);
});
</script>
@endsection
