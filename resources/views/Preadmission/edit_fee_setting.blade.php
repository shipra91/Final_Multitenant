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
                    <div class="col-sm-12 col-sm-offset-0 text-right">
                        <a href="{{ url('preadmission-fee') }}" type="button" class="btn btn-info">Back</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-md-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">class</i>
                            </div>
                            <div class="card-content">
                                   <h4 class="card-title">Edit Fee Setting</h4>
                                   <form method="POST" id="applicationSettingForm" enctype="multipart/form-data">
                                        <input type="hidden" name="id_institute" value="{{session()->get('institutionId')}}">
                                        <input type="hidden" name="id_academic" value="{{session()->get('academicYear')}}">
                                        <input type="hidden" id="id_fee_setting" value="{{$selectedFeeSetting->id}}">

                                        <div class="row">

                                            <div class="form-group col-lg-6">
                                                <label class="control-label">Application Name</label>
                                                <input type="text" class="form-control" value="{{$selectedFeeSetting->application_name}}" readonly>
                                                <input type="hidden" class="form-control" name="application_id" value="{{$selectedFeeSetting->id_application_setting}}">
                                            </div> 

                                            <div class="form-group col-lg-6">
                                                <label class="control-label">Select Standards</label>
                                                <input type="text" class="form-control" value="{{$selectedFeeSetting->standard_name}}" readonly>
                                                <input type="hidden" class="form-control" name="standard_id" value="{{$selectedFeeSetting->id_standard}}">
                                            </div> 
                                            
                                            <div class="form-group col-lg-4">
                                                <label class="control-label">Application Fee Amount</label>
                                                <input name="fee_amount" type="text" class="form-control" value="{{$selectedFeeSetting->fee_amount}}" required>
                                            </div> 
                                            
                                            <div class="form-group col-lg-4">
                                                <label class="control-label">Receipt Prefix</label>
                                                <input name="receipt_prefix" type="text" class="form-control" value="{{$selectedFeeSetting->receipt_prefix}}" required>
                                            </div> 
                                            
                                            <div class="form-group col-lg-4">
                                                <label class="control-label">Receipt Starting Number</label>
                                                <input name="receipt_starting_number" type="text" class="form-control" value="{{$selectedFeeSetting->receipt_starting_number}}" required>
                                            </div> 
                                        </div>

                                        <div class="wizard-footer">
                                            <div class="pull-right">
                                                <button type='submit' class='btn btn-finish btn-fill btn-info btn-wd' id="submit">Submit</button>
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
</div>       
@endsection
  
@section('script-content')
<script>
$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('body').delegate('#applicationSettingForm', 'submit', function(e) { 
        e.preventDefault();

        var btn=$('#submit');
        var id = $("#id_fee_setting").val();
        
        $.ajax({
            url:"{{ url('/preadmission-fee') }}/"+id,  
            type:"post", 
            dataType:"json",
            data: new FormData(this), 
            contentType: false,
            processData:false, 
            beforeSend:function() { 
                btn.html('Submitting...'); 
                btn.attr('disabled',true);
            },   
            success:function(result) {
                console.log(result);
                btn.html('Submit'); 
                btn.attr('disabled',false);

                if(result['status'] == "200"){
                    if(result.data['signal'] == "success") { 
                        swal({
                            title: result.data['message'],
                            buttonsStyling: false,
                            confirmButtonClass: "btn btn-success"
                        }).then(function() {
                            window.location.replace('/preadmission-fee');
                        }).catch(swal.noop)

                    }else if(result.data['signal'] == "exist") { 

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
    });

});
</script>
@endsection    