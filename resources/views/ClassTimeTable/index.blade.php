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
                @if(Helper::checkAccess('class-time-table', 'create'))
                    <div class="row">
                        <div class="col-sm-12 col-sm-offset-0">
                            <div class="card">
                                <div class="card-content">
                                    <h4 class="card-title"></h4>
                                    <form method="GET" action="{{ url('get-standard/filter') }}" id="getStandard">
                                        <div class="row">
                                            <div class="col-lg-4 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Standard<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="standard" id="standard" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required">
                                                        @foreach($standard['institutionStandards'] as $standard)
                                                            <option value="{{$standard['institutionStandard_id']}}" @if($_REQUEST && $_REQUEST['standard'] == $standard['institutionStandard_id']) {{ "selected" }} @endif>{{$standard['class']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-lg-offset-0">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5">Submit</button>
                                                    <a href="" class="btn btn-finish btn-fill btn btn-danger btn-wd">Close</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
<<<<<<< HEAD

=======
                
>>>>>>> main
                    @if(isset($timeTableSettingData))
                        @if(count($timeTableSettingData['subjects']) > 0)
                            <div class="row mt-5">
                                <div class="col-sm-12 col-sm-offset-0">
                                    <div class="card">
                                        <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                            <i class="material-icons">assessment</i>
                                        </div>
                                        <form method="POST" id="timeTableForm" enctype="multipart/form-data">
<<<<<<< HEAD
=======
                                            <input type="hidden" name="id_institute" value="{{session()->get('institutionId')}}">
                                            <input type="hidden" name="id_academic" value="{{session()->get('academicYear')}}">
                                            <input type="hidden" name="organization" value="{{session()->get('organizationId')}}">
>>>>>>> main
                                            <input type="hidden" id="days_array" value="{{ implode(',',$timeTableSettingData['daysPeriodDetails']['days_array']) }}">
                                            <div class="card-content">
                                                <h4 class="card-title">Add Time Table</h4>
                                                <div class="toolbar"></div>
                                                <div class="row mt-30">
                                                    <div class="col-sm-12 col-sm-offset-0">
                                                        <ul class="nav nav-tabs p10">
                                                            @foreach ($timeTableSettingData['dayPeriodSettingData'] as $key => $periodSettingData)
                                                                <li class="nav-item @if($key == 0){{ "active" }} @endif">
                                                                    <a data-toggle="tab" class="nav-link @if($key == 0){{ "active" }} @endif" href="#{{ $periodSettingData['days'] }}">{{ $periodSettingData['days'] }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul>

<<<<<<< HEAD
                                                        <div class="tab-content" style="margin-top: 15px; padding: 0px 15px;">
                                                            <input type="hidden" id="standard_id" name="standard_id" value="{{ $_REQUEST['standard'] }}">
=======
                                                        <div class="tab-content">
                                                            <input type="hidden" id="standard_id" name="standard_id" value="{{ $_REQUEST['standard'] }}">

>>>>>>> main
                                                            @foreach ($timeTableSettingData['dayPeriodSettingData'] as $index => $periodSettingData)
                                                                <input type="hidden" id="day_period_array_{{ $periodSettingData['days'] }}" value="{{ implode(',',$timeTableSettingData['daysPeriodDetails']['day_periods'][$periodSettingData['days']]) }}">

                                                                <input type="hidden" name="day[]" id="day" value="{{ $periodSettingData['days'] }}">
                                                                <div class="tab-pane  wizard-pane  @if($index == 0){{ "active" }} @endif" id="{{ $periodSettingData['days'] }}">
                                                                    <div class="material-datatables">
                                                                        <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                                                            <div class="timeTable-header">
                                                                                <h4>Set Time Table For - <span class="text-primary fw-500">{{ $periodSettingData['days'] }}</span></h4>
                                                                            </div>

                                                                            <thead style="font-size:12px;">
                                                                                <div class="row">
                                                                                    <div class="col-md-1"><b>S.N.</b></div>
                                                                                    <div class="col-md-2"><b>Period</b></div>
                                                                                    <div class="col-md-3"><b>Subject</b></div>
                                                                                    <div class="col-md-3"><b>Teacher</b></div>
                                                                                    <div class="col-md-3"><b>Room</b></div>
                                                                                </div>
                                                                            </thead>

                                                                            <tbody>
                                                                                @foreach ($periodSettingData['classTimeTableSettingData'] as $key => $timetableSetting)
                                                                                    <div class="row">
<<<<<<< HEAD
                                                                                        <div class="col-md-1 pt-20 ">{{ $key + 1 }} <input type="hidden" name="periodId[{{ $periodSettingData['days'] }}][]" value="{{ $timetableSetting['id_period'] }}"></div>
                                                                                        <div class="col-md-2 pt-20 ">{{ ucwords($timetableSetting['period']) }}
=======
                                                                                        <div class="col-md-1">{{ $key + 1 }} <input type="hidden" name="periodId[{{ $periodSettingData['days'] }}][]" value="{{ $timetableSetting['id_period'] }}"></div>
                                                                                        <div class="col-md-2">{{ ucwords($timetableSetting['period']) }}
>>>>>>> main
                                                                                        </div>
                                                                                        <div class="col-md-9">
                                                                                            <div id="repeater_{{$periodSettingData['days']}}_{{$timetableSetting['id_period']}}">
                                                                                                <input type="hidden" id="totalCount_{{$periodSettingData['days']}}_{{$timetableSetting['id_period']}}" value="{{  (count($timetableSetting['selected_subject']) > 0) ? $timetableSetting['count'] : 1;}}">
                                                                                                @if(count($timetableSetting['selected_subject']) > 0)
                                                                                                    @foreach($timetableSetting['selected_subject'] as $subKey => $subject)
                                                                                                        <div class="row row_child" id="section_{{$periodSettingData['days']}}_{{$timetableSetting['id_period']}}_{{$subKey + 1}}" data-id="{{$periodSettingData['days']}}_{{$timetableSetting['id_period']}}_{{$subKey + 1}}">
                                                                                                            <div class="col-md-4">
                                                                                                                <div class="form-group">
<<<<<<< HEAD
                                                                                                                    <select class="selectpicker subject" name="subject_{{ $periodSettingData['days'] }}_{{ $timetableSetting['id_period'] }}[]" id="subject" data-size="5" data-style="select-with-transition" data-live-search="true" data-selected-text-format="count > 1" title="Select">
=======
                                                                                                                    <select class="selectpicker subject" name="subject_{{ $periodSettingData['days'] }}_{{ $timetableSetting['id_period'] }}[]" id="subject" data-size="5" data-style="select-with-transition" data-live-search="true" data-selected-text-format="count > 1" title="Select Subject">
>>>>>>> main
                                                                                                                        @foreach($timeTableSettingData['subjects'] as $subjectData)
                                                                                                                            <option value="{{ $subjectData['id'] }}" @if($subjectData['id'] == $subject)) {{ "selected" }} @endif>{{ $subjectData['name'] }}</option>
                                                                                                                        @endforeach
                                                                                                                    </select>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="col-md-4">
                                                                                                                <div class="form-group">
<<<<<<< HEAD
                                                                                                                    <select class="selectpicker staff" name="staff_{{ $periodSettingData['days'] }}_{{ $timetableSetting['id_period'] }}_{{++$subKey}}[]" id="staff" data-size="3" data-style="select-with-transition" data-live-search="true" data-selected-text-format="count > 1" title="Select" data-actions-box="true" multiple>
=======
                                                                                                                    <select class="selectpicker staff" name="staff_{{ $periodSettingData['days'] }}_{{ $timetableSetting['id_period'] }}_{{++$subKey}}[]" id="staff" data-size="3" data-style="select-with-transition" data-live-search="true" data-selected-text-format="count > 1" title="Select Teacher" data-actions-box="true" multiple>
>>>>>>> main
                                                                                                                    @foreach ($timetableSetting['all_staff'][$subject] as $staff)
                                                                                                                        <option value="{{ $staff['id'] }}"  @if(in_array($staff['id'], $timetableSetting['selected_staff'][$subject])) {{ "selected" }} @endif> {{ $staff['name'] }} - {{ $staff['display_name'] }} ({{ $staff['subject_type'] }}) </option>
                                                                                                                    @endforeach
                                                                                                                    </select>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="col-md-3">
                                                                                                                <div class="form-group">
<<<<<<< HEAD
                                                                                                                    <select class="selectpicker room" name="room_{{ $periodSettingData['days'] }}_{{ $timetableSetting['id_period'] }}[]" id="room" data-size="3" data-style="select-with-transition" data-live-search="true" data-selected-text-format="count > 1" title="Select" data-actions-box="true">
=======
                                                                                                                    <select class="selectpicker room" name="room_{{ $periodSettingData['days'] }}_{{ $timetableSetting['id_period'] }}[]" id="room" data-size="3" data-style="select-with-transition" data-live-search="true" data-selected-text-format="count > 1" title="Select Room" data-actions-box="true">
>>>>>>> main
                                                                                                                        @foreach ($roomData as $room)
                                                                                                                            <option value="{{ $room['id'] }}" @if(in_array($room['id'], $timetableSetting['selected_room'][$subject])) {{ "selected" }} @endif> {{ $room['display_name'] }} </option>
                                                                                                                        @endforeach
                                                                                                                    </select>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            @if((--$subKey) == 0)
                                                                                                            <div class="col-md-1">
                                                                                                                <div class="form-group">
                                                                                                                <button id="add_more_{{$periodSettingData['days']}}_{{$timetableSetting['id_period']}}" type="button" class="btn btn-warning btn-xs"><i class="material-icons">add_circle_outline</i></button>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            @endif
                                                                                                        </div>
<<<<<<< HEAD
=======
                                                                                                    
>>>>>>> main
                                                                                                    @endforeach
                                                                                                @else
                                                                                                    <div class="row row_child" id="section_{{$periodSettingData['days']}}_{{$timetableSetting['id_period']}}_1" data-id="{{$periodSettingData['days']}}_{{$timetableSetting['id_period']}}_1">
                                                                                                        <div class="col-md-4">
                                                                                                            <div class="form-group">
<<<<<<< HEAD
                                                                                                                <select class="selectpicker subject" name="subject_{{ $periodSettingData['days'] }}_{{ $timetableSetting['id_period'] }}[]" id="subject" data-size="5" data-style="select-with-transition" data-live-search="true" data-selected-text-format="count > 1" title="Select">
=======
                                                                                                                <select class="selectpicker subject" name="subject_{{ $periodSettingData['days'] }}_{{ $timetableSetting['id_period'] }}[]" id="subject" data-size="5" data-style="select-with-transition" data-live-search="true" data-selected-text-format="count > 1" title="Select Subject">
>>>>>>> main
                                                                                                                    @foreach($timeTableSettingData['subjects'] as $subjectData)
                                                                                                                        <option value="{{ $subjectData['id'] }}">{{ $subjectData['name'] }}</option>
                                                                                                                    @endforeach
                                                                                                                </select>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-md-4">
                                                                                                            <div class="form-group">
<<<<<<< HEAD
                                                                                                                <select class="selectpicker staff" name="staff_{{ $periodSettingData['days'] }}_{{ $timetableSetting['id_period'] }}_1[]" id="staff" data-size="3" data-style="select-with-transition" data-live-search="true" data-selected-text-format="count > 1" title="Select" data-actions-box="true" multiple>

=======
                                                                                                                <select class="selectpicker staff" name="staff_{{ $periodSettingData['days'] }}_{{ $timetableSetting['id_period'] }}_1[]" id="staff" data-size="3" data-style="select-with-transition" data-live-search="true" data-selected-text-format="count > 1" title="Select Teacher" data-actions-box="true" multiple>
                                                                                                               
>>>>>>> main
                                                                                                                </select>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-md-3">
                                                                                                            <div class="form-group">
<<<<<<< HEAD
                                                                                                                <select class="selectpicker room" name="room_{{ $periodSettingData['days'] }}_{{ $timetableSetting['id_period'] }}[]" id="room" data-size="3" data-style="select-with-transition" data-live-search="true" data-selected-text-format="count > 1" title="Select" data-actions-box="true">
=======
                                                                                                                <select class="selectpicker room" name="room_{{ $periodSettingData['days'] }}_{{ $timetableSetting['id_period'] }}[]" id="room" data-size="3" data-style="select-with-transition" data-live-search="true" data-selected-text-format="count > 1" title="Select Room" data-actions-box="true">
>>>>>>> main
                                                                                                                    @foreach ($roomData as $room)
                                                                                                                        <option value="{{ $room['id'] }}"> {{ $room['display_name'] }} </option>
                                                                                                                    @endforeach
                                                                                                                </select>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-md-1">
                                                                                                            <div class="form-group">
                                                                                                            <button id="add_more_{{$periodSettingData['days']}}_{{$timetableSetting['id_period']}}" type="button" class="btn btn-warning btn-xs"><i class="material-icons">add_circle_outline</i></button>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                @endif
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="pull-right mt-10">
                                                    <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit">Submit</button>
                                                    <a href="" class="btn btn-finish btn-fill btn btn-danger btn-wd">Close</a>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <h5 class="text-center">No data available</h5>
                        @endif
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

        // Get subject based on standard selection
<<<<<<< HEAD
        function getSubjects(standardId){

            var retVal;

=======
        
        function getSubjects(standardId){
            var retVal;
>>>>>>> main
            $.ajax({
                url: "/assignment-subjects",
                type: "POST",
                async: false,
                data: {standardId: standardId},
                success: function(data){
                    retVal = data;
                }
            });
<<<<<<< HEAD

            return retVal;
        }

        // Add more timetable
        var days_array = $('#days_array').val();
        const daysArray = days_array.split(",");
        daysArray.forEach(function(day) {

            var day_period_array = $('#day_period_array_'+day).val();
            if(day_period_array) {

                const dayPeriodArray = day_period_array.split(",");
                dayPeriodArray.forEach(function(periodId) {

                    $(document).on('click', '#add_more_' + day + '_'+ periodId + '', function(){
                        var count = $('#totalCount_'+ day + '_'+ periodId + '').val();
                    // console.log(count);
                        var html = '';
                        count++;

                        html += '<div class="row row_child" id="section_'+ day + '_'+ periodId + '_' + count + '" data-id="' + day + '_'+ periodId + '_' + count + '">';
                        html += '<div class="col-md-4">';
                        html += '<div class="form-group">';
                        html += '<select class="selectpicker subject" name="subject_'+ day +'_'+ periodId +'[]" id="subject" data-size="5" data-style="select-with-transition" data-live-search="true" data-selected-text-format="count > 1" title="Select Subject" data-actions-box="true" >';
                            var subjectResult = getSubjects($("#standard").val());
                            // console.log('d'+result);
                            $.map(subjectResult, function(item, index){
                                var subject_type = '';
                                if(item.subject_type === "PRACTICAL"){
                                    subject_type = ' - ' + item.subject_type;
                                }else{
                                    subject_type = '';
                                }
                                html += '<option value="' + item.id_institution_subject +
                                    '">' + item.display_name + '' + subject_type + '</option>';
                            });

                        html += '</select>';
                        html += '</div>';
                        html += '</div>';

                        html += '<div class="col-md-4">';
                        html += '<div class="form-group">';
                        html += '<select class="selectpicker staff" name="staff_'+ day +'_'+ periodId +'_'+count+'[]" id="staff" data-size="3" data-style="select-with-transition" data-live-search="true" data-selected-text-format="count > 1" title="Select Teacher" data-actions-box="true" multiple>';

                        html += '</select>';
                        html += '</div>';
                        html += '</div>';

                        html += '<div class="col-md-3">';
                        html += '<div class="form-group">';
                        html += '<select class="selectpicker room" name="room_'+ day +'_'+ periodId +'[]" id="room" data-size="3" data-style="select-with-transition" data-live-search="true" data-selected-text-format="count > 1" title="Select Room" data-actions-box="true">';
                        <?php foreach ($roomData as $room){?>
                        html += '<option value="<?php echo $room['id'];?>"> <?php echo $room['display_name'];?> </option>';
                        <?php } ?>
                        html += '</select>';
                        html += '</div>';
                        html += '</div>';

                        html += '<div class="col-md-1">';
                        html += '<div class="form-group">';
                        html += '<button type="button" id="' + day + '_'+ periodId + '_' + count + '" class="btn btn-danger btn-xs remove_button"><i class="material-icons">highlight_off</i></button>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';

                        $('#repeater_' + day + '_'+ periodId + '').append(html);
                        $("#totalCount_" + day + '_'+ periodId + "").val(count);
                        $(".subject").selectpicker('refresh');
                        $(".staff").selectpicker('refresh');
                        $(".room").selectpicker('refresh');

                    });
                });
            }
        });

        // Remove timetable
        $(document).on('click', '.remove_button', function(event){
=======
            return retVal;
        }

        var days_array = $('#days_array').val();
        const daysArray = days_array.split(",");
        //console.log(daysArray);
        daysArray.forEach(function(day) {
            var day_period_array = $('#day_period_array_'+day).val();
            const dayPeriodArray = day_period_array.split(",");
            //console.log(dayPeriodArray);
            dayPeriodArray.forEach(function(periodId) {
                
                $(document).on('click', '#add_more_' + day + '_'+ periodId + '', function(){
                    var count = $('#totalCount_'+ day + '_'+ periodId + '').val();
                // console.log(count);
                    var html = '';
                    count++;
               
                    html += '<div class="row row_child" id="section_'+ day + '_'+ periodId + '_' + count + '" data-id="' + day + '_'+ periodId + '_' + count + '">';
                    html += '<div class="col-md-4">';
                    html += '<div class="form-group">';
                    html += '<select class="selectpicker subject" name="subject_'+ day +'_'+ periodId +'[]" id="subject" data-size="5" data-style="select-with-transition" data-live-search="true" data-selected-text-format="count > 1" title="Select Subject" data-actions-box="true" >';
                        var subjectResult = getSubjects($("#standard").val());
                        // console.log('d'+result);
                        $.map(subjectResult, function(item, index){
                            var subject_type = '';
                            if(item.subject_type === "PRACTICAL"){ 
                                subject_type = ' - ' + item.subject_type;
                            }else{
                                subject_type = '';
                            }
                            html += '<option value="' + item.id_institution_subject +
                                '">' + item.display_name + '' + subject_type + '</option>';
                        });
                    
                    html += '</select>';
                    html += '</div>';
                    html += '</div>';

                    html += '<div class="col-md-4">';
                    html += '<div class="form-group">';
                    html += '<select class="selectpicker staff" name="staff_'+ day +'_'+ periodId +'_'+count+'[]" id="staff" data-size="3" data-style="select-with-transition" data-live-search="true" data-selected-text-format="count > 1" title="Select Teacher" data-actions-box="true" multiple>';
                  
                    html += '</select>';
                    html += '</div>';
                    html += '</div>';

                    html += '<div class="col-md-3">';
                    html += '<div class="form-group">';
                    html += '<select class="selectpicker room" name="room_'+ day +'_'+ periodId +'[]" id="room" data-size="3" data-style="select-with-transition" data-live-search="true" data-selected-text-format="count > 1" title="Select Room" data-actions-box="true">';
                    <?php foreach ($roomData as $room){?>
                    html += '<option value="<?php echo $room['id'];?>"> <?php echo $room['display_name'];?> </option>';
                    <?php } ?>
                    html += '</select>';
                    html += '</div>';
                    html += '</div>';

                    html += '<div class="col-md-1">';
                    html += '<div class="form-group">';
                    html += '<button type="button" id="' + day + '_'+ periodId + '_' + count + '" class="btn btn-danger btn-xs remove_button"><i class="material-icons">highlight_off</i></button>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';

                    $('#repeater_' + day + '_'+ periodId + '').append(html);
                    $("#totalCount_" + day + '_'+ periodId + "").val(count);
                    $(".subject").selectpicker('refresh');
                    $(".staff").selectpicker('refresh');
                    $(".room").selectpicker('refresh');
            
                });
            });
        });

         // Remove semester/trimester mapping
         $(document).on('click', '.remove_button', function(event){
>>>>>>> main
            event.preventDefault();

            var id = $(this).attr('id');
            var data = id.split("_");
            var dayPeriod = data[0] + '_' + data[1];
            var totalCount = $("#totalCount_" + dayPeriod).val();
            // console.log('before remove' + totalCount);
            $(this).closest('div #section_' + id + '').remove();
            totalCount--;
<<<<<<< HEAD

=======
            
>>>>>>> main
            // console.log('remove' + totalCount);
            $("#totalCount_" + dayPeriod + "").val(totalCount);
        });

        // Get staff on standard and subject selection
        $("body").delegate('#subject', 'change', function(){

            var subjectId = $(this).val();
            var standardId = $("#standard_id").val();
            var parentDiv = $(this).parents('div .row_child');

            $.ajax({
                url:"/get-subject-staff",
                type:"POST",
                data: {subjectId : subjectId, standardId : standardId },
                success: function(data){
<<<<<<< HEAD
                    var options = '';
=======

                    var options = '';

>>>>>>> main
                    $.map(data, function(item, index){
                        options += '<option value="'+item.id+'">'+item.name+' - '+item.display_name+' ('+item.subject_type+')</option>';
                    });
                    parentDiv.find("#staff").html(options);
                    parentDiv.find("#staff").selectpicker('refresh');
                }
            });
        });

        $("#getStandard").parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

<<<<<<< HEAD
        // Save timetable
        $('body').delegate('#timeTableForm', 'submit', function(e){
            e.preventDefault();

            var btn=$('#submit');
=======
        // Save time table
        $('body').delegate('#timeTableForm', 'submit', function(e){
            e.preventDefault();
            // alert();
            var btn=$('#submit');           
>>>>>>> main

            $.ajax({
                url:"{{url('/class-time-table')}}",
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
                                window.location.reload();
                                // window.location.replace('/class-timetable-settings');
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
