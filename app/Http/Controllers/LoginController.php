<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function loginAction(Request $request)
    {
        return redirect('welcome');
    }
}
