@extends('template/header')

@section('content')
<h1 class="text-2xl font-bold">Tambah Paket Penjualan</h1>
<div class="text-sm breadcrumbs mb-5  ">
    <ul>
        <li><a href="/paket">Data Paket</a></li>
        <li>Tambah Paket</li>
    </ul>
</div>
<div class="rounded-2xl bg-accent p-4 my-5">
    <form method="POST" id="form">
        @csrf
        <div class="flex flex-wrap mb-5">
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text text-lg font-bold">Nama Paket</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="Nama Paket..." class="input   w-full" name="nama" required/>
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text text-lg font-bold">Harga Paket</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="1000" class="input   w-full harga" name="harga" required/>
            </div>
        </div>
        <h1 class="text-lg font-bold mb-5 mt-10">Barang Yang Dijual Pada Paket</h1>
        <table class="table-zebra data-table">
            <thead>
                <th><h3 class="font-bold">Part</h3></th>
                <th><h3 class="font-bold">Nama</h3></th>
                <th><h3 class="font-bold">Quantity</h3></th>
            </thead>
            <tbody>
                @foreach ($barang as $item)
                <tr>
                    <td>{{ $item->part }}</td>
                    <td>{{ $item->nama }}</td>
                    <td><input type="text" class="input input-secondary part-input" part="{{ $item->part }}"></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button class="btn btn-primary" name="btn">Tambah</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
let data = [];

$('body').on('keyup', '.part-input', function() {
    let value = $(this).val();
    let part = $(this).attr('part');
    try {
        if (value == "") {
            let index = 0;
            for (let i = 0; i < data.length; i++) {
                const element = data[i];
                if (element.part == part) {
                    index = i;
                }
            }

            data.splice(index, 1)
        }else{
            let integerValue = parseInt(value)
            if (!isNaN(integerValue)) {
                console.log(part)

                let index = data.filter((item) => item.part == part);
                if (index.length > 0) {
                    index[0].qty = value
                }else{
                    data.push({
                        part: part,
                        qty: value
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
        .attr("name", "data")
        .attr("value", JSON.stringify(data))
        .appendTo("#form");
    return true;
});
</script>

@endsection
