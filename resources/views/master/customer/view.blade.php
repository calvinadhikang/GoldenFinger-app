@extends('template/header')

@section('content')
<div class="flex items-center mb-10">
    <div class="grow m-auto">
        <div class="prose">
            <h1>Data Customer</h1>
        </div>
    </div>
</div>
<div class="rounded bg-accent p-4 w-full">
    <div class="flex justify-end w-full mb-5">
        <a class="btn btn-primary" href="{{url('customer/add')}}">Tambah</a>
    </div>
    <div class="overflow-x-auto">
        <table id="table">
            <thead>
                <tr>
                    <th class="prose"><h3 class="font-bold">ID</h3></th>
                    <th class="prose"><h3 class="font-bold">Nama</h3></th>
                    <th class="prose"><h3 class="font-bold">Nomor Telp</h3></th>
                    <th class="prose"><h3 class="font-bold">Alamat</h3></th>
                    <th class="prose"><h3 class="font-bold">Jumlah Transaksi</h3></th>
                    <th class="prose"><h3 class="font-bold">Aksi</h3></th>
                </tr>
            </thead>
            <tbody>
                @if ($data == null)
                    <tr>
                        <td class="text-danger" colspan="6">Tidak ada Data...</td>
                    </tr>
                @else
                    @foreach ($data as $item)
                    <tr>
                        <th>{{ $item->id }}</th>
                        <th>{{ $item->nama }}</th>
                        <td>{{ $item->telp }}</td>
                        <td>{{ $item->alamat }}</td>
                        <td>3</td>
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
