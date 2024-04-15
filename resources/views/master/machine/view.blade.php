@extends('template/header')

@section('content')
<div class="flex justify-between items-center">
    <h1 class="text-2xl font-bold">Data Mesin Vulkanisir</h1>
    <a class="btn btn-primary" href="{{url('machine/add')}}">Tambah</a>
</div>
<div role="tablist" class="tabs tabs-boxed w-fit mt-5 bg-accent font-semibold mb-5">
    <a role="tab" href="/machine" class="tab {{ $type == 'all' ? 'tab-active' : '' }}"">Mesin Aktif</a>
    <a role="tab" href="/machine?type=deleted" class="tab {{ $type == 'deleted' ? 'tab-active' : '' }}">Mesin Non-Aktif</a>
</div>
<div class="rounded bg-accent p-4 w-full">
    <div class="overflow-x-auto">
        <table class="data-table table-zebra">
            <thead>
                <tr>
                    <th><h3 class="font-bold">ID</h3></th>
                    <th><h3 class="font-bold">Nama</h3></th>
                    <th><h3 class="font-bold">Status</h3></th>
                    <th><h3 class="font-bold">Aksi</h3></th>
                </tr>
            </thead>
            <tbody>
            @if (count($data) <= 0)
                <tr>
                    <th class="text-error text-lg" colspan="4">Tidak ada data...</th>
                </tr>
            @else
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->nama }}</td>
                        <td><span class="badge font-semibold {{ $item->service_id ? 'badge-error' : 'badge-secondary' }}">{{ $item->service_id ? 'Sedang Digunakan' : 'Kosong' }}</span></td>
                        <td>
                            <a href="{{ url("machine/detail/$item->id") }}">
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
