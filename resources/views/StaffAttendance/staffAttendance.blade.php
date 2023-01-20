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
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">event</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Add Staff Attendance</h4>
                                <form method="GET" action="{{url('/staff-attendance/filter')}}" id="getStaffAttendance">
                                    <div class="row">
                                        <input type="hidden" name="idInstitute" value="{{session()->get('institutionId')}}">
                                        <input type="hidden" name="idAcademic" value="{{session()->get('academicYear')}}">

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Attendance Date<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker" name="attendanceDate" id="attendanceDate" value="@php echo date('d/m/Y'); @endphp"required />
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Staff Category<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="staffCategory" id="staffCategory" data-style="select-with-transition" title="Select" required="required">
                                                    {{-- @foreach($attendanceDetails['staffCategory'] as $staffCategory)
                                                        <option value="{{$staffCategory->id}}">{{ucwords($staffCategory->name)}}</option>
                                                    @endforeach --}}
                                                    @foreach($attendanceDetails['staffCategory'] as $staffCategory)
                                                        <option value="{{$staffCategory['id']}}" @if($_REQUEST && $_REQUEST['staffCategory'] == $staffCategory['id']) {{ "selected" }} @endif>{{$staffCategory['name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5">Submit</button>
                                                <a href="{{ url('staff-attendance') }}" class="btn btn-danger">Close</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @if(isset($attendanceData))
                    <div class="row mt-5">
                        <div class="col-sm-12 col-sm-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">event</i>
                                </div>
                                <form method="POST" id="staffAttendanceForm" enctype="multipart/form-data">
                                    <input type="hidden" name="idInstitute" value="{{session()->get('institutionId')}}">
                                    <input type="hidden" name="idAcademic" value="{{session()->get('academicYear')}}">
                                    <input type="hidden" name="staffCategory" value="{{request()->get('staffCategory')}}">
                                    <input type="hidden" name="date" value="@php echo date('d/m/Y'); @endphp" />
                                    <div class="card-content">
                                        <h4 class="card-title">@php echo date('d M Y'); @endphp</h4>
                                        <div class="material-datatables mt-20">
                                            <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" width="100%">
                                                <thead style="font-size:12px;">
                                                    <tr>
                                                        <th><b>S.N.</b></th>
                                                        <th><b>Staff Id</b></th>
                                                        <th><b>Name</b></th>
                                                        <th><b>Present</b></th>
                                                        <th><b>Absent</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($attendanceData as $index => $attendance)
                                                        <tr id="{{$attendance->id}}" style="background-color: #d9edf7">
                                                            <td>{{$index + 1}}</td>
                                                            <td>{{$attendance->staff_uid}}</td>
                                                            <td>{{ucwords($attendance->name)}}</td>
                                                            <td>
                                                                <div class="form-group label-floating">
                                                                    <div class="radio col-lg-4" style="margin-top:10px;">
                                                                        <label>
                                                                            <input type="radio" name="status[{{$attendance->id}}]" value="present" @if($attendance->attendanceStatus === "present") {{'checked'}} @endif onclick="changeColorp('@php echo $attendance['id']; @endphp')">
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group label-floating">
                                                                    <div class="radio col-lg-4" style="margin-top:10px;">
                                                                        <label>
                                                                            <input type="radio" name="status[{{$attendance->id}}]" value="absent" @if($attendance->attendanceStatus === "absent") {{'checked'}} @endif onclick="changeColora('@php echo $attendance['id']; @endphp')">
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <script>
                                                            function changeColorp(id){
                                                                document.getElementById(id).style.background = "#d9edf7";
                                                            }
                                                            function changeColora(id){
                                                                document.getElementById(id).style.background = "#fcf8e3";
                                                            }
                                                        </script>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="pull-right mt-10">
                                            <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Submit</button>
                                            <input type="button" class="btn btn-finish btn-fill btn-danger btn-wd" onclick="window.history.go(-1)" name="close" value="close" />
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

        $("#getStaffAttendance").parsley({
	        triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save staff attendance
        $('body').delegate('#staffAttendanceForm', 'submit', function(e){
            e.preventDefault();

            var btn=$('#submit');

            $.ajax({
                url:"{{url('/staff-attendance')}}",
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
                                window.location.replace('/staff-attendance');
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
