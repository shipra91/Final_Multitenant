@php

@endphp

@extends('layouts.master')

@section('content')
<div class="wrapper">
    @include('ETPLSliderbar/sliderbar')
    <div class="main-panel">
        @include('ETPLSliderbar/navigation')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 col-sm-offset-0 text-right">
                        <a href="{{url('/etpl/organization/create')}}" type="button" class="btn btn-primary mr-5"><i class="material-icons">add</i> Add Organization</a>
                        <a href="{{url('/etpl/organization-deleted-records')}}" type="button" class="btn btn-info"><i class="material-icons">delete_forever</i> Deleted Records</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-sm-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">school</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Organization List</h4>
                                <div class="material-datatables">
                                    <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" width="100%">
                                        <thead style="font-size:12px;">
                                            <tr>
                                                <th><b>S.N.</b></th>
                                                <th><b>Name</b></th>
                                                <th><b>Address</b></th>
                                                <th><b>Email ID</b></th>
                                                <th><b>Mobile No</b></th>
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

        // View organization
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "/etpl/organization",
            columns: [
                {data: 'DT_RowIndex', name: 'created_at', "width": "8%"},
                {data: 'name', name: 'name', "width": "25%", className: "capitalize"},
                {data: 'address', name: 'address', "width": "25%"},
                {data: 'office_email', name: 'office_email', "width": "15%"},
                {data: 'mobile_number', name: 'mobile_number', "width": "12%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "15%", className: "text-center"},
            ]
        });

        $(document).on('click', '.delete', function(e) {
            e.preventDefault();

            var id = $(this).data('id');
            if (confirm("Are you sure you want to delete this?")) {
                $.ajax({
                    type: "DELETE",
                    url: "/etpl/organization/" + id,
                    dataType: "json",
                    data: {
                        id: id
                    },
                    success: function(result) {
                        if (result['status'] == "200") {
                            if (result.data['signal'] == "success") {
                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function() {
                                    window.location.reload();
                                }).catch(swal.noop)

                            } else {
                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-danger"
                                });
                            }
                        } else {
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
