@extends('template/header')

@section('content')
<div class="flex justify-between items-center">
    <h1 class="text-2xl font-bold">Data Invoice</h1>
    <a class="btn btn-primary" href="{{url('invoice/customer')}}">Tambah</a>
</div>
<div role="tablist" class="tabs tabs-boxed w-fit mt-5 bg-accent font-semibold">
    <a role="tab" href="/invoice?type=unconfirmed" class="tab {{ $type == 'unconfirmed' ? 'tab-active' : '' }}"">Perlu Konfirmasi</a>
    <a role="tab" href="/invoice" class="tab {{ $type == 'all' ? 'tab-active' : '' }}"">Invoice Terkonfirmasi</a>
    <a role="tab" href="/invoice?type=canceled" class="tab {{ $type == 'canceled' ? 'tab-active' : '' }}"">Invoice Dibatalkan</a>
    <a role="tab" href="/invoice?type=deleted" class="tab {{ $type == 'deleted' ? 'tab-active' : '' }}">Invoice Terhapus</a>
</div>
<div class="rounded bg-accent p-4 w-full mt-2">
    <div class="overflow-x-auto">
        <table class="data-table table-zebra">
            <thead>
                <tr>
                    <th><h3 class="font-bold">Kode</h3></th>
                    <th><h3 class="font-bold">Customer</h3></th>
                    <th><h3 class="font-bold">Grand Total (Rp)</h3></th>
                    <th><h3 class="font-bold">Tanggal Pesanan</h3></th>
                    <th><h3 class="font-bold">Status Pembayaran</h3></th>
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
                        <td>Rp {{ number_format($item->grand_total) }}</td>
                        <td>{{ date_format($item->created_at, 'd M Y') }}</td>
                        <td>
                            @if (!$item->paid_at)
                            <span class="badge badge-error">
                                Belum Lunas
                            </span>
                            @else
                            <span class="badge badge-secondary">
                                Lunas
                            </span>
                            @endif
                        </td>
                        <td>
                            {{ date_format(new DateTime($item->jatuh_tempo), 'd M Y') }}
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
