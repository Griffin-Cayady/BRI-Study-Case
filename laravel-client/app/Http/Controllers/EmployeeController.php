<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class EmployeeController extends Controller
{
    public function index()
    {
        $token = session('jwt_token');

        $response = Http::withToken($token)
            ->get('http://localhost:9001/api_fe/list_employee');

        if ($response->status() === 401) {
            session()->forget('jwt_token');
            return redirect()->route('login')->withErrors([
                'login' => 'Your session has expired. Please log in again.',
            ]);
        }

        $data      = $response->json();
        $employees = $data['data'] ?? [];

        return view('employees', compact('employees'));
    }
}
