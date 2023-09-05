@extends('template/header')

@section('content')
<div class="text-3xl font-bold">
    <i class="fa-solid fa-circle-info me-2"></i> Detail Vendor
</div>
<div class="rounded bg-accent p-4 my-5">
    <form method="POST">
        @csrf
        <input type="hidden" value="{{ $vendor->id }}" name="id">
        <div class="flex flex-wrap mb-5">
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text text-lg font-bold">Nama</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" value="{{ $vendor->nama }}" class="input input-bordered w-full" name="nama" required/>
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text text-lg font-bold">Email</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" value="{{ $vendor->email }}" class="input input-bordered w-full" name="email" required/>
            </div>
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text text-lg font-bold">Telp</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" value="{{ $vendor->telp }}" class="input input-bordered w-full" name="telp" required/>
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text text-lg font-bold">Alamat</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" value="{{ $vendor->alamat }}" class="input input-bordered w-full" name="alamat" required/>
            </div>
        </div>
        <button class="btn btn-primary">Simpan</button>
    </form>
</div>

<div class="text-xl font-semibold">
    <i class="fa-solid fa-address-book me-2"></i> Contact Person
</div>
<div class="rounded bg-accent p-4 my-5">
    <div class="flex justify-end w-full mb-5">
        <a class="btn btn-primary" href="{{url("vendors/add/contact/$vendor->id")}}">Tambah</a>
    </div>
    <div class="flex flex-wrap">
        @if (count($vendor->contact_person) <= 0)
            <div class="text-rose-400 font-bold">Belum ada contact, klik tombol di kanan untuk menambah...</div>
        @else
            @foreach ($vendor->contact_person as $item)
                <?php $i = 1; ?>
                <div class="flex items-center p-2 bg-base-100 rounded-lg shadow-md m-1">
                    <div class="text-2xl p-2 me-2">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div class="me-2">
                        <span class="text-xl font-semibold me-10"> {{ $item->nama }}</span><br>
                        <span class="text-sm"><i class="fa-solid fa-phone me-2"></i>{{ $item->telp }}</span>
                    </div>
                    <div class="hover:shadow-xl bg-red-500 hover:bg-red-600 p-3 rounded-full">
                        <form action="{{ url("/vendors/remove/contact/$item->id") }}" method="POST">
                            <button type="submit"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                    </div>
                </div>
                <?php $i += 1; ?>
            @endforeach
        @endif
    </div>
</div>

<div class="text-xl font-semibold">
    <i class="fa-solid fa-box me-2"></i> Barang Di Supply Vendor
</div>
<div class="rounded bg-accent p-4 my-5">
    <div class="flex justify-end w-full mb-5">
        <a class="btn btn-primary" href="{{url("vendors/add/barang/$vendor->id")}}">Tambah</a>
    </div>
        <table id="table">
            <thead>
                <tr>
                    <th class="prose"><h3 class="font-bold">Part Number</h3></th>
                    <th class="prose"><h3 class="font-bold">Nama</h3></th>
                    <th class="prose"><h3 class="font-bold">Harga Beli</h3></th>
                    <th class="prose"><h3 class="font-bold">Stok</h3></th>
                    <th class="prose"><h3 class="font-bold">Aksi</h3></th>
                </tr>
            </thead>
            <tbody>
            @if (count($data) <= 0)
                <tr>
                    <th class="text-error text-lg" colspan="5">Tidak ada data...</th>
                </tr>
            @else
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->part }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>Rp {{ number_format($item->hargaBeli) }}</td>
                        <td>{{ $item->stok }}</td>
                        <td>
                            <a href="{{ url("barang/detail/$item->id") }}">
                                <i class="fa-solid fa-circle-info text-base hover:text-secondary"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
</div>
@endsection
