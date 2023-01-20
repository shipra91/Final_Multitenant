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
                    <div class="col-sm-12 col-sm-offset-0 text-right">
                        @if(Helper::checkAccess('project', 'create'))
                            <a href="{{ url('project/create') }}" type="button" class="btn btn-primary mr-5"><i class="material-icons">add</i>Add Project</a>
                        @endif
                        @if(Helper::checkAccess('project', 'view'))
                            <a href="{{ url('project-deleted-records') }}" type="button" class="btn btn-info"><i class="material-icons">delete_forever</i> Deleted Records</a>
                        @endif
                    </div>
                </div>

                @if(Helper::checkAccess('project', 'view'))
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
                                                    <th><b>Project</b></th>
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
                @endif
            </div>
        </div>
    </div>
</div>

<!-- View project detail modal -->
<div class="modal fade" id="project_modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="card1">
                <div class="card-header card-header-tabs" data-background-color="mediumaquamarine">
                    <h4 class="card-title1" id="project_name"></h4>
                    <p style="margin:0;display:inline;" id="staff_name">&nbsp;</p>
                    <p style="margin:5px;display:inline;border-right:1px solid rgba(255, 255, 255, 0.62);;font-size:11px;">
                    </p>
                    <p style="margin:5px;display:inline" align="right" id="subject_name"></p>
                </div>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <textarea id="description" class="ckeditor"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Chapter Name</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="chapter_name" disabled />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="control-label">Submission Type</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="submission_type" disabled />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="control-label">Start Time</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="start_time" disabled />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="control-label">End Time</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="end_time" disabled />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="control-label">Grading Required</label>
                        <div class="form-group">
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
                        <label class="control-label">Read receipt from recipients required?</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="read_receipt" disabled />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="control-label">SMS alert to recipients required</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="sms_alert" disabled />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger">
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
@endsection

@section('script-content')
<script>
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // View project
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "project",
            columns: [
                {data: 'DT_RowIndex', name: 'created_at', "width": "8%"},
                {data: 'class_name', name: 'class_name', "width": "15%"},
                {data: 'subject_name', name: 'subject_name', "width": "12%"},
                {data: 'staff_name', name: 'staff_name', "width": "12%", className: "capitalize"},
                {data: 'project_name', name: 'project_name', "width": "15%"},
                {data: 'from_date', name: 'from_date', "width": "10%"},
                {data: 'to_date', name: 'to_date', "width": "10%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "18%", className: "text-center"
                },
            ]
        });

        // Delete project
        $(document).on('click', '.delete', function(e){
            e.preventDefault();

            var id = $(this).data('id');

            if (confirm("Are you sure you want to delete this?")){

                $.ajax({
                    type: "DELETE",
                    url: "/project/" + id,
                    dataType: "json",
                    data: {
                        id: id
                    },
                    success: function(result){

                        if (result['status'] == "200"){

                            if (result.data['signal'] == "success"){

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

        // View project detail
        $("body").delegate(".projectDetail", "click", function(event){
            event.preventDefault();

            var projectId = $(this).attr('data-id');

            $.ajax({
                url: "{{ url('/project-detail') }}",
                type: "post",
                dataType: "json",
                data: {projectId: projectId, login_type: ''},
                success: function(response){
                    //console.log(response.description);
                    var html = '';
                    var gradingOption = '';
                    var gradeValue = '';
                    var marksValue = '';
                    $("#project_modal").find("#project_name").text("Project Name: " + response.project_name);
                    $("#project_modal").find("#staff_name").text("Staff Name: " + response.staff_name);
                    $("#project_modal").find("#subject_name").text("Subject Name: " + response.subject_name);
                    $("#project_modal").find(CKEDITOR.instances.description.setData(response.description));
                    $("#project_modal").find(CKEDITOR.instances.description.setReadOnly(true));
                    $("#project_modal").find("#submit_date").text("Submit Before: " + response.to_date + " - " + response.end_time);
                    $("#project_modal").find("#chapter_name").val(response.chapter_name);
                    $("#project_modal").find("#submission_type").val(response.submission_type);
                    $("#project_modal").find("#grading_required").val(response.grading_required);
                    $("#project_modal").find("#read_receipt").val(response.read_receipt);
                    $("#project_modal").find("#sms_alert").val(response.sms_alert);
                    $("#project_modal").find("#start_time").val(response.start_time);
                    $("#project_modal").find("#end_time").val(response.end_time);

                    if (response.grading_required == 'YES'){

                        gradingOption += '<label class="control-label">Grading Option</label>';
                        gradingOption += '<div class="form-group">';
                        gradingOption += '<input type="text" class="form-control" value = ' + response.grading_option + ' disabled />';
                        gradingOption += '</div>';

                        if (response.grading_option == 'GRADE'){

                            gradeValue += '<label class="control-label">GRADES</label>';
                            gradeValue += '<div class="form-group">';
                            gradeValue += '<input type="text" class="form-control" value = ' + response.grade + ' disabled />';
                            gradeValue += '</div>';
                            $('#grade').removeClass('d-none');
                            $('#marks').addClass('d-none');

                        }else if (response.grading_option == 'MARKS'){

                            marksValue += '<label class="control-label">MARKS</label>';
                            marksValue += '<div class="form-group">';
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
    });
</script>
@endsection
