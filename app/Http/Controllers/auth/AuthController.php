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
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:8',
        ], [
            'email.required'    => 'Email is required.',
            'email.email'       => 'Please enter a valid email address.',
            'password.required' => 'Password is required.',
            'password.min'      => 'Password must be at least 8 characters.',
        ]);

        if (Auth::attempt([
            'email'    => $request->email,
            'password' => $request->password,
            'role'     => 'admin',
            'status'   => 'active',
        ], $request->boolean('remember_me'))) {
            $request->session()->regenerate();
            return redirect()->route('admin.setting.site-settings');
        }
        return back()->withErrors(['error' => 'The provided credentials are incorrect.'])->withInput();
    }

}
