@php

@endphp

@extends('layouts.master')

@section('content')
<style>
    .cke_top { display: none !important }
</style>
<div class="wrapper">
    @include('sliderbar')
    <div class="main-panel">
        @include('navigation')
        <div class="content">
            <div class="container-fluid">
                <!-- <div class="row">
                    <div class="col-sm-12 col-sm-offset-0 text-right">
                        <a href="{{ url('project/create') }}" type="button" class="btn btn-primary">Add Project</a>
                        <a href="{{ url('project/deleted-records') }}" type="button" class="btn btn-info">Deleted Records</a>
                    </div>
                </div> -->
                <div class="row">
                    <div class="col-sm-12 col-sm-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">assignment</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Project List</h4>
                                <div class="material-datatables">
                                    <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                        <thead style="font-size:12px;">
                                            <tr>
                                                <th><b>S.N.</b></th>
                                                <th><b>Standard</b></th>
                                                <th><b>Subject</b></th>
                                                <th><b>Staff</b></th>
                                                <th><b>Project Name</b></th>
                                                <th><b>Start Date</b></th>
                                                <th><b>End Date</b></th>
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

<!-- Project detail modal -->
<div class="modal fade" id="project_modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="card1">
                <div class="card-header card-header-tabs" data-background-color="mediumaquamarine">
                    <p class="card-title1 mb-5 font-15" id="project_name"></p>
                    <p class="font-15" style="margin:0; display:inline;" id="staff_name">&nbsp;</p>
                    <p style="margin:5px; display:inline; border-right:1px solid rgba(255, 255, 255, 0.62); font-size:11px;">
                    </p>
                    <p class="font-15" style="margin:5px; display:inline" align="right" id="subject_name"></p>
                </div>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <textarea id="description" class="ckeditor"></textarea>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Chapter Name</label>
                            <input type="text" class="form-control" id="chapter_name" disabled />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Submission Type</label>
                            <input type="text" class="form-control" id="submission_type" disabled />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label mt-0">Start Time</label>
                            <input type="text" class="form-control" id="start_time" disabled />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label mt-0">End Time</label>
                            <input type="text" class="form-control" id="end_time" disabled />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label mt-0">Grading Required</label>
                            <input type="text" class="form-control" id="grading_required" disabled />
                        </div>
                    </div>

                    <div class="col-md-6" id="grading_option">
                    </div>
                    <div class="col-md-6 d-none" id="grade">
                    </div>
                    <div class="col-md-6 d-none" id="marks">
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label mt-0">Read receipt from recipients required?</label>
                            <input type="text" class="form-control" id="read_receipt" disabled />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label mt-0">SMS alert to recipients required</label>
                            <input type="text" class="form-control" id="sms_alert" disabled />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label mt-0">Re-submission Required</label>
                            <input type="text" class="form-control" id="resubmission_required" disabled />
                        </div>
                    </div>
                    <div class="col-md-6" id="resubmission_date"></div>
                    <div class="col-md-6" id="resubmission_time"></div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger mt-5 mb-5">
                            <strong id="submit_date"></strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-right btn-wd" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- project submission modal -->
<div class="modal fade" id="project_submission_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="projectSubmissionForm" enctype="multipart/form-data">
                <input type="hidden" name="id_project" id="id_project">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="card-title">Attachment</h4>
                            <div class="text-center">
                                <h6 class="file_label">Homework Attachment</h6>
                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                    <span class="btn btn-square btn-info btn-file btn-sm">
                                        <span class="fileinput-new">Add</span>
                                        <span class="fileinput-exists">Change</span>
                                        <input type="file" name="attachmentProject[]" id="attachmentProject" multiple accept="image/*,.pdf,.doc,.docx" />
                                    </span>
                                    <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="material-icons">highlight_off</i></a>
                                </div>
                            </div>

                            <div class="form-group" id="image_preview">

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Submit</button>
                            <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- project valuation modal -->
