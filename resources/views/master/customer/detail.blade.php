@extends('template/header')

@section('content')
<div class="prose">
    <h1 class="text-white">Detail Customer</h1>
</div>
<div class="rounded bg-accent p-4 my-5">
    <div class="flex flex-wrap my-5">
        <div class="form-control w-full">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-id-badge me-2"></i>Nama</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" placeholder="Joko.." class="input input-bordered w-full" />
        </div>
        <div class="form-control w-full md:w-1/2 md:pe-2">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-location-dot me-2"></i>Alamat</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" placeholder="Jalan..." class="input input-bordered w-full" />
        </div>
        <div class="form-control w-full md:w-1/2">
            <label class="label">
                <span class="label-text text-lg font-bold"><i class="fa-solid fa-phone me-2"></i>Nomor Telp</span>
                <span class="label-text-alt"></span>
            </label>
            <input type="text" placeholder="081..." class="input input-bordered w-full" />
        </div>
    </div>
    <button class="btn btn-primary">Simpan</button>
</div>
<div class="prose mt-10">
    <h1 class="text-white">Detail Transaksi</h1>
</div>
<div class="flex w-full mt-5">
    <div class="stat bg-accent w-auto me-4">
        <div class="stat-title text-white">Total Transaksi</div>
        <div class="stat-value text-primary">5</div>
        <div class="stat-desc">21% more than last month</div>
    </div>
    <div class="stat bg-accent w-auto me-4">
        <div class="stat-title text-white">Grand Total Transaksi</div>
        <div class="stat-value">Rp <span class="text-primary">2.500.400</span></div>
        <div class="stat-desc">21% more than last month</div>
    </div>
</div>
<div class="rounded bg-accent p-4 my-5">
    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th class="prose"><h3 class="font-bold">Kode</h3></th>
                    <th class="prose"><h3 class="font-bold">Grand Total (Rp)</h3></th>
                    <th class="prose"><h3 class="font-bold">Tanggal</h3></th>
                    <th class="prose"><h3 class="font-bold">Status</h3></th>
                    <th class="prose"><h3 class="font-bold">Aksi</h3></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>INV001</th>
                    <td>Rp 1,000,000</td>
                    <td>02 April 2023</td>
                    <td><span class="badge badge-primary">Finished</span></td>
                    <td>
                        <i class="fa-solid fa-circle-info text-base hover:text-secondary"></i>
                    </td>
                </tr>
                <tr>
                    <th>INV002</th>
                    <td>Rp 2,500,000</td>
                    <td>02 Juni 2023</td>
                    <td><span class="badge badge-primary">Finished</span></td>
                    <td>
                        <i class="fa-solid fa-circle-info text-base hover:text-secondary"></i>
                    </td>
                </tr>
                <tr>
                    <th>INV003</th>
                    <td>Rp 3,500,000</td>
                    <td>02 Juni 2023</td>
                    <td><span class="badge badge-primary">Finished</span></td>
                    <td>
                        <i class="fa-solid fa-circle-info text-base hover:text-secondary"></i>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
