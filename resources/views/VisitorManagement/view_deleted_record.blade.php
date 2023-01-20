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
                        <a href="{{ url('/visitor') }}" type="button" class="btn btn-primary"><i class="material-icons">menu</i> All Visitors List</a>
                        <!-- <button type="button" class="btn btn-info restoreAll">Restore All</button> -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-sm-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">query_builder</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Visitors List</h4>
                                <div class="toolbar"></div>
                                <div class="material-datatables">
                                    <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                        <thead style="font-size:12px;">
                                            <tr>
                                                <th><b>S.N.</b></th>
                                                <th><b>Name</b></th>
                                                <th><b>Phone</b></th>
                                                <th><b>Age</b></th>
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
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Deleted records list
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "visitor-deleted-records",
            columns: [
                {data: 'DT_RowIndex', name: 'created_at', "width": "8%"},
                {data: 'visitor_name', name: 'visitor_name', "width": "22%", className:"capitalize"},
                {data: 'visitor_contact', name: 'visitor_contact', "width": "15%"},
                {data: 'visitor_age', name: 'visitor_age', "width": "15%"},
                {data: 'type', name: 'type', "width": "15%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "20%", className:"text-center"},
            ]
        });

        // Restore records
        $(document).on('click', '.restore', function (e){
            e.preventDefault();

            var id = $(this).data('id');

            $.ajax({
                type: "GET",
                url:"/visitor/restore/"+id,
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
        });

        // Restore all
        // $(document).on('click', '.restoreAll', function (e){
        //     e.preventDefault();

        //     $.ajax({
        //         type: "GET",
        //         url:"/institution/restore-all",
        //         dataType: "json",
        //         success: function (result){

        //             if(result['status'] == "200"){

        //                 if(result.data['signal'] == "success"){

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