<div class="modal fade" id="project_valuation_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="card1">
                <div class="card-header card-header-tabs" data-background-color="mediumaquamarine">
                    <p class="card-title1 mb-5 font-15" id="project_name"></p>
                    <p class="font-15" style="margin:0; display:inline;" id="staff_name">&nbsp;</p>
                    <p style="margin:5px; display:inline; border-right:1px solid rgba(255, 255, 255, 0.62); font-size:11px;"></p>
                    <p class="font-15" style="margin:5px; display:inline" align="right" id="subject_name"></p>
                </div>
            </div>
            <div class="modal-body1 col-lg-12 col-sm-12">
                <div class="row" id="marksCommentDetails">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-right btn-wd" data-dismiss="modal">Close</button>
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

        // Multiple file upload with preview
        var fileArr = [];
        $("#attachmentProject").change(function(){
            // check if fileArr length is greater than 0
            if(fileArr.length > 0) fileArr = [];

            $('#image_preview').html("");
            var total_file = document.getElementById("attachmentProject").files;
            if(!total_file.length) return;

            for(var i = 0; i < total_file.length; i++){

                var extension = total_file[i].name.substr((total_file[i].name.lastIndexOf('.') + 1));
                var fileType = '';
                // console.log(extension);

                fileArr.push(total_file[i]);

                if(extension != "pdf" && extension != "docs" && extension != "doc" && extension != "docx"){

                    fileType += '<div class="img_div" id="img_div' + i + '">';
                    fileType += '<img src="' + URL.createObjectURL(event.target.files[i]) + '" class="multiple_image img-responsive" title="' + total_file[i].name + '">';
                    fileType += '<div class="middle_div"><button id="action-icon" value="img_div' + i + '" class="btn btn-danger btn-xs" role="' + total_file[i].name + '"><i class="material-icons">delete</i></button></div></div>';

                }else if (extension == "pdf"){

                    fileType += '<div class="img_div" id="img_div' + i + '">';
                    fileType += '<img src="https://cdn-icons-png.flaticon.com/512/337/337946.png" class="multiple_image img-responsive" title="' + total_file[i].name + '">';
                    fileType += '<div class="middle_div"><button id="action-icon" value="img_div' + i + '" class="btn btn-danger btn-xs" role="' + total_file[i].name + '"><i class="material-icons">delete</i></button></div></div>';

                }else if (extension == "docs" || extension == "doc" || extension == "docx"){

                    fileType += '<div class="img_div" id="img_div' + i + '">';
                    fileType += '<img src="https://cdn-icons-png.flaticon.com/512/337/337932.png" class="multiple_image img-responsive" title="' + total_file[i].name + '">';
                    fileType += '<div class="middle_div"><button id="action-icon" value="img_div' + i + '" class="btn btn-danger btn-xs" role="' + total_file[i].name + '"><i class="material-icons">delete</i></button></div></div>';
                }

                $('#image_preview').append(fileType);
            }
        });

        $('body').on('click', '#action-icon', function(evt){

            var divName = this.value;
            var fileName = $(this).attr('role');

            $(`#${divName}`).remove();
            for(var i = 0; i < fileArr.length; i++){
                if(fileArr[i].name === fileName){
                    fileArr.splice(i, 1);
                }
            }
            document.getElementById('attachmentProject').files = FileListItem(fileArr);
            evt.preventDefault();
        });

        function FileListItem(file){
            file = [].slice.call(Array.isArray(file) ? file : arguments)
            for(var c, b = c = file.length, d = !0; b-- && d;) d = file[b] instanceof File
            if(!d) throw new TypeError("expected argument to FileList is File or array of File objects")
            for(b = (new ClipboardEvent("")).clipboardData || new DataTransfer; c--;) b.items.add(file[c])
            return b.files
        }

        // View Project
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "project-submission",
            columns: [
                {data: 'DT_RowIndex', name: 'created_at', "width": "8%"},
                {data: 'class_name', name: 'class_name', "width": "15%"},
                {data: 'subject_name', name: 'subject_name', "width": "15%"},
                {data: 'staff_name', name: 'staff_name', "width": "15%", className: "capitalize"},
                {data: 'project_name', name: 'project_name', "width": "15%"},
                {data: 'from_date', name: 'from_date', "width": "10%"},
                {data: 'to_date', name: 'to_date', "width": "10%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "12%", className: "text-center"},
            ]
        });

        // Delete project
        // $(document).on('click', '.delete', function(e){
        //     e.preventDefault();

        //     var id = $(this).data('id');

        //     if(confirm("Are you sure you want to delete this?")){

        //         $.ajax({
        //             type: "DELETE",
        //             url: "/project/" + id,
        //             dataType: "json",
        //             data: {id: id},
        //             success: function(result){

        //                 if(result['status'] == "200"){

        //                     if(result.data['signal'] == "success"){

        //                         swal({
        //                             title: result.data['message'],
        //                             buttonsStyling: false,
        //                             confirmButtonClass: "btn btn-success"
        //                         }).then(function() {
        //                             window.location.reload();
        //                         }).catch(swal.noop)

        //                     }else{

        //                         swal({
        //                             title: result.data['message'],
        //                             buttonsStyling: false,
        //                             confirmButtonClass: "btn btn-danger"
        //                         });
        //                     }

        //                 }else{

        //                     swal({
        //                         title: 'Server error',
        //                         buttonsStyling: false,
        //                         confirmButtonClass: "btn btn-danger"
        //                     })
        //                 }
        //             }
        //         });
        //     }

        //     return false;
        // });

        // View project details
        $("body").delegate(".projectDetail", "click", function(event){
            event.preventDefault();

            var projectId = $(this).attr('data-id');

            $.ajax({
                url: "{{ url('/project-detail') }}",
                type: "post",
                dataType: "json",
                data: {projectId: projectId, login_type: 'student'},
                success: function(response){

                    var html = '';
                    var gradingOption = '';
                    var gradeValue = '';
                    var marksValue = '';

                    $("#project_modal").find("#project_name").text("Project Name: " + response.project_name);
                    $("#project_modal").find("#staff_name").text("Staff Name: " + response.staff_name);
                    $("#project_modal").find("#subject_name").text("Subject Name: " + response.subject_name);
                    //$("#project_modal").find("#description").html(response.description);
                    $("#project_modal").find(CKEDITOR.instances.description.setData(response.description));
                    $("#project_modal").find(CKEDITOR.instances.description.setReadOnly(true));
                    $("#project_modal").find("#submit_date").text("Submit Before: " + response.to_date + " - " + response.end_time);
                    $("#project_modal").find("#chapter_name").val(response.chapter_name);
                    $("#project_modal").find("#submission_type").val(response.submission_type);
                    $("#project_modal").find("#grading_required").val(response.grading_required);
                    $("#project_modal").find("#read_receipt").val(response.read_receipt);
                    $("#project_modal").find("#sms_alert").val(response.sms_alert);

                    if(response.grading_required == 'YES'){

                        gradingOption += '<div class="form-group">';
                        gradingOption += '<label class="control-label mt-0">Grading Option</label>';
                        gradingOption += '<input type="text" class="form-control" value = ' + response.grading_option + ' disabled />';
                        gradingOption += '</div>';

                        if(response.grading_option == 'GRADE'){

                            gradeValue += '<div class="form-group">';
                            gradeValue += '<label class="control-label mt-0">GRADES</label>';
                            gradeValue += '<input type="text" class="form-control" value = ' + response.grade + ' disabled />';
                            gradeValue += '</div>';
                            $('#grade').removeClass('d-none');
                            $('#marks').addClass('d-none');

                        }else if(response.grading_option == 'MARKS'){

                            marksValue += '<div class="form-group">';
                            marksValue += '<label class="control-label mt-0">MARKS</label>';
                            marksValue += '<input type="text" class="form-control" value = ' + response.marks + ' disabled />';
                            marksValue += '</div>';
                            $('#grade').addClass('d-none');
                            $('#marks').removeClass('d-none');
                        }
                    }
                    $("#project_modal").find("#grading_option").html(gradingOption);
                    $("#project_modal").find("#grade").html(gradeValue);
                    $("#project_modal").find("#marks").html(marksValue);

                    $("#project_modal").find('tbody').html(html);
                    $("#project_modal").modal('show');
                }
            });
        })

        // View project valuation details
        $("body").delegate(".valuationDetails", "click", function(event){
            event.preventDefault();

            var projectId = $(this).attr('data-id');
            var studentId = $(this).attr('student-id');

            $.ajax({
                url: "{{ url('/project-verified-details') }}",
                type: "post",
                dataType: "json",
                data: {projectId: projectId, studentId: studentId},
                success: function(response){
                    //console.log(response.valuation_details);
                    var marksCommentDetails = '';
                    var html = '';

                    $("#project_valuation_modal").find("#project_name").text("Project Name: " + response.project_name);
                    $("#project_valuation_modal").find("#staff_name").text("Staff Name: " + response.staff_name);
                    $("#project_valuation_modal").find("#subject_name").text("Subject Name: " + response.subject_name);

                    response.valuation_details.forEach((item) => {

                        marksCommentDetails += '<div class="col-md-8">';
                        marksCommentDetails += '<div class="form-group">';
                        marksCommentDetails += '<label class="control-label mt-0">Comments</label>';
                        marksCommentDetails += '<input type="text" class="form-control" value="' + item.comments + '" readonly/>';
                        marksCommentDetails += '</div>';
                        marksCommentDetails += '</div>';

                        marksCommentDetails += '<div class="col-md-4">';
                        marksCommentDetails += '<div class="form-group">';
                        marksCommentDetails += '<label class="control-label mt-0">Obtained Grade/Marks</label>';
                        marksCommentDetails += '<input type="text" class="form-control" value="' + item.obtained_marks + '" readonly/>';
                        marksCommentDetails += '</div>';
                        marksCommentDetails += '</div>';
                    });

                    $("#project_valuation_modal").find('#marksCommentDetails').html(marksCommentDetails);
                    $("#project_valuation_modal").find('tbody').html(html);
                    $("#project_valuation_modal").modal('show');
                }
            });
        })

        // View project submission detail
        $("body").delegate(".projectSubmissionDetail", "click", function(event){
            event.preventDefault();

            var projectId = $(this).attr('data-id');

            $("#project_submission_modal").find("#id_project").val(projectId);
            $("#project_submission_modal").modal('show');
        });

        // Save project submission
        $('body').delegate('#projectSubmissionForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');

            $.ajax({
                url: "/project-submission",
                type: "POST",
                dataType: "json",
                data: new FormData(this),
                contentType: false,
                processData: false,
                beforeSend: function(){
                    btn.html('Submitting...');
                    btn.attr('disabled', true);
                },
                success: function(result){
                    btn.html('Submit');
                    btn.attr('disabled', false);

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
