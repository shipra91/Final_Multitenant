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
                        <a href="{{ url('/event') }}" type="button" class="btn btn-primary"><i class="material-icons">menu</i> All Event</a>
                        <!-- <button type="button" class="btn btn-info restoreAll">Restore All</button> -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-sm-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">event</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Event List</h4>
                                <div class="toolbar"></div>
                                <div class="material-datatables">
                                    <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                        <thead style="font-size:12px;">
                                            <tr>
                                                <th><b>S.N.</b></th>
                                                <th><b>Event Name</b></th>
                                                <th><b>Start Date</b></th>
                                                <th><b>End Date</b></th>
                                                <th><b>Event Type</b></th>
                                                <th><b>Applicable To</b></th>
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
            ajax: "event-deleted-records",
            columns: [
                {data: 'DT_RowIndex', name: 'created_at', "width": "8%"},
                {data: 'name', name: 'name', "width": "22%"},
                {data: 'start_date', name: 'start_date', "width": "15%"},
                {data: 'end_date', name: 'end_date', "width": "15%"},
                {data: 'event_type', name: 'event_type', "width": "10%"},
                {data: 'recepient', name: 'recepient', "width": "15%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "15%", className:"text-center"},
            ]
        });

        // Restore records
        $(document).on('click', '.restore', function (e){
            e.preventDefault();

            var id = $(this).data('id');

            $.ajax({
                type: "GET",
                url:"/event/restore/"+id,
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
