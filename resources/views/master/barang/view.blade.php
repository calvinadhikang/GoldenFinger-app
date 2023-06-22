@extends('template/header')

@section('content')
<div class="flex items-center mb-10">
    <div class="grow m-auto">
        <div class="prose">
            <h1>Data Barang</h1>
        </div>
    </div>
    <button class="btn btn-secondary">Import Excel</button>
</div>
<div class="rounded bg-accent p-4 w-full">
    <div class="flex justify-end w-full">
        <a class="btn btn-primary" href="{{url('barang/add')}}">Tambah</a>
    </div>
    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th class="prose"><h3 class="font-bold">Part Number</h3></th>
                    <th class="prose"><h3 class="font-bold">Nama Barang</h3></th>
                    <th class="prose"><h3 class="font-bold">Harga Jual</h3></th>
                    <th class="prose"><h3 class="font-bold">Stok</h3></th>
                    <th class="prose"><h3 class="font-bold">Aksi</h3></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>123123123</th>
                    <th>Ban Mobil Besar</th>
                    <td>Rp <i>1,000,000</i></td>
                    <td>20 Pcs</td>
                    <td>
                        <i class="fa-solid fa-circle-info text-base hover:text-secondary"></i>
                    </td>
                </tr>
                <tr>
                    <th>123123123</th>
                    <th>Ban Mobil Besar</th>
                    <td>Rp <i>1,000,000</i></td>
                    <td>20 Pcs</td>
                    <td>
                        <i class="fa-solid fa-circle-info text-base hover:text-secondary"></i>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
    
@endsection