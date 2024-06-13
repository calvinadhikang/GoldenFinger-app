@extends('template/header')

@section('content')
<h1 class="text-2xl font-bold">Tambah Service Vulkanisir</h1>
<div class="text-sm breadcrumbs mb-5  ">
    <ul>
        <li><a href="/vservice">Data Service Vulkanisir</a></li>
        <li>Tambah Service Vulkanisir</li>
    </ul>
</div>
<div class="mt-5 flex justify-center my-10">
    <ul class="steps w-full">
        <li class="step step-primary font-medium">Pilih Customer</li>
        <li class="step">Isi Keterangan</li>
        <li class="step">Konfirmasi</li>
    </ul>
</div>

@if ($customer == null)
@if (count($customers) > 0)
    <h1 class="text-xl font-medium">Pilih Customer</h1>

    <div class="rounded-2xl bg-accent p-4 my-5">
        <table class="data-table table-fixed">
            <thead>
                <tr>
                    <th><h3 class="font-bold">Nama Customer</h3></th>
                    <th><h3 class="font-bold">Email</h3></th>
                    <th><h3 class="font-bold">Alamat</h3></th>
                    <th><h3 class="font-bold">Telp</h3></th>
                    <th><h3 class="font-bold">Aksi</h3></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $item)
                    <tr>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->email }}</td>
                        <td class="truncate">{{ $item->alamat }}</td>
                        <td>{{ $item->telp }}</td>
                        <td>
                            <form method="POST" action="{{ url('/vservice/customer') }}">
                                @csrf
                                <button class="btn btn-sm btn-primary" name="id" value="{{ $item->id }}">Pilih</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="divider">Atau</div>
    @endif

    <h1 class="text-xl font-medium">Buat Customer Baru</h1>
    <div class="rounded-2xl bg-accent p-4 my-5">
        <form method="POST" action="{{ url('vservice/customer/new') }}">
            @csrf
            <div class="flex flex-wrap">
                <div class="form-control w-full md:w-1/2 md:pe-2">
                    <label class="label">
                        <span class="label-text font-bold"><i class="fa-solid fa-id-badge me-2"></i>Nama</span>
                        <span class="label-text-alt">@error('nama') {{ $message }}  @enderror</span>
                    </label>
                    <input type="text" required placeholder="Nama..." class="input   w-full" name="nama" value="{{ old('nama') }}" />
                </div>
                <div class="form-control w-full md:w-1/2">
                    <label class="label">
                        <span class="label-text font-bold"><i class="fa-solid fa-envelope me-2"></i>Email</span>
                        <span class="label-text-alt">@error('email') {{ $message }}  @enderror</span>
                    </label>
                    <input type="email" required placeholder="...@..." class="input   w-full" name="email" value="{{ old('email') }}" />
                </div>
                <div class="form-control w-full md:w-1/2 md:pe-2">
                    <label class="label">
                        <span class="label-text font-bold"><i class="fa-solid fa-location-dot me-2"></i>Alamat</span>
                        <span class="label-text-alt">@error('alamat') {{ $message }}  @enderror</span>
                    </label>
                    <input type="text" required placeholder="Jalan..." class="input   w-full" name="alamat" value="{{ old('alamat') }}" />
                </div>
                <div class="form-control w-full md:w-1/2">
                    <label class="label">
                        <span class="label-text font-bold"><i class="fa-solid fa-phone me-2"></i>Nomor Telp</span>
                        <span class="label-text-alt">@error('telp') {{ $message }}  @enderror</span>
                    </label>
                    <input type="text" required placeholder="081..." class="input   w-full" name="telp" value="{{ old('telp') }}" />
                </div>
                <div class="form-control w-full md:w-1/2 md:pe-2">
                    <label class="label">
                        <span class="label-text font-bold"><i class="fa-solid fa-city me-2"></i>Kota</span>
                        <span class="label-text-alt">@error('kota') {{ $message }}  @enderror</span>
                    </label>
                    <input type="text" required placeholder="Kota..." class="input   w-full" name="kota" value="{{ old('kota') }}" />
                </div>
                <div class="form-control w-full md:w-1/2">
                    <label class="label">
                        <span class="label-text font-bold"><i class="fa-solid fa-barcode me-2"></i>NPWP</span>
                        <span class="label-text-alt">Beri tanda '-' bila tidak punya NPWP</span>
                    </label>
                    <input type="text" value="-" required placeholder="001.002.003" class="input   w-full" name="NPWP" />
                </div>
            </div>
            <button class="btn btn-primary mt-5">Tambah Customer Baru</button>
        </form>
    </div>
@else
    <div class="text-xl font-semibold">Konfirmasi Customer</div>
    <div class="rounded-2xl bg-accent p-4 my-5">
        <div class="flex flex-wrap mb-5">
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-id-badge me-2"></i>Nama</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" class="input   w-full " value="{{ $customer->nama }}" disabled/>
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-envelope me-2"></i>Email</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="email" class="input   w-full" value="{{ $customer->email }}" disabled/>
            </div>
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-location-dot me-2"></i>Alamat</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" class="input   w-full" value="{{ $customer->alamat }}" disabled/>
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-phone me-2"></i>Nomor Telp</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" class="input   w-full" value="{{ $customer->telp }}" disabled/>
            </div>
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-city me-2"></i>Kota</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" class="input   w-full" value="{{ $customer->kota }}" disabled/>
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text font-bold"><i class="fa-solid fa-barcode me-2"></i>NPWP</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" class="input   w-full" value="{{ $customer->NPWP }}" disabled/>
            </div>
        </div>
        <a href="{{ url('/vservice/keterangan') }}">
            <button class="btn btn-primary">Customer, Sudah Benar!</button>
        </a>
        <a href="{{ url('/vservice/customer/unset') }}">
            <button class="btn btn-ghost border-error text-error">Ganti Customer</button>
        </a>
    </div>
@endif

@endsection
