@extends('template/header')

@section('content')
<h1 class="text-2xl font-bold mb-5">Data Customer</h1>
<div class="rounded-2xl bg-accent p-4 w-full">
    <div class="flex justify-end w-full mb-5">
        <a class="btn btn-primary" href="{{url('customer/add')}}">Tambah</a>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table table-zebra">
            <thead>
                <tr>
                    <th><h3 class="font-bold">ID</h3></th>
                    <th><h3 class="font-bold">Nama</h3></th>
                    <th><h3 class="font-bold">Nomor Telp</h3></th>
                    <th><h3 class="font-bold">Alamat</h3></th>
                    <th><h3 class="font-bold">Jumlah Transaksi</h3></th>
                    <th><h3 class="font-bold">Aksi</h3></th>
                </tr>
            </thead>
            <tbody>
                @if (count($data) <= 0)
                    <tr>
                        <th class="text-error text-lg" colspan="6">Tidak ada data...</th>
                    </tr>
                @else
                    @foreach ($data as $item)
                    <tr>
                        <th>{{ $item->id }}</th>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->telp }}</td>
                        <td>{{ $item->alamat }}</td>
                        <td>{{ count($item->invoice) }}</td>
                        <td>
                            <a href="{{ url('/customer/detail/'.$item->id) }}">
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
