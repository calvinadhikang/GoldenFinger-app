@extends('template/header')

@section('content')
<h1 class="text-2xl font-bold">Detail Karyawan</h1>
<div class="text-sm breadcrumbs mb-5 text-slate-300">
    <ul>
        <li><a href="/karyawan">Data Karyawan</a></li>
        <li>Detail Karyawan</li>
    </ul>
</div>
<div class="rounded bg-accent p-4 mb-5">
    <form action="" method="POST">
        @csrf
        <div class="flex flex-wrap mb-5">
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text text-lg font-bold"><i class="fa-solid fa-id-badge me-2"></i>Nama</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="Joko.." class="input input-bordered w-full" value="{{$karyawan->nama}}" name="nama" />
            </div>
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text text-lg font-bold"><i class="fa-solid fa-key me-2"></i>Username</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="Ban..." class="input input-bordered w-full" value="{{$karyawan->username}}" name="username"/>
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text text-lg font-bold"><i class="fa-solid fa-phone me-2"></i>Nomor Telp</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="081..." class="input input-bordered w-full" value="{{$karyawan->telp}}" name="telp"/>
            </div>
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text text-lg font-bold"><i class="fa-solid fa-dice-d6 me-2"></i>Role</span>
                    <span class="label-text-alt"></span>
                </label>
                <select name="role" id="" class="input input-bordered w-full">
                    <option value="" selected disabled>Pilih Role</option>
                    <option value="Admin" {{ $karyawan->role == "Admin" ? "selected" : "" }}>Admin</option>
                    <option value="Stakeholder" {{ $karyawan->role == "Stakeholder" ? "selected" : "" }}>Stakeholder</option>
                    <option value="Teknisi" {{ $karyawan->role == "Teknisi" ? "selected" : "" }}>Teknisi</option>
                </select>
            </div>
            <div class="form-control w-full mt-3">
                <span class="label-text text-lg font-bold mb-2"><i class="fa-solid fa-power-off me-2"></i>Status</span>
                <input type="checkbox" name="status" class="toggle toggle-primary" {{ $karyawan->status == "Aktif" ? "checked" : "" }}/>
            </div>
        </div>
        <button class="btn btn-primary">Simpan</button>
    </form>
</div>

@endsection
