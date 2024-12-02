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
    <h1 class="h3 mb-4 text-gray-800">{{ __('Get Client') }}</h1>
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <div class="row">
                        <form action="" id="clientForm" class="w-100 d-block">
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="transaction-id" class="mt-2">Transaction Id</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="text" class="input-group-text" id="transaction-id" name="transaction_id"
                                                   value="{{ !empty($transactionId) ? $transactionId : old('transaction_id') }}">
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
                <div class="card-body" id="client-body">
                    @if(!empty($customerInfo))
                        <div class="row">
                            <div class="col-3">Id</div>
                            <div class="col-9" id="client-id">{{ $customerInfo->id }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Created At</div>
                            <div class="col-9" id="client-created_at">{{ $customerInfo->created_at }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Updated At</div>
                            <div class="col-9" id="client-updated_at">{{ $customerInfo->updated_at }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Deleted At</div>
                            <div class="col-9" id="client-deleted_at">{{ $customerInfo->deleted_at }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Number</div>
                            <div class="col-9" id="client-number">{{ $customerInfo->number }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Expiry Month</div>
                            <div class="col-9" id="client-expiryMonth">{{ $customerInfo->expiryMonth }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Expiry Year</div>
                            <div class="col-9" id="client-expiryYear">{{ $customerInfo->expiryYear }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Start Month</div>
                            <div class="col-9" id="client-startMonth">{{ $customerInfo->startMonth }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Start Year</div>
                            <div class="col-9" id="client-startYear">{{ $customerInfo->startYear }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Issue Number</div>
                            <div class="col-9" id="client-issueNumber">{{ $customerInfo->issueNumber }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Email</div>
                            <div class="col-9" id="client-email">{{ $customerInfo->email }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Birthday</div>
                            <div class="col-9" id="client-birthday">{{ $customerInfo->birthday }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Gender</div>
                            <div class="col-9" id="client-gender">{{ $customerInfo->gender }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Billing Title</div>
                            <div class="col-9" id="client-billingTitle">{{ $customerInfo->billingTitle }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Billing First Name</div>
                            <div class="col-9" id="client-billingFirstName">{{ $customerInfo->billingFirstName }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Billing Last Name</div>
                            <div class="col-9" id="client-billingLastName">{{ $customerInfo->billingLastName }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Billing Company</div>
                            <div class="col-9" id="client-billingCompany">{{ $customerInfo->billingCompany }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Billing Address 1</div>
                            <div class="col-9" id="client-billingAddress1">{{ $customerInfo->billingAddress1 }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Billing Address 2</div>
                            <div class="col-9" id="client-billingAddress2">{{ $customerInfo->billingAddress2 }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Billing City</div>
                            <div class="col-9" id="client-billingCity">{{ $customerInfo->billingCity }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Billing Post Code</div>
                            <div class="col-9" id="client-billingPostCode">{{ $customerInfo->billingPostCode }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Billing State</div>
                            <div class="col-9" id="client-billingState">{{ $customerInfo->billingState }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Billing Country</div>
                            <div class="col-9" id="client-billingCountry">{{ $customerInfo->billingCountry }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Billing Phone</div>
                            <div class="col-9" id="client-billingPhone">{{ $customerInfo->billingPhone }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Billing Fax</div>
                            <div class="col-9" id="client-billingFax">{{ $customerInfo->billingFax }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Shipping Title</div>
                            <div class="col-9" id="client-shippingTitle">{{ $customerInfo->shippingTitle }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Shipping First Name</div>
                            <div class="col-9" id="client-shippingFirstName">{{ $customerInfo->shippingFirstName }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Shipping Last Name</div>
                            <div class="col-9" id="client-shippingLastName">{{ $customerInfo->shippingLastName }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Shipping Company</div>
                            <div class="col-9" id="client-shippingCompany">{{ $customerInfo->shippingCompany }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Shipping Address 1</div>
                            <div class="col-9" id="client-shippingAddress1">{{ $customerInfo->shippingAddress1 }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Shipping Address 2</div>
                            <div class="col-9" id="client-shippingAddress2">{{ $customerInfo->shippingAddress2 }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Shipping City</div>
                            <div class="col-9" id="client-shippingCity">{{ $customerInfo->shippingCity }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Shipping Post Code</div>
                            <div class="col-9" id="client-shippingPostCode">{{ $customerInfo->shippingPostCode }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Shipping State</div>
                            <div class="col-9" id="client-shippingState">{{ $customerInfo->shippingState }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Shipping Country</div>
                            <div class="col-9" id="client-shippingCountry">{{ $customerInfo->shippingCountry }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Shipping Phone</div>
                            <div class="col-9" id="client-shippingPhone">{{ $customerInfo->shippingPhone }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3">Shipping Fax</div>
                            <div class="col-9" id="client-shippingFax">{{ $customerInfo->shippingFax }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
