<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class LoginController extends Controller
{
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
                Cookie::queue('jwt_token', $token, 10);

                return redirect()->route('home');
            }

            return redirect()->route('login')->withErrors([
                "message" => "Email or password is incorrect",
            ]);
        } catch (ConnectionException $e) {
            return $e->getMessage();
        }
    }

    public function logout(): RedirectResponse
    {
        if (!Cookie::has('jwt_token')) {
            return redirect()->back();
        }

        Cookie::queue(Cookie::forget('jwt_token'));

        return redirect()->route('login');
    }
}
