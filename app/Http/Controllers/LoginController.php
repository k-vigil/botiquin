<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('GET'))
            return view('login');

        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

        if (is_null($user))
            return redirect('/')
                ->with('msgType', 'error')
                ->with('msg', 'Usuario no existe');

        if ($user->activo == 0)
            return redirect('/')
                ->with('msgType', 'error')
                ->with('msg', 'Usuario inactivo');

        if (!Auth::attempt($credentials))
            return redirect('/')
                ->with('msgType', 'error')
                ->with('msg', 'Credenciales invalidas');

        $request->session()->regenerate();
        return redirect("/dashboard");
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
