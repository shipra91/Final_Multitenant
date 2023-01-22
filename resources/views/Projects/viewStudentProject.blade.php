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
                                <i class="material-icons">assignment</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Project List</h4>
                                <input type="hidden" id="projectId" value="{{ request()->route()->parameters['id'] }}"/>
                                <div class="material-datatables">
                                    <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                        <thead style="font-size:12px;">
                                            <tr>
                                                <th><b>S.N.</b></th>
                                                <th><b>Student Name</b></th>
                                                <th><b>Submitted Date</b></th>
                                                <th><b>Submitted Time</b></th>
                                                <th><b>View Count</b></th>
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
            </div>
        </div>
    </div>
</div>

<!-- Before submission start -->
<div class="modal fade" id="resubmission_permission_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="permissionForm" enctype = "multipart/form-data">
            <input type="hidden" id="student_id" name="student_id">
            <input type="hidden" id="project_id" name="project_id">
            <div class="modal-content">
                <div class="card1">
                    <div class="card-header card-header-tabs" data-background-color="mediumaquamarine">
                        <p class="card-title1 mb-5 font-15" id="project_name"></p>
                        <p class="font-15" style="margin:0; display:inline;" id="staff_name">&nbsp;</p>
                        <p style="margin:5px; display:inline; border-right:1px solid rgba(255, 255, 255, 0.62); font-size:11px;"></p>
                        <p class="font-15" style="margin:5px;display:inline" align="right" id="subject_name"></p>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="row" id="resubmission_option">
                    </div>
                    <div class="row d-none" id="resubmission_date_time">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label mt-0">Re-submission Date</label>
                                <input type="text" class="form-control datepicker" name="resubmission_date" id="resubmission_date" data-parsley-trigger="change" value="{{date('d-m-Y')}}" />
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label mt-0">Re-submission Time</label>
                                <input type="text" class="form-control timepicker" name="resubmission_time"  id="resubmission_time" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-info btn-wd mr-5" id="submit_permission" name="submit">Submit</button>
                                <button type="button" class="btn btn-danger btn-wd" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- After submission start -->
