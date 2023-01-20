<?php 
    use Carbon\Carbon;
?>
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
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">local_library</i>
                            </div>
                            <form method="GET" class="demo-form" action="{{ url('get-exam-timetable') }}">

                                <div class="card-content">
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">view_headline</i>
                                            </span>
                                            <div class="form-group">
                                                <label class="control-label">Class<span
                                                        class="text-danger">*</span></label>
                                                <select name="exam" id="exam" class="selectpicker"
                                                    data-live-search="true" data-style="select-with-transition"
                                                    data-size="5" required title="Select Exam"
                                                    data-parsley-errors-container=".examError">
                                                    @foreach($examDetails as $exam)
                                                    <option value="{{$exam['id']}}" @if($_REQUEST &&
                                                        $_REQUEST['exam']==$exam['id']) {{ 'selected'}} @endif>
                                                        {{$exam['exam_name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 label-floating" style="margin-top:-12px;">
                                        <select name="timetable_type" id="timetable_type" class="selectpicker"
                                            data-live-search="true" data-style="select-with-transition" data-size="5"
                                            required title="Select Timetable Type">
                                            <option value="classwise" @if($_REQUEST &&
                                                $_REQUEST['timetable_type']=='classwise' ) {{ 'selected'}} @endif>
                                                CLASSWISE</option>
                                            <option value="subjectwise" @if($_REQUEST &&
                                                $_REQUEST['timetable_type']=='subjectwise' ) {{ 'selected'}} @endif>
                                                SUBJECTWISE</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-3 label-floating" style="margin-top:-12px;" id="idStandard">
                                        <select name="standard[]" id="standard" class="selectpicker"
                                            data-live-search="true" data-style="select-with-transition" data-size="5"
                                            required title="Select Standard" multiple data-actions-box="true">
                                            @if(count($examStandardDetails['standard_details'])>0)
                                            @foreach($examStandardDetails['standard_details'] as $details)
                                            <option value={{$details['id']}} @if($_REQUEST && in_array(
                                                $details['id'],$_REQUEST['standard'] )) {{ 'selected'}} @endif>
                                                {{$details['label']}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-fill btn-info pull-left btn-sm"
                                    style="margin-top: -19px;" name="submit" value="submit">Submit</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            @if(sizeof($examTimetableDetails)>0)
            <div class="row" mt-20>
                <form method="POST" id="examTimetableForm">
                    <div class="col-lg-12">
                        <div class="card">
                            @foreach($examTimetableDetails as $key => $details)
                            <input type="hidden" name="id_exam" value="{{$details['exam_detail']['exam']}}">
                            <input type="hidden" name="timetable_type"
                                value="{{$details['exam_detail']['timetable_type']}}">
                            <input type="hidden" name="standard_id" value="{{$details['exam_detail']['standard_id']}}">
                            <input type="hidden" id="from_date"
                                value="{{Carbon::createFromFormat('d/m/Y', $details['exam_detail']['from_date'])->format('Y/m/d')}}">
                            <input type="hidden" id="to_date"
                                value="{{Carbon::createFromFormat('d/m/Y', $details['exam_detail']['to_date'])->format('Y/m/d')}}">

                            <div class="card-content">
                                <h4 class="text-center"><b>{{$details['exam_detail']['class_name']}}</b></h4>

                                <h4 class="text-center mt-20"><b> From Date :
                                        {{$details['exam_detail']['from_date']}}
                                        To Date : {{$details['exam_detail']['to_date']}} </b></h4>
                                <div class=" col-lg-12" style="margin-top: 10px;">
                                    <table class="table table-striped">
                                        <thead style="font-size:12px;">
                                            <tr>
                                                <th><b>Select</b></th>
                                                <th><b>Subject</b></th>
                                                <th><b>Exam Date</b></th>
                                                <th><b>Duration In Min</b></th>
                                                <th><b>Start Time</b></th>
                                                <th><b>Max Marks</b></th>
                                                <th><b>Min Marks</b></th>
                                            </tr>
                                        </thead>
                                        <tbody id="dataTable">
                                            @foreach($details[$key] as $index => $examTimetable)
                                            <tr>
                                                <input type="hidden"
                                                    name="subject_id[$details['exam_detail']['standard_id']][]"
                                                    value="{{ $examTimetable['subject_id'] }}">
                                                <td class="text-center">
                                                    <div class="checkbox">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox"
                                                                    name="{{$details[0]['standard_id']}}_check_{{ $examTimetable['subject_id'] }}"
                                                                    value="{{ $examTimetable['subject_id'] }}"
                                                                    {{ $examTimetable['check'] }}>
                                                            </label>
                                                        </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                            value="{{ $examTimetable['subject_name'] }}" disabled>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="text"
                                                            name="{{$details[0]['standard_id']}}_exam_date_{{ $examTimetable['subject_id'] }}"
                                                            class="form-control exam_datepicker"
                                                            value="{{ $examTimetable['exam_date'] }}" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="text"
                                                            name="{{$details[0]['standard_id']}}_duration_in_min_{{ $examTimetable['subject_id'] }}"
                                                            class="form-control"
                                                            value="{{ $examTimetable['duration_in_min'] }}" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="text"
                                                            name="{{$details[0]['standard_id']}}_start_time_{{ $examTimetable['subject_id'] }}"
                                                            class="form-control timepicker"
                                                            value="{{ $examTimetable['start_time'] }}" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="text"
                                                            name="{{$details[0]['standard_id']}}_max_marks_{{ $examTimetable['subject_id'] }}"
                                                            id="max_marks" class="form-control test"
                                                            onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"
                                                            value="{{ $examTimetable['max_marks'] }}" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="text"
                                                            name="{{$details[0]['standard_id']}}_min_marks_{{ $examTimetable['subject_id'] }}"
                                                            class="form-control test" onkeyup="check()"
                                                            onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"
                                                            value="{{ $examTimetable['min_marks'] }}" />
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endforeach
                            <div class="pull-right">
                                <input type='button' class='btn btn-finish btn-fill btn-danger btn-wd'
                                    onclick="window.location.href='exam-timetable'"
                                    style="float:right;margin-right:0px;" name='close' value='close' />
                                <button type="submit" class="btn btn-info pull-right" style="margin-right:6px;"
                                    name="submit" id="submit" value="submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @endif
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

    var fromDate = $('#from_date').val();
    var toDate = $('#to_date').val();
    // alert(fromDate);
    $('.exam_datepicker').datetimepicker({

        format: 'DD/MM/YYYY',
        maxDate: new Date(toDate),
        minDate: new Date(fromDate),
    });

    $('#timetable_type').on('change', function() {
        var timetableType = $(this).find(":selected").val();
        if (timetableType == 'subjectwise') {
            $('#idStandard').hide();
        } else {
            $('#idStandard').show();
        }
    });

    $('#exam').on('change', function() {
        var examId = $(this).find(":selected").val();
        $.ajax({
            url: "/exam-master-data",
            type: "POST",
            data: {
                id: examId
            },
            success: function(data) {
                var standardDetails = data.standard_details;

                for (var i = 0; i < standardDetails.length; i++) {
                    $('#standard').append('<option value="' +
                        standardDetails[i]['id'] +
                        '">' +
                        standardDetails[i]['label'] +
                        '</option>');
                }

                $('#from_date').html(data.from_date);
                $('#to_date').html(data.to_date);
                $('#standard').selectpicker('refresh');
            }
        });
    });


    $('body').delegate('#examTimetableForm', 'submit', function(e) {
        e.preventDefault();

        var btn = $('#submit');

        $.ajax({
            url: "/exam-timetable",
            type: "POST",
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
                            window.location.reload();
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
    });


});
</script>
@endsection