@extends('layouts.admin')

@section('main-content')
    @if ($errors->has('message'))
        <div class="alert alert-danger border-left-danger" role="alert" id="transactionQueryErrors">
            @foreach($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Transaction Query') }}</h1>
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <div class="row">
                        <form action="" id="transactionQueryForm" class="w-100 d-block">
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
                                <div class="col-3">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="merchant" class="mt-2">Merchant</label>
                                        </div>
                                        <div class="col-9">
                                            <select class="custom-select" name="merchant" id="merchant_id">
                                                <option value="1" selected>Demo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="acquirer" class="mt-2">Acquirer</label>
                                        </div>
                                        <div class="col-9">
                                            <select class="custom-select" name="acquirer" id="acquirer_id">
                                                <option value="1" selected>Demo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-3">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="merchant" class="mt-2">Status</label>
                                        </div>
                                        <div class="col-9">
                                            <select class="custom-select" name="status" id="status">
                                                <option value="" selected>Select Status</option>
                                                @foreach($statuses as $status)
                                                    <option value="{{ $status }}">{{ $status }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="merchant" class="mt-2">Operation</label>
                                        </div>
                                        <div class="col-9">
                                            <select class="custom-select" name="operation" id="operation">
                                                <option value="" selected>Select Operation</option>
                                                @foreach($operations as $operation)
                                                    <option value="{{ $operation }}">{{ $operation }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="merchant" class="mt-2">Payment Method</label>
                                        </div>
                                        <div class="col-9">
                                            <select class="custom-select" name="payment_method" id="payment_method">
                                                <option value="" selected>Select Payment Method</option>
                                                @foreach($paymentMethods as $paymentMethod)
                                                    <option value="{{ $paymentMethod }}">{{ $paymentMethod }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="merchant" class="mt-2">Error Code</label>
                                        </div>
                                        <div class="col-9">
                                            <select class="custom-select" name="error_code" id="error_code">
                                                <option value="" selected>Select Error Code</option>
                                                @foreach($errorCodes as $errorCode)
                                                    <option value="{{ $errorCode }}">{{ $errorCode }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-3">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="merchant" class="mt-2">Filter Field</label>
                                        </div>
                                        <div class="col-9">
                                            <select class="custom-select" name="filter_field" id="filter_field">
                                                <option value="" selected>Select Filter Field</option>
                                                @foreach($filterFields as $filterField)
                                                    <option value="{{ $filterField }}">{{ $filterField }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="merchant" class="mt-2">Filter Value</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="text" class="input-group-text w-100 text-left bg-white" id="filter_value" name="filter_value"
                                                   value="{{ !empty($filterValue) ? $filterValue : old('filter_value') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4"></div>
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
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Fx</th>
                                <th>Customer</th>
                                <th>Merchant</th>
                                <th>Ipn</th>
                                <th>Transaction</th>
                                <th>Acquirer</th>
                                <th>Refundable</th>
                            </tr>
                            </thead>
                            <tbody id="loadingTbody">
                            <tr>
                                <td colspan="8">
                                    <img src="{{ asset('img/loading.gif') }}" alt="loading">
                                </td>
                            </tr>
                            </tbody>
                            <tbody id="transactionQueryBody">
                            @foreach($data as $dataRow)
                                <tr>
                                    <td>{{ $dataRow['number'] }}</td>
                                    <td>
                                        <b>{{ $dataRow['fx']['merchant']['originalAmount'] . ' ' . $dataRow['fx']['merchant']['originalCurrency'] }}</b>
                                    </td>
                                    <td>
                                        <p>{{ $dataRow['customerInfo']['billingFirstName'] . ' ' . $dataRow['customerInfo']['billingLastName'] }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $dataRow['merchant']['name'] }}</p>
                                    </td>
                                    <td>
                                        {!! $dataRow['ipn']['received'] ? "<p class='text-success'>Received</p>" : "<p class='text-danger'>Not Received</p>" !!}
                                    </td>
                                    <td>
                                        @foreach($dataRow['transaction'] as $transaction)
                                            @switch($transaction['status'])
                                                @case("APPROVED") <span class='text-success'>APROVED</span> @break
                                                @case("WAITING") <span class='text-warning'>WAITING</span> @break
                                                @case("DECLINED") <span class='text-danger'>DECLINED</span> @break
                                                @case("ERROR") <span class='text-danger'>ERROR</span> @break
                                            @endswitch
                                        /
                                            <span class='text-info'>{{ $transaction['operation'] }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <span>{{ $dataRow['acquirer']['name'] }}</span>
                                        /
                                        <span class='text-info'>{{ $dataRow['acquirer']['type'] }}</span>
                                    </td>
                                    <td>{!! $dataRow['refundable'] ? "<p class='text-success'>True</p>" : "<p class='text-danger'>False</p>" !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot id="paginationTFoot">
                            <tr>
                                <td colspan="8" id="pagination">
                                    {{ !empty($paginator) ? $paginator->links() : '' }}
                                </td>
                            </tr>
                            </tfoot>
                            <tbody id="transactionQueryAjaxBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
