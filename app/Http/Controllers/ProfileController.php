<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function profileView(){
        $user = Session::get('user');
        return view('profile.view', [
            'user' => $user
        ]);
    }

    public function profileAction(Request $request){
        $user = Session::get('user');
        $nama = $request->input('nama');
        $username = $request->input('username');
        $telp = $request->input('telp');

        $target = Karyawan::find($user->id);
        $target->nama = $nama;
        $target->username = $username;
        $target->telp = $telp;
        $target->save();

        Session::put('user', $target);

        toast('Berhasil update profile', 'success');
        return back();
    }

    public function profileUpdatePassword(Request $request){
        $user = Session::get('user');
        $newPassword = $request->input('new-password');
        $oldPassword = $request->input('old-password');

        if (Hash::check($oldPassword, $user->password)) {
            $target = Karyawan::find($user->id);
            $target->password = Hash::make($newPassword);
            $target->save();

            toast('Berhasil Update Password', 'success');
        }
        else{
            toast('Password Lama Salah', 'error');
        }

        return back();
    }
}
