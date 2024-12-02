<?php

namespace App\Http\Controllers;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
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
    private function makeRequest(string $endpoint, array $data): PromiseInterface|Response
    {
        return Http::withHeaders([
            'Authorization' => session()->get('jwt_token'),
            'Accept' => 'application/json',
        ])->post(env('API_URL') . $endpoint, $data);
    }
}
