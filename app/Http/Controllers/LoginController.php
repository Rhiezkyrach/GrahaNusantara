<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;

class LoginController extends Controller
{
    public function index(){

        $setting = Setting::first();
        
        return view('admin.cmslogin',[
            'judul' => "Log in - " . $setting->judul_situs,
            'setting' => $setting,
        ]);
    }

    public function authenticate(Request $request){

        // $credentials = User::where([
        // 'username' => $request->username,
        // 'password' => md5($request->password)
        // ])->first();

        // if ($credentials) {
        // Auth::login($credentials);
        // // $request->session()->regenerate();

        // return redirect()->intended('admin/dashboard');
        // }

        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',    
        ]);

        $credentials['status'] = 1;

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard');
        }

        return back()->with('loginError', 'Username atau password salah');

    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
