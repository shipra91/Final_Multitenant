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
                @if(Helper::checkAccess('fee-master', 'create'))
                    <div class="row">
                        <div class="col-sm-12 col-sm-offset-0 text-right">
                            <a href="{{ url('fee-master/create') }}" type="button" class="btn btn-primary"><i class="material-icons">add</i> Add Fee Master</a>
                        </div>
                    </div>
                @endif

                @if(Helper::checkAccess('fee-master', 'view'))
                    <div class="row">
                        <div class="col-sm-12 col-sm-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">account_balance_wallet</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Fee Master List</h4>
                                    <div class="toolbar"></div>
                                    <div class="material-datatables">
                                        <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                            <thead style="font-size:12px;">
                                                <tr>
                                                    <th><b>S.N.</b></th>
                                                    <th><b>Standard</b></th>
                                                    <th><b>Fee Category</b></th>
                                                    <th><b>Fee Type</b></th>
                                                    <th><b>Installment Type</b></th>
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

        // View fee master
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "fee-master",
            columns: [
                {data: 'DT_RowIndex', name: 'created_at', "width": "8%"},
                {data: 'standard', name: 'standard', "width": "20%"},
                {data: 'feeCategory', name: 'feeCategory', "width": "20%"},
                {data: 'feeType', name: 'feeType', "width": "20%"},
                {data: 'installmentType', name: 'installmentType', "width": "20%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "12%", className:"text-center"},
            ]
        });

        // Delete fee master
        $(document).on('click', '.delete', function (e){
            e.preventDefault();

            var id = $(this).attr('data-id');

            if(confirm("Are you sure you want to delete this?")){

                $.ajax({
                    type: "DELETE",
                    url:"/fee-master/"+id,
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
    });
</script>
@endsection
