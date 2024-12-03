<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cookie;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class TransactionTest extends TestCase
{
    private string $fakeJwtToken = 'fake-jwt-token';

    public function test_user_can_view_transaction_report_page()
    {
        $response = $this->withCookie('jwt_token', $this->fakeJwtToken)->get(route('report'));

        $response->assertStatus(200);
        $response->assertViewIs('report');
    }

    public function test_user_can_view_transaction_query_page()
    {
        $response = $this->withCookie('jwt_token', $this->fakeJwtToken)->get(route('transaction_query'));

        $response->assertStatus(200);
        $response->assertViewIs('transaction-query');
    }

    public function test_user_can_view_get_transaction_page()
    {
        $response = $this->withCookie('jwt_token', $this->fakeJwtToken)->get(route('get_transaction', ['transactionId' => "1-1444392550-1"]));

        $response->assertStatus(200);
        $response->assertViewIs('get-transaction');
    }

    public function test_transaction_report_ajax()
    {
        Http::fake([
            '*' => Http::response([
                'status' => 'APPROVED',
                'response' => [
                    [
                        'count' => 283,
                        'total' => 28300,
                        'currency' => 'USD'
                    ]
                ]
            ], 200)
        ]);

        $response = $this->withCookie('jwt_token', $this->fakeJwtToken)->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest'
        ])->post(route('transactions.report.ajax'), [
            'from_date' => '2024-01-01',
            'to_date' => '2024-12-03',
            'merchant' => 1,
            'acquirer' => 1
        ]);

        $response->assertStatus(200);
    }

    public function test_transaction_query_ajax()
    {
        Http::fake([
            '*' => Http::response([
                'per_page' => 50,
                'current_page' => 1,
                'next_page_url' => "http://reporting.rpdpymnt.com/api/v3/transaction/list/?page=2",
                'prev_page_url' => null,
                'from' => 1,
                'to' => 50,
                'data' => [
                    [
                        "fx" => [
                            "merchant" => [
                                "originalAmount" => 5,
                                "originalCurrency" => "EUR"
                            ]
                        ],
                        "customerInfo" => [
                            "number" => "448574XXXXXX3395",
                            "email" => "aykut.aras@bumin.com.tr",
                            "billingFirstName" => "Aykut",
                            "billingLastName" => "Aras"
                        ],
                        "merchant" => [
                            "id" =>  3,
                            "name" =>  "Dev-Merchant"
                        ],
                        "ipn" => [ "received" => true ],
                        "transaction" => [
                            "merchant" => [
                                "referenceNo" => "api_560a4a9314208",
                                "status" => "APPROVED",
                                "operation" => "3DAUTH",
                                "message" => "Auth3D is APPROVED",
                                "created_at" => "2015-09-29 08 => 24 => 42",
                                "transactionId" => "2827-1443515082-3"
                            ]
                        ],
                        "acquirer" => [
                            "id" => 12,
                            "name" => "Mergen Bank",
                            "code" => "MB",
                            "type" => "CREDITCARD"
                        ],
                        "refundable" => true
                    ],
                ]
            ], 200)
        ]);

        $response = $this->withCookie('jwt_token', $this->fakeJwtToken)->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest'
        ])->post(route('transactions.query.ajax'), [
            'from_date' => '2024-01-01',
            'to_date' => '2024-12-03',
            'merchant_id' => 1,
            'acquirer_id' => 1,
            'status' => "",
            'operation' => "",
            'payment_method' => "",
            'error_code' => "",
            'filter_field' => "",
            'filter_value' => "",
            'page' => 1,
        ]);

        $response->assertStatus(200);
    }



    public function test_get_transaction_ajax()
    {
        Http::fake([
            '*' => Http::response([
                'fx' => [
                    "merchant" => [
                        "originalAmount" => 100,
                        "originalCurrency" => "EUR"
                    ]
                ],
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
                ],
                'merchant' => [
                    "name" => "Dev-Merchant",
                ],
                'transaction' => [
                    "merchant" => [
                        "referenceNo" => "reference_5617ae66281ee",
                        "merchantId" => 1,
                        "status" => "WAITING",
                        "channel" => "API",
                        "customData" => null,
                        "chainId" => "5617ae666b4cb",
                        "agentInfoId" => 1,
                        "operation" => "DIRECT",
                        "fxTransactionId" => 1,
                        "updated_at" => "2015-10-09 12:09:12",
                        "created_at" => "2015-10-09 12:09:10",
                        "id" => 1,
                        "acquirerTransactionId" => 1,
                        "code" => "00",
                        "message" => "Waiting",
                        "transactionId" => "1-1444392550-1",
                        "agent" => [
                            "id" => 1,
                            "customerIp" => "192.168.1.2",
                            "customerUserAgent" => "Agent",
                            "merchantIp" => "127.0.0.1",
                        ]
                    ]
                ]
            ], 200)
        ]);

        $response = $this->withCookie('jwt_token', $this->fakeJwtToken)->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest'
        ])->post(route('get.transaction.ajax'), [
            'transaction_id' => "1-1444392550-1",
        ]);

        $response->assertStatus(200);
    }

    public function test_unauthorized_access_is_redirected()
    {
        $response = $this->get(route('report'));

        $response->assertRedirect(route('login'));
    }
}
