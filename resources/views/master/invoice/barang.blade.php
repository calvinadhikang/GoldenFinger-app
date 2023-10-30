@extends('template/header')

@section('content')
<h1 class="text-3xl font-bold mb-5">Buat Invoice</h1>
<div class="mt-5 flex justify-center">
    <ul class="steps w-full">
        <li class="step step-primary hover:underline"><a href="{{ url('/invoice/customer') }}">Pilih Customer</a></li>
        <li class="step step-primary font-medium">Pilih Barang</li>
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
                    <th><h3 class="font-bold">Part Number</h3></th>
                    <th><h3 class="font-bold">Nama</h3></th>
                    <th><h3 class="font-bold">Harga</h3></th>
                    <th><h3 class="font-bold">Quantity</h3></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($barang as $item)
                <tr>
                    <td>{{ $item->part }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>
                        <div class="flex items-center">
                            <div class="">Rp</div>
                            <input type="text" class="input input-bordered input-secondary harga flex-shrink" name="harga[]" value="{{ number_format($item->harga) }}">
                        </div>
                    </td>
                    <td>
                        <input type="number" class="input input-bordered input-secondary" name="qty[]" value="{{ $item->qty }}">
                        <input type="hidden" name="part[]" value="{{ $item->part }}">
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @error('limit')
        <div class="alert alert-error my-5">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span>{{ $message }}. <br><span class="italic font-semibold">Silahkan minta Customer melunasi / kurangi jumlah pembelian</span></span>
        </div>
        @enderror
        <button class="btn btn-primary">Selanjutnya</button>
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
