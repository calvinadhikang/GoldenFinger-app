@extends('template/header')

@section('content')
<div class="flex items-center mb-10">
    <div class="grow m-auto">
        <div class="prose">
            <h1>Data Invoice</h1>
        </div>
    </div>
</div>
<div class="rounded bg-accent p-4 w-full">
    <div class="flex justify-end w-full mb-5">
        <a class="btn btn-primary" href="{{url('invoice/add')}}">Tambah</a>
    </div>
    <div class="overflow-x-auto">
        <table id="table">
            <thead>
                <tr>
                    <th class="prose"><h3 class="font-bold">Kode</h3></th>
                    <th class="prose"><h3 class="font-bold">Customer</h3></th>
                    <th class="prose"><h3 class="font-bold">Grand Total (Rp)</h3></th>
                    <th class="prose"><h3 class="font-bold">Tanggal Pesanan</h3></th>
                    <th class="prose"><h3 class="font-bold">Status</h3></th>
                    <th class="prose"><h3 class="font-bold">Jatuh Tempo</h3></th>
                    <th class="prose"><h3 class="font-bold">Aksi</h3></th>
                </tr>
            </thead>
            <tbody>
                @if (count($data) <= 0)
                    <tr>
                        <th class="text-error text-lg" colspan="6">Tidak ada Data...</th>
                    </tr>
                @else
                    @foreach ($data as $item)
                    <tr>
                        <th>{{ $item->id }}</th>
                        <td>{{ $item->customer->nama }}</td>
                        <td>Rp {{ number_format($item->total) }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>
                            @if ($item->status == 0)
                            <span class="badge badge-error">
                                Belum Lunas
                            </span>
                            @elseif ($item->status == 1)
                            <span class="badge badge-secondary">
                                Lunas
                            </span>
                            @endif
                        </td>
                        <td>
                            {{ $item->jatuh_tempo }}
                        </td>
                        <td>
                            <a href="{{ url('/invoice/detail/'.$item->id) }}">
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
