<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * Test Logout and clear JWT token from session.
     */
    public function test_logout_and_clear_cookie()
    {
        Cookie::queue('jwt_token', 'fake-jwt-token', 10);

        $response = $this->post('/logout');

        $this->assertNull(Cookie::get('jwt_token'));

        $response->assertRedirect('/login');
    }

    /**
     * Test Login API and save JWT token in session.
     */
    public function test_login_and_save_jwt_token_in_cookie()
    {
        Http::fake([
            env('API_URL') . '/merchant/user/login' => Http::response([
                'success' => true,
                'token' => 'fake-jwt-token',
            ], 200),
        ]);

        $response = $this->post('/login', [
            'email' => 'demo@financialhouse.io',
            'password' => 'cjaiU8CV',
        ]);

        $response->assertRedirect('/');
        $response->assertCookie('jwt_token', 'fake-jwt-token');
    }
}
