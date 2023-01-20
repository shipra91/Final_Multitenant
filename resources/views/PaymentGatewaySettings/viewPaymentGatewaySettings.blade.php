@php

@endphp

@extends('layouts.master')

@section('content')
<div class="wrapper">
    @include('sliderbar')
    <div class="main-panel">
        @include('navigation')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-md-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">account_balance_wallet</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Payment Gateway Settings Detail</h4>
                                <div class="row">
                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Payment Gateway</label>
                                            <input type="text" class="form-control" name="paymentGateway" id="paymentGateway" value="{{$selectedGatewaySettings['gateway_name']}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">A/C Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="accountName" id="accountName" value="{{ $selectedGatewaySettings['account_name'] }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">A/C No<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="accountNo" id="accountNo" value="{{$selectedGatewaySettings['account_no']}}" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="fieldsContainer">
                                    @foreach($selectedGatewaySettings['field_detail'] as $fieldDetails)
                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">{{$fieldDetails['field_name']}}<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="fieldValue[]" id="fieldValue" value="{{$fieldDetails['field_value']}}" disabled />
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="pull-right">
                                            <a href="/payment-gateway-settings/{{$selectedGatewaySettings['setting_id']}}" type="button" class="btn btn-success btn-wd mr-5">Edit</a>
                                            <a href="{{ url('payment-gateway-settings') }}" class="btn btn-wd btn btn-danger">Close</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
