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
                @if(Helper::checkAccess('challan-setting', 'create'))
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">account_balance_wallet</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Add Challan Setting</h4>
                                    <form method="POST" id="challanSettingForm">
                                        <div class="row">
                                            <input type="hidden" name="template" value="1">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Fee Category<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="fee_category[]" data-style="select-with-transition" data-size="3" data-live-search="true" title="Select" multiple data-actions-box="true" required>
                                                        @foreach($feeCategories as $feeCategory)
                                                            <option value="{{ $feeCategory->id }}">{{ $feeCategory->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Display Type<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="display_type" data-style="select-with-transition" data-size="3" data-live-search="true" title="Select" required>
                                                        <option value="HEADWISE">Heading Wise</option>
                                                        <option value="CATEGORYWISE">Category Wise</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Prefix</label>
                                                    <input type="text" class="form-control" name="challan_prefix">
                                                </div>
                                            </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label  mt-0">Challan Number Sequence<span class="text-danger">*</span></label>
                                                <input type="number" min='0' class="form-control" name="challan_sequence" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Account Number<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="bank_detail_id" id="bank_detail_id" data-style="select-with-transition" data-size="3" data-live-search="true" title="Select" data-actions-box="true" required>
                                                    @foreach($institutionBankDetails as $bankData)
                                                        <option value="{{ $bankData->id }}">{{ $bankData->account_number }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Bank Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="bank_name" required readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Branch Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="branch_name" required readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">IFSC Code<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="ifsc_code" required readonly>
                                            </div>
                                        </div>
                                    </div>

                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="control-label">No of Copy<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="no_of_copy" id="no_of_copy" data-style="select-with-transition" data-size="3" data-live-search="true" title="Select" required>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" id="getExtraColumns">

                                        </div>

                                        <div class="row">
                                            <div class="form-group col-lg-12 text-right">
                                                <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd" id="submit" name="submit">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(Helper::checkAccess('challan-setting', 'view'))

                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger" role="alert">
                                <strong>Note:</strong> You can't delete this setting if it is used in any challan creation.
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons"> account_balance_wallet</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Challan Setting List</h4>
                                    <div class="material-datatables">
                                        <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                            <thead style="font-size:12px;">
                                                <tr>
                                                    <th><b>S.N.</b></th>
                                                    <th><b>Fee Category</b></th>
                                                    <th><b>Display Type</b></th>
                                                    <th><b>Prefix</b></th>
                                                    <th><b>No Sequence</b></th>
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

<!-- View challanSetting detail modal -->
<div class="modal fade" id="challanSetting_modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="card1">
                <div class="card-header card-header-tabs" data-background-color="mediumaquamarine">
                    <div class="card-title1">Challan Setting Details</div>
                </div>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label class="control-label mt-0">Fee Category</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="fee_category" disabled />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="control-label mt-0">Display Type</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="display_type" disabled/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label mt-0">Prefix</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="challan_prefix" disabled/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="control-label mt-0">Number of Sequence</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="no_of_sequence" disabled/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label mt-0">Number of Copy</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="no_of_copy" disabled/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="control-label mt-0">Display Copy Name</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="display_copy_name" disabled />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="control-label mt-0">Bank Name</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="bank_name" disabled/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label mt-0">Branch Name</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="branch_name" disabled/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="control-label mt-0">Account Number</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="account_number" disabled/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label mt-0">IFSC Code</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="ifsc_code" disabled/>
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

        // View challan setting
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "challan-setting",
            columns: [
                {data: 'DT_RowIndex', name: 'id', "width": "8%"},
                {data: 'fee_category', name: 'fee_category', "width": "15%"},
                {data: 'display_type', name: 'display_type', "width": "15%"},
                {data: 'challan_prefix', name: 'challan_prefix', "width": "15%"},
                {data: 'challan_no_sequence', name: 'challan_no_sequence', "width": "15%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "12%"},
            ]
        });

        $("#no_of_copy").on('change', function(event){
            event.preventDefault();

            var no_of_copy = $(this).val();
            var html = '';

            for(var i = 1; i <= no_of_copy; i++){

                html += '<div class="col-lg-3">';
                html += '<div class="form-group">';
                html += '<label class="control-label">Display Name '+i+'<span class="text-danger">*</span></label>';
                html += '<input type="text" class="form-control" name="display_name[]" required>';
                html += '</div>';
                html += '</div>';
            }

            $("#getExtraColumns").html(html);
        });

        $("#bank_detail_id").on('change', function(event){
            event.preventDefault();

            var bankDetailId = $(this).val();

            $.ajax({
                url: "/get-bank-data",
                type: "POST",
                data: {bankDetailId: bankDetailId},
                success: function(data){

                    $("#bank_name").val(data.bank_name);
                    $("#branch_name").val(data.branch_name);
                    $("#account_number").val(data.account_number);
                    $("#ifsc_code").val(data.ifsc_code);
                }
            });
        });

        $('#challanSettingForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save challan setting
        $('body').delegate('#challanSettingForm', 'submit', function(e){
            e.preventDefault();

            var btn=$('#submit');

            if ($('#challanSettingForm').parsley().isValid()){

                $.ajax({
                    url:"/challan-setting",
                    type:"post",
                    dataType:"json",
                    data: new FormData(this),
                    contentType: false,
                    processData:false,
                    beforeSend:function(){
                        btn.html('Submitting...');
                        btn.attr('disabled',true);
                    },
                    success:function(result) {
                        console.log(result);
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
            }
        });

        // Delete challan setting
        $(document).on('click', '.delete', function (e){
            e.preventDefault();

            var id = $(this).data('id');

            if(confirm("Are you sure you want to delete this?")){

                $.ajax({
                    type: "DELETE",
                    url:"/challan-setting/"+id,
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
        });

         // View Challan Setting details
         $("body").delegate(".challanSettingDetail", "click", function(event){
            event.preventDefault();

            var challanSettingId = $(this).attr('data-id');

            $.ajax({
                url:"{{ url('/challan-setting-data') }}",
                type : "post",
                dataType : "json",
                data : {challanSettingId:challanSettingId},
                success : function(response){
                    console.log(response);

                    var html = '';

                    $("#challanSetting_modal").find("#fee_category").val(response.feeChallanSettingCategory);
                    $("#challanSetting_modal").find("#display_type").val(response.display_type);
                    $("#challanSetting_modal").find("#challan_prefix").val(response.challan_prefix);
                    $("#challanSetting_modal").find("#no_of_sequence").val(response.challan_no_sequence);
                    $("#challanSetting_modal").find("#no_of_copy").val(response.no_of_copy);
                    $("#challanSetting_modal").find("#display_copy_name").val(response.copy_name);
                    $("#challanSetting_modal").find("#bank_name").val(response.bank_name);
                    $("#challanSetting_modal").find("#branch_name").val(response.branch_name);
                    $("#challanSetting_modal").find("#account_number").val(response.account_number);
                    $("#challanSetting_modal").find("#ifsc_code").val(response.ifsc_code);
                    $("#challanSetting_modal").find('tbody').html(html);
                    $("#challanSetting_modal").modal('show');
                }
            });
        });
    });
</script>
@endsection
