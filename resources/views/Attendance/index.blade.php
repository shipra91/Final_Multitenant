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
                @if(Helper::checkAccess('student-attendance', 'create'))
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <a href="{{url('student-attendance/create')}}" class="btn btn-primary"><i class="material-icons">add</i> Add Attendance</a>
                        </div> 
                    </div>                       
                @endif

                @if(Helper::checkAccess('student-attendance', 'view'))
                    <div class="row">
                        <div class="col-sm-12 col-sm-offset-0">
                            <div class="card">
                                <div class="card-content">
                                    <form method="GET" id="attendanceDate">
                                        <div class="row">
                                            <div class="col-lg-3 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Standard<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="standard" id="standard" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" required="required">
                                                        @foreach($institutionStandards as $standard)
                                                            <option value="{{$standard['institutionStandard_id']}}" @if($_REQUEST && $_REQUEST['standard'] == $standard['institutionStandard_id']) {{ "selected" }} @endif>{{$standard['class']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Date<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control datepicker" name="attendance_date" id="attendance_date" value="{{ $_REQUEST ? $_REQUEST['attendance_date'] : date('d/m/Y')}}" required />
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5">Submit</button>
                                                    {{-- <button type='button' id="edit_attendance" class='btn btn-next btn-fill btn-success mr-5'>Edit</button>
                                                    <button onclick="window.history.go(-1)" class="btn btn-default">Close</button> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(isset($_GET['standard']))
                        <div class="row">
                            <div class="col-sm-12 col-sm-offset-0">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                        <i class="material-icons">event</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Attendance List</h4>
                                        <div class="material-datatables">
                                            <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" width="100%">
                                                <thead style="font-size:12px;">
                                                    <tr>
                                                        {{-- <th><b>Roll No</b></th> --}}
                                                        <th><b>UID</b></th>
                                                        <th><b>Name</b></th>
                                                        <th><b>Contact</b></th>
                                                        <th><b>Status</b></th>
                                                        <th><b>Working Period</b></th>
                                                        <th><b>Attended Period</b></th>
                                                        <th><b>Percentage</b></th>
                                                        <th><b>Action</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

        $("#attendanceDate").parsley({
	        triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // View student attendance
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: '{{ url('/student-attendance')}}',
                data: function (d) {
                    d.standard = $("#standard").val(),
                    d.attendance_date = $("#attendance_date").val()
                }
            },
            columns: [
                // {data: 'roll_number', name: 'roll_number', "width": "10%"},
                {data: 'egenius_uid', name: 'egenius_uid', "width": "10%"},
                {data: 'name', name: 'name', "width": "15%", className:"capitalize"},
                {data: 'father_mobile_number', name: 'father_mobile_number', "width": "10%"},
                {data: 'status', name: 'status', "width": "10%"},
                {data: 'workingDays', name: 'workingDays', "width": "15%"},
                {data: 'presentDays', name: 'presentDays', "width": "15%"},
                {data: 'percentage', name: 'percentage', "width": "15%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "10%"},
            ]
        });
    });
</script>
@endsection
