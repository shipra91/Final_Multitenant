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
                    <div class="col-sm-12 col-sm-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">query_builder</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Add Period</h4>
                                <form method="POST" id="periodFrom">
                                    <div class="row">
                                        <input type="hidden" name="idInstitute" value="{{session()->get('institutionId')}}">
                                        <input type="hidden" name="idAcademic" value="{{session()->get('academicYear')}}">

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Period Label<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="periodName" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Period Type<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="periodType" id="periodType" data-style="select-with-transition" title="Select" required="required">
                                                    <option value="teaching">Teaching Period</option>
                                                    <option value="break">Break</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Priority<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" min='1' max="10" name="priority" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Submit</button>
                                                <button onclick="window.history.go(-1)" class="btn btn-danger">Close</button>
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

        $("#periodFrom").parsley({
	        triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save period
        $('body').delegate('#periodFrom', 'submit', function(e){
            e.preventDefault();

            var btn=$('#submit');

            if ($('#periodFrom').parsley().isValid()){

                $.ajax({
                    url:"/period",
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
                        btn.html('Submit');
                        btn.attr('disabled',false);

                        if(result['status'] == "200"){

                            if(result.data['signal'] == "success"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function() {
                                    window.location.replace('/period');
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
