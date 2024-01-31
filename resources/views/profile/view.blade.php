@extends('template.header')

@section('content')
<h1 class="text-2xl font-bold">Profile</h1>
<div class="rounded p-4 shadow bg-accent my-5">
    <form method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-5">
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text text-lg font-bold">Nama</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="B001..." class="input input-bordered w-full" name="nama" value="{{ $user->nama }}"/>
            </div>
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text text-lg font-bold">Role</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="B001..." class="input input-bordered w-full" name="role" value="{{ $user->role }}" disabled/>
            </div>
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text text-lg font-bold">Username</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="B001..." class="input input-bordered w-full" name="username" value="{{ $user->username }}" required/>
            </div>
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text text-lg font-bold">Nomor Telp</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" placeholder="B001..." class="input input-bordered w-full" name="telp" value="{{ $user->telp }}" required/>
            </div>

        </div>
        <button class="btn btn-primary">Simpan</button>
    </form>
</div>

<h1 class="text-lg font-medium">Ganti Password</h1>
<div class="p-4 rounded bg-accent shadow mt-5">
    <form method="POST" action="{{ url('profile/password-update') }}">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-5">
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text text-lg font-bold">Password Baru</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" class="input input-bordered w-full" name="new-password" required/>
            </div>
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text text-lg font-bold">Konfirmasi Password Lama</span>
                    <span class="label-text-alt"></span>
                </label>
                <input type="text" class="input input-bordered w-full" name="old-password" required/>
            </div>
        </div>
        <button class="btn btn-primary">Simpan</button>
    </form>
</div>

@endsection
