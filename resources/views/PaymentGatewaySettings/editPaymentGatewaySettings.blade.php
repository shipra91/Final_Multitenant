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
                                <h4 class="card-title">Edit Payment Gateway Settings</h4>
                                <form method="POST" id="gatewaySettingsForm">
                                    <div class="row">
                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Payment Gateway</label>
                                                <input type="text" class="form-control" name="paymentGateway" id="paymentGateway" value="{{$selectedGatewaySettings['gateway_name']}}" readonly />
                                                <input type="hidden" class="form-control" name="paymentSettingId" id="paymentSettingId" value="{{$selectedGatewaySettings['setting_id']}}" />
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">A/C Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="accountName" id="accountName" value="{{ $selectedGatewaySettings['account_name'] }}" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">A/C No<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="accountNo" id="accountNo" value="{{$selectedGatewaySettings['account_no']}}" required />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="fieldsContainer">
                                        @foreach($selectedGatewaySettings['field_detail'] as $fieldDetails)
                                            <div class="col-lg-4 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">{{$fieldDetails['field_name']}}<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="fieldValue[]" id="fieldValue" value="{{$fieldDetails['field_value']}}" required />
                                                    <input type="hidden" name="gatewayValueId[]" value="{{$fieldDetails['value_id']}}">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="form-group pull-right submit">
                                        <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Update</button>
                                        <a href="{{url('payment-gateway-settings')}}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
                                    </div>
                                </form>
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
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#gatewaySettingsForm").parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Update payment gateway settings
        $('body').delegate('#gatewaySettingsForm', 'submit', function(e){
            e.preventDefault();

            var btn=$('#submit');
            var paymentSettingId = $("#paymentSettingId").val();

            if ($('#gatewaySettingsForm').parsley().isValid()){

                $.ajax({
                    url:"/payment-gateway-settings/"+paymentSettingId,
                    type:"post",
                    dataType:"json",
                    data: new FormData(this),
                    contentType: false,
                    processData:false,
                    beforeSend:function(){
                        btn.html('Updating...');
                        btn.attr('disabled',true);
                    },
                    success:function(result){
                        //console.log(result);
                        btn.html('Update');
                        btn.attr('disabled',false);

                        if(result['status'] == "200"){

                            if(result.data['signal'] == "success"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function() {
                                    window.location.reload();
                                }).catch(swal.noop)

                            }else if(result.data['signal'] == "exist"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-warning"
                                });

                            }else{

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-danger"
                                });
                            }

                        }else{

                            swal({
                                title: 'Server error',
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-danger"
                            })
                        }
                    }
                });
            }
        });
    });
</script>
@endsection
