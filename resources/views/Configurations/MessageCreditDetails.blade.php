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
                        <a href="{{ url('/etpl/message-credit-details-create') }}" type="button" class="btn btn-primary"><i class="material-icons">add</i> Add Message Credit</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-sm-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">email</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Message Credit Details</h4>
                                <div class="toolbar"></div>
                                <div class="material-datatables">
                                    <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                        <thead style="font-size:12px;">
                                            <tr>
                                                <th><b>S.N.</b></th>
                                                <th><b>Institution Name</b></th>
                                                <th><b>Available Credits</b></th>
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

        // View message credit details
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "message-credit-details",
            columns: [
                {data: 'DT_RowIndex', name: 'created_at', "width": "10%", className:"text-center"},
                {data: 'institution_name', name: 'institution_name', "width": "35%"},
                {data: 'available_credits', name: 'available_credits', "width": "35%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "20%", className:"text-center"},
            ]
        });

        // Delete message credit details
        $(document).on('click', '.delete', function (e){
            e.preventDefault();

            var label = $(this).attr('data-label');

            if(confirm("Are you sure you want to delete this?")){

                $.ajax({
                    type: "DELETE",
                    url:"/etpl/message-credit-details/"+label,
                    dataType: "json",
                    data: {label:label},
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

        // $('body').delegate('#fineSettingForm', 'submit', function(e){
        //     e.preventDefault();

        //     var btn = $('#submit');

        //     $.ajax({
        //         url:"/message-credit-details",
        //         type:"POST",
        //         dataType:"json",
        //         data: new FormData(this),
        //         contentType: false,
        //         processData:false,
        //         beforeSend:function(){
        //             btn.html('Submitting...');
        //             btn.attr('disabled',true);
        //         },
        //         success:function(result){
        //             btn.html('Submit');
        //             btn.attr('disabled',false);

        //             if(result['status'] == "200"){

        //                 if(result.data['signal'] == "success"){
        //                     swal({
        //                         title: result.data['message'],
        //                         buttonsStyling: false,
        //                         confirmButtonClass: "btn btn-success"
        //                     }).then(function() {
        //                         window.location.replace('/message-credit-details');
        //                     }).catch(swal.noop)

        //                 }else if(result.data['signal'] == "exist"){

        //                     swal({
        //                         title: result.data['message'],
        //                         buttonsStyling: false,
        //                         confirmButtonClass: "btn btn-warning"
        //                     });

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

