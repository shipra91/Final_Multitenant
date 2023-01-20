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
                    <div class="col-sm-12 col-sm-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">message</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Message List</h4>
                                <div class="toolbar"></div>
                                <div class="material-datatables">
                                    <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                        <thead style="font-size:12px;">
                                            <tr>
                                                <th><b>S.N.</b></th>
                                                <th><b>Date-Time</b></th>
                                                <th><b>Send To</b></th>
                                                <th><b>Description</b></th>
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

            // View message
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "message-report",
                columns: [
                    {data: 'DT_RowIndex', name: 'created_at', "width": "8%"},
                    {data: 'date_time', name: 'date_time', "width": "15%"},
                    {data: 'message_to', name: 'message_to', "width": "15%"},
                    {data: 'description', name: 'description', "width": "47%"},
                    {data: 'action', name: 'action', orderable: false, searchable: false, "width": "15%", className:"text-center"},
                ]
            });
        });
    </script>
@endsection
