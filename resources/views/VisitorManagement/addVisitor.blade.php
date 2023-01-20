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
                                    <h4 class="card-title">Add Visitor</h4>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Visit Type<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="visitor_type" id="visitor_type" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".typeError">
                                                    <option value="VISITOR">VISITOR</option>
                                                    <option value="SCHEDULED_VISITOR">SCHEDULED VISITOR</option>
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
                                                        <input type="text" class="form-control" name="full_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" required />
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Gender</label>
                                                        <select class="selectpicker" name="visitor_gender" id="visitor_gender" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".genderError">
                                                            <option value="MALE">Male</option>
                                                            <option value="FEMALE">Female</option>
                                                            <option value="OTHER">Other</option>
                                                        </select>
                                                        <div class="genderError"></div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Phone<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="visitor_phone" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" number="true" onblur="this" required />
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Age<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="visitor_age" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="1" maxlength="3" required />
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Address<span class="text-danger">*</span></label>
                                                        <textarea class="form-control" row="3" name="visitor_address" required></textarea>
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
                                                            <option value="STUDENT">Student</option>
                                                            <option value="STAFF">Staff</option>
                                                            <option value="PRINCIPAL">Principal</option>
                                                            <option value="PRESIDENT">President</option>
                                                            <option value="OTHERS">Others</option>
                                                        </select>
                                                        <div class="meetError"></div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 d-none" id="otherPersonDiv">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Other Person Name<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="other_person" id="other_person" autocomplete="off" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" />
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Purpose of visit<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="visit_purpose" required autocomplete="off" />
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Visitor Type<span class="text-danger">*</span></label>
                                                        <select class="selectpicker" name="visitorType" id="visitorType" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".visitorError">
                                                            <option value="PARENT">Parent</option>
                                                            <option value="VENDOR">Vendor</option>
                                                            <option value="OTHERS">Others</option>
                                                        </select>
                                                        <div class="visitorError"></div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 d-none" id="otherTypeDiv">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Other Type<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="other_type" id="other_type" autocomplete="off" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" />
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Meeting Date & Time<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control datetimepicker" name="meeting_date" data-parsley-trigger="change" value="@php echo date('d/m/Y H:i:s'); @endphp" required autocomplete="off" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="pull-right">
                                                <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Submit</button>
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
            }
        });

        $('#visitorForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save visitor
        $('body').delegate('#visitorForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');

            if ($('#visitorForm').parsley().isValid()){

                $.ajax({
                    url: "/visitor",
                    type: "POST",
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

                        if(result['status'] == "200"){

                            if(result.data['signal'] == "success"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function() {
                                    window.location.reload();
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
