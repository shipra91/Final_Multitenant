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
                        <a href="{{ url('/etpl/email-template/create') }}" type="button" class="btn btn-primary mr-5"><i class="material-icons">add</i> Add Email Templates</a>
                        <a href="{{ url('/etpl/email-deleted-template') }}" type="button" class="btn btn-info"><i class="material-icons">delete_forever</i> Deleted Records</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-sm-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">local_post_office</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Email Template</h4>
                                <div class="material-datatables">
                                    <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                        <thead style="font-size:12px;">
                                            <tr>
                                                <th><b>S.N.</b></th>
                                                <th><b>Module</b></th>
                                                <th><b>Template Name</b></th>
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

        // View email template
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "/etpl/email-template",
            columns: [
                {data: 'DT_RowIndex', name: 'id'},
                {data: 'module', name: 'module'},
                {data: 'template_name', name: 'template_name'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        // Delete email template
        $(document).on('click', '.delete', function (e){
            e.preventDefault();

            var id = $(this).data('id');

            if(confirm("Are you sure you want to delete this?")){

                $.ajax({
                    type: "DELETE",
                    url: "/etpl/email-template/"+id,
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
