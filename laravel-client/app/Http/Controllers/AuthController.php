<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session('jwt_token')) {
            return redirect()->route('employees');
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $response = Http::post('http://localhost:9001/api_fe/auth/login', [
            'username' => $request->username,
            'password' => $request->password,
        ]);

        $data = $response->json();

        if ($response->successful() && isset($data['token'])) {
            session(['jwt_token' => $data['token']]);
            return redirect()->route('employees');
        }

        return back()->withErrors([
            'login' => $data['message'] ?? 'Login failed. Please try again.',
        ])->withInput(['username' => $request->username]);
    }

    public function logout()
    {
        session()->forget('jwt_token');
        return redirect()->route('login');
    }
}
