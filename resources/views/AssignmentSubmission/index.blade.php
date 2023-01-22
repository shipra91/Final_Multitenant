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
                <div class="row">
                    <div class="col-sm-12 col-sm-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">assignment</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Assignment List</h4>
                                <div class="material-datatables">
                                    <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                        <thead style="font-size:12px;">
                                            <tr>
                                                <th><b>S.N.</b></th>
                                                <th><b>Standard</b></th>
                                                <th><b>Subject</b></th>
                                                <th><b>Staff</b></th>
                                                <th><b>Assignment Name</b></th>
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

<!-- Assignment detail modal -->
{{-- <div class="modal fade" id="assignment_modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="card1">
                <div class="card-header card-header-tabs" data-background-color="mediumaquamarine">
                    <p class="card-title1 mb-5 font-15" id="assignment_name"></p>
                    <p class="font-15" style="margin:0; display:inline;" id="staff_name">&nbsp;</p>
                    <p style="margin:5px; display:inline; border-right:1px solid rgba(255, 255, 255, 0.62); font-size:11px;">
                    </p>
                    <p class="font-15" style="margin:5px; display:inline" align="right" id="subject_name">Name : </p>
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
</div> --}}

<!-- Assignment submission modal -->
<div class="modal fade" id="assignment_submission_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="assignmentSubmissionForm" enctype="multipart/form-data">
                <input type="hidden" name="id_assignment" id="id_assignment">
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
                                        <input type="file" name="attachmentAssignment[]" id="attachmentAssignment" multiple accept="image/*,.pdf,.doc,.docx" />
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
                            <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd" id="submit" name="submit">Submit</button>
                            <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Assignment valuation modal -->
