<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ClientController extends Controller
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ConnectionException
     */
    public function index(Request $request): Application|Factory|View
    {
        $transactionId = $request->transaction_id ?? "1-1444392550-1";

        $response = Http::withHeaders([
            'Authorization' => session()->get('jwt_token'),
            'Accept' => 'application/json',
        ])->post(env('API_URL') . '/client', [
            'transactionId' => $transactionId,
        ]);

        $customerInfo = null;

        if (!empty($response->json()['customerInfo'])) {
            $customerInfo = $response->json()['customerInfo'];
        }

        return view('client', compact('customerInfo', 'transactionId'));
    }

    public function clientAjax(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|max:255',
        ]);

        $transactionId = $request->transaction_id;

        $response = Http::withHeaders([
            'Authorization' => session()->get('jwt_token'),
            'Accept' => 'application/json',
        ])->post(env('API_URL') . '/client', [
            'transactionId' => $transactionId,
        ]);

        $customerInfo = null;

        if (!empty($response->json()['customerInfo'])) {
            $customerInfo = $response->json()['customerInfo'];
        }

        return $customerInfo;
    }
}
