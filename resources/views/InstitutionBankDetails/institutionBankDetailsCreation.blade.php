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
                                <h4 class="card-title">Add Bank Details</h4>
                                <form method="POST" id="institutionBankDetailsForm" action="#">                                    
                                        
                                    <input type="hidden" name="id_academic" value="{{session()->get('academicYear')}}">
                                    <input type="hidden" name="id_institute" value="{{session()->get('institutionId')}}">
                                    <input type="hidden" name="organization" value="{{session()->get('organizationId')}}">
                                        
                                    <div id="repeater">
                                        <input type="hidden" name="totalCount" id="totalCount" value="1">
                                        <div class="row" id="section_1" data-id="1">

                                            <div class="col-lg-6 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Bank Name<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="bank_name[]" id="bank_name" required />
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Branch Name<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="branch_name[]" id="branch_name" required />
                                            </div>
                                            </div><div class="col-lg-6 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Account Number<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="account_number[]" id="account_number" required />
                                                </div>
                                            </div><div class="col-lg-5 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">IFSC Code<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="ifsc_code[]" id="ifsc_code" required />
                                                </div>
                                            </div>

                                           <div class="col-lg-1 col-lg-offset-0 text-right">
                                                <button type="button" id="1" class="btn btn-danger btn-sm remove_button mt-30"><i class="material-icons">highlight_off</i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-lg-offset-0 form-group">
                                        <button id="add_more" type="button" class="btn btn-warning btn-sm"><i class="material-icons">add_circle_outline</i> Add</button>
                                    </div>

                                    <div class="row pull-right">
                                        <div class="col-lg-12 col-lg-offset-0 form-group">
                                            <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Submit</button>
                                            <a href="{{url('/institution-bank-details')}}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
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

        // Add More Fee Heading
        var count = $('#totalCount').val();

        $(document).on('click', '#add_more', function(){

            var html = '';
            count++;

            html += '<div class="row" id="section_'+count+'" data-id="'+count+'">';
            html += '<div class="col-lg-6 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Bank Name<span class="text-danger">*</span></label>';
            html += '<input type="text" class="form-control" name="bank_name[]" id="bank_name" required />';
            html += '</div>';
            html += '</div>';
            html += '<div class="col-lg-6 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Branch Name<span class="text-danger">*</span></label>';
            html += '<input type="text" class="form-control" name="branch_name[]" id="branch_name" required />';
            html += '</div>';
            html += '</div><div class="col-lg-6 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Account Number<span class="text-danger">*</span></label>';
            html += '<input type="text" class="form-control" name="account_number[]" id="account_number" required />';
            html += '</div>';
            html += '</div>';
            html += '<div class="col-lg-5 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">IFSC Code<span class="text-danger">*</span></label>';
            html += '<input type="text" class="form-control" name="ifsc_code[]" id="ifsc_code" required />';
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

        // Remove Fee Heading
        $(document).on('click', '.remove_button', function(event){
            event.preventDefault();

            var id = $(this).attr('id');//alert(id);
            console.log(id);
            var totalCount = $('#repeater tr:last').attr('id');

            $(this).closest('div #section_'+id+'').remove();
            totalCount--;
        });

        $("#institutionBankDetailsForm").parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save fee heading
        $('body').delegate('#institutionBankDetailsForm', 'submit', function(e){
            e.preventDefault();

            var btn=$('#submit');

            if ($('#institutionBankDetailsForm').parsley().isValid()){

                $.ajax({
                    url:"institution-bank-details",
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
                                }).then(function(){
                                    window.location.replace('institution-bank-details');
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
