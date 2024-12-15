<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

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

    public function getSignUp() {
        return view('authorization_pages.sign_up_page');
    }

    public function createUser(Request $request) {
        $data = $request->validate([
            'name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'email' => 'required|email',
            'password' => 'required|min:6|alpha_dash',
        ]);
        $data['name'] .= ' '.$data['last_name'];
        unset($data['last_name']);
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        event(new Registered($user));
        return redirect('/email/verify');
    }
}
