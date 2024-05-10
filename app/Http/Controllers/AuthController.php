<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function home()
    {
        return view('welcome');
    }
    public function login()
    {
        if (Auth::id()) {
            return redirect()->route('admin.dashboard')->with('success', __("Successfully login"));
        }
        return view('login');
    }

    public function loginProcess(LoginRequest $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->route('admin.dashboard')->with('success', __("Successfully login"));
        }
        return redirect()->back()->with('dismiss', __("Email or Password not matched"));
    }
}
