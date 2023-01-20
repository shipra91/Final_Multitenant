
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
                                <h4 class="card-title">Add Payment Gateway Settings</h4>
                                <form method="POST" id="gatewaySettingsForm">
                                    <div class="row">
                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Payment Gateway<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="paymentGateway" id="paymentGateway" data-size="4" data-style="select-with-transition" data-live-search="true" title="Select" required="required">
                                                    @foreach($paymentGateways as $paymentGateway)
                                                        <option value="{{$paymentGateway->id}}">{{$paymentGateway->gateway_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">A/C Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="accountName" id="accountName" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">A/C No<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="accountNo" id="accountNo" required />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="fieldsContainer">

                                    </div>

                                    <div class="form-group pull-right submit">
                                        <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Submit</button>
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

        // Get data based on payment gateway
        $('#paymentGateway').on('change', function(){

            var gatewayId = $(this).find(":selected").val();

            $.ajax({
                url:"/payment-gateway-fields",
                type:"POST",
                data: {id : gatewayId},
                success: function(response) {
                    var html = '';
                    jQuery.map(response['data'], function(val){
                        console.log(val.field_id);
                        html += '<div class="col-lg-4 col-lg-offset-0">';
                        html += '<input type="hidden" name="gatewayFieldId[]" value="'+val.field_id+'">';
                        html += '<div class="form-group">';
                        html += '<label class="control-label mt-0">'+val.field_name+'<span class="text-danger">*</span></label>';
                        html += '<input type="text" class="form-control" name="fieldValue[]" id="fieldValue" value="" required />';
                        html += '</div>';
                        html += '</div>';
                    });

                    $("#fieldsContainer").html(html);
                    // $("#accountName").val(response.account_name);
                    // $("#accountNo").val(response.account_no);
                }
            });
        });

        $("#gatewaySettingsForm").parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save payment gateway settings
        $('body').delegate('#gatewaySettingsForm', 'submit', function(e){
            e.preventDefault();

            var btn=$('#submit');

            if ($('#gatewaySettingsForm').parsley().isValid()){

                $.ajax({
                    url:"/payment-gateway-settings",
                    type:"post",
                    dataType:"json",
                    data: new FormData(this),
                    contentType: false,
                    processData:false,
                    beforeSend:function(){
                        btn.html('Submitting...');
                        btn.attr('disabled',true);
                    },
                    success:function(result){
                        //console.log(result);
                        btn.html('Submit');
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
