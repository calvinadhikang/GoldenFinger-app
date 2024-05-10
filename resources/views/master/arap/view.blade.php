@extends('template/header')

@section('content')
<h1 class="text-2xl font-bold mb-5">AR AP Handle</h1>
<div class="stats w-full shadow">
    <div class="stat bg-accent">
        <div class="text-xl">Total Hutang</div>
        <div class="stat-value">Rp. {{ number_format($hutang) }}</div>
        <div class="text-gray-400 mt-3">PO Jatuh Tempo : </div>
    </div>
    <div class="stat bg-accent">
        <div class="text-xl">Total Piutang</div>
        <div class="stat-value">Rp. {{ number_format($piutang) }}</div>
        <div class="grid grid-cols-3">
            <div class="text-gray-400 mt-3">Jatuh Tempo : {{ $invoice_jatuh_tempo }}</div>
            <div class="text-gray-400 mt-3">Jatuh Tempo : {{ $invoice_jatuh_tempo }}</div>
            <div class="text-gray-400 mt-3">Jatuh Tempo : {{ $invoice_jatuh_tempo }}</div>

        </div>
    </div>
</div>
@endsection
