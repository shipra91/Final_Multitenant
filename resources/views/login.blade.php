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
                                    <form id="loginForm" method="POST">
                                        @csrf
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Mobile</label>
                                                        <input type="text" name="username" id="username" class="form-control" autocomplete="off" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" number="true" onblur="this" required/>
                                                    </div>
                                                </div>    
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">lock_outline</i>
                                                    </span>
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">mPIN</label>
                                                        <input type="password" name="password" id="password" class="form-control" autocomplete="off"  onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="4" maxlength="4" number="true" onblur="this" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 text-center">
                                                <button type="submit" id="login" class="btn btn-warning btn-simple btn-wd btn-lg">LOGIN</button>
                                                <p class="text-danger">New User ? <a href="{{ route('registration') }}">Click Here</a></p>
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
    
    // $("#loginForm").parsley();

    $("#loginForm").submit(function(event){
        event.preventDefault();

        var btn = $("#login");

        if ($('#loginForm').parsley().isValid()) {
            
            $.ajax({
                url: "/",
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
                    // return false;
                    btn.html('SUBMIT');
                    btn.attr('disabled', false);

                    if(result['signal'] == "success"){

                        swal({
                            title: result['msg'],
                            buttonsStyling: false,
                            confirmButtonClass: "btn btn-success"
                        }).then(function() {
                            window.location.replace('/dashboard');
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