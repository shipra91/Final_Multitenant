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
                        @if(Helper::checkAccess('homework', 'create'))
                            <a href="{{ url('homework/create') }}" type="button" class="btn btn-primary mr-5"><i class="material-icons">add</i> Add Homework</a>
                        @endif
                        @if(Helper::checkAccess('homework', 'view'))
                            <a href="{{ url('homework-deleted-records') }}" type="button" class="btn btn-info"><i class="material-icons">delete_forever</i> Deleted Records</a>
                        @endif
                    </div>
                </div>

                @if(Helper::checkAccess('homework', 'view'))
                    <div class="row">
                        <div class="col-sm-12 col-sm-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Homework List</h4>
                                    <div class="material-datatables">
                                        <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                            <thead style="font-size:12px;">
                                                <tr>
                                                    <th><b>S.N.</b></th>
                                                    <th><b>Standard</b></th>
                                                    <th><b>Subject</b></th>
                                                    <th><b>Staff</b></th>
                                                    <th><b>Homework</b></th>
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

<!-- View homework detail modal -->
<div class="modal fade" id="homework_modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="card1">
                <div class="card-header card-header-tabs" data-background-color="mediumaquamarine">
                    <h4 class="card-title1" id="homework_name"></h4>
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
                            <label class="control-label">Start Time</label>
                            <input type="text" class="form-control" id="start_time" disabled />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">End Time</label>
                            <input type="text" class="form-control" id="end_time" disabled />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Grading Required</label>
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
                            <label class="control-label">Read receipt from recipients required?</label>
                            <input type="text" class="form-control" id="read_receipt" disabled />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">SMS alert to recipients required</label>
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

        // View homework
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "homework",
            columns: [
                {data: 'DT_RowIndex', name: 'created_at', "width": "8%"},
                {data: 'class_name', name: 'class_name', "width": "13%"},
                {data: 'subject_name', name: 'subject_name', "width": "13%"},
                {data: 'staff_name', name: 'staff_name', "width": "10%", className: "capitalize"},
                {data: 'homework_name', name: 'homework_name', "width": "20%"},
                {data: 'from_date', name: 'from_date', "width": "10%"},
                {data: 'to_date', name: 'to_date', "width": "10%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "16%", className: "text-center"},
            ]
        });

        // Delete homework
        $(document).on('click', '.delete', function(e){
            e.preventDefault();

            var id = $(this).data('id');

            if (confirm("Are you sure you want to delete this?")){

                $.ajax({
                    type: "DELETE",
                    url: "/homework/" + id,
                    dataType: "json",
                    data: {id: id},
                    success: function(result){

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

        // View homework details
        $("body").delegate(".homeworkDetail", "click", function(event){
            event.preventDefault();

            var homeworkId = $(this).attr('data-id');

            $.ajax({
                url: "{{ url('/homework-detail') }}",
                type: "post",
                dataType: "json",
                data: {homeworkId: homeworkId,login_type: ''},
                success: function(response){
                    // console.log(response);
                    var html = '';
                    var gradingOption = '';
                    var gradeValue = '';
                    var marksValue = '';
                    var resubmissionDateValue = '';
                    var resubmissionTimeValue = '';

                    $("#homework_modal").find("#homework_name").text("Homework Name: " + response.homework_name);
                    $("#homework_modal").find("#staff_name").text("Staff Name: " + response.staff_name);
                    $("#homework_modal").find("#subject_name").text("Subject Name: " + response.subject_name);
                    //$("#homework_modal").find("#description").html(response.description);
                    $("#homework_modal").find(CKEDITOR.instances.description.setData(response.description));
                    $("#homework_modal").find(CKEDITOR.instances.description.setReadOnly(true));
                    $("#homework_modal").find("#submit_date").text("Submit Before: " + response.to_date + " - " + response.end_time);
                    $("#homework_modal").find("#chapter_name").val(response.chapter_name);
                    $("#homework_modal").find("#submission_type").val(response.submission_type);
                    $("#homework_modal").find("#grading_required").val(response.grading_required);
                    $("#homework_modal").find("#read_receipt").val(response.read_receipt);
                    $("#homework_modal").find("#sms_alert").val(response.sms_alert);
                    $("#homework_modal").find("#start_time").val(response.start_time);
                    $("#homework_modal").find("#end_time").val(response.end_time);
                    $("#homework_modal").find("#grading_option").html(gradingOption);
                    $("#homework_modal").find("#grade").html(gradeValue);
                    $("#homework_modal").find("#marks").html(marksValue);
                    $("#homework_modal").find('tbody').html(html);
                    $("#homework_modal").modal('show');
                }
            });
        })
    });
</script>
@endsection
