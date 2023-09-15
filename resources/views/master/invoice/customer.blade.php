@extends('template/header')

@section('content')
<div class="prose">
    <h1 class="text-white">Buat Invoice</h1>
</div>
<div class="mt-5 flex justify-center my-10">
    <ul class="steps w-full">
        <li class="step step-primary"><a href="{{ url('/invoice/add') }}" class="bg-secondary mt-2 rounded-lg p-1 hover:bg-blue-500">Pilih Barang</a></li>
        <li class="step step-primary"><a href="{{ url('/invoice/customer') }}">Pilih Customer</a></li>
        <li class="step">Konfirmasi</li>
    </ul>
</div>
<div class="mb-5 mt-10">
    <h2 class="text-primary font-bold text-3xl">Pilih Customer</h2>
    <p>Silahkan pilih customer, anda dapat memilih dengan memasukan nama customer di kolom <b>cari nama customer</b><br><span class="text-primary">Tekan tombol kuning di sebelah kanan</span>, bila customer sudah sesuai</p>
</div>

@if ($customer != null)
<div class="text-xl font-semibold">Informasi Customer</div>
@endif

@if ($customer == null)
    <h1 class="text-xl font-medium">Pilih Customer</h1>
    <div class="rounded bg-accent p-4 my-5">
        <div class="mb-5">
            <p class="text-sm font-bold"><i class="fa-solid fa-magnifying-glass me-3"></i>Cari nama Customer</p>
            <input type="text" class="input mt-2" placeholder="Joko" id="search">
        </div>
        <span class="loading loading-spinner loading-lg" id="loading"></span>

        <div id="formAdd">
            <p id="message" class="font-bold text-error">Customer Tidak Ditemukan</p>
            <p class="text-error">Silahkan buat customer baru dibawah</p>
            {{-- <a href="{{ url('/customer/add') }}"><button class="btn btn-secondary">Tambah Customer</button></a> --}}
        </div>

        <form method="POST" action="{{ url('/invoice/customer') }}" id="formCustomer">
            @csrf
            <p class="mb-2 font-bold">Nama Customer</p>
            <div class="flex w-full justify-between">
                <div class="w-full">
                    <select name="customer" class="select w-full" id="selectCustomer"></select>
                </div>
                <button class="btn btn-primary ms-5">Pilih Customer!</button>
            </div>
        </form>
    </div>

    <div class="divider">Atau</div>

    <h1 class="text-xl font-medium">Buat Customer Baru</h1>
    <div class="rounded bg-accent p-4 my-5">
        <form method="POST" action="{{ url('invoice/customer/new') }}">
            @csrf
            <div class="flex flex-wrap my-5">
                <div class="form-control w-full md:w-1/2 md:pe-2">
                    <label class="label">
                        <span class="label-text text-lg font-bold"><i class="fa-solid fa-id-badge me-2"></i>Nama</span>
                        <span class="label-text-alt"></span>
                    </label>
                    <input type="text" placeholder="Joko.." class="input input-bordered w-full" name="nama" />
                </div>
                <div class="form-control w-full md:w-1/2">
                    <label class="label">
                        <span class="label-text text-lg font-bold"><i class="fa-solid fa-envelope me-2"></i>Email</span>
                        <span class="label-text-alt"></span>
                    </label>
                    <input type="email" placeholder="...@..." class="input input-bordered w-full" name="email" />
                </div>
                <div class="form-control w-full md:w-1/2 md:pe-2">
                    <label class="label">
                        <span class="label-text text-lg font-bold"><i class="fa-solid fa-location-dot me-2"></i>Alamat</span>
                        <span class="label-text-alt"></span>
                    </label>
                    <input type="text" placeholder="Jalan..." class="input input-bordered w-full" name="alamat" />
                </div>
                <div class="form-control w-full md:w-1/2">
                    <label class="label">
                        <span class="label-text text-lg font-bold"><i class="fa-solid fa-phone me-2"></i>Nomor Telp</span>
                        <span class="label-text-alt"></span>
                    </label>
                    <input type="text" placeholder="081..." class="input input-bordered w-full" name="telp" />
                </div>
            </div>
            <button class="btn btn-primary">Tambah</button>
        </form>
    </div>
@else
    <div class="rounded bg-accent p-4 my-5">
        <div class="flex flex-wrap mb-5">
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text text-lg font-bold"><i class="fa-solid fa-id-badge me-2"></i>Nama</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" class="input input-bordered w-full " value="{{ $customer->nama }}" disabled/>
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text text-lg font-bold"><i class="fa-solid fa-envelope me-2"></i>Email</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="email" class="input input-bordered w-full" value="{{ $customer->email }}" disabled/>
            </div>
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text text-lg font-bold"><i class="fa-solid fa-location-dot me-2"></i>Alamat</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" class="input input-bordered w-full" value="{{ $customer->alamat }}" disabled/>
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text text-lg font-bold"><i class="fa-solid fa-phone me-2"></i>Nomor Telp</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" class="input input-bordered w-full" value="{{ $customer->telp }}" disabled/>
            </div>
        </div>
        <div class="">
            <a href="{{ url('/invoice/customer/unset') }}">
                <button class="btn btn-error">Ganti Customer</button>
            </a>
            <a href="{{ url('/invoice/confirmation') }}">
                <button class="btn btn-secondary">Konfirmasi</button>
            </a>
        </div>
    </div>
@endif

{{-- <div class="text-xl font-semibold">
    <h3>Informasi Pesanan</h3>
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
        @foreach ($barang as $item)
            <tr>
                <td>{{ $item->part }}</td>
                <td>{{ $item->nama }}</td>
                <td>Rp {{ number_format($item->harga) }}</td>
                <td>{{ number_format($item->qty) }}</td>
                <td>Rp {{ number_format($item->subtotal) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="text-right w-full mt-10">
        Grand Total : <span class="text-2xl font-bold text-primary">Rp {{ number_format($grandTotal) }}</span>
    </div>
</div> --}}

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
$(document).ready(function () {
    fetchCustomerData()
});

$('#search').on('keyup', function (e) {
    let target = e.target.value
    fetchCustomerData(target)
});

fetchCustomerData = (target) => {
    isLoading(true)

    $.ajax({
        type: "GET",
        url: "http://127.0.0.1:8000/api/customer",
        data: {
            key: target
        },
        success: function (response) {
            isLoading(false)

            if(response.error || response.data.length <= 0){
                $('#formCustomer').hide();
                $('#formAdd').show();
            }else{
                $('#formCustomer').show();
                $('#formAdd').hide();
                renderData(response.data)
            }
        }
    });
}

renderData = (data) => {
    let html = ``
    data.forEach(element => {
        html += `<option value="${element.id}">Nama ${element.nama} - Telp ${element.telp}</option>`
    })

    $('#selectCustomer').html(html)
}

isLoading = (status) => {
    if(status){
        $('#loading').show();
    }else{
        $('#loading').hide();
    }
}

</script>
@endsection
