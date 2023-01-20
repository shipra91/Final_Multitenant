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
                <input type="hidden" id="institutionId" value="{{ request()->route()->parameters['id'] }}"/>
                <div class="row">
                    <div class="col-sm-12 col-sm-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">email</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Message Credit Details :  {{$institution_name}}</h4>
                                <div class="material-datatables">
                                    <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                        <thead style="font-size:12px;">
                                            <tr>
                                                <th><b>S.N.</b></th>
                                                <th><b>Number Of Credits</b></th>
                                                <th><b>Credit Type</b></th>
                                                <th><b>Received on</b></th>
                                                <th><b>Amount</b></th>
                                                <th><b>Narration</b></th>
                                                <th><b>Transaction Id</b></th>
                                                <!-- <th><b>Action</b></th> -->
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="row mt-10">
                                    <div class="col-lg-12 text-right">
                                        <a type='button' class='btn btn-finish btn-fill btn-danger btn-wd' href="{{url('/etpl/message-credit-details')}}">Close</a>
                                    </div>
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
        var institutionId = $('#institutionId').val();
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "/etpl/institution-message-credit-details/"+institutionId,
            columns: [
                {data: 'DT_RowIndex', name: 'created_at', "width": "10%"},
                {data: 'credit_numbers', name: 'credit_numbers', "width": "20%"},
                {data: 'credit_type', name: 'credit_type', "width": "20%"},
                {data: 'amount_received_date', name: 'amount_received_date', "width": "15%"},
                {data: 'amount', name: 'amount', "width": "10%"},
                {data: 'narration', name: 'narration', "width": "10%"},
                {data: 'transaction_id', name: 'transaction_id', "width": "15%"},
                // {data: 'action', name: 'action', orderable: false, searchable: false, "width": "1%", className:"text-center"},
            ]
        });
    });
</script>
@endsection

