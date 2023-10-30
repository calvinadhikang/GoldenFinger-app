@extends('template/header')

@section('content')
<h1 class="text-2xl font-bold mb-5">Data Invoice</h1>
<div class="rounded bg-accent p-4 w-full">
    <div class="flex justify-end w-full mb-5">
        <a class="btn btn-primary" href="{{url('invoice/customer')}}">Tambah</a>
    </div>
    <div class="overflow-x-auto">
        <table id="table" class="table-zebra">
            <thead>
                <tr>
                    <th><h3 class="font-bold">Kode</h3></th>
                    <th><h3 class="font-bold">Customer</h3></th>
                    <th><h3 class="font-bold">Grand Total (Rp)</h3></th>
                    <th><h3 class="font-bold">Tanggal Pesanan</h3></th>
                    <th><h3 class="font-bold">Status</h3></th>
                    <th><h3 class="font-bold">Jatuh Tempo</h3></th>
                    <th><h3 class="font-bold">Aksi</h3></th>
                </tr>
            </thead>
            <tbody>
                @if (count($data) <= 0)
                    <tr>
                        <th class="text-error text-lg" colspan="7">Tidak ada Data...</th>
                    </tr>
                @else
                    @foreach ($data as $item)
                    <tr>
                        <th>{{ $item->kode }}</th>
                        <td>{{ $item->customer->nama }}</td>
                        <td>Rp {{ number_format($item->total) }}</td>
                        <td>{{ date_format($item->created_at, 'd M Y') }}</td>
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
