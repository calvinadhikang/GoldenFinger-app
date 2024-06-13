@extends('template/header')

@section('content')
<h1 class="text-2xl font-bold">Buat Invoice</h1>
<div class="text-sm breadcrumbs mb-5  ">
    <ul>
        <li><a href="/invoice">Data Invoice</a></li>
        <li>Buat Invoice</li>
    </ul>
</div>
<div class="mt-5 flex justify-center">
    <ul class="steps w-full">
        <li class="step step-primary hover:underline"><a href="{{ url('/invoice/customer') }}">Pilih Customer</a></li>
        <li class="step step-primary font-medium">Pilih Barang</li>
        <li class="step">Konfirmasi</li>
    </ul>
</div>
<div class="mb-5 mt-10 flex items-center">
    <i class="fa-solid me-2 w-6 fa-box-open"></i>
    <h2 class="text-xl font-bold">Pilih Barang</h2>
</div>
<div class="rounded-2xl bg-accent p-4 my-5">
    <table class="table-zebra data-table">
        <thead>
            <tr>
                <th><h3 class="font-bold">Part Number</h3></th>
                <th><h3 class="font-bold">Nama</h3></th>
                <th><h3 class="font-bold">Stok</h3></th>
                <th><h3 class="font-bold">Harga</h3></th>
                <th><h3 class="font-bold">Quantity</h3></th>
            </tr>
        </thead>
        <tbody>
        @foreach ($barang as $item)
            <tr>
                <td>{{ $item->part }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->stok }}</td>
                <td>
                    <div class="flex items-center">
                        <div class="me-2 font-medium text-lg">Rp</div>
                        <input type="text" class="input harga flex-shrink harga-input" part="{{ $item->part }}" value="{{ number_format($item->harga) }}">
                    </div>
                </td>
                <td>
                    <input type="number" class="input qty-input" part="{{ $item->part }}" value="{{ $item->qty }}">
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@if ($hutang > 0)
    <div role="alert" class="alert alert-warning mt-10 mb-5">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
        <span>Hutang customer sebesar Rp {{ number_format($hutang) }} Belum dibayar !<br><span class="italic font-semibold">Jangan lupa untuk ingatkan pelunasan.</span></span>
    </div>
@endif

<div class="mb-5 mt-10 flex items-center">
    <h2 class="text-xl font-bold">Konfirmasi Pesanan</h2>
</div>
<div class="p-4 bg-accent rounded-2xl my-5">
    <div>Barang / Paket Penjualan dengan Quantity 0 tidak akan dimasukan.</div>
    <form id="form" class="flex items-center justify-between" method="POST" action="{{ url('/invoice/barang') }}">
        @csrf
        <div class="my-5 flex items-center gap-3">
            <input type="checkbox" name="ppn-include" class="checkbox">
            <label class="text-sm">Harga Sudah PPN</label>
        </div>
        <button class="btn btn-primary">Selanjutnya</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
let data = [];
let paket = [];
let listQtyInput = document.querySelectorAll('.qty-input');
let listHargaInput = document.querySelectorAll('.harga-input');
let listHargaPaketInput = document.querySelectorAll('.harga-paket-input');

$('body').on('keyup', '.qty-input', function() {
    let qty = $(this).val();
    let part = $(this).attr('part');
    let harga = 0;

    listHargaInput.forEach(element => {
        if (element.getAttribute('part') == part) {
            harga = element.value
        }
    });

    try {
        if (qty == "" || qty <= 0) {
            let index = 0;
            for (let i = 0; i < data.length; i++) {
                const element = data[i];
                if (element.part == part) {
                    index = i;
                }
            }

            data.splice(index, 1)
        }else{
            let integerValue = parseInt(qty)
            if (!isNaN(integerValue)) {
                let index = data.filter((item) => item.part == part);
                if (index.length > 0) {
                    index[0].qty = parseInt(qty)
                    index[0].harga = harga
                }else{
                    data.push({
                        part: part,
                        harga: harga,
                        qty: parseInt(qty)
                    })
                }
            }
        }
    } catch (error) {

    }
    console.log(data)
});

$('body').on('keyup', '.harga-input', function() {
    let harga = $(this).val();
    let part = $(this).attr('part');

    data.forEach(element => {
        if (element.part == part) {
            element.harga = harga
        }
    });
    console.log(data)
});

$('body').on('keyup', '.qty-paket-input', function() {
    let qty = $(this).val();
    let part = $(this).attr('part');
    let harga = 0;

    listHargaPaketInput.forEach(element => {
        if (element.getAttribute('part') == part) {
            harga = element.value
        }
    });

    try {
        if (qty == "" || qty <= 0) {
            let index = 0;
            for (let i = 0; i < paket.length; i++) {
                const element = paket[i];
                if (element.part == part) {
                    index = i;
                }
            }

            paket.splice(index, 1)
        }else{
            let integerValue = parseInt(qty)
            if (!isNaN(integerValue)) {
                let index = paket.filter((item) => item.part == part);
                if (index.length > 0) {
                    index[0].qty = parseInt(qty)
                    index[0].harga = harga
                }else{
                    paket.push({
                        part: part,
                        harga: harga,
                        qty: parseInt(qty)
                    })
                }
            }
        }
    } catch (error) {

    }
    console.log(paket)
});

$('body').on('keyup', '.harga-paket-input', function() {
    let harga = $(this).val();
    let part = $(this).attr('part');

    paket.forEach(element => {
        if (element.part == part) {
            element.harga = harga
        }
    });
    console.log(paket)
});

$('#form').submit(function(event) {
    $("<input />").attr("type", "hidden")
        .attr("name", "barang")
        .attr("value", JSON.stringify(data))
        .appendTo("#form");

    $("<input />").attr("type", "hidden")
        .attr("name", "paket")
        .attr("value", JSON.stringify(paket))
        .appendTo("#form");

    return true;
});


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
