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
                        <a href="{{ url('institution-bank-details-create') }}" type="button" class="btn btn-primary mr-5"><i class="material-icons">add</i> Add Bank Details</a>
                        <a href="{{url('institution-bank-details-deleted-records')}}" type="button" class="btn btn-info">Deleted Records</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-md-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">account_balance_wallet</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Bank Details List</h4>
                                <div class="alert alert-danger" role="alert">
                                    <strong>Note:</strong> If bank details is used in challan setting, bank details can't be edited or deleted.  .
                                </div>
                                <div class="material-datatables">
                                    <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                        <thead style="font-size:12px;">
                                            <tr>
                                                <th><b>S.N.</b></th>
                                                <th><b>Bank Name</b></th>
                                                <th><b>Branch Name</b></th>
                                                <th><b>Account Number</b></th>
                                                <th><b>IFSC Code</b></th>
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
@endsection

@section('script-content')
<script>
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // View fee heading
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "institution-bank-details",
            columns: [
                {data: 'DT_RowIndex', name: 'id', "width": "10%"},
                {data: 'bank_name', name: 'bank_name', "width": "20%"},
                {data: 'branch_name', name: 'branch_name', "width": "20%"},
                {data: 'account_number', name: 'account_number', "width": "20%"},
                {data: 'ifsc_code', name: 'ifsc_code', "width": "20%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "10%"},
            ]
        });

        // Delete fee heading
        $(document).on('click','.delete',function(){

            var id = $(this).data('id');

            if(confirm("Are you sure you want to delete this?")){

                $.ajax({
                    type: "DELETE",
                    url:"institution-bank-details/"+id,
                    dataType: "json",
                    data: {id:id},
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
    });
</script>
@endsection
