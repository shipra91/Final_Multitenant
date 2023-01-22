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
                    <div class="col-sm-12 col-sm-offset-0 text-right">
                        @if(Helper::checkAccess('leave', 'create'))
                            <a href="{{ url('leave-management/create') }}" type="button" class="btn btn-primary mr-5"><i class="material-icons">add</i> Add Leave Application</a>
                        @endif
                        @if(Helper::checkAccess('leave', 'view'))
                            <a href="{{ url('leave-management-deleted-records') }}" type="button" class="btn btn-info"><i class="material-icons">delete_forever</i> Deleted Records</a>
                        @endif
                    </div>
                </div>

                @if(Helper::checkAccess('leave', 'view'))
                    <div class="row">
                        <div class="col-sm-12 col-sm-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">query_builder</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Leave Application List</h4>
                                    <div class="toolbar"></div>
                                    <div class="material-datatables">
                                        <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                            <thead style="font-size:12px;">
                                                <tr>
                                                    <th><b>S.N.</b></th>
                                                    <th><b>Student</b></th>
                                                    <th><b>Leave Title</b></th>
                                                    <th><b>From Date</b></th>
                                                    <th><b>To Date</b></th>
                                                    <th><b>Status</b></th>
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

<!-- leave approval modal -->
<div class="modal fade" id="leave_approval_modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form id="applicationApprovalForm" method="post">
                <input type="hidden" id="applicationId" name="applicationId">
                <div class="card1">
                    <div class="card-header card-header-tabs" data-background-color="mediumaquamarine">
                        <p class="card-title1 text-center mb-0 font-15">Leave Application Approval</p>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="control-label mt-0">Leave Application Approval<span class="text-danger">*</span></label>
                                <select class="selectpicker" name="application_approval" id="application_approval" data-style="select-with-transition" title="Select" required="required">
                                    <option value ="APPROVE">Approve</option>
                                    <option value ="REJECT">Reject</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12 d-none" id="rejection_reason_div">
                            <div class="form-group">
                                <label class="control-label mt-0">Reason of Rejection<span class="text-danger">*</span></label>
                                <textarea class="form-control" row="4" name="rejection_reason" id="rejection_reason"></textarea>
                            </div>
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
            </form>
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

        // View leave application
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "leave-management",
            columns: [
                {data: 'DT_RowIndex', name: 'created_at', "width": "8%"},
                {data: 'student', name: 'student', "width": "22%", className:"capitalize"},
                {data: 'leaveTitle', name: 'leaveTitle', "width": "25%", className:"capitalize"},
                {data: 'fromDate', name: 'fromDate', "width": "10%"},
                {data: 'toDate', name: 'toDate', "width": "10%"},
                {data: 'leaveStatus', name: 'leaveStatus', "width": "10%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "15%", className:"text-center"},
            ]
        });

        // Delete leave application
        $(document).on('click', '.delete', function (e){
            e.preventDefault();

            var id = $(this).data('id');

            if(confirm("Are you sure you want to delete this?")){

                $.ajax({
                    type: "DELETE",
                    url:"/leave-management/"+id,
                    dataType: "json",
                    data: {id:id},
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

        // leave approval modal
        $(document).on('click', '.leaveApproval', function (e){
            e.preventDefault();

            var id = $(this).data('id');//alert(id);

            $("#leave_approval_modal").modal();
            $('#applicationId').val(id);
        });

        // Rejection reason hide/show based on leave application approval
        $('#application_approval').change(function (){
            var val = $(this).val();//alert(val);

            if(val === 'REJECT'){
                $('#rejection_reason_div').removeClass('d-none');
                $("#rejection_reason").attr('required', true);
            }else{
                $('#rejection_reason_div').addClass('d-none');
                $("#rejection_reason").attr('required', false);
            }
        });

        $("#applicationApprovalForm").parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Update leave application
        $('body').delegate('#applicationApprovalForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');
            var id = $(this).find('#applicationId').val(); //alert(id);

            if($('#applicationApprovalForm').parsley().isValid()){

                if(confirm("Are you sure you want to release this?")){

                    $.ajax({
                        url: "/leave-approval-store/"+id,
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
                }
            }
        });
    });
</script>
@endsection
