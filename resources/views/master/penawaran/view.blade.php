@extends('template/header')

@section('content')
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Data Penawaran</h1>
    </div>
    <div role="tablist" class="tabs tabs-boxed w-fit mt-5 bg-accent font-semibold">
        <a role="tab" href="/penawaran?type=unconfirmed" class="tab {{ $type == 'unconfirmed' ? 'tab-active' : '' }}"">
            <div class="indicator">
                Perlu Konfirmasi
                @if ($countNotConfirm > 0)
                    <span class="indicator-item badge badge-secondary">{{ $countNotConfirm }}</span>
                @endif
            </div>
        </a>
        <a role="tab" href="/penawaran" class="tab {{ $type == 'confirmed' ? 'tab-active' : '' }}"">Penawaran Terkonfirmasi</a>
        <a role="tab" href="/penawaran?type=canceled" class="tab {{ $type == 'canceled' ? 'tab-active' : '' }}"">Penawaran
            Dibatalkan</a>
    </div>
    <div class="rounded-2xl bg-accent p-4 w-full mt-2">
        <div class="overflow-x-auto">
            <table class="data-table table-zebra">
                <thead>
                    <tr>
                        <th>
                            <h3 class="font-bold">Kode</h3>
                        </th>
                        <th>
                            <h3 class="font-bold">Customer</h3>
                        </th>
                        <th>
                            <h3 class="font-bold">Grand Total (Rp)</h3>
                        </th>
                        <th>
                            <h3 class="font-bold">Tanggal Pesanan</h3>
                        </th>
                        <th>
                            <h3 class="font-bold">Status</h3>
                        </th>
                        <th>
                            <h3 class="font-bold">Aksi</h3>
                        </th>
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
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->customer->nama }}</td>
                                <td>Rp {{ number_format($item->grand_total) }}</td>
                                <td>{{ date_format($item->created_at, 'd M Y') }}</td>
                                <td>{{ $item->status }}</td>
                                <td>
                                    <a href="{{ url('/penawaran/detail/' . $item->id) }}">
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
