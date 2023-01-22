@extends('layouts.master')

@section('content')
<div class="wrapper">
    @include('sliderbar')
    <div class="main-panel">
        @include('navigation')
        <div class="content">
            <div class="container-fluid">
                @if(Helper::checkAccess('practical-attendance', 'create'))
                    <div class="row">
                        <div class="col-sm-12 col-sm-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">event</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Add Practical Attendance</h4>
                                    <form method="GET" id="getPracticalAttendance" action="{{ url('/practical-attendance-filter') }}">
                                        <div class="row">
                                            <div class="col-lg-2 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Date<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control datepicker" name="attendance_date" value="{{ $_GET && $_GET['attendance_date']? $_GET['attendance_date'] : date('d/m/Y') }}" required />
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Practical Subject<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="practicalSubject" id="practicalSubject" data-size="4" data-style="select-with-transition" data-live-search="true" title="Select" required="required">
                                                        @foreach($practicalSubjects as $subject)
                                                            <option value="{{$subject['id']}}" @if($_REQUEST && $_REQUEST['practicalSubject'] == $subject['id']) {{ "selected" }} @endif>{{$subject['display_name'] . ' ' . $subject['subject_type']}}</option>
                                                        @endforeach
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

                                            <div class="col-lg-2 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Period<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="period" id="period" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" required="required>
                                                        @foreach($periods as $period)
                                                            <option value="{{$period['id']}}" @if($_REQUEST && $_REQUEST['period'] == $period['id']) {{ "selected" }} @endif>{{$period['name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Batch<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="batch" id="batch" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" required="required">

                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row text-right">
                                            <div class="col-lg-12">
                                                <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(isset($attendanceData))
                    <div class="row">
                        <div class="col-md-12 col-lg-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">event</i>
                                </div>

                                <form method="POST" id="practicalAttendanceForm" enctype="multipart/form-data">
                                    <input type="hidden" name="id_institute" value="{{session()->get('institutionId')}}">
                                    <input type="hidden" name="id_academic" value="{{session()->get('academicYear')}}">
                                    <input type="hidden" name="organization" value="{{session()->get('organizationId')}}">
                                        
                                    <input type="hidden" name="date" value="{{ $_GET && $_GET['attendance_date']? $_GET['attendance_date'] : date('d/m/Y') }}" />
                                    <input type="hidden" name="standard" value="{{$_GET['standard']}}" />
                                    <input type="hidden" name="practicalSubject" value="{{$_GET['practicalSubject']}}" />
                                    <input type="hidden" name="period" value="{{$_GET['period']}}" />
                                    <input type="hidden" name="batch" value="{{$_GET['batch']}}" />

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
                                                        <tr id="{{$attendance->id}}" style="background-color: #7bbc9c30">
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $attendance->roll_number }}</td>
                                                            <td>{{ $attendance->egenius_uid }}</td>
                                                            <td>{{ ucwords($attendance['studentName']) }}</td>
                                                            <td>
                                                                <div class="form-group label-floating">
                                                                    <div class="radio col-lg-4" style="margin-top:10px;">
                                                                        <label>
                                                                            <input type="radio" name="status[{{ $attendance->id }}]" value="PRESENT" @if($attendance->attendanceStatus === "PRESENT") {{'checked'}} @endif onclick="changeColorp('@php echo $attendance['id']; @endphp')">
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group label-floating">
                                                                    <div class="radio col-lg-4" style="margin-top:10px;">
                                                                        <label>
                                                                            <input type="radio" name="status[{{ $attendance->id }}]" value="ABSENT" @if($attendance->attendanceStatus === "ABSENT") {{'checked'}} @endif onclick="changeColora('@php echo $attendance['id']; @endphp')">
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <script>
                                                            function changeColorp(id) {
                                                                document.getElementById(id).style.background = "#7bbc9c30";
                                                            }
                                                            function changeColora(id) {
                                                                document.getElementById(id).style.background = "#f4433824";
                                                            }
                                                        </script>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="pull-right mt-10">
                                            <button type="submit" class="btn btn-info btn-wd mr-5" id="submit" name="submit">Submit</button>
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

        var standardId = getUrlVars()["standard"]; //alert(standardId);
        var subjectId = getUrlVars()["practicalSubject"]; //alert(subjectId);
        var batchId = getUrlVars()["batch"]; //alert(batchId);

        if(subjectId != ''){
            getStandard(subjectId);
        }

        if(standardId != ''){
            getStandardBatches(standardId);
        }

        // Get standard based on subject
        $("body").delegate("#practicalSubject", "change", function(event){
            event.preventDefault();

            var subjectId = $(this).val();
            getStandard(subjectId);
        });

        function getStandard(subjectId){
            $.ajax({
                url:"/quick-subject-standards",
                type:"POST",
                data: {subjectId : subjectId},
                success: function(data){
                    console.log(data);
                    var html = '';
                    $.each(data, function(index, item){
                        html += '<option value="'+item.id_standard+'"'; if(standardId == item.id_standard) html +='selected'; html+='>'+item.standard+'</option>';
                    });
                    $("#standard").html(html);
                    $("#standard").selectpicker('refresh');
                }
            });
        }

        // Get batch based on standard
        $("body").delegate("#standard", "change", function(event){
            event.preventDefault();

            var standardId = $(this).val();
            getStandardBatches(standardId);
        });

        function getStandardBatches(standardId){
            $.ajax({
                url:"/practical-attendance-batch",
                type:"POST",
                data: {standardId : standardId},
                success: function(data){
                    console.log(data);
                    var html = '';
                    $.each(data, function(index, item){
                        html += '<option value="'+item.id+'"'; if(batchId == item.id) html +='selected'; html+='>'+item.batch_name+'</option>';
                    });
                    $("#batch").html(html);
                    $("#batch").selectpicker('refresh');
                }
            });
        }

        $("#getPracticalAttendance").parsley({
	        triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save practical attendance
        $('body').delegate('#practicalAttendanceForm', 'submit', function(e){
            e.preventDefault();

            var btn=$('#submit');

            $.ajax({
                url:"{{url('/practical-attendance')}}",
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
