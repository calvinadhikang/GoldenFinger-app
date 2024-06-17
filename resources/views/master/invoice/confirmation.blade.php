@extends('template/header')

@section('content')
<h1 class="text-2xl font-bold">Buat Invoice</h1>
<div class="text-sm breadcrumbs mb-5  ">
    <ul>
        <li><a href="/invoice">Data Invoice</a></li>
        <li>Buat Invoice</li>
    </ul>
</div>
<div class="flex justify-center">
    <ul class="steps w-full">
        <li class="step step-primary hover:underline"><a href="{{ url('/invoice/customer') }}">Pilih Customer</a></li>
        <li class="step step-primary hover:underline"><a href="{{ url('/invoice/barang') }}">Pilih Barang</a></li>
        <li class="step step-primary font-medium">Konfirmasi</li>
    </ul>
</div>
<div class="mb-5 mt-10">
    <h2 class="font-bold text-xl">Konfirmasi Pesanan</h2>
    <p>Pastikan informasi pesanan, dan customer sudah benar.</p>
    <p>Jangan lupa cek ulang data pesanan dan totalnya.</p>
</div>

<h2 class="font-semibold text-xl mb-5">Detail Biaya</h2>
<div class="rounded-2xl bg-accent p-4 my-5 items-center">
    <div class="gap-x-10 gap-y-3 grid-cols-2 grid">
        <div class="font-medium">Total Harga Barang</div>
        <div class="text-right">Rp {{ format_decimal($invoice->total) }}</div>
        <p class="font-medium">Total Pajak</p>
        <p class="text-right">Rp {{ format_decimal($invoice->PPN_value) }}</p>
        <p class="font-medium">Total Biaya</p>
        <p class="text-right text-lg font-semibold">Rp {{ format_decimal($invoice->grandTotal) }}</p>
    </div>
</div>

<h3 class="font-semibold text-xl mb-5">Informasi Customer</h3>
<div class="rounded-2xl bg-accent p-4 my-5">
    <div class="flex flex-wrap">
        <div class="form-control w-full md:w-1/2 md:pe-2">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-id-badge me-2"></i>Nama</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" class="input w-full " value="{{ $invoice->customer->nama }}" disabled/>
        </div>
        <div class="form-control w-full md:w-1/2">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-envelope me-2"></i>Email</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="email" class="input w-full" value="{{ $invoice->customer->email }}" disabled/>
        </div>
        <div class="form-control w-full md:w-1/2 md:pe-2">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-location-dot me-2"></i>Alamat</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" class="input w-full" value="{{ $invoice->customer->alamat }}" disabled/>
        </div>
        <div class="form-control w-full md:w-1/2">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-phone me-2"></i>Nomor Telp</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" class="input w-full" value="{{ $invoice->customer->telp }}" disabled/>
        </div>
    </div>
</div>

<div class="flex items-center mb-5">
    <i class="fa-solid me-2 w-6 fa-box-open"></i>
    <h3 class="font-semibold text-xl">Data Barang Pesanan</h3>
