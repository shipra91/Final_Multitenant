@php

@endphp

@extends('layouts.master')

@section('content')
    <nav class="navbar navbar-primary navbar-transparent navbar-absolute">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href=" # ">
                    @if($domainDetail == 'error')
                        @php 
                            $logo = "http://egenius-s3.s3.ap-south-1.amazonaws.com/MDES/INSTITUTION_DETAILS/10330251001653397178.png";
                            $name = "eGenius";
                            $domainId = '';
                            $domainInstitutionId = '';
                        @endphp                        
                    @else
                        @php 
                            $logo = $domainDetail->logo;
                            $name = $domainDetail->name;
                            $domainId = $domainDetail->id;
                            $domainInstitutionId = $domainDetail->institution_id;
                        @endphp
                    @endif
                    <img class="logo-alt" style="width:140px" src="{{ $logo }}" alt="logo">
                </a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-left" style="margin-top:18px;font-weight:900;font-size:28px;">
                    <p style="margin-top:10px;">{{ $name }}</p> 		
                </ul>
            </div>
        </div>
    </nav>

    <div class="wrapper wrapper-full-page">
        <div class="full-page login-page" filter-color="black" data-image="//cdn.egenius.in/img/image3.jpg" style="width:auto;height:100%;">
            <div class="content">
                <div class="container">
                    <div class="row" style="margin-top:80px;">
                        <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">

                            <div class="card card-login card-hidden">
                                <div class="card-header text-center" data-background-color="mediumaquamarine">
                                    <h4 class="card-title">Login</h4>
                                    <input type="hidden" name="id_organization" value={{ $domainId }} />
                                    <input type="hidden" name="id_institution" value={{ $domainInstitutionId }} />
                                </div>

                                <div class="card-content">
                                    <form class="" id="otpForm" method="POST">
                                        @csrf
                                        <div class="row">

                                            <div class="col-lg-12" id="mobileDiv">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Mobile</label>
                                                        <input type="text" name="mobile" id="mobile" class="form-control" autocomplete="off" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" number="true" onblur="this" required/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 d-none" id="otpDiv">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">lock_outline</i>
                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">OTP</label>
                                                        <input type="password" name="otp" id="otp" class="form-control" autocomplete="off" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="6" maxlength="6" number="true" onblur="this">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 text-center">
                                                <button type="button" id="requestOTP" class="btn btn-warning btn-simple btn-wd btn-lg">REQUEST OTP</button>
                                                <button type="submit" id="submitOTP" class="btn btn-warning btn-simple btn-wd btn-lg d-none">SUBMIT</button>
                                            </div>
                                        </div>
                                    </form>

                                    <form class="d-none" id="mPINForm" method="POST" action="{{ url('/mPINRegistration') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-12" id="mPINDiv">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">lock_outline</i>
                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">mPIN</label>
                                                        <input type="password" name="password" id="mPIN" class="form-control" autocomplete="off"  onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="4" maxlength="4" number="true" onblur="this" required>
                                                        <input type="hidden" name="username" id="phone" value="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12" id="mPINDiv">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">lock_outline</i>
                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Re-enter mPIN</label>
                                                        <input type="password" name="confirm_password" id="confirm_mPIN" class="form-control" autocomplete="off" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="4" maxlength="4" number="true" onblur="this" data-parsley-equalto="#mPIN" data-parsley-required-message="Please re-enter your password." data-parsley-trigger="focusin keyup" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 text-center">
                                                <button type="submit" id="submit" class="btn btn-warning btn-simple btn-wd btn-lg">SUBMIT</button>
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

    demo.checkFullPageBackgroundImage();
    setTimeout(function() {
        $('.card').removeClass('card-hidden');
    }, 600)

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#requestOTP").click(function(event){
        event.preventDefault();

        var btn = $(this);
        $('#otpForm').parsley().validate();
        var mobile = $("#mobile").val(); //alert(mobile);

        $.ajax({
            url: "/getOTP",
            type: "post",
            dataType: "json",
            data: {mobile : mobile},
            beforeSend: function() {
                btn.html('Processing...');
                btn.attr('disabled', true);
            },
            success: function(result) {
                console.log(result);

                if(result['signal'] == "success" || result['signal'] == "data_exist"){

                    $("#otpDiv").removeClass('d-none');
                    $("#otp").attr('required', true);
                    btn.addClass('d-none');
                    $("#mobileDiv").addClass('d-none');
                    $('#submitOTP').removeClass('d-none');

                    swal({
                        title: "OTP is successfully sent to "+ mobile,
                        buttonsStyling: false,
                        confirmButtonClass: "btn btn-success"
                    });

                }else if(result['signal'] == "already_loggedin"){

                    swal({
                        title: "You have already set your mPIN, mPIN is sent to your number",
                        buttonsStyling: false,
                        confirmButtonClass: "btn btn-success"
                    }).then(function() {
                        window.location.replace('/');
                    }).catch(swal.noop)

                }else{

                    swal({
                        title: "This number does not exist with us",
                        buttonsStyling: false,
                        confirmButtonClass: "btn btn-success"
                    }).then(function() {
                        window.location.reload();
                    }).catch(swal.noop)
                }
            }
        });
    });

    $("#otpForm").submit(function(event){
        event.preventDefault();

        var btn = $("#submitOTP");
        var mobile = $("#mobile").val();

        if ($('#otpForm').parsley().isValid()) {

            $.ajax({
                url: "/loginWithOTP",
                type: "post",
                dataType: "json",
                data: new FormData(this),
                contentType: false,
                processData: false,
                beforeSend: function() {
                    btn.html('Validating...');
                    btn.attr('disabled', true);
                },
                success: function(result) {
                    console.log(result);
                    btn.html('SUBMIT');
                    btn.attr('disabled', false);

                    if(result['signal'] == "success" || result['signal'] == "data_exist"){

                        swal({
                            title: result['msg'],
                            buttonsStyling: false,
                            confirmButtonClass: "btn btn-success"
                        }).then(function() {
                            $("#phone").val(mobile);
                            $("#mPINForm").removeClass('d-none');
                            $("#otpForm").addClass('d-none');
                            $('#mPINForm').parsley();
                        }).catch(swal.noop)

                    }else{

                        swal({
                            title: result['msg'],
                            buttonsStyling: false,
                            confirmButtonClass: "btn btn-success"
                        });
                    }
                }
            });
        }
    });

});
</script>
@endsection
