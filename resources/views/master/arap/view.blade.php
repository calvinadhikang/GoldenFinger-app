@extends('template/header')

@section('content')
<h1 class="text-2xl font-bold mb-5">AR AP Handle</h1>
<div class="stats w-full shadow">
    <div class="stat bg-accent">
        <div class="text-xl">Total Hutang</div>
        <div class="stat-value">Rp. {{ number_format($total_hutang) }}</div>
        <div class="grid grid-cols-3">
            <div class="mt-3">Lewat Jatuh Tempo : {{ count($hutang_jatuh_tempo) }}</div>
            <div class="mt-3">Jatuh Tempo dalam 7 hari: {{ count($hutang_jatuh_tempo_seminggu) }}</div>
            <div class="mt-3">Jumlah Total : {{ count($data_hutang) }}</div>
        </div>
    </div>
    <div class="stat bg-accent">
        <div class="text-xl">Total Piutang</div>
        <div class="stat-value">Rp. {{ number_format($total_piutang) }}</div>
        <div class="grid grid-cols-3">
            <div class="mt-3">Lewat Jatuh Tempo : {{ count($piutang_jatuh_tempo) }}</div>
            <div class="mt-3">Jatuh Tempo dalam 7 hari: {{ count($piutang_jatuh_tempo_seminggu) }}</div>
            <div class="mt-3">Jumlah Total : {{ count($data_piutang) }}</div>
        </div>
    </div>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 mt-10 gap-10">
    <div class="bg-accent p-4 rounded">
        <div class="flex mb-5 gap-x-5">
            <a href="{{ url('/arap?hutang_mode=0') }}"><button class="btn btn-xs {{ $hutang_mode == 0 ? "btn-primary" : "btn-outline" }}">Semua</button></a>
            <a href="{{ url('/arap?hutang_mode=1') }}"><button class="btn btn-xs {{ $hutang_mode == 1 ? "btn-primary" : "btn-outline" }}">Lewat Jatuh Tempo</button></a>
            <a href="{{ url('/arap?hutang_mode=2') }}"><button class="btn btn-xs {{ $hutang_mode == 2 ? "btn-primary" : "btn-outline" }}">Jatuh Tempo Dalam 7 Hari</button></a>
        </div>
        <div class="grid grid-cols-2 font-medium text-lg mb-5">
            <div class="">Hutang</div>
            <div class="text-right">Rp {{ number_format($show_hutang_total) }}</div>
        </div>
        <div class="divider"></div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Vendor</th>
                    <th>Grand Total</th>
                    <th>Jatuh Tempo</th>
                    <th>Sisa Hari</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($show_hutang as $item)
                <tr>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->vendor->nama }}</td>
                    <td>Rp {{ number_format($item->grand_total) }}</td>
                    <td>{{ date_format(new DateTime($item->jatuh_tempo), 'd M Y') }}</td>
                    <td>{{ $item->sisa_hari }} Hari</td>
                    <td><a href="{{ url("/po/detail/$item->id") }}"><button class="btn-xs btn-secondary btn">Detail</button></a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="bg-accent p-4 rounded">
        <div class="flex mb-5 gap-x-5">
            <a href="{{ url('/arap?piutang_mode=0') }}"><button class="btn btn-xs {{ $piutang_mode == 0 ? "btn-primary" : "btn-outline" }}">Semua</button></a>
            <a href="{{ url('/arap?piutang_mode=1') }}"><button class="btn btn-xs {{ $piutang_mode == 1 ? "btn-primary" : "btn-outline" }}">Lewat Jatuh Tempo</button></a>
            <a href="{{ url('/arap?piutang_mode=2') }}"><button class="btn btn-xs {{ $piutang_mode == 2 ? "btn-primary" : "btn-outline" }}">Jatuh Tempo Dalam 7 Hari</button></a>
        </div>
        <div class="grid grid-cols-2 font-medium text-lg mb-5">
            <div class="">Piutang</div>
            <div class="text-right">Rp {{ number_format($show_piutang_total) }}</div>
        </div>
        <div class="divider"></div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Customer</th>
                    <th>Grand Total</th>
                    <th>Jatuh Tempo</th>
                    <th>Sisa Hari</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($show_piutang as $item)
                <tr>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->customer->nama }}</td>
                    <td>Rp {{ number_format($item->grand_total) }}</td>
                    <td>{{ date_format(new DateTime($item->jatuh_tempo), 'd M Y') }}</td>
                    <td>{{ $item->sisa_hari }} Hari</td>
                    <td><a href="{{ url("/invoice/detail/$item->id") }}"><button class="btn-xs btn-secondary btn">Detail</button></a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
