<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthenticationController extends Controller
{
    public function authenticate(Request $request){
        $data = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($data,$request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Błędny email lub hasło',
        ])->onlyInput('email');
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
 
        return redirect('/');
    }

    public function getLogin() {
        return view('panel_pages.login_page');
    }
}
