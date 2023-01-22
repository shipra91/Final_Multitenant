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
                        @if(Helper::checkAccess('preadmission', 'create'))
                            <a href="{{ url('preadmission/create') }}" type="button" class="btn btn-success mr-5"><i class="material-icons">add</i> Add Preadmission</a>
                        @endif
                        @if(Helper::checkAccess('preadmission', 'create'))
                            <a href="{{ url('admit-preadmission') }}" type="button" class="btn btn-primary"><i class="material-icons">add</i> Admit Students</a>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-sm-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">face</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Student List</h4>
                                <div class="material-datatables">
                                    <table id="datatables" class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                        <thead style="font-size:12px;">
                                            <tr>
                                                <th><b>S.N.</b></th>
                                                <th><b>Application No</b></th>
                                                <th><b>Name</b></th>
                                                <th><b>Class</b></th>
                                                <th><b>Father Name</b></th>
                                                <th><b>Mobile No</b></th>
                                                <th><b>Type</b></th>
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

        // View preadmission
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ url('/all-preadmission')}}",
            columns: [
                {data: 'DT_RowIndex', name: 'id', "width": "8%"},
                {data: 'application_number', name: 'application_number', "width": "15%"},
                {data: 'name', name: 'name', "width": "20%", className:"capitalize"},
                {data: 'class', name: 'class', "width": "20%"},
                {data: 'father_name', name: 'father_name', "width": "12%", className:"capitalize"},
                {data: 'phone_number', name: 'phone_number', "width": "10%"},
                {data: 'type', name: 'type', "width": "10%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "15%", className:"text-center"},
            ]
        });

        // Delete preadmission
        $(document).on('click', '.delete', function (e){
            e.preventDefault();

            var id = $(this).data('id');

            if(confirm("Are you sure you want to delete this?")){

                $.ajax({
                    type: "DELETE",
                    url:"/preadmission/"+id,
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

        // Admit preadmission
        // $(document).on('click', '.admit', function (e) {
        //     e.preventDefault();

        //     var id = $(this).data('id');
        //     $.ajax({
        //         type: "POST",
        //         url:"/preadmission-admit/"+id,
        //         dataType: "json",
        //         data: {id:id},
        //         success: function (result) {
        //             if(result['status'] == "200"){
        //                 if(result.data['signal'] == "success") {
        //                     swal({
        //                         title: result.data['message'],
        //                         buttonsStyling: false,
        //                         confirmButtonClass: "btn btn-success"
        //                     }).then(function() {
        //                         window.location.reload();
        //                     }).catch(swal.noop)

        //                 }else{
        //                     swal({
        //                         title: result.data['message'],
        //                         buttonsStyling: false,
        //                         confirmButtonClass: "btn btn-danger"
        //                     });
        //                 }
        //             }else{
        //                 swal({
        //                     title: 'Server error',
        //                     buttonsStyling: false,
        //                     confirmButtonClass: "btn btn-danger"
        //                 })
        //             }
        //         }
        //     });
        // });
    });
</script>
@endsection
