@extends('template/header')

@section('content')
<div class="prose">
    <h1 class="text-white">Tambah Karyawan</h1>
</div>
<div class="rounded bg-accent p-4 my-5">
    <form method="POST" action="">
        @csrf
        <div class="flex flex-wrap my-5">
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text text-lg font-bold"><i class="fa-solid fa-id-badge me-2"></i>Nama</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="Joko.." class="input input-bordered w-full" name="nama" required/>
            </div>
            <div class="form-control w-full md:w-1/2 md:pe-2">
                <label class="label">
                    <span class="label-text text-lg font-bold"><i class="fa-solid fa-key me-2"></i>Password</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="password" placeholder="password" class="input input-bordered w-full" name="password" required/>
            </div>
            <div class="form-control w-full md:w-1/2">
                <label class="label">
                    <span class="label-text text-lg font-bold"><i class="fa-solid fa-phone me-2"></i>Username</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="username" class="input input-bordered w-full" name="username" required/>
            </div>
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text text-lg font-bold"><i class="fa-solid fa-phone me-2"></i>Nomor Telp</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="081..." class="input input-bordered w-full" name="telp" required/>
            </div>
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text text-lg font-bold"><i class="fa-solid fa-dice-d6 me-2"></i>Role</span>
                    <span class="label-text-alt"></span>
                </label>
                <select class="select input input-bordered w-full" name="role" required>
                    <option value="" selected disabled>Pilih Role</option>
                    <option value="0">Admin</option>
                    <option value="1">Stakeholder</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Tambah</button>
    </form>
</div>

@endsection
