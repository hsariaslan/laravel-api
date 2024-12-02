<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct(Request $request)
    {
        if ($request->session()->has('jwt_token')) {
            return redirect()->route('home');
        }
    }

    public function index(): Renderable
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|max:255',
        ]);

        try {
            $response = Http::withHeaders(['Accept' => 'application/json'])->post(env('API_URL') . '/merchant/user/login', [
                'email' => $request->email,
                'password' => $request->password,
            ]);

            if ($response->successful()) {
                $token = $response->json()['token'];
                session(['jwt_token' => $token]);

                return redirect()->route('home');
            }

            return redirect()->route('login')->withErrors([
                "message" => "Email or password is incorrect",
            ]);
        } catch (ConnectionException $e) {
            return $e->getMessage();
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        if (!$request->session()->has('jwt_token')) {
            return redirect()->back();
        }

        session()->forget('jwt_token');

        return redirect()->route('login');
    }
}
