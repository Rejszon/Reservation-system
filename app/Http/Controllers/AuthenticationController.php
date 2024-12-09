<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthenticationController extends Controller
{
    public function authenticate(Request $request){
        Log::info("hi");
        $data = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);
        Log::info("hi1");

        if (Auth::attempt($data,$request->remember)) {
            Log::info("hi");
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
