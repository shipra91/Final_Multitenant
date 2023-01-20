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
                        <div class="wizard-container">
                            <div class="card wizard-card" data-color="mediumaquamarine" id="wizardProfile">
                                <div class="wizard-header">
                                    <h3 class="wizard-title">Attendance Report</h3>
                                </div>
                                <div class="wizard-navigation">
                                    <ul>
                                        <li> <a href="#monthly" data-toggle="tab">Monthly Report </a></li>
                                        <li> <a href="#absent-report" data-toggle="tab">Daily Absent Report </a> </li>
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane" id="monthly">
                                        <h6 class="text-center fw-500 text-danger">Please fill all the fields before submitting</h6>
                                        <form method="POST" id="monthlyReportForm" action="{{ url('/attendance-report-data') }}" target="print_popup" onsubmit="window.open('about:blank','print_popup','width=1000,height=800');">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Attendance Type<span class="text-danger">*</span></label>
                                                        <select class="selectpicker" name="attendanceType" id="attendanceType" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" data-parsley-errors-container=".typeError">
                                                            <option value="daywise">Daywise</option>
                                                            <option value="sessionwise">Sessionwise</option>
                                                            <option value="periodwise">Periodwise</option>
                                                        </select>
                                                        <div class="typeError"></div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Standard<span class="text-danger">*</span></label>
                                                        <select class="selectpicker" name="standard[]" id="standard" data-size="3" data-style="select-with-transition" data-live-search="true" data-actions-box="true" title="Select" multiple data-parsley-errors-container=".standardError">

                                                        </select>
                                                        <div class="standardError"></div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">From Date<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control datepicker startDate" name="from_date" value="{{ $_REQUEST && $_REQUEST['from_date'] ? $_REQUEST['from_date'] : date('d/m/Y')}}">
                                                    </div>
                                                </div>

                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">To Date<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control datepicker endDate" name="to_date" value="{{ $_REQUEST && $_REQUEST['to_date'] ? $_REQUEST['to_date'] : date('d/m/Y')}}">
                                                    </div>
                                                </div>

                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <button type="submit" name="getAttendanceReport" id="getAttendanceReport" class="btn btn-info">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="tab-pane" id="absent-report">
                                        <h6 class="text-center fw-500 text-danger">Please fill all the fields before submitting</h6>
                                        <form method="POST" id="dailyReportForm" action="{{ url('/absent-report-data') }}" target="print_popup" onsubmit="window.open('about:blank','print_popup','width=1000,height=800');">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Attendance Type<span class="text-danger">*</span></label>
                                                        <select class="selectpicker" name="dailyAattendanceType" id="dailyAattendanceType" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" data-parsley-errors-container=".typeError" required="required">
                                                            <option value="daywise">Daywise</option>
                                                            <option value="sessionwise">Sessionwise</option>
                                                            <option value="periodwise">Periodwise</option>
                                                        </select>
                                                        <div class="typeError"></div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Standard<span class="text-danger">*</span></label>
                                                        <select class="selectpicker" name="standardIds[]" id="standardIds" data-size="3" data-style="select-with-transition" data-live-search="true" data-actions-box="true" title="Select" multiple required="required" data-parsley-errors-container=".standardError">

                                                        </select>
                                                        <div class="standardError"></div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Date<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control datepicker" name="from_date" id="dailyReportFromDate" value="{{ $_REQUEST && $_REQUEST['from_date'] ? $_REQUEST['from_date'] : date('d/m/Y')}}">
                                                    </div>
                                                </div>

                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <button type="submit" name="getAttendanceReport" id="getAttendanceReport" class="btn btn-info">Submit</button>
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

        $("#attendanceType").change(function(event){
            event.preventDefault();

            var attendanceType = $(this).val();

            $.ajax({
                url:"/attendance-standard",
                type:"post",
                data : {attendanceType : attendanceType},
                success:function(result){
                    //console.log(result);
                    var html = '';
                    $.each(result.standardData, function(index, item){
                        html += '<option value="'+item.id_standard+'"'; if(standard == item.id_standard) html +='selected'; html+='>'+item.standard+'</option>';
                    });

                    $("#standard").html(html);
                    $("#standard").selectpicker('refresh');
                }
            });
        });

        $("#dailyAattendanceType").change(function(event){
            event.preventDefault();

            var attendanceType = $(this).val();

            $.ajax({
                url:"/attendance-standard",
                type:"post",
                data : {attendanceType : attendanceType},
                success:function(result){
                    //console.log(result);
                    var html = '';
                    $.each(result.standardData, function(index, item){
                        html += '<option value="'+item.id_standard+'"'; if(standard == item.id_standard) html +='selected'; html+='>'+item.standard+'</option>';
                    });

                    $("#standardIds").html(html);
                    $("#standardIds").selectpicker('refresh');
                }
            });
        });
    });
</script>
@endsection
