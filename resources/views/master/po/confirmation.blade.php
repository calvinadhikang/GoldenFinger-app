@extends('template/header')

@section('content')
<h1 class="  text-2xl font-bold">Buat Purchase Order</h1>
<div class="text-sm breadcrumbs mb-5  ">
    <ul>
        <li><a href="/po">Data Purchase Order</a></li>
        <li>Buat Purchase Order</li>
    </ul>
</div>
<div class="mt-5 flex justify-center">
    <ul class="steps w-full">
        <li class="step step-primary"><a href="/po/barang" class="hover:underline">Pilih Barang</a></li>
        <li class="step step-primary"><a href="/po/vendor" class="hover:underline">Pilih Vendor</a></li>
        <li class="step step-primary font-medium">Konfirmasi</li>
    </ul>
</div>
<div class="mb-5 mt-10">
    <h2 class="font-semibold text-xl">Informasi Vendor</h2>
</div>
<div class="bg-accent rounded-2xl p-4 my-5">
    <div class="flex flex-wrap mb-5">
        <div class="form-control w-full md:w-1/2 md:pe-2">
            <label class="label">
                <span class="label-text text-lg font-bold">Nama</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" value="{{ $po->vendor->nama }}" class="input w-full" name="nama" disabled required/>
        </div>
        <div class="form-control w-full md:w-1/2">
            <label class="label">
                <span class="label-text text-lg font-bold">Email</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" value="{{ $po->vendor->email }}" class="input w-full" name="email" disabled required/>
        </div>
        <div class="form-control w-full md:w-1/2 md:pe-2">
            <label class="label">
                <span class="label-text text-lg font-bold">Telp</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" value="{{ $po->vendor->telp }}" class="input w-full" name="telp" disabled required/>
        </div>
        <div class="form-control w-full md:w-1/2">
            <label class="label">
                <span class="label-text text-lg font-bold">Alamat</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" value="{{ $po->vendor->alamat }}" class="input w-full" name="alamat" disabled required/>
        </div>
    </div>
</div>

<div class="mb-5">
    <h2 class="font-semibold text-xl">Informasi Barang</h2>
</div>
<div class="rounded-2xl bg-accent p-4 my-5">
    <form method="POST">
        @csrf
        <table class="data-table table-zebra">
            <thead>
                <tr>
                    <th><h3 class="font-medium">Part Number</h3></th>
                    <th><h3 class="font-medium">Nama</h3></th>
                    <th><h3 class="font-medium">Stok</h3></th>
                    <th><h3 class="font-medium">Quantity Pembelian</h3></th>
                    <th><h3 class="font-medium">Harga Vendor</h3></th>
                    <th><h3 class="font-medium">Subtotal</h3></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($po->list as $item)
                <tr>
                    <td>{{ $item->part }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->stok }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>
                        <div>
                            <p class="font-semibold">{{ format_decimal($item->harga * $po->PPN / 100 + $item->harga) }}</p>
                            <p class="text-xs">Tanpa PPN: Rp {{ format_decimal($item->harga) }}</p>
                        </div>
                    </td>
                    <td>
                        <div>
                            <p class="font-semibold">{{ format_decimal($item->subtotal * $po->PPN / 100 + $item->subtotal) }}</p>
                            <p class="text-xs">Tanpa PPN: Rp {{ format_decimal($item->subtotal) }}</p>
                        </div>
                        </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </form>
    <p class="text-right mt-5 text-lg font-semibold">Total : Rp {{ format_decimal($po->total * $po->PPN / 100 + $po->total) }}</p>
    <p class="text-right text-xs">Tanpa PPN : Rp{{ format_decimal($po->total) }}</p>
</div>

<div class="mb-5">
    <h2 class="font-semibold text-xl">Informasi PPN</h2>
</div>
<div class="rounded-2xl bg-accent p-4 my-5">
    <div class="flex gap-5">
        <div class="grow">
            <p class="text-lg font-semibold mb-1">PPN :<p>
            <form action="{{ url('/po/confirmation/ppn') }}" method="post">
                @csrf
                <input type="text" class="input me-5" name="ppn" value="{{ $po->PPN }}"> <button class="btn btn-primary">Simpan !</button>
            </form>
        </div>
        <div class="grow text-right">
            <p class="text-lg font-semibold mb-1">Total Pajak</p>
            <p>Rp {{ format_decimal($po->PPN_value) }}</p>
        </div>
    </div>
</div>

<div class="mb-5">
    <h2 class="font-semibold text-xl">Grand Total</h2>
</div>
<div class="rounded-2xl bg-accent p-4 my-5 items-center">
    <?php $grandTotal = $po->total + ($po->PPN * $po->total / 100) ?>
    <div class="gap-x-10 gap-y-3 grid-cols-2 grid">
        <p class="font-medium">Total Harga Barang</p>
        <p class="text-right">Rp {{ format_decimal($po->total) }}</p>
        <p class="font-medium">Total Pajak</p>
        <p class="text-right">Rp {{ format_decimal($po->PPN * $po->total / 100) }}</p>
        <p class="font-medium">Total Biaya</p>
        <p class="text-right text-lg font-semibold">Rp {{ format_decimal($grandTotal) }}</p>
    </div>
