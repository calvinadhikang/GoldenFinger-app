@extends('template/header')

@section('content')
<div class="prose">
    <h1 class="text-white">Buat PO</h1>
</div>
<ul class="mt-5 steps w-full">
    <li class="step step-primary">Pilih Barang</li>
    <li class="step">Pilih Vendor</li>
    <li class="step">Konfirmasi</li>
</ul>
<div class="rounded bg-accent p-4 my-5">
    <div class="flex w-full">
        <div class="mb-2 grow">
            <div class="prose">
                <h2 class="mb-0">Pilih Barang</h2>
            </div>
            <p class="text">Pilih barang yang ingin di beli, dengan mencentang barang</p>
        </div>
        <a class="btn btn-primary float-right" href="{{url('po/vendor')}}">Pilih Vendor <i class="fa-solid fa-chevron-right"></i></a>
    </div>
    <div class="overflow-x-auto mb-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="prose"><h3 class="font-bold">Part Number</h3></th>
                    <th class="prose"><h3 class="font-bold">Nama</h3></th>
                    <th class="prose"><h3 class="font-bold">Stok</h3></th>
                    <th class="prose"><h3 class="font-bold">Aksi</h3></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>123123123</th>
                    <th>Ban Mobil Besar</th>
                    <td>20 Pcs</td>
                    <td>
                        <input type="checkbox" class="checkbox">
                    </td>
                </tr>
                <tr>
                    <th>123123123</th>
                    <th>Ban Mobil Besar</th>
                    <td>20 Pcs</td>
                    <td>
                        <input type="checkbox" class="checkbox">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
