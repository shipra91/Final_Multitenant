<?php
    use Carbon\Carbon;
?>
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
                        <a href="{{ url('/etpl/message-sender-entity/create') }}" type="button" class="btn btn-primary"><i class="material-icons">add</i>Add Sender & Entity ID</a>
                        {{-- <a href="{{ url('/etpl/sender-entity-deleted-records') }}" type="button" class="btn btn-info">Deleted Records</a> --}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-sm-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">email</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Sender ID and Entity ID List</h4>
                                <div class="toolbar"></div>
                                <div class="material-datatables">
                                    <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                        <thead style="font-size:12px;">
                                            <tr>
                                                <th><b>S.N.</b></th>
                                                <th><b>Sender ID</b></th>
                                                <th><b>Entity ID</b></th>
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

        // View sender and entity Id
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "/etpl/message-sender-entity",
            columns: [
                {data: 'DT_RowIndex', name: 'created_at', "width": "10%"},
                {data: 'sender_id', name: 'sender_id', "width": "35%"},
                {data: 'entity_id', name: 'entity_id', "width": "35%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "20%", className:"text-center"},
            ]
        });

        // Delete sender and entity Id
        $(document).on('click', '.delete', function (e){
            e.preventDefault();

            var id = $(this).attr('data-id');

            if(confirm("Are you sure you want to delete this?")){

                $.ajax({
                    type: "DELETE",
                    url:"/etpl/message-sender-entity/"+id,
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

