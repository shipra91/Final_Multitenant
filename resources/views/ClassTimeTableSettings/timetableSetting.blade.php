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
                            
                            <div class="card-content">
                                
                                <form method="GET" id="timeTableForm" action="{{ url('period-settings/filter') }}">
                                    <div class="row">
                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Standard<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="standard[]" id="standard" data-size="5" data-style="select-with-transition" data-live-search="true" data-selected-text-format="count > 1" title="Select" data-actions-box="true" multiple required="required" data-parsley-errors-container=".standard">
                                                    @foreach($timeTableData['institutionStandards'] as $standard)
                                                        <option value="{{ $standard['institutionStandard_id'] }}" @if($_REQUEST && in_array($standard['institutionStandard_id'], $_REQUEST['standard'])) {{ "selected" }} @endif>{{$standard['class']}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="standard"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Days<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="day[]" id="day" data-size="3" data-style="select-with-transition" data-live-search="true" data-selected-text-format="count > 1" title="Select" data-actions-box="true" multiple required="required" data-parsley-errors-container=".day">>
                                                    @foreach($daysArray as $day)
                                                        <option value="{{ $day }}" @if($_REQUEST && in_array($day, $_REQUEST['day'])) {{ "selected" }} @endif>{{$day}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="day"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">No of Teaching Periods<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="noOfTeachingPeriods" id="noOfTeachingPeriods" value="{{$timeTableData['teachingCount']}}" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">No of Break Periods<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="noOfBreakPeriods" id="noOfBreakPeriods" value="{{$timeTableData['breakCount']}}" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Time interval<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="timeInterval" value="{{ $_REQUEST? $_REQUEST ['timeInterval']:""}}" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-lg-offset-0 text-right">
                                            <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5">Submit</button>
                                            <a href="{{ url('class-timetable-settings') }}" class="btn btn-finish btn-fill btn btn-danger btn-wd">Close</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @if(isset($timeTableSettings))
                    <div class="row mt-5">
                        <div class="col-sm-12 col-sm-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">assessment</i>
                                </div>
                                <form method="POST" id="timeTableSettingsForm" enctype="multipart/form-data">
                                    <input type="hidden" name="id_institute" value="{{session()->get('institutionId')}}">
                                    <input type="hidden" name="id_academic" value="{{session()->get('academicYear')}}">
                                    <input type="hidden" name="organization" value="{{session()->get('organizationId')}}">
                                    <input type="hidden" name="standardId" value="{{ $timeTableSettings['id_standard'] }}">
                                    <input type="hidden" name="days" value="{{ $timeTableSettings['days'] }}">
                                    <input type="hidden" name="noOfTeachingPeriods" value="{{ $timeTableSettings['no_of_teaching_periods'] }}">
                                    <input type="hidden" name="noOfBreakPeriods" value="{{ $timeTableSettings['no_of_break_periods'] }}">
                                    <input type="hidden" name="time_interval" id="time_interval" value="{{ $timeTableSettings['time_interval'] }}">
                                    <input type="hidden" name="totalPeriods" value="{{ $timeTableSettings['total_period'] }}">

                                    <div class="card-content">
                                        <h4 class="card-title">Add Time Table Settings</h4>
                                        <div class="material-datatables mt-20">
                                            <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" width="100%">
                                                <thead style="font-size:12px;">
                                                    <tr>
                                                        <th><b>S.N.</b></th>
                                                        <th><b>Period Type</b></th>
                                                        <th><b>Start Time</b></th>
                                                        <th><b>End Time</b></th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach($timeTableSettings['timetableData'] as $index => $timeTable)
                                                        @php $count = $index + 1; @endphp
                                                        <tr>
                                                            <td class="col-md-2">{{ $count }}</td>
                                                            <td class="col-md-4">
                                                                <div class="form-group">
                                                                    <select class="selectpicker" name="periodType[]" id="periodType" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select">
                                                                        @foreach($timeTable['periods'] as $period)
                                                                            <option value="{{$period['id']}}">{{$period['name']}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </td>

                                                            <td class="col-md-3">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control timepicker start_time" name="startTime[]" id="startTime" value="{{ $timeTable['start_time'] }}" />
                                                                </div>
                                                            </td>

                                                            <td class="col-md-3">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control timepicker end_time" name="endTime[]" id="end_time" value="{{ $timeTable['end_time'] }}" />
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="pull-right mt-10">
                                            <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit">Submit</button>
                                            <a href="{{ url('class-timetable-settings') }}" class="btn btn-finish btn-fill btn btn-danger btn-wd">Close</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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

        $(".start_time").on("dp.change", function(e){

            var timeInterval = $("#time_interval").val();

            if( e.date ){
                $(this).parents('tr').find('#end_time').data("DateTimePicker").date(e.date.add(timeInterval, 'm'));
            }
        });

        $('#timeTableForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save time table settings
        $('body').delegate('#timeTableSettingsForm', 'submit', function(e){
            e.preventDefault();

            console.log('hello');

            var btn=$('#submit');

            $.ajax({
                url:"{{url('/class-timetable-settings')}}",
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
                                //window.location.reload();
                                window.location.replace('/class-timetable-settings');
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
        });
    });
</script>
@endsection
