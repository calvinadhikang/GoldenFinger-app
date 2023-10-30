@extends('template/header')

@section('content')
<h1 class="text-3xl font-bold mb-5">Buat Invoice</h1>
<div class="mt-5 flex justify-center my-10">
    <ul class="steps w-full">
        <li class="step step-primary font-medium">Pilih Customer</li>
        <li class="step">Pilih Barang</li>
        <li class="step">Konfirmasi</li>
    </ul>
</div>
<div class="mb-5 mt-10">
    <h2 class="text-primary font-bold text-3xl">Pilih Customer</h2>
    <p>Silahkan pilih customer, anda dapat memilih dengan memasukan nama customer di kolom <b>cari nama customer</b><br><span class="text-primary">Tekan tombol kuning di sebelah kanan</span>, bila customer sudah sesuai</p>
</div>

@if ($customer != null)
<div class="text-xl font-semibold">Konfirmasi Customer</div>
@endif

@if ($customer == null)
    <h1 class="text-xl font-medium">Pilih Customer</h1>
    <div class="rounded bg-accent p-4 my-5">

        <table id="table">
            <thead>
                <tr>
                    <th><h3 class="font-bold">Nama Customer</h3></th>
                    <th><h3 class="font-bold">Aksi</h3></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $item)
                    <tr>
                        <td>{{ $item->nama }}</td>
                        <td>
                            <form method="POST" action="{{ url('/invoice/customer') }}">
                                @csrf
                                <button class="btn btn-sm btn-primary" name="id" value="{{ $item->id }}">Pilih</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
            <a href="{{ url('/invoice/barang') }}">
                <button class="btn btn-primary">Customer, Sudah Benar!</button>
            </a>
        </div>
    </div>
@endif

@endsection
