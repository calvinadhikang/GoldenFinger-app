@extends('template/header')

@section('content')
<div class="prose">
    <h1 class="text-white">Detail Karyawan</h1>
</div>
<div class="rounded bg-accent p-4 my-5">
    <form action="" method="POST">
        @csrf
        <div class="flex flex-wrap my-5">
            <input type="hidden" name="id" value="{{$karyawan->id}}">
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
                    <option value="0" {{ $karyawan->role == 0 ? "selected" : "" }}>Admin</option>
                    <option value="1" {{ $karyawan->role == 1 ? "selected" : "" }}>Stakeholder</option>
                </select>
            </div>
            <div class="form-control w-full mt-3">
                <span class="label-text text-lg font-bold mb-2"><i class="fa-solid fa-power-off me-2"></i>Status</span>
                <input type="checkbox" name="status" class="toggle toggle-primary" {{ $karyawan->status == 1 ? "checked" : "" }}/>
            </div>
        </div>
        <button class="btn btn-primary">Simpan</button>
    </form>
</div>

@endsection
