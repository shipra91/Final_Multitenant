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
                                <h4 class="card-title">Edit Payment Gateway</h4>
                                <form method="POST" id="paymentGatewayForm">
                                    <input type="hidden" name="paymentGatewayId" id="paymentGatewayId" class="form-control" value="{{$selectedPaymentGateway->id}}">
                                    <div class="row">
                                        <div class="col-lg-6 col-lg-offset-0">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons icon-middle">view_headline</i>
                                                </span>
                                                <div class="form-group">
                                                    <label class="control-label">Payment Gateway<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="paymentGateway" id="paymentGateway" value="{{$selectedPaymentGateway->gateway_name}}" required />
                                                </div>
                                            </div>

                                            <input type="hidden" class="form-control" name="paymentGatewayKey" id="paymentGatewayKey" value="{{$selectedPaymentGateway->gateway_key}}" />
                                        </div>

                                        <div class="col-lg-12 col-lg-offset-0">
                                            <div id="repeater">
                                                @php $countRow = 0;@endphp
                                                @if($selectedPaymentGateway['paymentGatewayFields'])
                                                    @foreach($selectedPaymentGateway['paymentGatewayFields'] as $index => $data)
                                                        @php $countRow++;@endphp
                                                        <div class="row" id="section_{{ $countRow }}" data-id="{{ $countRow }}" style="margin-top: -20px;">
                                                            <input type="hidden" name="gatewayFieldsId[]" value = "{{$data->id}}">
                                                            <div class="col-lg-5 col-lg-offset-0">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="material-icons icon-middle">view_headline</i>
                                                                    </span>
                                                                    <div class="form-group">
                                                                        <label class="control-label">Label<span class="text-danger">*</span></label>
                                                                        <input type="text" class="form-control" name="fieldLabel[]" id="fieldLabel_1" value="{{$data->field_label}}" required />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-5 col-lg-offset-0">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="material-icons icon-middle">view_headline</i>
                                                                    </span>
                                                                    <div class="form-group">
                                                                        <label class="control-label">Key<span class="text-danger">*</span></label>
                                                                        <input type="text" class="form-control" name="fieldKey[]" id="fieldKey_1" value="{{$data->field_key}}" required />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-1 col-lg-offset-0 text-right">
                                                                <button type="button" id="{{$data->id}}" class="btn btn-danger btn-sm delete_button mt-30" data-id={{ $countRow }}><i class="material-icons">delete</i></button>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                @else

                                                    <div class="row" id="section_1" data-id="1" style="margin-top: -20px;">
                                                        <input type="hidden" name="gatewayFieldsId[]" value = "">
                                                        <div class="col-lg-5 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">view_headline</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label">Label<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="fieldLabel[]" id="fieldLabel_1" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-5 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">view_headline</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label">Key<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="fieldKey[]" id="fieldKey_1" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-1 col-lg-offset-0 text-right">
                                                            <button type="button" id="1" class="btn btn-danger btn-sm delete_button" data-id="1"><i class="material-icons">delete</i></button>
                                                        </div>
                                                    </div>
                                                @endif
                                                <input type="hidden" name="totalCount" id="totalCount" class="form-control" value="{{ $selectedPaymentGateway['paymentGatewayFields']?$countRow:1 }}">
                                            </div>
                                            <div class="col-lg-12 col-lg-offset-0">
                                                <button id="add_more" type="button" class="btn btn-warning btn-sm"><i class="material-icons">add_circle_outline</i> Add</button>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-lg-offset-0 text-right">
                                            <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Submit</button>
                                            <a href="{{url('/etpl/payment-gateway')}}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
                                        </div>
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

        // Autogenerate payment gateway key
        $("body").delegate("#paymentGateway", "keyup", function(e) {
            e.preventDefault();

            var gatewayKey = $(this).val().trim();
            $("#paymentGatewayKey").val(gatewayKey.toLowerCase().replace(/ /g, "-"));
        });

        // Add more payment gateway
        var count = $('#totalCount').val();

        $(document).on('click', '#add_more', function(){

            var html = '';
            count++;

            html += '<div class="row" id="section_'+count+'" data-id="'+count+'">';
            html += '<input type="hidden" name="gatewayFieldsId[]" value = "">';
            html += '<div class="col-lg-5 form-group col-lg-offset-0">';
            html += '<div class="input-group">';
            html += '<span class="input-group-addon">';
            html += '<i class="material-icons icon-middle">view_headline</i>';
            html += '</span>';
            html += '<div class="form-group">';
            html += '<label class="control-label">Label<span class="text-danger">*</span></label>';
            html += '<input type="text" class="form-control" name="fieldLabel[]" id="fieldLabel_'+count+'" required />';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-5 form-group col-lg-offset-0">';
            html += '<div class="input-group">';
            html += '<span class="input-group-addon">';
            html += '<i class="material-icons icon-middle">view_headline</i>';
            html += '</span>';
            html += '<div class="form-group">';
            html += '<label class="control-label">Key<span class="text-danger">*</span></label>';
            html += '<input type="text" class="form-control" name="fieldKey[]" id="fieldKey_'+count+'" required />';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            html += ' <div class="col-lg-1 form-group col-lg-offset-0 text-right">';
            html += '<button type="button" id="'+count+'" class="btn btn-danger btn-sm remove_button mt-30"><i class="material-icons">highlight_off</i></button>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            $('#repeater').append(html);
            $("#totalCount").val(count);
        });

        // Remove payment gateway
        $(document).on('click', '.remove_button', function(event){
            event.preventDefault();

            var id = $(this).attr('id');//alert(id);
            console.log(id);
            var totalCount = $('#repeater tr:last').attr('id');

            $(this).closest('div #section_'+id+'').remove();
            totalCount--;
        });

        // Delete payment gateway
        $(document).on('click','.delete_button',function(){

            var id = $(this).attr('id');//alert(id);
            var dataId= $(this).attr('data-id');
            var parent = $(this).parents("div #section_"+dataId);

            if(confirm("Are you sure you want to delete this?")){

                $.ajax({
                    type: "DELETE",
                    url:"/etpl/gateway-fields-detail/"+id,
                    dataType: "json",
                    data: {id:id},
                    success: function(result){

                        if(result['status'] == "200"){

                            if(result.data['signal'] == "success"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function() {
                                    parent.animate({ backgroundColor: "#f1f1f1" }, "slow").animate({ opacity: "hide" }, "slow");
                                }).catch(swal.noop)

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

            return false;
        });

        $("#paymentGatewayForm").parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Update payment gateway
        $('body').delegate('#paymentGatewayForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');
            var id = $("#paymentGatewayId").val();

            if ($('#paymentGatewayForm').parsley().isValid()){

                $.ajax({
                    url:"/etpl/payment-gateway/"+id,
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
                        // console.log(result);
                        btn.html('Update');
                        btn.attr('disabled',false);

                        if(result['status'] == "200"){

                            if(result.data['signal'] == "success"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function() {
                                    window.location.replace('/etpl/payment-gateway');
                                    // window.location.reload();
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

