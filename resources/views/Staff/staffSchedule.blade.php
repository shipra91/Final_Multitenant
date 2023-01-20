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
                                <i class="material-icons">watch_later</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Staff Schedule</h4>
                                <form method="POST" id="staffScheduleForm" enctype="multipart/form-data">
                                    <div class="row">
                                        <input type="hidden" name="id_academic" value="{{session()->get('academicYear')}}">
                                        <input type="hidden" id="staffId" name="staffId" value="{{ $staffId }}">
                                        <input type="hidden" id="daysArray" name="daysArray" value="{{ implode(",", $daysArray) }}">
                                        <div class="col-lg-12 col-lg-offset-0">
                                            <div class="repeaterData">
                                                @foreach ($daysArray as $day)
                                                    <div id="repeater_{{ $day }}">
                                                        <input type="hidden" name="totalCount_{{ $day }}" id="totalCount_{{ $day }}" value="{{ count($staffSchedules[$day])>0?count($staffSchedules[$day]):1 }}">

                                                        @if(count($staffSchedules[$day]) > 0)

                                                            @foreach($staffSchedules[$day] as $key => $staffSchedule)
                                                                <div class="row" id="section_{{ $day }}_{{ $key + 1 }}" data-id="{{ $day }}_{{ $key + 1 }}">
                                                                    <div class="col-lg-2 col-lg-offset-0">
                                                                        <div class="form-group">
                                                                            <h6 class="h6 mt-40 fw-400">{{ $day }}</h6>
                                                                            <input type="hidden" name="scheduleId_{{ $day }}[]" value="{{ $staffSchedule->id }}">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-4 col-lg-offset-0">
                                                                        <div class="form-group">
                                                                            <label class="control-label mt-0">From Time</label>
                                                                            <input type="text" class="form-control timepicker" name="fromTime_{{ $day }}[]" value="{{ $staffSchedule->start_time }}"/>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-4 col-lg-offset-0">
                                                                        <div class="form-group">
                                                                            <label class="control-label mt-0">To Time</label>
                                                                            <input type="text" class="form-control timepicker" name="toTime_{{ $day }}[]" value="{{ $staffSchedule->end_time }}"/>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-2 col-lg-offset-0">
                                                                        <div class="form-group">
                                                                            <button type="button" id="{{ $day }}_1" class="btn btn-danger btn-sm mt-15 remove_button"><i class="material-icons">highlight_off</i></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach

                                                        @else

                                                            <div class="row" id="section_{{ $day }}_1" data-id="{{ $day }}_1">
                                                                <div class="col-lg-2 col-lg-offset-0">
                                                                    <div class="form-group">
                                                                        <h6 class="h6 mt-40 fw-400">{{ $day }}</h6>
                                                                        <input type="hidden" name="scheduleId_{{ $day }}[]" class="form-control" value="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-lg-offset-0">
                                                                    <div class="form-group">
                                                                        <label class="control-label mt-0">From Time</label>
                                                                        <input type="text" class="form-control timepicker" name="fromTime_{{ $day }}[]"/>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-4 col-lg-offset-0">
                                                                    <div class="form-group">
                                                                        <label class="control-label mt-0">To Time</label>
                                                                        <input type="text" class="form-control timepicker" name="toTime_{{ $day }}[]"/>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-2 col-lg-offset-0">
                                                                    <button type="button" id="{{ $day }}_1" class="btn btn-danger btn-sm mt-30 remove_button"><i class="material-icons">highlight_off</i></button>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <button id="add_more_{{ $day }}" type="button" class="btn btn-warning mb-30 btn-sm"><i class="material-icons">add_circle_outline</i> Add</button>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-lg-offset-0 text-right">
                                            <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Submit</button>
                                            <a href="{{url('staff')}}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
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

        $('.timepicker').datetimepicker({
            format: 'LT'
        });

        // Add more staff schedule
        let days = $("#daysArray").val();
        const dayArray = days.split(",");
        dayArray.forEach(function(day){

            var count = $('#totalCount_'+ day).val();

            $(document).on('click', '#add_more_'+day, function(){

                var html = '';
                count++;

                html += ' <div class="row" id="section_'+day+'_'+count+'" data-id="'+day+'_'+count+'">';
                html += ' <div class="col-lg-2 col-lg-offset-0">';
                html += ' <div class="form-group">';
                html += ' <h6 class="h6 mt-40 fw-400">'+day+'</h6>';
                html += ' <input type="hidden" name="scheduleId_'+day+'[]" value="">';
                html += ' </div>';
                html += ' </div>';

                html += ' <div class="col-lg-4 col-lg-offset-0">';
                html += ' <div class="form-group">';
                html += ' <label class="control-label mt-0">From Time</label>';
                html += ' <input type="text" class="form-control timepicker" id="fromTimepicker_'+day+'_'+count+'" name="fromTime_'+day+'[]" />';
                html += ' </div>';
                html += ' </div>';

                html += ' <div class="col-lg-4 col-lg-offset-0">';
                html += ' <div class="form-group">';
                html += ' <label class="control-label mt-0">To Time</label>';
                html += ' <input type="text" class="form-control timepicker" id="toTimepicker_'+day+'_'+count+'" name="toTime_'+day+'[]"/>';
                html += ' </div>';
                html += ' </div>';

                html += ' <div class="col-lg-2 col-lg-offset-0">';
                html += ' <div class="form-group">';
                html += ' <button type="button" id="'+day+'_'+count+'" class="btn btn-danger btn-sm mt-15 remove_button"><i class="material-icons">highlight_off</i></button>';
                html += ' </div>';
                html += ' </div>';
                html += ' </div>';

                $('#repeater_'+day).append(html);
                $("#totalCount_"+day).val(count);
                $('#toTimepicker_'+day+'_'+count).datetimepicker({
                    format: 'LT'
                });

                $('#fromTimepicker_'+day+'_'+count).datetimepicker({
                    format: 'LT'
                });
            });
        }) ;

        // Remove staff schedule
        $(document).on('click', '.remove_button', function(event){
            event.preventDefault();

            var id = $(this).attr('id');
            var data = id.split("_");
            var day = data[0];
            var totalCount = $("#totalCount_"+day).val();

            $(this).closest('div #section_'+id+'').remove();
            totalCount--;

            $("#totalCount_"+day).val(totalCount);
        });

        // Save staff schedule
        $('body').delegate('#staffScheduleForm', 'submit', function(e){
            e.preventDefault();

            var btn=$('#submit');

            $.ajax({
                url:"{{url('/staff-schedule')}}",
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
                            }).then(function(){
                                window.location.replace('/staff');
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

