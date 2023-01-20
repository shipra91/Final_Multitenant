@php

@endphp

@extends('layouts.master')

@section('content')
<nav class="navbar navbar-primary navbar-transparent navbar-absolute">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">
                <img class="logo-alt" style="width:60px" src="http://egenius-s3.s3.ap-south-1.amazonaws.com/MDES/INSTITUTION_DETAILS/10330251001653397178.png" alt="logo">
            </a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-left" style="margin-top:10px;font-weight:900;font-size:28px;">
			    <p style="margin-top:10px;">eGenius</p>
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
                        <form id="loginForm" method="POST">
                            @csrf
                            <div class="card card-login card-hidden">
                                <div class="card-header text-center" data-background-color="mediumaquamarine">
                                    <h4 class="card-title mb-0 p2">Sign Up</h4>
                                </div>
                                <div class="card-content">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">person_outline</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Employee Id <span class="text-danger">*</span></label>
                                            <input type="text" name="emp_id" class="form-control" autocomplete="off" required/>
                                        </div>
                                    </div>

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">person_outline</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" name="fullname" class="form-control" autocomplete="off"onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" required/>
                                        </div>
                                    </div>

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">person_outline</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Contact <span class="text-danger">*</span></label>
                                            <input type="text" name="mobile" class="form-control" autocomplete="off" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" number="true" required/>
                                        </div>
                                    </div>

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">person_outline</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" class="form-control" autocomplete="off" required/>
                                        </div>
                                    </div>

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">lock_outline</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Password <span class="text-danger">*</span></label>
                                            <input type="password" name="password" id="password" class="form-control" autocomplete="off" minlength="6" data-parsley-minlength="6" required>
                                        </div>
                                    </div>

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">lock_outline</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Confirm Password <span class="text-danger">*</span></label>
                                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" autocomplete="off" data-parsley-equalto="#password" data-parsley-required-message="Please re-enter your password." data-parsley-trigger="focusin keyup" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer row">
                                    <button type="submit" id="submit" class="btn btn-warning btn-simple btn-wd btn-lg">SignUp</button>
                                    <a href="/etpl/login" type="button" id="submit" class="btn btn-warning btn-simple btn-wd btn-lg">SignIn</a>
                                </div>
                            </div>
                        </form>
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

        demo.checkFullPageBackgroundImage();
        setTimeout(function() {
            $('.card').removeClass('card-hidden');
        }, 600)

        $('#loginForm').parsley({
            triggerAfterFailure: 'input keyup change focusout changed.bs.select'
        });

        // Save registration form
        $('body').delegate('#loginForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');

            if ($('#loginForm').parsley().isValid()){

                $.ajax({
                    url: "/etpl/custom-registration",
                    type: "post",
                    dataType: "json",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        btn.html('Submitting...');
                        btn.attr('disabled', true);
                    },
                    success: function(result){
                        btn.html('Submit');
                        btn.attr('disabled', false);

                        if (result['status'] == "200"){

                            if(result.data['signal'] == "success"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function() {
                                    location.replace('/etpl/login');
                                }).catch(swal.noop)

                            }else if (result.data['signal'] == "exist"){

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

