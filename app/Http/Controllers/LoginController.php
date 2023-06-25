<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    public function loginAction(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if ($email == "admin" || $password == "admin") {
            toast("Berhasil Login", "success");
            return redirect('/master');
        } else {
            toast("Gagal Login", "error");
            return redirect()->back();
        }
    }

    public function loginView(){
        return view('login');
    }
}
