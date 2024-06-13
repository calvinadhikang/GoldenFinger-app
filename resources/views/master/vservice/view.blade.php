@extends('template/header')

@section('content')
<div class="flex justify-between items-center">
    <h1 class="text-2xl font-bold">Data Service Vulkanisir</h1>
    <a class="btn btn-primary" href="{{url('vservice/customer')}}">Tambah</a>
</div>
<div role="tablist" class="tabs tabs-boxed w-fit mt-5 bg-accent font-semibold mb-5">
    <a role="tab" href="/vservice" class="tab {{ $type == 'all' ? 'tab-active' : '' }}"">Service Aktif</a>
    <a role="tab" href="/vservice?type=deleted" class="tab {{ $type == 'deleted' ? 'tab-active' : '' }}">Service Selesai</a>
</div>
<div class="rounded-2xl bg-accent p-4 w-full">
    <div class="overflow-x-auto">
        <table class="data-table table-zebra">
            <thead>
                <tr>
                    <th><h3 class="font-bold">ID</h3></th>
                    <th><h3 class="font-bold">Nama Customer</h3></th>
                    <th><h3 class="font-bold">Nama Barang</h3></th>
                    <th><h3 class="font-bold">Harga</h3></th>
                    <th><h3 class="font-bold">Status</h3></th>
                    <th><h3 class="font-bold">Akan Selesai Pada Tanggal</h3></th>
                    <th><h3 class="font-bold">Teknisi</h3></th>
                    <th><h3 class="font-bold">Aksi</h3></th>
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
                        <td>{{ $item->customer->nama }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>Rp {{ number_format($item->harga) }}</td>
                        <td>
                            @if ($item->status == 'On Progress')
                            <span class="badge badge-neutral">{{ $item->status }}</span>
                            @elseif ($item->status == 'Pickup')
                                <span class="badge badge-secondary">{{ $item->status }}</span>
                            @elseif ($item->status == 'Canceled')
                                <span class="badge badge-error">{{ $item->status }}</span>
                            @elseif ($item->status == 'Finished')
                                <span class="badge badge-success">{{ $item->status }}</span>
                            @endif
                        </td>
                        <td>{{ $item->finish_text }}</td>
                        <td>{{ $item->teknisi->nama }}</td>
                        <td>
                            <a href="{{ url("vservice/detail/$item->id") }}">
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
