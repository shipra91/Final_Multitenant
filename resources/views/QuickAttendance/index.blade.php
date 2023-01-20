@extends('layouts.master')

@section('content')
<div class="wrapper">
    @include('sliderbar')
    <div class="main-panel">
        @include('navigation')
        <div class="content">
            <div class="container-fluid">

                @if(Helper::checkAccess('quick-attendance', 'create'))
                    
                    <div class="alert alert-danger" role="alert">
                        <strong>Note:</strong> Please fill all the required fields (with *) before student search</p>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">assessment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Add Attendance</h4>
                                    <form method="POST" id="studentAbsentForm">
                                        <div class="row">
                                            <div class="col-lg-3 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Date <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control datepicker" name="attendanceDate" id="attendanceDate" value="@php echo date('d/m/Y'); @endphp" required />
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Attendance Type <span class="text-danger">*</span></label>
                                                    <select class="selectpicker attendanceType" name="attendanceType" id="attendanceType" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" required="required">
                                                        <option value="daywise">Daywise</option>
                                                        <option value="sessionwise">Sessionwise</option>
                                                        <option value="periodwise">Periodwise</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-lg-offset-0 d-none" id="sessionDiv">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Session<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="session" id="session" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" >
                                                        @foreach($attendanceData['sessions'] as $session)
                                                            <option value="{{$session['id']}}">{{$session['name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-lg-offset-0 d-none" id="periodDiv">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Period<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="period" id="period" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" >
                                                        @foreach($attendanceData['period'] as $periods)
                                                            <option value="{{$periods['id']}}">{{$periods['name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-3" id="subjectDiv">
                                            </div>
                                        </div>

                                        <div class="row mt-20" id="standardDiv">

                                        </div>

                                        <div class="row mt-30">
                                            <div class="col-lg-6 col-lg-offset-3">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">search</i>
                                                    </span>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control autocomplete" id="autocomplete" placeholder="Search & select student name here" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12 col-lg-offset-0">
                                                <table class="table table-striped table-no-bordered table-hover mt-30">
                                                    <thead style="font-size:12px;">
                                                        <tr>
                                                            <th width="10%"><b>UID</b></th>
                                                            <th width="20%"><b>Student</b></th>
                                                            <th width="30%"><b>Standard</b></th>
                                                            <th width="30%"><b>Father Mobile</b></th>
                                                            <th width="10%"><b>Remove</b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="selectedStudent">

                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="col-lg-12 col-lg-offset-0">
                                                <div class="text-center pt-10">
                                                    <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd" id="submit" disabled>Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(Helper::checkAccess('quick-attendance', 'view'))
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">assessment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Absent Students List</h4>
                                    <div class="material-datatables">
                                        <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                            <thead style="font-size:12px;">
                                                <th><b>S.N.</b></th>
                                                <th><b>UID</b></th>
                                                <th><b>Name</b></th>
                                                <th><b>Standard</b></th>
                                                <th><b>Phone</b></th>
                                                <th><b>Action</b></th>
                                            </thead>
                                            <tbody id="absentStudent">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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

        // View absent student list
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "/absent-student-list/",
            columns: [
                {data: 'DT_RowIndex', name: 'id', "width": "10%"},
                {data: 'uid', name: 'uid', "width": "10%"},
                {data: 'student_name', name: 'student_name', "width": "25%", className:"capitalize"},
                {data: 'standard', name: 'standard', "width": "25%"},
                {data: 'phone', name: 'phone', "width": "15%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "15%"},
            ]
        });

        // Get standard
        $("#attendanceType").on("change", function(event){
            event.preventDefault();

            var attendanceType = $(this).val();

            if(attendanceType == 'daywise'){

                $("#sessionDiv").addClass('d-none');
                $("#periodDiv").addClass('d-none');
                $("#subjectDiv").addClass('d-none');
                $("#period, #subject").attr('required', false);

            }else if(attendanceType == 'sessionwise'){

                $("#sessionDiv").removeClass('d-none');
                $("#periodDiv").addClass('d-none');
                $("#subjectDiv").addClass('d-none');
                $("#period, #subject").attr('required', false);

            }else if(attendanceType == 'periodwise'){

                $("#sessionDiv").addClass('d-none');
                $("#periodDiv").removeClass('d-none');
                $("#subjectDiv").removeClass('d-none');
                $("#period").attr('required', true);
            }

            $.ajax({
                url:"/attendance-standard",
                type:"post",
                data : {attendanceType : attendanceType},
                success:function(result){
                    
                    var html = '';

                    if(attendanceType !== 'periodwise'){

                        $.each(result['standardData'], function(index, item){
                            html += '<div class="col-lg-3 checkbox mt-0"><label><input type="checkbox" name="standard_id[]" class="standard_id" value="'+item.id_standard+'" checked />'+item.standard+'</label></div>';
                        });
                        $("#standardDiv").removeClass('d-none');
                        $("#standardDiv").html(html);
                        $("#standardDiv").selectpicker('refresh');

                    }else{

                        html += '<div class="form-group">';
                        html += '<label class="control-label mt-0">Subject<span class="text-danger">*</span></label>';
                        html += '<select class="selectpicker subject" name="subject" id="subject" data-size="4" data-style="select-with-transition" data-live-search="true" title="Select">';

                        $.each(result['subjectData'], function(index, item){

                            if(item.subject_type === "PRACTICAL"){

                                var displayName = item.display_name+'-'+item.subject_type;

                            }else{

                                var displayName = item.display_name;
                            }

                            html += '<option value="'+item.id+'">'+displayName+'</option>';
                        });

                        html += '</select>';
                        html +=  '</div>';

                        $("#standardDiv").addClass('d-none');
                        $("#subjectDiv").html(html);
                        $(".subject").selectpicker();
                        $("#subjectDiv").selectpicker('refresh');
                        $("#subject").attr('required', true);
                    }
                }
            });
        });

        // Get standard based on subject selection
        $("body").delegate("#subject", "change", function(event){
            event.preventDefault();

            var attendanceType = $("#attendanceType").val();
            var subjectId = $(this).val();

            $.ajax({
                url:"/quick-subject-standards",
                type:"POST",
                data: {subjectId : subjectId, attendanceType : attendanceType},
                success: function(data){
                    //console.log(data);
                    var html = '';
                    $.each(data, function(index, item){
                        html += '<div class="col-lg-3 checkbox mt-0"><label><input type="checkbox" name="standard_id[]" class="standard_id" value="'+item.id_standard+'" checked />'+item.standard+'</label></div>';
                    });

                    $("#standardDiv").removeClass('d-none');
                    $("#standardDiv").html(html);
                    $("#standardDiv").selectpicker('refresh');
                }
            });
        });

        // Get students
        $('#autocomplete').autocomplete({
            source: function( request, response ){

                var standardId = [];
                var details = [];

                var attendanceType = '';
                var subject = '';

                if($("#attendanceType").val()){
                    attendanceType = $("#attendanceType").val();
                }
                if($("#subject").val()) {
                    subject = $("#subject").val();
                }

                $.each($("input[name='standard_id[]']:checked"), function (K, V){
                    standardId.push(V.value);
                });

                details.push(attendanceType);
                details.push(standardId);
                details.push(subject);

                $.ajax({
                    type: "POST",
                    url: '{{ url("attendance-student-search") }}',
                    dataType: "json",
                    data: {term: request.term, details:details},
                    success: function( data ){
                        response(data);
                        response( $.map( data, function( item ){
                            var code = item.split("@");
                            console.log(code);
                            var code1 = item.split("|");
                            return {
                                label: code[0],
                                value: code[0],
                                data : item
                            }
                        }));
                    }
                });
            },
            autoFocus: true,
            minLength: 2,
            select: function( event, ui ){

                var names = ui.item.data.split("@");
                var insert = true;
                var length = $('#selectedStudent tr').length;
                var absentLength = $('#absentStudent tr').length;
                var attendanceDate = $('#attendanceDate').val();

                if(length >0 || absentLength > 0){

                    $('#selectedStudent tr,#absentStudent tr').each(function(){

                        if($(this).attr("id") == names[1]){

                            swal({
                                title: "Student Already Added!",
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-success"
                            }).catch(swal.noop)
                            $("#autocomplete").val("");
                            insert = false;
                        }
                    });
                }

                if(insert == true){
                    $("#selectedStudent").append('<tr id='+names[1]+'><input type="hidden" name="student[]" value="'+names[1]+'" /><input type="hidden" name="'+ui.item.std_id+'" value="0" /><input type="hidden" name="hiddenDate" value="'+attendanceDate+'" /><td>'+names[5]+'</td><td>'+names[2]+'</td><td>'+names[3]+'</td><td>'+names[4]+'</td><td><button type="button" rel="tooltip" class="btn btn-danger btn-xs deleteStudent" data-id = '+names[1]+' title=""  data-original-title="delete"><i class="material-icons">close</i><div class="ripple-container"></div></button></td></tr>');
                    $("#autocomplete").val("");
                }

                if($('#selectedStudent tr').length > 0){
                    $("#submit").attr('disabled', false);
                }else{
                    $("#submit").attr('disabled', true);
                }

                return false;
            }
	    });

        // Remove student
        $("body").delegate(".deleteStudent", "click", function(event){
            event.preventDefault();

            var studentId=$(this).attr('data-id');

            $("#selectedStudent tr#"+studentId).remove();
            $("#absentStudent tr#"+studentId).remove();

            var length = $('#selectedStudent tr').length;

            if(length == 0){
                $("#modalAbsent").modal('hide');
                $("#submit").attr('disabled', true);
            }
        });

        // Save quick attendance
        $('body').delegate('#studentAbsentForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');

            $.ajax({
                url:"/quick-attendance",
                type:"POST",
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

        // Delete quick attendance
        $("body").delegate(".absentDetails", "click", function(event){
            event.preventDefault();

            var absentStudentId = $(this).attr('data-id');

            if(confirm("Are you sure want to Mark as present ?")){

                $.ajax({
                    url:"/quick-attendance/"+absentStudentId,
                    type:"POST",
                    dataType:"json",
                    success: function (result){

                        if(result['status'] == "200"){

                            if(result.data['signal'] == "success"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function() {
                                    window.location.reload();
                                }).catch(swal.noop)

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
            }

            return false;
        });
    });
</script>
@endsection







