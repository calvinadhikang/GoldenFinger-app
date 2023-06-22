@extends('template/header')

@section('content')
<div class="flex justify-end">
    <button class="btn btn-secondary my-5">Import Excel</button>
</div>
<div class="rounded bg-accent p-4 w-100">
    <div class="flex my-5">
        <h1 class="grow">Data Barang</h1>
        <a class="btn btn-primary">Tambah</a>        
    </div>
    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th class="font-bold">Part Number</th>
                    <th class="font-bold">Nama Barang</th>
                    <th class="font-bold">Harga Jual</th>
                    <th class="font-bold">Stok</th>
                    <th class="font-bold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>123123123</th>
                    <th>Ban Mobil Besar</th>
                    <td>Rp <i>1,000,000</i></td>
                    <td>20 Pcs</td>
                    <td>
                        <i class="fa-solid fa-circle-info text-primary hover:text-secondary"></i>
                    </td>
                </tr>
                <tr>
                    <th>123123123</th>
                    <th>Ban Mobil Besar</th>
                    <td>Rp <i>1,000,000</i></td>
                    <td>20 Pcs</td>
                    <td>
                        <i class="fa-solid fa-circle-info text-primary hover:text-secondary"></i>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
    
@endsection