@extends('template.header')

@section('content')
<h1 class="text-2xl font-bold">Pendapatan Bulan Ini</h1>
<div class="text-sm breadcrumbs mb-5">
    <ul>
        <li><a href="/dashboard">Dashboard</a></li>
        <li>Pendapatan Bulan Ini</li>
    </ul>
</div>
<p class="mb-5 text-sm text-gray-400">Invoice yang sudah belum terbayar bulan ini, dan sudah jatuh tempo.</p>
<div class="rounded-2xl bg-accent p-4">
    <table class="data-table table-zebra">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            @if (count($data) <= 0)
                <tr>
                    <th colspan="4" class="text-error">Tidak ada data</th>
                </tr>
            @else
                @foreach ($data as $item)
                <tr>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->customer->nama }}</td>
                    <td>Rp {{ format_decimal($item->grand_total) }}</td>
                    <td><a href="{{ url("/invoice/detail/$item->id") }}"><i class="fa-solid fa-circle-info text-base hover:text-secondary"></i></a></td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <p class="text-right font-medium mt-5">Rp {{ format_decimal($total) }}</p>
</div>
@endsection