<div class="modal fade" id="project_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="markCommentForm" enctype = "multipart/form-data">
            <input type="hidden" id="id_project_submission">
            <input type="hidden" id="grading_option">
            <input type="hidden" id="gradeValues">
            <input type="hidden" id="maxMarksValue">
            <input type="hidden" id="obtainedMark">
            <div class="modal-content">
                <div class="card1">
                    <div class="card-header card-header-tabs" data-background-color="mediumaquamarine">
                        <p class="card-title1 mb-5 font-15" id="project_name"></p>
                        <p class="font-15" style="margin:0; display:inline;" id="staff_name">&nbsp;</p>
                        <p style="margin:5px; display:inline; border-right:1px solid rgba(255, 255, 255, 0.62); font-size:11px;"></p>
                        <p class="font-15" style="margin:5px; display:inline" align="right" id="subject_name"></p>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label mt-0">Add Comment </label>
                                <textarea class="form-control" name="comment" id="comment" rows="1"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="resubmissionOption">
                    </div>

                    <div class="row d-none" id="resubmissionDateTime">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label mt-0">Re-submission Date</label>
                                <input type="text" class="form-control datepicker" name="resubmissionDate" id="resubmissionDate" data-parsley-trigger="change" value="{{date('d-m-Y')}}" />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label mt-0">Re-submission Time</label>
                                <input type="text" class="form-control timepicker" name="resubmissionTime"  id="resubmissionTime"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <input type="hidden" id="max_marks">
                        <div class="col-md-12 d-none" id="grade">
                        </div>
                        <div class="col-md-12 d-none" id="marks">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Submit</button>
                                <button type="button" class="btn btn-danger btn-wd" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </form>
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

        // View Project
        var projectId = $('#projectId').val();
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "/project-submission-student/"+projectId,
            columns: [
                {data: 'DT_RowIndex', name: 'id', "width": "8%"},
                {data: 'student_name', name: 'student_name', "width": "27%", className:"capitalize"},
                {data: 'submitted_date', name: 'submitted_date', "width": "15%"},
                {data: 'submitted_time', name: 'submitted_time', "width": "15%"},
                {data: 'view_count', name: 'view_count', "width": "15%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "20%", className:"text-center"},
            ]
        });

        // Before submission start
        $("body").delegate(".giveResubmissionPermission", "click", function(event){
            event.preventDefault();

            var studentId=$(this).attr('data-id');
            var projectId=$(this).attr('project-id');

            $.ajax({
                url:"{{ url('/project-valuation-details') }}",
                type : "post",
                dataType : "json",
                data : {projectId:projectId, studentId:studentId},
                success : function(response){
                    // console.log(response);
                    var html = '';
                    var resubmissionOption = '';
                    $("#resubmission_permission_modal").find("#project_name").text("Project Name: "+response.project_name);
                    $("#resubmission_permission_modal").find("#staff_name").text("Staff Name: "+response.staff_name);
                    $("#resubmission_permission_modal").find("#subject_name").text("Subject Name: "+response.subject_name);

                    resubmissionOption += '<div class="col-md-12">';
                    resubmissionOption += '<div class="form-group">';
                    resubmissionOption += '<label class="control-label mt-0">Resubmission Allowed?</label>';
                    resubmissionOption += '<select class="selectpicker resubmission_allowed" name="resubmission_allowed" id="resubmission_allowed" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required">';
                    resubmissionOption += '<option value ="YES"'; if(response.resubmission_allowed == 'YES') resubmissionOption += 'selected'; resubmissionOption +='>YES</option>';
                    resubmissionOption += '<option value ="NO"'; if(response.resubmission_allowed == 'NO') resubmissionOption += 'selected'; resubmissionOption +='>NO</option>';
                    resubmissionOption += '</select>';
                    resubmissionOption += '</div>';
                    resubmissionOption += '</div>';

                    if(response.resubmission_allowed == 'NO'){
                        $('#resubmission_date_time').addClass('d-none');
                    }else{
                        $('#resubmission_date_time').removeClass('d-none');
                    }

                    $("#resubmission_permission_modal").find("#resubmission_option").html(resubmissionOption);
                    $("#resubmission_permission_modal").find("#student_id").val(studentId);
                    $("#resubmission_permission_modal").find("#resubmission_date").val(response.resubmission_date);
                    $("#resubmission_permission_modal").find("#resubmission_time").val(response.resubmission_time);
                    $("#resubmission_permission_modal").find("#project_id").val(projectId);
                    $("#resubmission_permission_modal").find('tbody').html(html);
                    $("#resubmission_permission_modal").modal('show');
                    $('.resubmission_allowed').selectpicker('refresh');
                }
            });
        });

        $("body").delegate(".resubmission_allowed", "change", function(event){

            var resubmission_allowed = $("#resubmission_allowed").val();
            //console.log(resubmission_allowed);

            if(resubmission_allowed == "YES"){
                $('#resubmission_date_time').removeClass('d-none');
            }else{
                $('#resubmission_date_time').addClass('d-none');
            }
        });

        $('body').delegate('#permissionForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit_permission');

            $.ajax({
                url:"/project-submission-permission",
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

        // After submission start
        $("body").delegate(".addMarkComment", "click", function(event){
            event.preventDefault();

            var studentId=$(this).attr('data-id');
            var projectId=$(this).attr('project-id');

            $.ajax({
                url:"{{ url('/project-valuation-details') }}",
                type : "post",
                dataType : "json",
                data : {projectId:projectId, studentId:studentId},
                success : function(response){
                    //console.log(response);
                    var html = '';
                    var gradingOption = '';
                    var gradeValue = '';
                    var marksValue = '';

                    resubmissionOption = '';

                    $("#project_modal").find("#project_name").text("Project Name: "+response.project_name);
                    $("#project_modal").find("#staff_name").text("Staff Name: "+response.staff_name);
                    $("#project_modal").find("#subject_name").text("Subject Name: "+response.subject_name);

                    resubmissionOption += '<div class="col-md-12">';
                    resubmissionOption += '<div class="form-group">';
                    resubmissionOption += '<label class="control-label mt-0">Resubmission Allowed?</label>';
                    resubmissionOption += '<select class="selectpicker resubmissionAllowed" name="resubmissionAllowed" id="resubmissionAllowed" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" >';
                    resubmissionOption += '<option value ="YES"'; if(response.resubmission_allowed == 'YES') resubmissionOption += 'selected'; resubmissionOption +='>YES</option>';
                    resubmissionOption += '<option value ="NO"'; if(response.resubmission_allowed == 'NO') resubmissionOption += 'selected'; resubmissionOption +='>NO</option>';
                    resubmissionOption += '</select>';
                    resubmissionOption += '</div>';
                    resubmissionOption += '</div>';

                    if(response.resubmission_allowed == 'NO'){

                        $('#resubmissionDateTime').addClass('d-none');

                        if(response.grading_required == 'YES'){

                            if(response.grading_option == 'GRADE'){

                                gradeValue += '<div class="form-group">';
                                gradeValue += '<label class="control-label mt-0">Grade</label>';
                                gradeValue += '<select class="selectpicker grade" name="grade_obtained" id="grade_obtained" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select">';

                                response.grade_values.forEach((item)=> {
                                    gradeValue += '<option value ="'+item+'"'; if(response.obtained_marks == item) gradeValue += 'selected'; gradeValue +='>'+item+'</option>';
                                });
                                gradeValue += '</select>';
                                gradeValue += '</div>';
                                $('#grade').removeClass('d-none');
                                $('#marks').addClass('d-none');

                            }else if(response.grading_option == 'MARKS'){

                                marksValue += '<div class="form-group">';
                                marksValue += '<label class="control-label mt-0">MARKS</label>';
                                marksValue += '<input type="number" name="obtained_mark" id="obtained_mark" class="form-control obtained_mark" min="0" value="'+response.obtained_marks+'"/>';
                                marksValue += '</div>';
                                $('#grade').addClass('d-none');
                                $('#marks').removeClass('d-none');
                            }
                        }

                    }else{

                        $('#resubmissionDateTime').removeClass('d-none');
                        $('#marks').addClass('d-none');
                        $('#grade').addClass('d-none');
                    }

                    $("#project_modal").find("#resubmissionOption").html(resubmissionOption);
                    // $("#resubmission_permission_modal").find("#student_id").val(studentId);
                    $("#project_modal").find("#resubmissionDate").val(response.resubmission_date);
                    $("#project_modal").find("#resubmissionTime").val(response.resubmission_time);
                    $("#project_modal").find("#grading_option").val(response.grading_option);

                    $("#project_modal").find("#gradeValues").val(response.grade_values);
                    $("#project_modal").find("#maxMarksValue").val(response.marks);
                    $("#project_modal").find("#obtainedMark").val(response.obtained_marks);

                    $("#project_modal").find("#grade").html(gradeValue);
                    $("#project_modal").find("#marks").html(marksValue);
                    $("#project_modal").find("#max_marks").val(response.marks);
                    $("#project_modal").find("#id_project_submission").val(response.id_project_submission);
                    $("#project_modal").find("#comment").val(response.comments);
                    $(".grade").selectpicker();
                    $(".resubmissionAllowed").selectpicker();
                    $("#project_modal").find('tbody').html(html);
                    $("#project_modal").modal('show');
                }
            });
        })

        $("body").delegate(".obtained_mark", "keyup", function(event){
            event.preventDefault();

            var obtainedMark = $(this).val();
            var maxMark = $("#max_marks").val();

            if(parseInt(obtainedMark) > parseInt(maxMark)){
                $("#obtained_mark").val('');
                document.getElementById("obtained_mark").focus();
            }
        });

        $('body').delegate('#markCommentForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');
            var id = $("#id_project_submission").val();

            $.ajax({
                url:"/project-submission/"+id,
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

        $("body").delegate(".resubmissionAllowed", "change", function(event){

            var resubmissionAllowed = $("#resubmissionAllowed").val();
            var grading_option = $("#grading_option").val();
            var gradeValues = $("#gradeValues").val();
            var gradeValues = gradeValues.split(",");
            //console.log(gradeValues);
            var maxMarksValue = $("#maxMarksValue").val();
            var obtainedMark = $("#obtainedMark").val();
            var gradeValue = '';
            var marksValue = '';

            if(resubmissionAllowed == "YES"){

                $('#resubmissionDateTime').removeClass('d-none');
                $('#grade').addClass('d-none');
                $('#marks').addClass('d-none');

            }else{

                $('#resubmissionDateTime').addClass('d-none');
                console.log(grading_option);

                if(grading_option == 'GRADE'){

                    gradeValue += '<div class="form-group">';
                    gradeValue += '<label class="control-label mt-0">Select Grade <span class="text-danger">*</span></label>';
                    gradeValue += '<select class="selectpicker grade" name="grade_obtained" id="grade_obtained" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select">';

                    gradeValues.forEach((item)=> {
                        gradeValue += '<option value ="'+item+'"'; if(obtainedMark == item) gradeValue += 'selected'; gradeValue +='>'+item+'</option>';
                    });
                    gradeValue += '</select>';
                    gradeValue += '</div>';
                    $('#grade').removeClass('d-none');
                    $('#marks').addClass('d-none');

                }else if(grading_option == 'MARKS'){

                    marksValue += '<div class="form-group">';
                    marksValue += '<label class="control-label mt-0">MARKS</label>';
                    marksValue += '<input type="number" name="obtained_mark" id="obtained_mark" class="form-control obtained_mark" min="0" value="'+obtainedMark+'"/>';
                    marksValue += '</div>';
                    $('#grade').addClass('d-none');
                    $('#marks').removeClass('d-none');
                }

                $("#project_modal").find("#grade").html(gradeValue);
                $("#project_modal").find("#marks").html(marksValue);
                $(".grade").selectpicker();
            }
        });
    });
</script>
@endsection
