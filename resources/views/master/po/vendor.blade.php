@extends('template/header')

@section('content')
<div class="prose">
    <h1 class="text-white">Buat PO</h1>
</div>
<ul class="mt-5 steps w-full">
    <li class="step step-primary">Pilih Barang</li>
    <li class="step step-primary">Pilih Vendor</li>
    <li class="step">Konfirmasi</li>
</ul>
<div class="rounded bg-accent p-4 my-5">
    <div class="flex">
        <div class="mb-2 grow">
            <div class="prose">
                <h2 class="mb-0">Pilih Vendor</h2>
            </div>
            <p>Pilih vendor sesuai dengan barang yang ingin di beli, <br> 
            Kamu bisa merubah barang yang sudah kamu pilih dengan menekan tombol <a href="{{ url('/po/barang') }}" class="link text-secondary font-bold italic">kembali</a></p>
        </div>
        <button class="btn btn-primary float-right">Konfirmasi <i class="fa-solid fa-chevron-right"></i></button>
    </div>
    <div class="overflow-x-auto mb-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="prose"><h3 class="font-bold">Nama</h3></th>
                    <th class="prose"><h3 class="font-bold">Nomor Telepon</h3></th>
                    <th class="prose"><h3 class="font-bold">Harga Vendor</h3></th>
                    <th class="prose"><h3 class="font-bold">Pilih Vendor</h3></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Ban Kotak Lancar Jaya</th>
                    <th>081 330 77</th>
                    <td>Rp 2.000.000</td>
                    <td>
                        <input type="checkbox" class="checkbox">
                    </td>
                </tr>
                <tr>
                    <th>Vendor Ban Bulat</th>
                    <th>O813 3062 5509 </th>
                    <td>Rp 3.550.000</td>
                    <td>
                        <input type="checkbox" class="checkbox">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
