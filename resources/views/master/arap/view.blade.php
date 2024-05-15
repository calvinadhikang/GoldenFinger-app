@extends('template/header')

@section('content')
<h1 class="text-2xl font-bold mb-5">AR AP Handle</h1>
<div class="stats w-full shadow">
    <div class="stat bg-accent">
        <div class="text-xl">Total Hutang</div>
        <div class="stat-value">Rp. {{ number_format($hutang) }}</div>
        <div class="grid grid-cols-3">
            <div class="text-gray-400 mt-3">Lewat Jatuh Tempo : {{ 0 }}</div>
            <div class="text-gray-400 mt-3">Jatuh Tempo dalam 7 hari: {{ 2 }}</div>
            <div class="text-gray-400 mt-3">Jumlah Total : {{ 2 }}</div>
        </div>
    </div>
    <div class="stat bg-accent">
        <div class="text-xl">Total Piutang</div>
        <div class="stat-value">Rp. {{ number_format(900000) }}</div>
        <div class="grid grid-cols-3">
            <div class="text-gray-400 mt-3">Lewat Jatuh Tempo : {{ 0 }}</div>
            <div class="text-gray-400 mt-3">Jatuh Tempo dalam 7 hari: {{ 1 }}</div>
            <div class="text-gray-400 mt-3">Jumlah Total : {{ 1 }}</div>
        </div>
    </div>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 mt-10 gap-10">
    <div class="bg-accent p-4 rounded">
        <div class="flex mb-5 gap-x-5">
            <button class="btn btn-xs btn-primary">Semua</button>
            <button class="btn btn-xs btn-outline">Lewat Jatuh Tempo</button>
            <button class="btn btn-xs btn-outline">Jatuh Tempo Dalam 7 Hari</button>
        </div>
        <div class="grid grid-cols-2 font-medium text-lg mb-5">
            <div class="">Hutang</div>
            <div class="text-right">Rp 23,421,000</div>
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
                <tr>
                    <td>PO/GWI/05/24</td>
                    <td>PT. Ban Indonesia Cemerlang</td>
                    <td>Rp 14.541.000</td>
                    <td>23 May 2024</td>
                    <td>7 Hari</td>
                    <td><button class="btn-xs btn-secondary btn">Detail</button></td>
                </tr>
                <tr>
                    <td>PO/GWI/05/24</td>
                    <td>PT. PT. Nusa Roda Kencana</td>
                    <td>Rp 2.220.000</td>
                    <td>17 May 2024</td>
                    <td>1 Hari</td>
                    <td><button class="btn-xs btn-secondary btn">Detail</button></td>
                </tr>
                <tr>
                    <td>PO/GWI/05/24</td>
                    <td>PT. Ban Indonesia Cemerlang</td>
                    <td>Rp 6.660.000</td>
                    <td>17 May 2024</td>
                    <td>1 Hari</td>
                    <td><button class="btn-xs btn-secondary btn">Detail</button></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="bg-accent p-4 rounded">
        <div class="flex mb-5 gap-x-5">
            <button class="btn btn-xs btn-outline">Semua</button>
            <button class="btn btn-xs btn-outline">Lewat Jatuh Tempo</button>
            <button class="btn btn-xs btn-primary">Jatuh Tempo Dalam 7 Hari</button>
        </div>
        <div class="grid grid-cols-2 font-medium text-lg mb-5">
            <div class="">Piutang</div>
            <div class="text-right">Rp 900,000</div>
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
                <tr>
                    <td>GFLM/INV/2405/001</td>
                    <td>PT. BIMA NUSA</td>
                    <td>Rp 900,000</td>
                    <td>18 May 2024</td>
                    <td>2 Hari</td>
                    <td><button class="btn-xs btn-secondary btn">Detail</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
