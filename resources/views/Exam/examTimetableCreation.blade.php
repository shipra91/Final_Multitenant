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
                                <i class="material-icons">school</i>
                            </div>
                            <form method="GET" class="demo-form" id="settingForm" action="{{ url('get-exam-timetable') }}">
                                <div class="card-content">
                                    <h4 class="card-title">Add Exam Time Table</h4>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Exam<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="exam" id="examId" data-live-search="true" data-style="select-with-transition" data-size="5" required title="Select" data-parsley-errors-container=".examError">
                                                    @foreach($examDetails as $exam)
                                                        <option value="{{$exam['id']}}" @if($_REQUEST && $_REQUEST['exam']==$exam['id']) {{ 'selected'}} @endif>{{$exam['exam_name']}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="examError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Timetable Type<span class="text-danger">*</span></label>
                                                <select name="timetable_type" id="timetable_type" class="selectpicker" data-live-search="true" data-style="select-with-transition" data-size="5" required title="Select" data-parsley-errors-container=".typeError">
                                                    <option value="classwise" @if($_REQUEST && $_REQUEST['timetable_type']=='classwise' ) {{ 'selected'}} @endif>CLASSWISE</option>
                                                    <option value="subjectwise" @if($_REQUEST && $_REQUEST['timetable_type']=='subjectwise' ) {{ 'selected'}} @endif>SUBJECTWISE</option>
                                                </select>
                                                <div class="typeError"></div>
                                            </div>
                                        </div>

                                        @if($_REQUEST && $_REQUEST['timetable_type'] == 'classwise')
                                            @php $display = ""; @endphp
                                        @else
                                            @php $display = "d-none"; @endphp
                                        @endif

                                        <div class="col-lg-3 {{ $display }}" id="idStandard">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Standard<span class="text-danger">*</span></label>
                                                <select name="standard[]" id="standard" class="selectpicker" data-live-search="true" data-style="select-with-transition" data-size="5" title="Select" multiple data-actions-box="true">
                                                    @if(count($examStandardDetails['standard_details'])>0)
                                                        {{-- @foreach($examStandardDetails['standard_details'] as $details)
                                                            <option value="{{$details['id']}}">{{$details['label']}}</option>
                                                        @endforeach --}}
                                                        @foreach($examStandardDetails['standard_details'] as $standard)
                                                            <option value="{{$standard['id']}}" @if($_REQUEST && $_REQUEST['timetable_type'] == 'classwise' && in_array($standard['id'], $_REQUEST['standard'])) {{ "selected" }} @endif>{{$standard['label']}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @if(isset($_GET['submit']))
                    @if(count($examTimetableDetails)>0)
                        <div class="row">
                            <form method="POST" id="examTimetableForm">
                                <input type="hidden" name="id_institute" value="{{session()->get('institutionId')}}">
                                <input type="hidden" name="id_academic" value="{{session()->get('academicYear')}}">
                                <input type="hidden" name="organization" value="{{session()->get('organizationId')}}">
                                <div class="col-lg-12">

                                    @if($examTimetableDetails['setting']['timetable_type'] == 'classwise')

                                        <div class="card">
                                            <input type="hidden" name="id_exam" value="{{$examTimetableDetails['setting']['exam']}}">
                                            <input type="hidden" name="timetable_type" value="{{$examTimetableDetails['setting']['timetable_type']}}">
                                            <input type="hidden" name="id_standard" value="{{$examTimetableDetails['setting']['standard']}}">
                                            <input type="hidden" id="from_date" value="{{Carbon::createFromFormat('d/m/Y', $examTimetableDetails['setting']['from_date'])->format('Y/m/d')}}">
                                            <input type="hidden" id="to_date"  value="{{Carbon::createFromFormat('d/m/Y', $examTimetableDetails['setting']['to_date'])->format('Y/m/d')}}">

                                            <div class="card-content">
                                                @foreach($examTimetableDetails['class_wise'] as $details)
                                                    <h4 class="text-center"><b>{{$details['class_name']}}</b></h4>
                                                    <h4 class="text-center mt-20">
                                                        <b>
                                                            From Date : {{$examTimetableDetails['setting']['from_date']}}
                                                            To Date : {{$examTimetableDetails['setting']['to_date']}}
                                                        </b>
                                                    </h4>
                                                    <div class="" style="margin: 20px 0px;">
                                                        <table class="table table-striped">
                                                            <thead style="font-size:12px;">
                                                                <tr>
                                                                    <th><b>Select</b></th>
                                                                    <th><b>Subject</b></th>
                                                                    <th><b>Exam Date</b></th>
                                                                    <th><b>Start Time</b></th>
                                                                    <th><b>Duration In Min</b></th>
                                                                    <th><b>Max Marks</b></th>
                                                                    <th><b>Min Marks</b></th>
                                                                </tr>
                                                            </thead>

                                                            <tbody id="dataTable">
                                                                @if(count($details['subjectArray']) > 0)
                                                                    @foreach($details['subjectArray'] as $index => $examTimetable)
                                                                        <tr>
                                                                            <input type="hidden" name="subject_ids[{{$details['standard_id']}}][]" value="{{ $examTimetable['subject_id'] }}">
                                                                            <td class="text-center">
                                                                                <div class="checkbox">
                                                                                    <label>
                                                                                        <input type="checkbox" name="check_{{$details['standard_id']}}_{{ $examTimetable['subject_id']}}" value="{{ $examTimetable['subject_id'] }}"{{ $examTimetable['check'] }}>
                                                                                    </label>
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control" value="{{ $examTimetable['subject_name'] }}" disabled>
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control exam_datepicker current_class" name="exam_date_{{$details['standard_id']}}_{{ $examTimetable['subject_id']}}" value="{{ $examTimetable['exam_date'] }}" disabled="" />
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control timepicker current_class" name="start_time_{{$details['standard_id']}}_{{ $examTimetable['subject_id']}}" value="{{ $examTimetable['start_time'] }}" disabled="" />
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control current_class" name="duration_in_min_{{$details['standard_id']}}_{{ $examTimetable['subject_id']}}" value="{{ $examTimetable['duration_in_min'] }}" disabled="" />
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control test current_class max_marks" id="max_marks" name="max_marks_{{$details['standard_id']}}_{{ $examTimetable['subject_id']}}" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" value="{{ $examTimetable['max_marks'] }}" disabled="" />
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control test current_class min_marks" name="min_marks_{{$details['standard_id']}}_{{ $examTimetable['subject_id']}}" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" value="{{ $examTimetable['min_marks'] }}" disabled="" />
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td colspan="7" class="text-center">No Subjects Available</td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                    @else

                                        <div class="card">
                                            <input type="hidden" name="id_exam" value="{{$examTimetableDetails['setting']['exam']}}">
                                            <input type="hidden" name="timetable_type" value="{{$examTimetableDetails['setting']['timetable_type']}}">
                                            <input type="hidden" id="from_date" value="{{Carbon::createFromFormat('d/m/Y', $examTimetableDetails['setting']['from_date'])->format('Y/m/d')}}">
                                            <input type="hidden" id="to_date" value="{{Carbon::createFromFormat('d/m/Y', $examTimetableDetails['setting']['to_date'])->format('Y/m/d')}}">

                                            <div class="card-content">
                                                <h4 class="text-center mt-20">
                                                    <b>
                                                        From Date : {{ $examTimetableDetails['setting']['from_date'] }}
                                                        To Date : {{ $examTimetableDetails['setting']['to_date'] }}
                                                    </b>
                                                </h4>
                                                <div class="" style="margin: 20px 0px;">
                                                    <table class="table table-striped">
                                                        <tbody id="dataTable">
                                                            @if(count($examTimetableDetails['subject_wise']) > 0)
                                                                @foreach($examTimetableDetails['subject_wise'] as $details)
                                                                    <tr>
                                                                        <input type="hidden" name="subject_id[]" value="{{ $details['subject_id'] }}">
                                                                        <td colspan="6">
                                                                            <h4 class="h6 text-center">{{ $details['subject_name'] }}</h4>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th width="30%"><b>Standard</b></th>
                                                                        <th width="20%"><b>Exam Date</b></th>
                                                                        <th width="15%"><b>Start Time</b></th>
                                                                        <th width="15%"><b>Duration In Min</b></th>
                                                                        <th width="10%"><b>Max Marks</b></th>
                                                                        <th width="10%"><b>Min Marks</b></th>
                                                                    </tr>

                                                                    @foreach($details['classArray'] as $index => $data)

                                                                        <tr>
                                                                            <td>
                                                                                <input type="hidden" name="standard_ids[{{$details['subject_id']}}][]" value="{{$data['standard_id']}}">
                                                                                <div class="checkbox">
                                                                                    <label>
                                                                                        <input type="checkbox" name="check_{{ $data['standard_id'] }}_{{ $details['subject_id'] }}" value="{{ $data['standard_id'] }}" {{$data['check']}}>{{ $data['class'] }}
                                                                                    </label>
                                                                                    <br>
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control exam_datepicker current_class" name="exam_date_{{ $data['standard_id'] }}_{{ $details['subject_id'] }}" value="{{ $data['exam_date'] }}" disabled="" />
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control timepicker current_class" name="start_time_{{ $data['standard_id'] }}_{{ $details['subject_id'] }}" value="{{ $data['start_time'] }}" disabled="" />
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control current_class" name="duration_in_min_{{ $data['standard_id'] }}_{{ $details['subject_id'] }}" value="{{ $data['duration_in_min'] }}" disabled="" />
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control test current_class max_marks" name="max_marks_{{ $data['standard_id'] }}_{{ $details['subject_id'] }}" id="max_marks" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" value="{{ $data['max_marks'] }}" disabled="" />
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <div class="form-group">
                                                                                    <input type="text" class="form-control test current_class min_marks" name="min_marks_{{ $data['standard_id'] }}_{{ $details['subject_id'] }}" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" value="{{ $data['min_marks'] }}" disabled="" />
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endforeach
                                                            @else
                                                                <tr>
                                                                    <td colspan="6" class="text-center">No standards available</td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-lg-12 text-right" style="margin-top: -10px;">
                                    @if(Helper::checkAccess('exam-timetable', 'create'))
                                        <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Submit</button>
                                    @endif
                                    <a href="{{ url('exam-timetable') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
                                </div>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    @endif
                @endif
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

        $('#settingForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        $(function() {
            $("input[type=checkbox]:checked").each(function() {

                $(this).parents('tr').find('.current_class').attr('disabled', false);
            });
        });

        $('input[type=checkbox]').change(function() {

            var value = $(this).parents('tr').attr('data-id');

            if ($(this).is(':checked')) {

                $(this).parents('tr').find('.current_class').attr('disabled', false);
            } else {

                $(this).parents('tr').find('.current_class').attr('disabled', true);
            }

        });

        //CHECK MIN AND MAX MARKS
        $("body").delegate(".min_marks", "keyup", function(event){
            event.preventDefault();

            var minMarks = $(this).val(); //alert(minMarks);
            var maxMarks = $(this).parents('tr').find('.max_marks').val(); //alert(maxMarks);
            if(parseInt(minMarks) > parseInt(maxMarks)){
                $(this).val('');
            }
        });

        var fromDate = $('#from_date').val();
        var toDate = $('#to_date').val();
        // alert(fromDate);
        $('.exam_datepicker').datetimepicker({

            format: 'DD/MM/YYYY',
            minDate: new Date(fromDate),
            maxDate: new Date(toDate),
        });

        $('#timetable_type').on('change', function() {
            var timetableType = $(this).find(":selected").val();
            if (timetableType == 'subjectwise') {
                $('#idStandard').addClass('d-none');
                $("#standard").prop('required', false);
            } else {
                $('#idStandard').removeClass('d-none');
                $("#standard").prop('required', true);
            }
        });

        $('#examId').on('change', function() {
            var examId = $(this).find(":selected").val();
            console.log(examId);
            $.ajax({
                url: "/exam-master-data",
                type: "POST",
                data: {
                    id: examId
                },
                success: function(data) {
                    var standardDetails = data.standard_details;
                   console.log(standardDetails);
                    var option = '';
                    $.each(standardDetails, function(index, value){
                        option += '<option value="' +
                            value['id'] +
                            '">' +
                            value['label'] +
                            '</option>';
                    });

                    $('#from_date').html(data.from_date);
                    $('#to_date').html(data.to_date);
                    $('#standard').html(option);
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
