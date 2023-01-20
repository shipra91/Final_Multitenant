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
                                <i class="material-icons">assessment</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Edit Attendance Settings</h4>
                                <form method="POST" id="attendanceSettingsFrom">
                                    <div class="row">
                                        <input type="hidden" name="settingsId" id="settingsId" value="{{$selectedSettings->id}}">
                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Attendance Type<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="attendanceType" id="attendanceType" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required">
                                                    <option value="daywise" @if($selectedSettings->attendance_type == "daywise") {{"selected"}} @endif>DAYWISE</option>
                                                    <option value="sessionwise" @if($selectedSettings->attendance_type == "sessionwise") {{"selected"}} @endif>SESSIONWISE</option>
                                                    <option value="periodwise" @if($selectedSettings->attendance_type == "periodwise") {{"selected"}} @endif>PERIODWISE</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0 d-none">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Template</label>
                                                <select class="selectpicker" name="attendanceTemplate" id="attendanceTemplate" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select">
                                                    <option value="1" @if($selectedSettings->id_template == "1") {{"selected"}} @endif>A</option>
                                                    <option value="2" @if($selectedSettings->id_template == "2") {{"selected"}} @endif>B</option>
                                                    <option value="3" @if($selectedSettings->id_template == "3") {{"selected"}} @endif>C</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Display Subject</label>
                                                <select class="selectpicker" name="displaySubject" id="displaySubject" data-style="select-with-transition" title="Select">
                                                    <option value="yes" @if($selectedSettings->display_subject == "yes") {{"selected"}} @endif>YES</option>
                                                    <option value="no" @if($selectedSettings->display_subject == "no") {{"selected"}} @endif>No</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Is subject class timetable dependent</label>
                                                <select class="selectpicker" name="timetableDependent" id="timetableDependent" data-style="select-with-transition" title="Select">
                                                    <option value="yes" @if($selectedSettings->is_subject_classtimetable_dependent == "yes") {{"selected"}} @endif>YES</option>
                                                    <option value="no" @if($selectedSettings->is_subject_classtimetable_dependent == "no") {{"selected"}} @endif>No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group pull-right">
                                                <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Submit</button>
                                                <a href="{{ url('attendance-settings') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
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

        $("#attendanceSettingsFrom").parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Update attendance settings
        $('body').delegate('#attendanceSettingsFrom', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');
            var id = $("#settingsId").val();

            if ($('#attendanceSettingsFrom').parsley().isValid()){

                $.ajax({
                    url:"/attendance-settings/"+id,
                    type:"post",
                    dataType:"json",
                    data: new FormData(this),
                    contentType: false,
                    processData:false,
                    beforeSend:function(){
                        btn.html('Updating...');
                        btn.attr('disabled',true);
                    },
                    success:function(result){
                        // console.log(result);
                        btn.html('Update');
                        btn.attr('disabled',false);

                        if(result['status'] == "200"){

                            if(result.data['signal'] == "success"){
                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function() {
                                    window.location.replace('/attendance-settings');
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
