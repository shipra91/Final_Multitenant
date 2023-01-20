@php

@endphp

@extends('layouts.master')

@section('content')
<div class="wrapper">
    @include('ETPLSliderbar/sliderbar')
    <div class="main-panel">
        @include('ETPLSliderbar/navigation')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-md-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">account_balance_wallet</i>
                            </div>
                            <div class="card-content">
                                <div class="back back1" style="float:right;">
                                    <button onclick="window.history.go(-1)" class="btn btn-info"><i class="material-icons">arrow_back</i></button>
                                </div>
                                <h4 class="card-title">View Payment Gateway</h4>

                                <div class="row">
                                    <div class="col-lg-12 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Payment Gateway</label>
                                            <input type="text" class="form-control" value ="{{ucwords($paymentGatewayData->gateway_name)}}" disabled />
                                        </div>
                                    </div>
                                </div>

                                @foreach($paymentGatewayData['paymentGatewayFields'] as $index => $data)
                                    <div class="row">
                                        <div class="col-lg-6 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label">Label</label>
                                                <input type="text" class="form-control" value ="{{$data->field_label}}" disabled />
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label">Key</label>
                                                <input type="text" class="form-control" value ="{{$data->field_key}}" disabled />
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="row">
                                    <div class="col-lg-12" style="text-align:right;">
                                        <a href="/etpl/payment-gateway/{{$paymentGatewayData->id}}" type="button" rel="tooltip" title="Edit" class="btn btn-success btn-xs"><i class="material-icons">edit</i></a>
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

@section('script-content')
<script>
</script>
@endsection

