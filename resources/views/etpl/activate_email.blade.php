@php 

@endphp

@extends('layouts.master')

@section('content')

    <div class="wrapper wrapper-full-page">
        <div class="full-page login-page" filter-color="black" data-image="//cdn.egenius.in/img/image3.jpg" style="width:auto;height:100%;">
            <div class="content">
                <div class="container">
                    <div class="row" style="margin-top:80px;">
                        <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                            <form id="activationForm" method="POST">
                                @csrf
                                <div class="card card-login card-hidden">
                                    <div class="card-header text-center" data-background-color="mediumaquamarine">
                                        <h4 class="card-title">Activate Email</h4>
                                    </div>
                                  
                                    <div class="card-content">

                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">person</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Email</label>
                                                <input type="email" name="email" class="form-control" autocomplete="off" required/>
                                            </div>
                                        </div>   

                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Password</label>
                                                <input type="password" name="password" class="form-control" autocomplete="off" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer row">
                                        <div class="col-md-12 text-center">
                                            <button type="submit" id="submit" class="btn btn-warning btn-wd btn-sm">Activate</button>
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

    $('#activationForm').parsley({
        triggerAfterFailure: 'input keyup change focusout changed.bs.select'
    });

    $('body').delegate('#activationForm', 'submit', function(e) {
        e.preventDefault();

        var btn = $('#submit');
        if ($('#activationForm').parsley().isValid()) {

            $.ajax({
                url: "/etpl/emailActivation",
                type: "post",
                dataType: "json",
                data: new FormData(this),
                contentType: false,
                processData: false,
                beforeSend: function() {
                    btn.html('Submitting...');
                    btn.attr('disabled', true);
                },
                success: function(result) {
                    btn.html('Submit');
                    btn.attr('disabled', false);

                    if (result['status'] == "200") {

                        if (result.data['signal'] == "success") {

                            swal({
                                title: result.data['message'],
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-success"
                            }).then(function() {
                                location.replace('/etpl/login');
                            }).catch(swal.noop)

                        } else if (result.data['signal'] == "exist") {

                            swal({
                                title: result.data['message'],
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-warning"
                            });

                        } else {

                            swal({
                                title: result.data['message'],
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-danger"
                            });
                        }

                    } else {

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