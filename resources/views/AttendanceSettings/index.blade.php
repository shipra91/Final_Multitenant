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
                        @if(Helper::checkAccess('attendance-settings', 'create'))
                            <a href="{{ url('attendance-settings/create') }}" type="button" class="btn btn-primary mr-5"><i class="material-icons">add</i> Add Attendance Settings</a>
                        @endif
                        @if(Helper::checkAccess('attendance-settings', 'view'))
                            <a href="{{ url('attendance-settings-deleted-records') }}" type="button" class="btn btn-info"><i class="material-icons">delete_forever</i> Deleted Records</a>
                        @endif
                    </div>

                    @if(Helper::checkAccess('attendance-settings', 'view'))
                        <div class="col-sm-12 col-sm-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">assessment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Attendance Setting List</h4>
                                    <div class="material-datatables">
                                        <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" width="100%">
                                            <thead style="font-size:12px;">
                                                <tr>
                                                    <th><b>S.N.</b></th>
                                                    <th><b>Attendance Type</b></th>
                                                    <th><b>Standard</b></th>
                                                    <th><b>Display Subject</b></th>
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
                    @endif
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

        // View attendance settings
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ url('/attendance-settings')}}",
            columns: [
                {data: 'DT_RowIndex', name: 'id', "width": "10%"},
                {data: 'attendance_type', name: 'attendance_type', "width": "20%", className: "capitalize"},
                {data: 'id_standard', name: 'id_standard', "width": "30%"},
                {data: 'display_subject', name: 'display_subject', "width": "20%", className: "capitalize"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "20%", className:"text-center"},
            ]
        });

        // Delete attendance settings
        $(document).on('click', '.delete', function (e){
            e.preventDefault();

            var id = $(this).data('id');

            if(confirm("Are you sure you want to delete this?")){

                $.ajax({
                    type: "DELETE",
                    url:"/attendance-settings/"+id,
                    dataType: "json",
                    data: {id:id},
                    success: function (result) {

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
