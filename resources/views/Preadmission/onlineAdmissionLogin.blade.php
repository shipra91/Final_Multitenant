@php 

@endphp

@extends('layouts.master')

@section('content')
    <nav class="navbar navbar-primary navbar-transparent navbar-absolute">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="javascript:void(0);">
                    <img class="logo-alt" style="width:140px" src="{{ $domainDetail->logo }}" alt="logo">
                </a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-left" style="margin-top:18px;font-weight:900;font-size:28px;">
				    <p style="margin-top:10px;">{{ $domainDetail->name }}</p> 				
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
                            <form id="loginForm" method="GET" action="{{ url('online-admission-form') }}">
                                @csrf
                                <div class="card card-login card-hidden">
                                    <div class="card-header text-center" data-background-color="mediumaquamarine">
                                        <h4 class="card-title">Login</h4>
                                    </div>
                                  
                                    <div class="card-content">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">person</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Phone Number</label>
                                                <input type="text" name="phone_number" class="form-control" maxlength="10" minlength="10" autocomplete="off" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required/>
                                                <input type="hidden" name="id_organization" value={{ $domainDetail->id }} />
                                                <input type="hidden" name="id_institution" value={{ $domainDetail->institution_id }} />
                                            </div>
                                        </div>                              
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Student First Name</label>
                                                <input type="text" name="student_first_name" class="form-control" autocomplete="off" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer text-center">
                                        <button type="submit" id="submit" class="btn btn-warning btn-simple btn-wd btn-lg">Let's go</button>
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

    demo.checkFullPageBackgroundImage();
    setTimeout(function() {
        $('.card').removeClass('card-hidden');
    }, 600)

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
});
</script>
@endsection   