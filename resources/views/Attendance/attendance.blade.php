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
                                <h4 class="card-title">Add Student Attendance</h4>
                                <form method="GET" action="{{ url('/student-attendance-filter') }}" id="getstudentAttendance">
                                    <div class="row">
                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Date<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker" name="attendance_date" value="{{ $_GET && $_GET['attendance_date']? $_GET['attendance_date'] : date('d/m/Y') }}" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Attendance Type<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="attendanceType" id="attendanceType" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" required="required">
                                                    <option value="{{'daywise'}}" @if($_REQUEST && $_REQUEST['attendanceType'] == 'daywise') {{ "selected" }} @endif>{{'Daywise'}}</option>
                                                    <option value="{{'sessionwise'}}" @if($_REQUEST && $_REQUEST['attendanceType'] == 'sessionwise') {{ "selected" }} @endif>{{'Sessionwise'}}</option>
                                                    <option value="{{'periodwise'}}" @if($_REQUEST && $_REQUEST['attendanceType'] == 'periodwise') {{ "selected" }} @endif>{{'Periodwise'}}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Standard<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="standard" id="standard" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" required="required">

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0 {{ $_REQUEST && $_REQUEST['attendanceType'] == "sessionwise" ?"":'d-none'}}" id="sessionDiv">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Session</label>
                                                <select class="selectpicker" name="session" id="session" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select">
                                                    @foreach($allSessions as $session)
                                                        <option value="{{$session['id']}}" @if($_REQUEST && $_REQUEST['session'] == $session['id']) {{ "selected" }} @endif>{{$session['name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0 {{ $_REQUEST && $_REQUEST['attendanceType'] == "periodwise" ?"":'d-none'}} mb-5" id="periodDiv">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Period</label>
                                                <select class="selectpicker" name="period" id="period" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select">
                                                    @foreach($allPeriods as $period)
                                                        <option value="{{$period['id']}}" @if($_REQUEST && $_REQUEST['period'] == $period['id']) {{ "selected" }} @endif>{{$period['name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-lg-offset-0 {{ $_REQUEST && $_REQUEST['attendanceType'] == "periodwise" ?"":'d-none'}}" id="subjectDiv">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Subject</label>
                                                <select class="selectpicker" name="subject" id="subject" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select">

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row text-right">
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5">Submit</button>
                                            <a href="{{ url('student-attendance') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @if(isset($attendanceData))

                    <div class="row">
                        <div class="col-md-12 col-lg-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">event</i>
                                </div>

                                <form method="POST" id="studentAttendanceForm" enctype="multipart/form-data">
                                    <input type="hidden" name="idInstitute" value="{{session()->get('institutionId')}}">
                                    <input type="hidden" name="idAcademic" value="{{session()->get('academicYear')}}">
                                    <input type="hidden" name="date" value="{{ $_GET && $_GET['attendance_date']? $_GET['attendance_date'] : date('d/m/Y') }}" />
                                    <input type="hidden" name="periodSession" value="@if($_GET['attendanceType']==='periodwise'){{$_GET['period']}} @elseif($_GET['attendanceType']==='sessionwise'){{$_GET['session']}} @endif"  />
                                    <input type="hidden" name="standard" value="{{$_GET['standard']}}" />
                                    <input type="hidden" name="subject" value="{{$_GET['subject']}}" />
                                    <input type="hidden" name="attendanceType" value="{{$_GET['attendanceType']}}" />

                                    <div class="card-content">
                                        <h4 class="card-title">@php echo date('d M Y', strtotime(str_replace('/', '-', $_GET['attendance_date']))); @endphp</h4>
                                        <div class="material-datatables mt-20">
                                            <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" width="100%">
                                                <thead style="font-size:12px;">
                                                    <tr>
                                                        <th><b>S.N.</b></th>
                                                        <th><b>Roll No</b></th>
                                                        <th><b>UID</b></th>
                                                        <th><b>Name</b></th>
                                                        <th><b>Present</b></th>
                                                        <th><b>Absent</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($attendanceData as $index => $attendance)

                                                        <tr id="{{$attendance->id}}" style="background-color: #d9edf7">
                                                            <td>{{$index + 1}}</td>
                                                            <td>{{$attendance->roll_number}}</td>
                                                            <td>{{$attendance->egenius_uid }}</td>
                                                            <td>{{$attendance->name}}</td>
                                                            <td>
                                                                <div class="form-group label-floating">
                                                                    <div class="radio col-lg-4" style="margin-top:10px;">
                                                                        <label>
                                                                            <input type="radio" name="status[{{$attendance->id}}]" value="PRESENT" @if($attendance->attendanceStatus === "PRESENT") {{'checked'}} @endif onclick="changeColorp('@php echo $attendance['id']; @endphp')">
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group label-floating">
                                                                    <div class="radio col-lg-4" style="margin-top:10px;">
                                                                        <label>
                                                                            <input type="radio" name="status[{{$attendance->id}}]" value="ABSENT" @if($attendance->attendanceStatus === "ABSENT") {{'checked'}} @endif onclick="changeColora('@php echo $attendance['id']; @endphp')">
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <script>
                                                            function changeColorp(id) {
                                                                document.getElementById(id).style.background = "#d9edf7";
                                                            }
                                                            function changeColora(id) {
                                                                document.getElementById(id).style.background = "#fcf8e3";
                                                            }
                                                        </script>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="pull-right mt-10">
                                            <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Submit</button>
                                            <a href="{{ url('student-attendance') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
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

        function getUrlVars(){

            var vars = [], hash;
            var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');

            for(var i = 0; i < hashes.length; i++){

                hash = hashes[i].split('=');
                vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            }

            return vars;
        }

        var attendanceType = getUrlVars()["attendanceType"];
        var standard = getUrlVars()["standard"]; //alert(standard);
        var subject = getUrlVars()["subject"];

        if(attendanceType != ''){
            getStandardOnAttendanceType(attendanceType);
        }

        if(standard != ''){
            getStandardSubject(standard);
        }

        // Get standard based on attendance type
        function getStandardOnAttendanceType(attendanceType){

            $.ajax({
                url:"/attendance-standard",
                type:"post",
                data : {attendanceType : attendanceType},
                success:function(result){
                    console.log(result);
                    var html = '';
                    $.each(result.standardData, function(index, item){
                        html += '<option value="'+item.id_standard+'"'; if(standard == item.id_standard) html +='selected'; html+='>'+item.standard+'</option>';
                    });

                    $("#standard").html(html);
                    $("#standard").selectpicker('refresh');
                }
            });
        }

        // Get subject on standard selection
        function getStandardSubject(standardId){

            $.ajax({
                url:"/assignment-subjects",
                type:"POST",
                data: {standardId : standardId},
                success: function(data){
                    var options = '';
                    $.map(data, function(item, index){

                        var subject_type = '';

                        if(item.subject_type === "PRACTICAL"){
                            subject_type = ' - '+item.subject_type;
                        }else{
                            subject_type = '';
                        }

                        options += '<option value="'+item.id_institution_subject+'"'; if(subject == item.id_institution_subject) options +='selected'; options+='>'+item.display_name+''+ subject_type+'</option>';
                    });

                    $("#subject").html(options);
                    $("#subject").selectpicker('refresh');
                }
            });
        }

        // Hide and show fields based on attendance type
        $("#attendanceType").on("change", function(event){
            event.preventDefault();

            var attendanceType = $(this).val();

            if(attendanceType == 'daywise'){

                $("#sessionDiv").addClass('d-none');
                $("#periodDiv").addClass('d-none');
                $("#subjectDiv").addClass('d-none');

            }else if(attendanceType == 'sessionwise'){

                $("#sessionDiv").removeClass('d-none');
                $("#periodDiv").addClass('d-none');
                $("#subjectDiv").addClass('d-none');

            }else if(attendanceType == 'periodwise'){

                $("#sessionDiv").addClass('d-none');
                $("#periodDiv").removeClass('d-none');
                $("#subjectDiv").removeClass('d-none');
            }

            $("#subject").html('');
            $("#subject").selectpicker('refresh');

            // Get standard based on attendance type
            getStandardOnAttendanceType(attendanceType);
        });

        // Get subject on standard selection
        $('#standard').on('change', function(){
            var standardId = $(this).val();
            getStandardSubject(standardId);

        });

        $("#getstudentAttendance").parsley({
	        triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save student attendance
        $('body').delegate('#studentAttendanceForm', 'submit', function(e){
            e.preventDefault();

            var btn=$('#submit');

            $.ajax({
                url:"{{url('/student-attendance')}}",
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
                                window.location.replace('/student-attendance');
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
