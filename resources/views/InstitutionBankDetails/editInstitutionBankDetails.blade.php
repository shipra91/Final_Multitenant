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
                                <i class="material-icons">school</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Edit Bank Details</h4>
                                <form method="POST" id="institutionBankDetailsForm">
                                    <div class="row">
                                        <input type="hidden" name ="bank_details_id" id ="bank_details_id" value ="{{$institutionBankDetails->id}}">

                                        <div class="col-lg-6 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Bank Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="bank_name" id="bank_name" value ="{{$institutionBankDetails->bank_name}}" required />
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Branch Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="branch_name" id="branch_name" value ="{{$institutionBankDetails->branch_name}}" required />
                                        </div>
                                        </div><div class="col-lg-6 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Account Number<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="account_number" id="account_number" value ="{{$institutionBankDetails->account_number}}" required />
                                            </div>
                                        </div><div class="col-lg-6 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">IFSC Code<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="ifsc_code" id="ifsc_code" value ="{{$institutionBankDetails->ifsc_code}}" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-lg-offset-0 text-right">
                                            <div class="form-group">
                                                <button type="submit" id="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5">Update</button>
                                                <a href="{{ url('/institution-bank-details') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
                                            </div>
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

        $("#institutionBankDetailsForm").parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Update department
        $('body').delegate('#institutionBankDetailsForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');
            var id = $("#bank_details_id").val();

            if ($('#institutionBankDetailsForm').parsley().isValid()){

                $.ajax({
                    url:"/institution-bank-details/"+id,
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
                                }).then(function(){
                                    window.location.replace('/institution-bank-details');
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
