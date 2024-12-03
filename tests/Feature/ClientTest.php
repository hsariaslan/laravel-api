<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ClientTest extends TestCase
{
    private string $fakeJwtToken = 'fake-jwt-token';

    public function test_user_can_view_get_client_page()
    {
        $response = $this->withCookie('jwt_token', $this->fakeJwtToken)->get(route('client'));

        $response->assertStatus(200);
        $response->assertViewIs('client');
    }

    public function test_get_client_ajax()
    {
        Http::fake([
            '*' => Http::response([
                'customerInfo' => [
                    [
                        'id' => 1,
                        'created_at' => "2015-10-09 12:09:10",
                        'updated_at' => "2015-10-09 12:09:10",
                        'deleted_at' => null,
                        'number' => "401288XXXXXX1881",
                        'expiryMonth' => "6",
                        'expiryYear' => "2017",
                        'startMonth' => null,
                        'startYear' => null,
                        'issueNumber' => null,
                        'email' => "michael@gmail.com",
                        'birthday' => "1986-03-20 12:09:10",
                        'gender' => null,
                        'billingTitle' => null,
                        'billingFirstName' => "Michael",
                        'billingLastName' => "Kara",
                        'billingCompany' => null,
                        'billingAddress1' => "test address",
                        'billingAddress2' => null,
                        'billingCity' => "Antalya",
                        'billingPostCode' => "07070",
                        'billingState' => null,
                        'billingCountry' => "TR",
                        'billingPhone' => null,
                        'billingFax' => null,
                        'shippingTitle' => null,
                        'shippingFirstName' => "Michael",
                        'shippingLastName' => "Kara",
                        'shippingCompany' => null,
                        'shippingAddress1' => "test address",
                        'shippingAddress2' => null,
                        'shippingCity' => "Antalya",
                        'shippingPostCode' => "07070",
                        'shippingState' => null,
                        'shippingCountry' => "TR",
                        'shippingPhone' => null,
                        'shippingFax' => null,
                    ]
                ]
            ], 200)
        ]);

        $response = $this->withCookie('jwt_token', $this->fakeJwtToken)->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest'
        ])->post(route('client.ajax'), [
            'transaction_id' => "1-1444392550-1",
        ]);

        $response->assertStatus(200);
    }
}