</div>
<div class="rounded-2xl bg-accent p-4 my-5">
    @if (count($invoice->list_barang) <= 0)
    <p class="text-error">Tidak ada pesanan barang</p>
    @else
    <table class="data-table table-zebra">
        <thead>
            <tr>
                <th><h3 class="font-bold">Part Number</h3></th>
                <th><h3 class="font-bold">Nama</h3></th>
                <th><h3 class="font-bold">Harga</h3></th>
                <th><h3 class="font-bold">Jumlah</h3></th>
                <th><h3 class="font-bold">Subtotal</h3></th>
            </tr>
        </thead>
        <tbody>
        @foreach ($invoice->list_barang as $item)
            <tr>
                <td>{{ $item->part }}</td>
                <td>{{ $item->nama }}</td>
                <td>
                    <p>Rp {{ format_decimal($item->harga) }}</p>
                    {{-- <p class="text-xs text-slate-400">Harga Tanpa PPN : Rp {{ format_decimal($item->clean_price) }}</p> --}}
                </td>
                <td>{{ number_format($item->qty) }}</td>
                <td>Rp {{ format_decimal($item->subtotal) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <p class="text-right mt-5 text-lg font-semibold">Total : Rp {{ format_decimal($invoice->total_list_barang) }}</p>
    @endif
</div>

<h2 class="font-semibold text-xl mb-5">Informasi Pajak</h2>
<div class="rounded-2xl bg-accent p-4 my-5">
    <div class="grid grid-cols-1 md:grid-cols-2">
        <div>
            <p class="font-semibold mb-1">Besar PPN :<p>
            <form action="{{ url('/invoice/confirmation/ppn') }}" method="post">
                @csrf
                <input type="text" class="input me-5" name="ppn" value="{{ $invoice->PPN }}"> <button class="btn btn-primary">Simpan !</button>
            </form>
        </div>
        <div>
            <div class="font-medium text-right mb-1">Total Pajak</div>
            <div class="text-right">Rp {{ format_decimal($invoice->PPN_value) }}</div>
        </div>
    </div>
</div>

<form method="POST">
    @csrf

    {{-- Form Komisi --}}
    <div class="">
        <div class="flex gap-10 items-center justify-between mb-5 h-10">
            <div class="flex items-center gap-5">
                <span class="text-xl font-semibold">Dapat Komisi ? </span>
                <input type="checkbox" name="komisi" class="toggle" id="komisiCheck">
            </div>
            <div class="">
                <div id="komisiStatus" class="text-xl font-semibold text-secondary w-full">Dapat Komisi</div>
            </div>
        </div>
        <div class="rounded-2xl bg-accent mb-5">
            <div class="flex space-x-4 p-4" id="komisi-input">
                <div class="w-full">
                    <p class="font-semibold">Jumlah Komisi</p>
                    <input type="text" class="input w-full harga" name="komisiJumlah" value="0" id="komisi">
                </div>
                <div class="w-full">
                    <p class="font-semibold">Nama Penerima Komisi</p>
                    <input type="text" class="input w-full" name="komisiPenerima">
                </div>
            </div>
        </div>
    </div>

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
                    <div class="mt-2 space-y-4" id="statusValuePembayaran">
                        <div class="">
                            <label class="font-semibold">Waktu Pembayaran</label>
                            <input type="date" class="input w-full" name="timeValuePembayaran" id="timeValuePembayaran">
                        </div>
                        <div class="">
                            <label class="font-semibold">Metode Pembayaran</label>
                            <select name="oldMethodTransaksi" class="select w-full">
                                <option value="" disabled selected>Pilih Metode Pembayaran</option>
                                <option value="cash">Cash</option>
                                <option value="transfer">Transfer</option>
                            </select>
                        </div>
                        <div class="">
                            <label class="font-semibold">Kode Pembayaran</label>
                            <input type="text" class="input w-full" name="oldNomorTransaksi">
                        </div>
                    </div>
                </div>
                <div class="w-full space-y-2">
                    <div class="">
                        <p class="font-semibold">Kode Invoice</p>
                        <input type="text" class="input w-full" name="oldKode" id="kodePembuatan">
                    </div>
                    <div class="">
                        <p class="font-semibold">Tanggal Pembuatan Invoice</p>
                        <input type="date" class="input w-full" name="timePembuatan" id="timePembuatan">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <p class="text-xl font-semibold mb-5">Nomor PO</p>
    <div class="rounded-2xl bg-accent p-4 mb-5">
        <p class="font-semibold">Masukan nomor PO</p>
        <input type="text" class="input w-full" name="po" required value="-">
        <p class="text-sm mt-1">isi dengan ' - ' kalau tidak ada nomor PO</p>
    </div>

    <p class="text-xl font-semibold mb-5">Jatuh Tempo</p>
    <div class="rounded-2xl bg-accent p-4 mb-5">
        <input type="date" class="input w-full" name="jatuhTempo" value="{{ old('jatuhTempo') }}" required>
    </div>

    <button class="btn btn-primary w-full mb-10 shadow-lg">Buat Pesanan !</button>
</form>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
const toggleKomisiStatus = status => {
    if (status) {
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
}

const toggleTimeStatus = status => {
    if (status) {
        $('#timeStatus').html("Data Transaksi Lama");
        $('#timeStatus').addClass("text-error");
        $('#timeStatus').removeClass("text-secondary");
        $('#time-input').show();

        $('#timePembuatan').prop('required', true);
        $('#kodePembuatan').prop('required', true);
    }else{
        $('#timeStatus').html("Data Transaksi Baru");
        $('#timeStatus').addClass("text-secondary");
        $('#timeStatus').removeClass("text-error");
        $('#time-input').hide();

        $('#timePembuatan').prop('required', false);
        $('#kodePembuatan').prop('required', false);
    }
}

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

$('#komisiCheck').on('click', function() {
    let checkedStatus = $(this).prop('checked');
    toggleKomisiStatus(checkedStatus);
})

$('#timeCheck').on('click', function() {
    let checkedStatus = $(this).prop('checked');
    toggleTimeStatus(checkedStatus);
})

toggleKomisiStatus(false);
toggleTimeStatus(false);
$('#statusValuePembayaran').hide();

</script>
@endsection
