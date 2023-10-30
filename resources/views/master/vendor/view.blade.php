@extends('template/header')

@section('content')
<h1 class="text-3xl font-bold mb-5">Data Vendor</h1>
<div class="rounded bg-accent p-4 w-full">
    <div class="flex justify-end w-full mb-5">
        <a class="btn btn-primary" href="{{url('vendors/add')}}">Tambah</a>
    </div>
    <div class="overflow-x-auto">
        <table id="table" class="table-zebra">
            <thead>
                <tr>
                    <th><h3 class="font-bold">ID</h3></th>
                    <th><h3 class="font-bold">Nama</h3></th>
                    <th><h3 class="font-bold">Email</h3></th>
                    <th><h3 class="font-bold">Telp</h3></th>
                    <th><h3 class="font-bold">Alamat</h3></th>
                    <th><h3 class="font-bold">Jumlah Barang di Supply</h3></th>
                    <th><h3 class="font-bold">Action</h3></th>
                </tr>
            </thead>
            <tbody>
            @if (count($data) <= 0)
                <tr>
                    <th class="text-error text-lg" colspan="7">Tidak ada data...</th>
                </tr>
            @else
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->email}}</td>
                        <td>{{ $item->telp }}</td>
                        <td>{{ $item->alamat }}</td>
                        <td>{{ count($item->barang) }}</td>
                        <td>
                            <a href="{{ url("vendors/detail/$item->id") }}">
                                <i class="fa-solid fa-circle-info text-base hover:text-secondary"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>

@endsection
