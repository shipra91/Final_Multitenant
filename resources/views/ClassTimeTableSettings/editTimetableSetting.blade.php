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
                                <div class="row">
                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Standard</label>
                                            <input type="text" class="form-control" name="standard" id="standard" value="{{$selectedData['periodSettingsData']['standard']}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Days</label>
                                            <input type="text" class="form-control" name="noOfDays" id="noOfDays" value="{{$selectedData['periodSettingsData']['days']}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">No of Teaching Periods</label>
                                            <input type="text" class="form-control" name="noOfTeachingPeriods" id="noOfTeachingPeriods" value="{{$selectedData['periodSettingsData']['no_of_teaching_periods']}}"  disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">No of Break Periods</label>
                                            <input type="text" class="form-control" name="noOfBreakPeriods" id="noOfBreakPeriods" value="{{$selectedData['periodSettingsData']['no_of_break_periods']}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">interval</label>
                                            <input type="text" class="form-control" name="timeInterval" value="{{$selectedData['periodSettingsData']['time_interval']}}" disabled />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-sm-12 col-sm-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">assessment</i>
                            </div>
                            <form method="POST" id="timeTableSettingsForm" enctype="multipart/form-data">
                                <div class="card-content">
                                    <h4 class="card-title">Edit Time Table Settings</h4>
                                    <div class="toolbar"></div>
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
                                                @foreach($selectedData['timeTableData'] as $index => $timeTableData)
                                                    <tr>
                                                        <td class="col-md-2">{{$index + 1}}</td>
                                                        <td class="col-md-4">
                                                            <input type="hidden" name="id_timeTable[]" value="{{$timeTableData['id']}}">
                                                            <div class="form-group">
                                                                <select class="selectpicker" name="periodType[]" id="periodType" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select">
                                                                    @foreach($selectedData['periods'] as $period)
                                                                        <option value="{{$period['id']}}" @if($timeTableData['id_period'] == $period['id']) {{'selected'}} @endif>{{ucwords($period['name'])}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </td>

                                                        <td class="col-md-3">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control timepicker start_time" name="startTime[]" id="startTime" value="{{$timeTableData['start_time']}}" />
                                                            </div>
                                                        </td>

                                                        <td class="col-md-3">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control timepicker end_time" name="endTime[]" id="end_time" value="{{$timeTableData['end_time']}}" />
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="pull-right mt-10">
                                        <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit">Update</button>
                                        <a href="{{ url('class-timetable-settings') }}" class="btn btn-finish btn-fill btn btn-danger btn-wd">Close</a>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </form>
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

        // Update time table settings
        $('body').delegate('#timeTableSettingsForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');
            var id = $("#id_timeTable").val();

            $.ajax({
                url:"/class-timetable-settings/"+id,
                type:"POST",
                dataType:"json",
                data: new FormData(this),
                contentType: false,
                processData:false,
                beforeSend:function(){
                    btn.html('Updating...');
                    btn.attr('disabled',true);
                },
                success:function(result){
                    btn.html('Update');
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
