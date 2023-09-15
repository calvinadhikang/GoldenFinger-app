<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    public function loginAction(Request $request)
    {
        $nama = $request->input('nama');
        $password = $request->input('password');

        $user = Karyawan::where('nama','=',$nama)->where('password','=',$password)->get();
        if (count($user) > 0) {
            if ($user[0]->status == 1) {
                Session::put('user', $user[0]);
                toast("Berhasil Login", "success");
                return redirect('/dashboard');
            }else{
                toast("User tidak aktif", "error");
                return redirect()->back();
            }
        } else {
            toast("Gagal Login", "error");
            return redirect()->back();
        }
    }

    public function loginView(){
        return view('login');
    }
}
