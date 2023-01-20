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
                @if(Helper::checkAccess('receipt-settings', 'create'))
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">account_balance_wallet</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Add Receipt Setting</h4>
                                    <form method="POST" id="receiptSettingForm">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Template<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="template" data-style="select-with-transition" data-size="3" data-live-search="true" title="Select" required>
                                                        <option value="1">Template 1</option>
                                                    </select>
                                                </div>
                                            </div>

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
                                                    <input type="text" class="form-control" name="receipt_prefix">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="control-label">Receipt Number Sequence<span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" name="receipt_sequence" min="0" required>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="control-label">Receipt Size<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="receipt_size" data-style="select-with-transition" data-size="3" data-live-search="true" title="Select" required>
                                                        <option value="A4-P">A4 - Potrait</option>
                                                        <option value="A4-L">A4 - Landscape</option>
                                                        <option value="A5-P">A5 - Potrait</option>
                                                        <option value="A5-L">A5 - Landscape</option>
                                                        <option value="A6-P">A6 - Potrait</option>
                                                        <option value="A6-L">A6 - Landscape</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="control-label">No of Copy<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="no_of_copy" id="no_of_copy" data-style="select-with-transition" data-size="3" data-live-search="true" title="Select" required>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
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

                @if(Helper::checkAccess('receipt-settings', 'view'))
                    <div class="row mt-20">
                        <div class="col-md-12">
                            <div class="alert alert-danger" role="alert">
                                <strong>Note:</strong>You can't delete this setting if it is used in any fee collection.
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">account_balance_wallet</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Receipt Setting List</h4>

                                    <div class="material-datatables">
                                        <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                            <thead style="font-size:12px;">
                                                <tr>
                                                    <th><b>S.N.</b></th>
                                                    <th><b>Template</b></th>
                                                    <th><b>Fee Category</b></th>
                                                    <th><b>Display Type</b></th>
                                                    <th><b>Receipt Prefix</b></th>
                                                    <th><b>Sequence No.</b></th>
                                                    <th><b>Receipt Size</b></th>
                                                    <th><b>No Of Copy</b></th>
                                                    <th><b>Display Name</b></th>
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
@endsection

@section('script-content')
<script>
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // View receipt setting
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "receipt-settings",
            columns: [
                {data: 'DT_RowIndex', name: 'id', "width": "8%"},
                {data: 'template', name: 'template', "width": "20%"},
                {data: 'fee_category', name: 'fee_category', "width": "15%"},
                {data: 'display_type', name: 'display_type', "width": "15%"},
                {data: 'receipt_prefix', name: 'receipt_prefix'},
                {data: 'receipt_no_sequence', name: 'receipt_no_sequence'},
                {data: 'receipt_size', name: 'receipt_size'},
                {data: 'no_of_copy', name: 'no_of_copy', "width": "15%"},
                {data: 'copy_name', name: 'copy_name', "width": "15%", className:"capitalize"},
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

        $('#receiptSettingForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save receipt setting
        $('body').delegate('#receiptSettingForm', 'submit', function(e){
            e.preventDefault();

            var btn=$('#submit');

            if ($('#receiptSettingForm').parsley().isValid()){

                $.ajax({
                    url:"/receipt-settings",
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

        // Delete receipt setting
        $(document).on('click', '.delete', function (e){
            e.preventDefault();

            var id = $(this).data('id');

            if(confirm("Are you sure you want to delete this?")){

                $.ajax({
                    type: "DELETE",
                    url:"/receipt-settings/"+id,
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
    });
</script>
@endsection
