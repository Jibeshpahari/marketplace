<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function adminLoginView(){
        return view('admin.login');
    }

    public function adminLoginPost(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials, $request->remember)) {

            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Invalid credentials');
    }

}
