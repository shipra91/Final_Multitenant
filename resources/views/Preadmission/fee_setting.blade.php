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
                        <a href="{{ url('preadmission-fee/create') }}" type="button" class="btn btn-primary">Add Fee Setting</a>
                        <a href="{{ url('preadmission-deleted-fee/deleted-records') }}" type="button" class="btn btn-info">Deleted Records</a>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12 col-sm-offset-0">  
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">event</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">View Application Setting</h4>
                                <div class="toolbar">
                                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                                </div>
                                <div class="material-datatables">
                                    <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                        <thead style="font-size:12px;">
                                            <tr>
                                                <th><b>S.N.</b></th>
                                                <th><b>Application Name</b></th>
                                                <th><b>Standard</b></th>
                                                <th><b>Fee Amount</b></th>
                                                <th><b>Prefix</b></th>
                                                <th><b>Starting Number</b></th>
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
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "preadmission-fee",
        columns: [
            {data: 'DT_RowIndex', name: 'id'},
            {data: 'application_name', name: 'application_name'},
            {data: 'standard_name', name: 'standard_name'},
            {data: 'fee_amount', name: 'fee_amount'},
            {data: 'receipt_prefix', name: 'receipt_prefix'},
            {data: 'receipt_starting_number', name: 'receipt_starting_number'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
    $(document).on('click', '.delete', function (e) {
        e.preventDefault();
        var id = $(this).data('id');

        $.ajax({
            type: "DELETE",
            url: "/preadmission-fee/"+id, 
            dataType: "json",
            data: {id:id},
            success: function (result) {
                if(result['status'] == "200"){
                    if(result.data['signal'] == "success") { 
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

});
</script>
@endsection    