<?php

namespace App\Http\Controllers;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class TransactionController extends Controller
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ConnectionException
     */
    public function report(Request $request): View|Factory|Application
    {
        $fromDate = $request->from_date ?? date('Y-m-d');
        $toDate = $request->to_date ?? date('Y-m-d');
        $merchant = $request->merchant ?? 1;
        $acquirer = $request->acquirer ?? 1;

        $response = $this->makeRequest('/transactions/report', [
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'merchant' => $merchant,
            'acquirer' => $acquirer,
        ]);

        $results = [];

        if (is_array($response->json()) && $response->json()['status'] === 'APPROVED') {
            $results = $response->json()['response'];
        } else if ($response->json()['status'] === 'DECLINED') {
            return view('report', compact('results', 'fromDate', 'toDate', 'merchant', 'acquirer'))
                ->withErrors(["message" => $response->json()['message']]);
        }

        return view('report', compact('results', 'fromDate', 'toDate', 'merchant', 'acquirer'));
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ConnectionException
     */
    public function reportAjax(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'merchant' => 'required|numeric',
            'acquirer' => 'required|numeric',
        ]);

        $fromDate = $request->from_date;
        $toDate = $request->to_date;
        $merchant = $request->merchant;
        $acquirer = $request->acquirer;

        $response = $this->makeRequest('/transactions/report', [
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'merchant' => $merchant,
            'acquirer' => $acquirer,
        ]);

        $results = [];

        if ($response->json()['status'] === 'APPROVED') {
            $results = $response->json()['response'];
        }

        return $results;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ConnectionException
     */
    public function transactionQuery(Request $request): View|Factory|Application
    {
        $fromDate = $request->from_date ?? date('Y-m-d');
        $toDate = $request->to_date ?? date('Y-m-d');
        $merchantId = $request->merchant_id ?? 1;
        $acquirerId = $request->acquirer_id ?? 1;
        $status = $request->status ?? "";
        $operation = $request->operation ?? "";
        $paymentMethod = $request->payment_method ?? "";
        $errorCode = $request->error_code ?? "";
        $filterField = $request->filter_field ?? "";
        $filterValue = $request->filter_value ?? "";
        $page = $request->page ?? 1;

        $response = $this->makeRequest('/transaction/list', [
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'status' => $status,
            'operation' => $operation,
            'merchantId' => $merchantId,
            'acquirerId' => $acquirerId,
            'paymentMethod' => $paymentMethod,
            'errorCode' => $errorCode,
            'filterField' => $filterField,
            'filterValue' => $filterValue,
            'page' => $page,
        ]);
//        dd($response->json());

        $perPage = 50;
        $currentPage = $page;

        // dummy data for testing purposes begins
        $statuses = [
            "APPROVED",
            "WAITING",
            "DECLINED",
            "ERROR",
        ];

        $operations = [
            "DIRECT",
            "REFUND",
            "3D",
            "3DAUTH",
            "STORED",
        ];

        $paymentMethods = [
            "CREDITCARD",
            "CUP",
            "IDEAL",
            "GIROPAY",
            "MISTERCASH",
            "STORED",
            "PAYTOCARD",
            "CEPBANK",
            "CITADEL",
        ];

        $errorCodes = [
            "Do not honor",
            "Invalid Transaction",
            "Invalid Card",
            "Not sufficient funds",
            "Incorrect PIN",
            "Invalid country association",
            "Currency not allowed",
            "3-D Secure Transport Error",
            "Transaction not permitted to cardholder",
        ];

        $filterFields = [
            "Transaction UUID",
            "Customer Email",
            "Reference No",
            "Custom Data",
            "Card PAN",
        ];

        $data = [];
        $paginator = null;
        // dummy data ends

        if (!empty($response->json())) {
            $response = $response->json();

//            dd($response);
            if (isset($response['code']) && $response['code'] === "404") {
                // dummy data begins
                $from = 1;
                $to = 500;

                for ($i = $from; $i <= $to; $i++) {
                    $data[] = [
                        "number" => $i,
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
                    ];
                }
                // dummy data ends

                $offset = ($currentPage - 1) * $perPage;
                $data = array_slice($data, $offset, $perPage);

                $paginator = new LengthAwarePaginator(
                    $data,
                    $to,
                    $perPage,
                    $currentPage,
                    ['path' => url()->current()]
                );

                return view('transaction-query', compact(
                    'fromDate',
                    'toDate',
                    'status',
                    'operation',
                    'merchantId',
                    'acquirerId',
                    'paymentMethod',
                    'errorCode',
                    'filterField',
                    'filterValue',
                    'page',
                    'paginator',
                    'data',
                    'statuses',
                    'operations',
                    'paymentMethods',
                    'errorCodes',
                    'filterFields'
                ))->withErrors(["message" => $response['message']]);
            }

            if (!empty($response['data'])) {
                $data = $response['data'];
                $total = count($data);
                $offset = ($currentPage - 1) * $perPage;
                $data = array_slice($data, $offset, $perPage);

                $paginator = new LengthAwarePaginator(
                    $data,
                    $total,
                    $perPage,
                    $currentPage,
                    ['path' => url()->current()]
                );
            }
        }

        return view('transaction-query', compact(
            'fromDate',
            'toDate',
            'status',
            'operation',
            'merchantId',
            'acquirerId',
            'paymentMethod',
            'errorCode',
            'filterField',
            'filterValue',
            'page',
            'paginator',
            'data',
            'statuses',
            'operations',
            'paymentMethods',
            'errorCodes',
            'filterFields'
        ));
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ConnectionException
     */
    public function transactionQueryAjax(Request $request)
    {
        $fromDate = $request->from_date ?? date('Y-m-d');
        $toDate = $request->to_date ?? date('Y-m-d');
        $merchantId = $request->merchant_id ?? 1;
        $acquirerId = $request->acquirer_id ?? 1;
        $status = $request->status ?? "";
        $operation = $request->operation ?? "";
        $paymentMethod = $request->payment_method ?? "";
        $errorCode = $request->error_code ?? "";
        $filterField = $request->filter_field ?? "";
        $filterValue = $request->filter_value ?? "";
        $page = $request->page ?? 1;

        $response = $this->makeRequest('/transaction/list', [
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'status' => $status,
            'operation' => $operation,
            'merchantId' => $merchantId,
            'acquirerId' => $acquirerId,
            'paymentMethod' => $paymentMethod,
            'errorCode' => $errorCode,
            'filterField' => $filterField,
            'filterValue' => $filterValue,
            'page' => $page,
        ]);

        if (!empty($response->json())) {
            if (isset($response->json()['code']) && $response->json()['code'] === "404") {
                return response()->json([
                    'success' => false,
                    'message' => $response->json()['message']
                ], 404);
            }

            $data = $response->json()['data'];

            if (!empty($data)) {
                $perPage = 50;
                $currentPage = $page;
                $total = count($data);
                $offset = ($currentPage - 1) * $perPage;
                $data = array_slice($data, $offset, $perPage);

                $paginator = new LengthAwarePaginator(
                    $data,
                    $total,
                    $perPage,
                    $currentPage,
                    ['path' => url()->current()]
                );

                return response()->json([
                    "success" => true,
                    "data" => $data,
                    "paginator" => $paginator->links()->toHtml(),
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => "An unknown error occurred."
        ], 404);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ConnectionException
     */
    public function getTransaction(Request $request): View|Factory|Application
    {
        $transactionId = $request->transaction_id ?? "1-1444392550-1";

        $response = $this->makeRequest('/transaction', [
            'transactionId' => $transactionId,
        ]);

        $fxMerchant = null;
        $customerInfo = null;
        $merchant = null;
        $transactionMerchant = null;

        if (!empty($response->json())) {
            if ($response->json()['status'] === 'DECLINED') {
                return view('get-transaction', compact('transactionId', 'fxMerchant', 'customerInfo', 'merchant', 'transactionMerchant'))
                    ->withErrors(["message" => $response->json()['message']]);
            }

            $response = $response->json();
            $fxMerchant = $response['fx']['merchant'];
            $customerInfo = $response['customerInfo'];
            $merchant = $response['merchant'];
            $transactionMerchant = $response['transaction']['merchant'];
        }

        return view('get-transaction', compact('transactionId', 'fxMerchant', 'customerInfo', 'merchant', 'transactionMerchant'));
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ConnectionException
     */
    public function getTransactionAjax(Request $request)
    {
        $transactionId = $request->transaction_id ?? "1-1444392550-1";

        $response = $this->makeRequest('/transaction', [
            'transactionId' => $transactionId,
        ]);

        if (!empty($response->json())) {
            if (isset($response->json()['status']) && $response->json()['status'] === 'DECLINED') {
                return response()->json([
                    'success' => false,
                    'message' => $response->json()['message']
                ], 404);
            }

            return $response->json();
        }

        return response()->json([
            'success' => false,
            'message' => "An unknown error occurred."
        ], 404);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ConnectionException
     */
    private function makeRequest(string $endpoint, array $data): PromiseInterface|Response
    {
        return Http::withHeaders([
            'Authorization' => Cookie::get('jwt_token'),
            'Accept' => 'application/json',
        ])->post(env('API_URL') . $endpoint, $data);
    }
}
