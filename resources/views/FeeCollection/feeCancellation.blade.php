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
                            <div class="card-content">
                                <form method="GET" id="getStudent">
                                    <div class="row" style="padding: 10px 0px;">
                                        <div class="col-lg-8 col-lg-offset-1">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">search</i>
                                                </span>
                                                <div class="form-group">
                                                    <input type="text" class="form-control autocomplete" id="autocomplete" placeholder="Search & select student name here" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-lg-offset-0" style="margin-top: -5px;">
                                            <button type="submit" class="btn btn-info" id="receive">Search</button>
                                            <input type="hidden" name="student" id="student"/>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @if(isset($_GET['student']))
                    <div class="row">
                        <div class="col-lg-12 col-lg-offset-0">
                            <div class="card bg-primary">
                                <div class="card-content">
                                    <div class="row info">
                                        <h6 class="text-center">
                                            <span class="fw-400">{{$paymentDetails['studentDetails']['name']}} | {{$paymentDetails['studentDetails']['UID']}} | {{$paymentDetails['studentDetails']['class']}}</span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <input type="hidden" id="studentId" value="{{ $_GET['student'] }}"/>
                        <div class="col-sm-12 col-sm-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">account_balance_wallet</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Fee Payment Details</h4>

                                    <div class="material-datatables">
                                        <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                            <thead style="font-size:12px;">
                                            <tr>
											    <th><b>Sl No.</b></th>
                                                <th><b>Payment Mode</b></th>
                                                <th><b>Paid Date </b></th>
												<th><b>Receipt Number</b></th>
												<th><b>Amount Paid</b></th>
												<th><b>Action</b></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($paymentDetails['collectionDetails'])>0)
                                                    @foreach($paymentDetails['collectionDetails'] as $index => $data)
                                                        <tr>
                                                            <td>{{$index + 1}}</td>
                                                            <td>{{$data['payment_mode']}}</td>
                                                            <td>{{$data['paid_date']}}</td>
                                                            <td>{{$data['receipt_prefix']}}/{{$data['receipt_no']}}</td>
                                                            <td>{{$data['paid_amount']}}</td>
                                                            <td>
                                                            @if($data['cancelled_status'] == 'NO')
                                                            <a href="javascript:void();" data-id="{{$data['idFeeCollection']}}" rel="tooltip" title="Cancel Receipt" class="text-danger cancelReceipt"><i class="material-icons">cancel</i></a>
                                                            @else
                                                            <p class="danger-label">RECEIPT CANCELLED ON {{$data['cancelled_date']}}. </p>
                                                            <p class="danger-label">
                                                            REASON : {{$data['cancellation_remarks']}} </p>
                                                            @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td class="text-center" colspan="6">--NO DATA FOUND--</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="receipt_cancel_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="receiptCancelForm" enctype = "multipart/form-data">
                <div class="card1" class="mt-3">
                    <div class="card-header card-header-tabs" data-background-color="mediumaquamarine">
                        <h6 class="text-capitalize text-center font-16">Fee Receipt</h6>
                        {{-- <p ></p> --}}
                    </div>
                </div>
                <div class="modal-body col-lg-12">
                    <div class="row">
                        <input type="hidden" name='action_type' value="CANCEL"/>
                        <input type="hidden" id='feePaymentId' name='feePaymentId'/>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label mt-0">Type Reason<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="cancel_remarks" id="cancel_remarks" required/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="cancel_receipt" name="submit">Cancel Receipt</button>
                                <button type="button" class="btn btn-danger btn-wd" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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

        $("body").delegate(".cancelReceipt", "click", function(event){
            event.preventDefault();

            var feePaymentId = $(this).attr('data-id');

            $("#receipt_cancel_model").find("#feePaymentId").val(feePaymentId);
            $("#receipt_cancel_model").modal('show');
        });

        // Get students
        $('#autocomplete').autocomplete({
            source: function( request, response ){

                $.ajax({
                    type: "POST",
                    url: '{{ url("student-search") }}',
                    dataType: "json",
                    data: {term: request.term},
                    success: function( data ){
                        response(data);
                        response( $.map( data, function( item ){
                            var code = item.split("@");
                            // console.log(code);
                            var code1 = item.split("|");
                            return {
                                label: code[0],
                                value: code[0],
                                data : item
                            }
                        }));
                    }
                });
            },
            autoFocus: true,
            minLength: 2,
            select: function( event, ui ){
                var names = ui.item.data.split("@");
                // console.log(names);
                $("#student").val(names[1]);
            }
        });

        $('#receiptCancelForm, #getStudent').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save cancel receipt
        $("body").delegate("#receiptCancelForm", "submit", function(event){
            event.preventDefault();

            var btn = $('#challan_reject');
            var id = $('#feePaymentId').val();

            if(confirm("Are you sure you want to Cancel?")){

                if ($('#receiptCancelForm').parsley().isValid()){

                    $.ajax({
                        url:"/fee-cancellation/"+id,
                        type:"POST",
                        dataType:"json",
                        data: new FormData(this),
                        contentType: false,
                        processData:false,
                        beforeSend:function(){
                            btn.html('Cancelling...');
                            btn.attr('disabled',true);
                        },
                        success: function (result){

                            if(result['status'] == "200"){

                                if(result.data['signal'] == "success"){

                                    swal({
                                        title: result.data['message'],
                                        buttonsStyling: false,
                                        confirmButtonClass: "btn btn-success"
                                    }).then(function(){
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
            }

            return false;
        });
    });
</script>
@endsection
