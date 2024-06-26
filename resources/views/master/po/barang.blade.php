@extends('template/header')

@section('content')
<h1 class="  text-2xl font-bold">Buat Purhcase Order</h1>
<div class="text-sm breadcrumbs mb-5  ">
    <ul>
        <li><a href="/po">Data Purchase Order</a></li>
        <li>Buat Purchase Order</li>
    </ul>
</div>
<div class="mt-5 flex justify-center">
    <ul class="steps w-full">
        <li class="step step-primary font-medium">Pilih Barang</li>
        <li class="step">Pilih Vendor</li>
        <li class="step">Konfirmasi</li>
    </ul>
</div>
<div class="mb-5 mt-10">
    <h2 class="font-bold text-3xl">Pilih Barang</h2>
    <p>Isi jumlah barang yang ingin dibeli, di kolom "Quantity"</p>
</div>
<div class="rounded-2xl bg-accent p-4 my-5">
    <form method="POST" id="form">
        @csrf
        <table class="data-table table-zebra">
            <thead>
                <tr>
                    <th><h3 class="font-bold">Part Number</h3></th>
                    <th><h3 class="font-bold">Nama</h3></th>
                    <th><h3 class="font-bold">Stok</h3></th>
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
                        <input type="number" class="input   input-secondary qty-input" name="qty[]" part="{{ $item->part }}" value="{{ $item->qty }}">
                        <input type="hidden" name="part[]" value="{{ $item->part }}">
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <button class="btn btn-primary">Selanjutnya</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
let data = [];
let listQtyInput = document.querySelectorAll('.qty-input');

$('body').on('keyup', '.qty-input', function() {
    let qty = $(this).val();
    let part = $(this).attr('part');
    // let harga = 0;

    // listHargaInput.forEach(element => {
    //     if (element.getAttribute('part') == part) {
    //         harga = element.value
    //     }
    // });

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
            let integerValue = parseInt(qty.toString())
            if (!isNaN(integerValue)) {
                let index = data.filter((item) => item.part == part);
                if (index.length > 0) {
                    index[0].qty = integerValue
                    // index[0].harga = harga
                }else{
                    data.push({
                        part: part,
                        qty: integerValue,
                        // harga: harga,
                    })
                }
            }
        }
    } catch (error) {

    }
    console.log(data)
});

$('#form').submit(function(event) {
    $("<input />").attr("type", "hidden")
        .attr("name", "barang")
        .attr("value", JSON.stringify(data))
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
