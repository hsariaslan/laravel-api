@extends('layouts.admin')

@section('main-content')
    @if ($errors->has('message'))
        <div class="alert alert-danger border-left-danger" role="alert">
            @foreach($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Transaction Report') }}</h1>
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <div class="row">
                        <form action="" id="transactionReportForm" class="w-100 d-block">
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-3">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="from-date" class="mt-2">From Date:</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="text" class="datepicker input-group-text" id="from-date" name="from_date"
                                                   value="{{ $fromDate ? date("m/d/Y", strtotime($fromDate)) : date("m/d/Y") }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="to-date" class="mt-2">To Date:</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="text" class="datepicker input-group-text" id="to-date" name="to_date"
                                                   value="{{ $toDate ? date("m/d/Y", strtotime($toDate)) : date("m/d/Y") }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="merchant" class="mt-2">Merchant</label>
                                        </div>
                                        <div class="col-9">
                                            <select class="custom-select" name="merchant" id="merchant">
                                                <option value="1" selected>Demo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="acquirer" class="mt-2">Acquirer</label>
                                        </div>
                                        <div class="col-9">
                                            <select class="custom-select" name="acquirer" id="acquirer">
                                                <option value="1" selected>Demo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="row">
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Count</th>
                                <th>Total</th>
                                <th>Currency</th>
                            </tr>
                            </thead>
                            <tbody id="transactionReportBody">
                            @foreach($results as $result)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $result->count }}</td>
                                    <td>{{ $result->total }}</td>
                                    <td>{{ $result->currency }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tbody id="loadingTbody">
                            <tr>
                                <td colspan="4">
                                    <img src="{{ asset('img/loading.gif') }}" alt="loading">
                                </td>
                            </tr>
                            </tbody>
                            <tbody id="transactionReportAjaxBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
