@php
    use Carbon\Carbon;
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
                    <div class="col-sm-12 col-sm-offset-0 text-right">
                        <a href="{{url('attendance-settings')}}" class="btn btn-finish btn-fill btn-wd btn btn-info"><i class="material-icons">arrow_back</i> Back</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">assessment</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Attendance Settings Details</h4>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Attendance Type</label>
                                            <input type="text" class="form-control" value="{{ucwords($settingsData->attendance_type)}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Standard</label>
                                            <input type="text" class="form-control" value="{{ucwords($settingsData->standard)}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Display Subject</label>
                                            <input type="text" class="form-control" value="{{ucwords($settingsData->display_subject)}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Is subject class timetable dependent</label>
                                            <input type="text" class="form-control" value="{{ucwords($settingsData->is_subject_classtimetable_dependent)}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-12 d-none">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Template</label>
                                            <textarea class="form-control" rows="2" disabled>{{$settingsData->id_template}}</textarea>
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
    });
</script>
@endsection


