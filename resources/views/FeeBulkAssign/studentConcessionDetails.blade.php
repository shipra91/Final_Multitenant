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
                    <input type="hidden" id="studentId" value="{{ request()->route()->parameters['id'] }}">
                    <div class="col-md-12 col-md-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">school</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Student Concession List</h4>
                                <div class="material-datatables">
                                    <table class="table table-striped table-no-bordered table-hover data-table"
                                        cellspacing="0" width="100%">
                                        <thead style="font-size:12px;">
                                            <tr>
                                                <th><b>S.N.</b></th>
                                                <th><b>UID</b></th>
                                                <th><b>Name</b></th>
                                                <th><b>Fee Category</b></th>
                                                <th><b>Heading Name</b></th>
                                                <th><b>Amount</b></th>
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

<div class="modal fade" id="concession_approve_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="concessionApproveForm" enctype ="multipart/form-data">
                <div class="card1">
                    <div class="card-header card-header-tabs" data-background-color="mediumaquamarine">
                        <h6 style="text-capitalize text-center font-16">Approve Concession</h6>
                    </div>
                </div>
                <div class="modal-body col-lg-12">
                    <div class="row">
                        <input type="hidden" id='fee_assign_detail_id'/>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Concession Amount<span class="text-danger">*</span> </label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="concession_amount" id="concession_amount" readonly/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="concession_approve" name="submit">Approve</button>
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

<div class="modal fade" id="concession_reject_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="concessionRejectForm" enctype ="multipart/form-data">
                <div class="card1" class="mt-3">
                    <div class="card-header card-header-tabs" data-background-color="mediumaquamarine">
                        <h6 style="text-capitalize text-center font-16">Reject Concession</h6>
                    </div>
                </div>
                <div class="modal-body col-lg-12">
                    <div class="row">
                        <input type="hidden" id='fee_assign_details_id'/>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Concession Amount<span class="text-danger">*</span> </label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="concession_amounts" id="concession_amounts" readonly/>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Type reason<span class="text-danger">*</span> </label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="rejection_reason" id="rejection_reason" required/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="concession_reject" name="submit">Reject</button>
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

        $('#approvalForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // View student concession
        var studentId = $('#studentId').val();
        console.log(studentId);
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '/student-concession-details/'+studentId,
            columns: [{data: 'DT_RowIndex',name: 'id',"width": "8%"},
                {data: 'uid',name: 'uid',"width": "10%"},
                {data: 'name',name: 'name',"width": "20%"},
                {data: 'fee_category',name: 'fee_category',"width": "20%"},
                {data: 'heading_name',name: 'heading_name',"width": "15%"},
                {data: 'concession_amount',name: 'concession_amount',"width": "15%"},
                {data: 'action',name: 'action',orderable: false,searchable: false,"width": "12%"},]
        });

        $('#concessionRejectForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        $("body").delegate(".approveConcession", "click", function(event){
            event.preventDefault();
            var feeAssignDetailsId=$(this).attr('data-id');
            var concessionAmount=$(this).attr('data-amount');
            $("#concession_approve_modal").find("#fee_assign_detail_id").val(feeAssignDetailsId);
            $("#concession_approve_modal").find("#concession_amount").val(concessionAmount);
            $("#concession_approve_modal").modal('show');
        });

        //SUBMIT MODAL FORM
        $("body").delegate("#concessionApproveForm", "submit", function(event){
            event.preventDefault();

            var btn = $('#concession_approve');
            var id = $('#fee_assign_detail_id').val();

            if(confirm("Are you sure you want to approve?")){

                $.ajax({
                    url:"/approve-concession/"+id,
                    type:"POST",
                    dataType:"json",
                    data: new FormData(this),
                    contentType: false,
                    processData:false,
                    beforeSend:function(){
                        btn.html('Approving...');
                        btn.attr('disabled',true);
                    },
                    success: function (result) {
                        if(result['status'] == "200"){
                            if(result.data['signal'] == "success") {
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



        $("body").delegate(".rejectConcession", "click", function(event){
            event.preventDefault();
            var feeAssignDetailsId = $(this).attr('data-id');
            var concessionAmounts = $(this).attr('data-amount');
            $("#concession_reject_modal").find("#fee_assign_details_id").val(feeAssignDetailsId);
            $("#concession_reject_modal").find("#concession_amounts").val(concessionAmounts);
            $("#concession_reject_modal").modal('show');
        });

        //SUBMIT MODAL FORM
        $("body").delegate("#concessionRejectForm", "submit", function(event){
                event.preventDefault();

                var btn = $('#concession_reject');
                var id = $('#fee_assign_details_id').val();

                if ($('#concessionRejectForm').parsley().isValid()) {
                    if(confirm("Are you sure you want to reject?")){

                        $.ajax({
                            url:"/reject-concession/"+id,
                            type:"POST",
                            dataType:"json",
                            data: new FormData(this),
                            contentType: false,
                            processData:false,
                            beforeSend:function(){
                                btn.html('Rejecting...');
                                btn.attr('disabled',true);
                            },
                            success: function (result) {
                                if(result['status'] == "200"){
                                    if(result.data['signal'] == "success") {
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
                }
                return false;
            });

    });
</script>
@endsection
