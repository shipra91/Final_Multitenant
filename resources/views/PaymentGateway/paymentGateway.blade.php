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
                                <h4 class="card-title">Add Payment Gateway</h4>
                                <form method="POST" id="paymentGatewayForm">
                                    <div class="row">
                                        <div class="col-lg-6 col-lg-offset-0">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons icon-middle">view_headline</i>
                                                </span>
                                                <div class="form-group">
                                                    <label class="control-label">Payment Gateway<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="paymentGateway" id="paymentGateway" required />
                                                </div>
                                            </div>
                                            <input type="hidden" class="form-control" name="paymentGatewayKey" id="paymentGatewayKey" />
                                        </div>

                                        <div class="col-lg-12 col-lg-offset-0">
                                            <div id="repeater">
                                                <input type="hidden" name="totalCount" id="totalCount" class="form-control" value="1">
                                                <div class="row" id="section_1" data-id="1" style="margin-top: -20px;">
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

                                                    {{-- <div class="col-lg-1 col-lg-offset-0 text-right">
                                                        <button type="button" id="1" class="btn btn-danger btn-sm remove_button mt-30"><i class="material-icons">highlight_off</i></button>
                                                    </div> --}}
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-lg-offset-0">
                                                <button id="add_more" type="button" class="btn btn-warning btn-sm"><i class="material-icons">add_circle_outline</i> Add</button>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-lg-offset-0 text-right">
                                            <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd" id="submit" name="submit">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-md-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">account_balance_wallet</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Payment Gateway List</h4>
                                <div class="material-datatables">
                                    <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" width="100%" style="width:100%">
                                        <thead style="font-size:12px;">
                                            <tr>
                                                <th><b>S.N.</b></th>
                                                <th><b>Payment Gateway</b></th>
                                                <th><b>Action</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
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

        // View payment gateway
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: "payment-gateway",
            columns: [
                {data: 'DT_RowIndex', name: 'id', "width": "10%"},
                {data: 'gateway_name', name: 'gateway_name', "width": "75%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "15%"},
            ]
        });

        // Add more payment gateway
        var count = $('#totalCount').val();

        $(document).on('click', '#add_more', function(){

            var html = '';
            count++;

            html += '<div class="row" id="section_'+count+'" data-id="'+count+'">';
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

        $("#paymentGatewayForm").parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save payment gateway
        $('body').delegate('#paymentGatewayForm', 'submit', function(e){
            e.preventDefault();

            var btn=$('#submit');

            if ($('#paymentGatewayForm').parsley().isValid()){

                $.ajax({
                    url:"/etpl/payment-gateway",
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
                        console.log(result);
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

        // Delete payment gateway
        $(document).on('click', '.delete', function (event){
            event.preventDefault();

            var id = $(this).data('id');

            if(confirm("Are you sure you want to delete this?")){

                $.ajax({
                    type: "DELETE",
                    url:"/etpl/payment-gateway/"+id,
                    dataType: "json",
                    data: {id:id},
                    success: function (result) {

                        if(result['status'] == "200"){

                            if(result.data['signal'] == "success"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function() {
                                    window.location.reload();
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
    });
</script>
@endsection

