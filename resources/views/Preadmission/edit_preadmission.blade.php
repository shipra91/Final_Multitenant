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
                                <i class="material-icons">class</i>
                            </div>
                            <div class="card-content">
                                   <h4 class="card-title">Edit Application Setting</h4>
                                   <form method="POST" id="applicationSettingForm" enctype="multipart/form-data">
                                        <input type="hidden" name="id_institute" value="{{session()->get('institutionId')}}">
                                        <input type="hidden" name="id_academic" value="{{session()->get('academicYear')}}">
                                        <input type="hidden" id="setting_id" value="{{$preadmissionData->id}}">

                                        <div class="row">

                                            <div class="form-group col-lg-6">
                                                <label class="control-label">Application Name</label>
                                                <input name="application_name" type="text" class="form-control" value="{{$preadmissionData->name}}" required>
                                            </div> 
                                            
                                            <div class="form-group col-lg-6">
                                                <label class="control-label">Application Number Prefix</label>
                                                <input name="application_prefix" type="text" class="form-control" value="{{$preadmissionData->prefix}}" required>
                                            </div> 
                                            
                                            <div class="form-group col-lg-6">
                                                <label class="control-label">Application Starting Number</label>
                                                <input name="application_starting_number" type="text" class="form-control" value="{{$preadmissionData->starting_number}}" required>
                                            </div> 

                                            <div class="form-group col-lg-6">
                                                <label class="control-label">Select Standards</label>
                                                <select name="standards[]" class="selectpicker" data-style="select-with-transition" multiple data-size="3" class="form-control" title="Select Standards" data-live-search="true" data-actions-box="true" required>
                                                    @foreach($allStandard as $standard)
                                                    <option value="{{$standard['institutionStandard_id']}}" @if(in_array($standard["institutionStandard_id"], explode(",",$preadmissionData->standards))) {{"selected"}} @endif>{{$standard['class']}}</option>
                                                    @endforeach
                                                </select>
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

        var btn = $('#submit');
        var id = $("#setting_id").val();
        
        $.ajax({
            url:"/application-setting/"+id,  
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
                            window.location.replace('/application-setting');
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