<div class="modal fade" id="assignment_valuation_modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="card1">
                <div class="card-header card-header-tabs" data-background-color="mediumaquamarine">
                    <h4 class="card-title1" id="assignment_name"></h4>
                    <p style="margin:0;display:inline;" id="staff_name">&nbsp;</p>
                    <p style="margin:5px;display:inline;border-right:1px solid rgba(255, 255, 255, 0.62);;font-size:11px;">
                    </p>
                    <p style="margin:5px;display:inline" align="right" id="subject_name">Name : </p>
                </div>
            </div>

            <div class="modal-body">
                <div class="row" id="marksCommentDetails">

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-right btn-wd" data-dismiss="modal" style="margin-right:8px;">Close</button>
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
        $("#attachmentAssignment").change(function(){
            // check if fileArr length is greater than 0
            if(fileArr.length > 0) fileArr = [];

            $('#image_preview').html("");
            var total_file = document.getElementById("attachmentAssignment").files;
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

                }else if(extension == "pdf"){

                    fileType += '<div class="img_div" id="img_div' + i + '">';
                    fileType += '<img src="https://cdn-icons-png.flaticon.com/512/337/337946.png" class="multiple_image img-responsive" title="' + total_file[i].name + '">';
                    fileType += '<div class="middle_div"><button id="action-icon" value="img_div' + i + '" class="btn btn-danger btn-xs" role="' + total_file[i].name + '"><i class="material-icons">delete</i></button></div></div>';

                }else if(extension == "docs" || extension == "doc" || extension == "docx"){

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
            document.getElementById('attachmentAssignment').files = FileListItem(fileArr);
            evt.preventDefault();
        });

        function FileListItem(file){
            file = [].slice.call(Array.isArray(file) ? file : arguments)
            for(var c, b = c = file.length, d = !0; b-- && d;) d = file[b] instanceof File
            if(!d) throw new TypeError("expected argument to FileList is File or array of File objects")
            for(b = (new ClipboardEvent("")).clipboardData || new DataTransfer; c--;) b.items.add(file[c])
            return b.files
        }

        // View assignment
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "assignment-submission",
            columns: [
                {data: 'DT_RowIndex', name: 'created_at', "width": "8%"},
                {data: 'class_name', name: 'class_name', "width": "15%"},
                {data: 'subject_name', name: 'subject_name', "width": "15%"},
                {data: 'staff_name', name: 'staff_name', "width": "10%", className:"capitalize"},
                {data: 'assignment_name', name: 'assignment_name', "width": "20%"},
                {data: 'from_date', name: 'from_date', "width": "10%"},
                {data: 'to_date', name: 'to_date', "width": "10%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "12%", className: "text-center"},
            ]
        });

        // Delete assignment
        // $(document).on('click', '.delete', function(e){
        //     e.preventDefault();

        //     var id = $(this).data('id');

        //     if(confirm("Are you sure you want to delete this?")){

        //         $.ajax({
        //             type: "DELETE",
        //             url: "/assignment/" + id,
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

        // View assignment details
        // $("body").delegate(".assignmentDetail", "click", function(event){
        //     event.preventDefault();

        //     var assignmentId = $(this).attr('data-id');

        //     $.ajax({
        //         url: "{{ url('/assignment-detail') }}",
        //         type: "post",
        //         dataType: "json",
        //         data: {
        //             assignmentId: assignmentId,
        //             login_type: 'student'
        //         },
        //         success: function(response){
        //             //console.log(response);
        //             var html = '';
        //             var gradingOption = '';
        //             var gradeValue = '';
        //             var marksValue = '';
        //             var resubmissionDate = '';
        //             var resubmissionTime = '';

        //             $("#assignment_modal").find("#assignment_name").text("Assignment Name: " + response.assignment_name);
        //             $("#assignment_modal").find("#staff_name").text("Staff Name: " + response.staff_name);
        //             $("#assignment_modal").find("#subject_name").text("Subject Name: " + response.subject_name);
        //             //$("#assignment_modal").find("#description").html(response.description);
        //             $("#assignment_modal").find(CKEDITOR.instances.description.setData(response.description));
        //             $("#assignment_modal").find(CKEDITOR.instances.description.setReadOnly(true));
        //             $("#assignment_modal").find("#submit_date").text("Submit Before: " + response.to_date + " - " + response.end_time);
        //             $("#assignment_modal").find("#chapter_name").val(response.chapter_name);
        //             $("#assignment_modal").find("#submission_type").val(response.submission_type);
        //             $("#assignment_modal").find("#grading_required").val(response.grading_required);
        //             $("#assignment_modal").find("#read_receipt").val(response.read_receipt);
        //             $("#assignment_modal").find("#sms_alert").val(response.sms_alert);
        //             $("#assignment_modal").find("#start_time").val(response.start_time);
        //             $("#assignment_modal").find("#end_time").val(response.end_time);
        //             $("#assignment_modal").find("#resubmission_required").val(response.resubmission_required);

        //             if(response.resubmission_required == 'YES'){

        //                 resubmissionDate += '<div class="form-group">';
        //                 resubmissionDate += '<label class="control-label mt-0">Resubmission Date</label>';
        //                 resubmissionDate += '<input type="text" class="form-control" value="' + response.resubmission_date + '" disabled />';
        //                 resubmissionDate += '</div>';

        //                 resubmissionTime += '<div class="form-group">';
        //                 resubmissionTime += '<label class="control-label mt-0">Resubmission Time</label>';
        //                 resubmissionTime += '<input type="text" class="form-control" value="' + response.resubmission_time + '" disabled />';
        //                 resubmissionTime += '</div>';

        //                 $("#assignment_modal").find("#resubmission_date").html(resubmissionDate);
        //                 $("#assignment_modal").find("#resubmission_time").html(resubmissionTime);
        //             }

        //             if(response.grading_required == 'YES'){

        //                 gradingOption += '<div class="form-group">';
        //                 gradingOption += '<label class="control-label mt-0">Grading Option</label>';
        //                 gradingOption += '<input type="text" class="form-control" value="' + response.grading_option + '" disabled/>';
        //                 gradingOption += '</div>';

        //                 if(response.grading_option == 'GRADE'){

        //                     gradeValue += '<div class="form-group">';
        //                     gradeValue += '<label class="control-label mt-0">GRADES</label>';
        //                     gradeValue += '<input type="text" class="form-control" value="' + response.grade + '" disabled/>';
        //                     gradeValue += '</div>';
        //                     $('#grade').removeClass('d-none');
        //                     $('#marks').addClass('d-none');

        //                 }else if (response.grading_option == 'MARKS'){

        //                     marksValue += '<div class="form-group">';
        //                     marksValue += '<label class="control-label mt-0">MARKS</label>';
        //                     marksValue += '<input type="text" class="form-control" value ="' + response.marks + '" disabled/>';
        //                     marksValue += '</div>';
        //                     $('#grade').addClass('d-none');
        //                     $('#marks').removeClass('d-none');
        //                 }
        //             }

        //             $("#assignment_modal").find("#grading_option").html(gradingOption);
        //             $("#assignment_modal").find("#grade").html(gradeValue);
        //             $("#assignment_modal").find("#marks").html(marksValue);

        //             $("#assignment_modal").find('tbody').html(html);
        //             $("#assignment_modal").modal('show');
        //         }
        //     });
        // });

        // View assignment valuation details
        $("body").delegate(".valuationDetails", "click", function(event){
            event.preventDefault();

            var assignmentId = $(this).attr('data-id');
            var studentId = $(this).attr('student-id');

            $.ajax({
                url: "{{ url('/assignment-verified-details') }}",
                type: "post",
                dataType: "json",
                data: {assignmentId: assignmentId, studentId: studentId},
                success: function(response){
                    //console.log(response.valuation_details);
                    var marksCommentDetails = '';
                    var html = '';

                    $("#assignment_valuation_modal").find("#assignment_name").text("Assignment Name: " + response.assignment_name);
                    $("#assignment_valuation_modal").find("#staff_name").text("Staff Name: " + response.staff_name);
                    $("#assignment_valuation_modal").find("#subject_name").text("Subject Name: " + response.subject_name);

                    response.valuation_details.forEach((item) => {

                        marksCommentDetails += '<div class="col-md-8">';
                        marksCommentDetails += '<div class="form-group">';
                        marksCommentDetails += '<label class="control-label mt-0">Comments</label>';
                        marksCommentDetails += '<input type="text" class="form-control" value="' + item.comments + '" disabled/>';
                        marksCommentDetails += '</div>';
                        marksCommentDetails += '</div>';

                        marksCommentDetails += '<div class="col-md-4">';
                        marksCommentDetails += '<div class="form-group">';
                        marksCommentDetails += '<label class="control-label mt-0">Obtained Grade/Marks</label>';
                        marksCommentDetails += '<input type="text" class="form-control" value="' + item.obtained_marks + '" disabled/>';
                        marksCommentDetails += '</div>';
                        marksCommentDetails += '</div>';
                    });

                    $("#assignment_valuation_modal").find('#marksCommentDetails').html(marksCommentDetails);
                    $("#assignment_valuation_modal").find('tbody').html(html);
                    $("#assignment_valuation_modal").modal('show');
                }
            });
        })

        // View assignment submission detail
        $("body").delegate(".assignmentSubmissionDetail", "click", function(event){
            event.preventDefault();

            var assignmentId = $(this).attr('data-id');

            $("#assignment_submission_modal").find("#id_assignment").val(assignmentId);
            $("#assignment_submission_modal").modal('show');
        });

        // Save assignment submission
        $('body').delegate('#assignmentSubmissionForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');

            $.ajax({
                url: "/assignment-submission",
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

                        }else if (result.data['signal'] == "exist"){

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
