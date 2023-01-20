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
                    <form method="POST" class="demo-form" id="visitorForm">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">face</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Edit Visitor</h4>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Visit Type<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="visitor_type" id="visitor_type" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".typeError">
                                                    <option value="VISITOR" @if($visitorData->type === 'VISITOR') {{ "SELECTED" }} @endif>VISITOR</option>
                                                    <option value="SCHEDULED_VISITOR" @if($visitorData->type === 'SCHEDULED_VISITOR') {{ "SELECTED" }} @endif>SCHEDULED VISITOR</option>
                                                </select>
                                                <div class="typeError"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-20">
                                        <div class="col-lg-6">
                                            <h6 class="fw-500 text-capitalize">Visitor Detail</h6>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Full Name<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="full_name" value="{{ $visitorData->visitor_name }}" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" required />
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Gender</label>
                                                        <select class="selectpicker" name="visitor_gender" id="visitor_gender" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".genderError">
                                                            <option value="MALE" @if($visitorData->gender === 'MALE') {{ "SELECTED" }} @endif>Male</option>
                                                            <option value="FEMALE" @if($visitorData->gender === 'FEMALE') {{ "SELECTED" }} @endif>Female</option>
                                                            <option value="OTHER" @if($visitorData->gender === 'OTHER') {{ "SELECTED" }} @endif>Other</option>
                                                        </select>
                                                        <div class="genderError"></div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Phone<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="visitor_phone" value="{{ $visitorData->visitor_contact }}" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" number="true" onblur="this" required />
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Age<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="visitor_age" value="{{ $visitorData->visitor_age }}" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="1" maxlength="3" required />
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Address<span class="text-danger">*</span></label>
                                                        <textarea class="form-control" row="3" name="visitor_address" required>{{ $visitorData->visitor_address }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <h6 class="fw-500 text-capitalize">Meeting Detail</h6>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Person To Meet<span class="text-danger">*</span></label>
                                                        <select class="selectpicker" name="person_to_meet" id="person_to_meet" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".meetError">
                                                            <option value="STUDENT" @if($visitorData->person_to_meet === 'STUDENT') {{ "SELECTED" }} @endif>Student</option>
                                                            <option value="STAFF" @if($visitorData->person_to_meet === 'STAFF') {{ "SELECTED" }} @endif>Staff</option>
                                                            <option value="PRINCIPAL" @if($visitorData->person_to_meet === 'PRINCIPAL') {{ "SELECTED" }} @endif>Principal</option>
                                                            <option value="PRESIDENT" @if($visitorData->person_to_meet === 'PRESIDENT') {{ "SELECTED" }} @endif>President</option>
                                                            <option value="OTHERS" @if($visitorData->person_to_meet === 'OTHERS') {{ "SELECTED" }} @endif>Others</option>
                                                        </select>
                                                        <div class="meetError"></div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 @if($visitorData->person_to_meet !== 'OTHERS') {{ 'd-none' }} @endif" id="otherPersonDiv">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Other Person Name<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="other_person" id="other_person" value="{{ $visitorData->concerned_person }}" autocomplete="off" />
                                                        <input type="hidden" name="visitorId" id="visitorId" value="{{ $visitorData->id }}" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" />
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Purpose of visit<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="visit_purpose" required  value="{{ $visitorData->visit_purpose }}" autocomplete="off" />
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Visitor Type <span class="text-danger">*</span></label>
                                                        <select class="selectpicker" name="visitorType" id="visitorType" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".visitorError">
                                                            <option value="PARENT" @if($visitorData->visitor_type === 'PARENT') {{ "SELECTED" }} @endif>Parent</option>
                                                            <option value="VENDOR" @if($visitorData->visitor_type === 'VENDOR') {{ "SELECTED" }} @endif>Vendor</option>
                                                            <option value="OTHERS" @if($visitorData->visitor_type === 'OTHERS') {{ "SELECTED" }} @endif>Others</option>
                                                        </select>
                                                        <div class="visitorError"></div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 @if($visitorData->visitor_type !== 'OTHERS') {{ 'd-none' }} @endif" id="otherTypeDiv">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Other Type <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="other_type" id="other_type" value="{{ $visitorData->visitor_type_name }}" autocomplete="off" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" />
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Meeting Date & Time<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control datetimepicker" name="meeting_date" data-parsley-trigger="change" value="{{ $visitorData->startTime }}" required autocomplete="off" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="pull-right">
                                                <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Update</button>
                                                <a href="{{ url('visitor') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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

        // Show and hide visitor
        $('#person_to_meet').on('change', function(){

            var person_to_meet = $(this).val();

            if(person_to_meet === "OTHERS"){
                $("#otherPersonDiv").removeClass('d-none');
                $("#other_person").attr('required', true);
            }else{
                $("#otherPersonDiv").addClass('d-none');
                $("#other_person").attr('required', false);
                $("#other_person").val('');
            }
        });

        // Show and hide visitor type
        $('#visitorType').on('change', function(){

            var visitorType = $(this).val();

            if(visitorType === "OTHERS"){
                $("#otherTypeDiv").removeClass('d-none');
                $("#other_type").attr('required', true);
            }else{
                $("#otherTypeDiv").addClass('d-none');
                $("#other_type").attr('required', false);
                $("#other_type").val('');
            }
        });

        $('#visitorForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Update visitor
        $('body').delegate('#visitorForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');
            var visitorId = $("#visitorId").val();

            if ($('#visitorForm').parsley().isValid()){

                $.ajax({
                    url: "/visitor/"+visitorId,
                    type: "POST",
                    dataType: "json",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        btn.html('Updating...');
                        btn.attr('disabled', true);
                    },
                    success: function(result){
                        btn.html('Update');
                        btn.attr('disabled', false);

                        if(result['status'] == "200"){

                            if(result.data['signal'] == "success"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function() {
                                    window.location.replace('/visitor');
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

                        }else {

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
