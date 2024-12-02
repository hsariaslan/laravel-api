<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function report(): View|Factory|Application
    {
        return view('report');
    }
}
