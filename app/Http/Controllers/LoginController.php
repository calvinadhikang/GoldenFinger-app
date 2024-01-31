<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function loginAction(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $users = Karyawan::where('username','=',$username)->get();
        if (count($users) > 0) {
            //cari user yang sesuai dengan bcrypt
            foreach ($users as $key => $value) {
                if (Hash::check($password, $value->password)) {
                    if ($value->status == "Aktif") {
                        Session::put('user', $value);
                        return redirect('/dashboard');
                    }else{
                        toast("User tidak aktif", "error");
                        return back();
                    }
                }
            }

            toast('Password Salah !', 'error');
            return back();
        } else {
            toast("Username tidak ditemukan", "error");
            return back();
        }
    }

    public function loginView(){
        return view('login');
    }
}
