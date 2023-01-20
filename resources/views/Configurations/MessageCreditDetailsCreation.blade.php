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
                                <i class="material-icons">email</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Add Credit</h4>
                                <form method="GET" action="{{ url('/etpl/message-credit-details-create') }}" id="getMessageCredit">
                                    <div class="row">
                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Institute<span class="text-danger">*</span></label>
                                                <select name="institution"  id="institution" class="selectpicker" data-live-search="true" data-style="select-with-transition" data-size="5" required title="Select">
                                                    @foreach($institutionDetails as $institution)
                                                    <option value="{{$institution['id']}}" @if($_REQUEST && $_REQUEST['institution'] == $institution['id'] )  {{ 'selected'}} @endif >{{$institution['instituteName']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-lg-offset-0">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5">Submit</button>
                                                <a href="{{url('/etpl/message-credit-details')}}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @if($messageCreditDetails['institution'])
                    <div class="row">
                        <form method="POST" id="messageCreditForm">
                            <input type="hidden" name="institutionId" value ="{{$messageCreditDetails['institution']}}">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                        <i class="material-icons">email</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Add Message Credit Details</h4>
                                        <div class="row">
                                            <div class="col-lg-4 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label">Number Of Credits<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="number_of_credits" id="number_of_credits" required />
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label">Credit Type<span class="text-danger">*</span></label>
                                                    <select class="selectpicker credit_type" name="credit_type" id="credit_type" data-size="5" data-style="select-with-transition" data-live-search="true" required="required" title="select">
                                                        <option value="AS_PER_PO">AS PER PO</option>
                                                        <option value="PAID">PAID</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row d-none" id='paid_details'>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="control-label">Amount Received On</label>
                                                    <input type="text" class="form-control datepicker" name="received_on" id="received_on" />
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="control-label">Received Amount</label>
                                                    <input type="text" class="form-control" name="amount" id="amount" />
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="control-label">Transaction ID</label>
                                                    <input type="text" class="form-control" name="transaction_id" id="transaction_id" />
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="control-label">Narration</label>
                                                    <input type="text" class="form-control" name="narration" id="narration" />
                                                </div>
                                            </div>
                                        </div>

                                        {{-- <div class="row">
                                            <div class="col-lg-12 text-right">
                                                <button type="submit" class="btn btn-info" name="submit" id="submit" value="submit">Submit</button>
                                                <a type='button' class='btn btn-finish btn-fill btn-danger btn-wd' href="{{url('message-credit-details')}}">Close</a>
                                            </div>
                                        </div> --}}

                                        <div class="row pull-right">
                                            <div class="col-lg-12 col-lg-offset-0 form-group">
                                                <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Submit</button>
                                                <a href="{{url('/etpl/message-credit-details')}}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
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

        $('#credit_type').on('change', function(){

            var creditType = $(this).val();

            if(creditType == "PAID"){
                $('#paid_details').removeClass('d-none');
            }else{
                $('#paid_details').addClass('d-none');
            }
        });

        $("#messageCreditForm, #getMessageCredit").parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save message credit details
        $('body').delegate('#messageCreditForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');

            if ($('#messageCreditForm').parsley().isValid()){

                $.ajax({
                    url:"/etpl/message-credit-details",
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
                        // console.log(result);
                        btn.html('Submit');
                        btn.attr('disabled',false);

                        if(result['status'] == "200"){

                            if(result.data['signal'] == "success"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function(){
                                    window.location.replace('/etpl/message-credit-details');
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
