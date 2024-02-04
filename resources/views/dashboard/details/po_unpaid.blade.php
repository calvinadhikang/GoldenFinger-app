@extends('template.header')

@section('content')
<div class="text-xs breadcrumbs">
    <ul>
        <li><a href="/dashboard">Dashboard</a></li>
        <li>PO Belum Lunas</li>
    </ul>
</div>
<h1 class="text-2xl font-bold mb-5">PO Belum Lunas</h1>
<div class="p-4 rounded shadow bg-accent">
    <table id="table" class="table-zebra">
        <thead>
            <tr>
                <th>Kode PO</th>
                <th>Vendor</th>
                <th>Jumlah</th>
                <th>Jatuh Tempo</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
            <tr>
                <td>{{ $item->kode }}</td>
                <td>{{ $item->vendor->nama }}</td>
                <td>{{ format_decimal($item->grand_total) }}</td>
                <td>{{ date_format(new DateTime($item->jatuh_tempo), 'd M Y') }}</td>
                <td><a href="{{ url("/po/detail/$item->id") }}"><i class="fa-solid fa-circle-info text-base hover:text-secondary"></i></a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="font-medium text-right mt-5">
        <p>Jumlah PO Belum Lunas : {{ count($data) }}</p>
        <p>Jumlah Hutang : Rp {{ format_decimal($total) }}</p>
    </div>
</div>
@endsection