</div>

<form action="" method="post">
    @csrf

    {{-- Form Transaksi Lama --}}
    <div class="">
        <div class="flex gap-10 items-center justify-between mb-5 h-10">
            <div class="flex items-center gap-5">
                <span class="text-xl font-semibold">Data Transaksi Lama ?</span>
                <input type="checkbox" name="time" class="toggle" id="timeCheck">
            </div>
            <div class="">
                <div id="timeStatus" class="text-xl font-semibold text-secondary w-full">Data Transaksi Baru</div>
            </div>
        </div>
        <div class="rounded-2xl bg-accent mb-5">
            <div class="flex space-x-4 p-4" id="time-input">
                <div class="w-full">
                    <p class="font-semibold mb-2">Status Pembayaran</p>
                    <div class="flex items-start justify-start">
                        <input type="checkbox" class="checkbox me-2" name="statusPembayaran" id="statusPembayaran">
                        <label>Pembayaran Sudah Lunas</label>
                    </div>
                    <div class="mt-2 space-y-2" id="statusValuePembayaran">
                        <div class="">
                            <label class="text-sm">Waktu Pembayaran</label>
                            <input type="date" class="input w-full" name="timeValuePembayaran" id="timeValuePembayaran">
                        </div>
                        <div class="">
                            <label class="text-sm">Metode Pembayaran</label>
                            <select name="oldMethodTransaksi" class="select w-full">
                                <option value="" disabled selected>Pilih Metode Pembayaran</option>
                                <option value="cash">Cash</option>
                                <option value="transfer">Transfer</option>
                            </select>
                        </div>
                        <div class="">
                            <label class="text-sm">Nomor Transaksi</label>
                            <input type="text" class="input w-full" name="oldNomorTransaksi">
                        </div>
                    </div>
                    <p class="font-semibold mb-2 mt-10">Status Penerimaan Barang</p>
                    <div class="flex items-start justify-start">
                        <input type="checkbox" class="checkbox me-2" name="statusPenerimaan" id="statusPenerimaan">
                        <label>Barang Pesanan Sudah Diterima</label>
                    </div>
                    <div class="mt-2" id="statusValuePenerimaan">
                        <label class="text-sm">Waktu Penerimaan Barang</label>
                        <input type="date" class="input w-full" name="timeValuePenerimaan" id="timeValuePenerimaan">
                    </div>
                </div>
                <div class="w-full space-y-2">
                    <div class="space-y-2">
                        <p class="font-semibold">Kode Purchase Order</p>
                        <input type="text" class="input w-full" name="oldKode">
                    </div>
                    <div class="space-y-2">
                        <p class="font-semibold">Tanggal Pembuatan Purchase Order</p>
                        <input type="date" class="input w-full" name="timePembuatan" id="timePembuatan">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h1 class="text-xl font-semibold mb-5">Jatuh Tempo</h1>
    <div class="bg-accent p-4 rounded-2xl mb-10">
        <p class="text-sm mb-2">Pastikan tanggal jatuh tempo lebih dari tanggal sekarang</p>
        <input type="date" class="input w-full" name="jatuhTempo" required>
    </div>

    <div class="mb-5">
        <button class="btn btn-primary btn-block">Buat Pesanan !</button>
    </div>
</form>

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

const toggleTimeStatus = status => {
    if (status) {
        $('#timeStatus').html("Data Transaksi Lama");
        $('#timeStatus').addClass("text-error");
        $('#timeStatus').removeClass("text-secondary");
        $('#time-input').show();

        $('#timePembuatan').prop('required', true);
    }else{
        $('#timeStatus').html("Data Transaksi Baru");
        $('#timeStatus').addClass("text-secondary");
        $('#timeStatus').removeClass("text-error");
        $('#time-input').hide();

        $('#timePembuatan').prop('required', false);
    }
}

$('#timeCheck').on('click', function() {
    let checkedStatus = $(this).prop('checked');
    toggleTimeStatus(checkedStatus);
})

$('#statusPembayaran').on('change', function() {
    let isChecked = $(this).prop('checked');
    if (isChecked) {
        $('#statusValuePembayaran').show();
        $('#timeValuePembayaran').prop('required', true);
    } else {
        $('#statusValuePembayaran').hide();
        $('#timeValuePembayaran').prop('required', false);
    }
})

$('#statusPenerimaan').on('change', function() {
    let isChecked = $(this).prop('checked');
    if (isChecked) {
        $('#statusValuePenerimaan').show();
        $('#timeValuePenerimaan').prop('required', true);
    } else {
        $('#statusValuePenerimaan').hide();
        $('#timeValuePenerimaan').prop('required', false);
    }
})

toggleTimeStatus(false);
$('#statusValuePembayaran').hide();
$('#statusValuePenerimaan').hide();

</script>
@endsection
