@php
    if(Auth::user()->type === 'developer')
        $menuPath = 'module-permission';
    else
        $menuPath = 'menu-permission';
@endphp

@extends('layouts.master')

@section('content')
<div class="wrapper">
    @if(Auth::user()->type === 'developer')
        @include('/ETPLSliderbar/sliderbar')
    @else
        @include('sliderbar')
    @endif
    <div class="main-panel">
        @if(Auth::user()->type === 'developer')
            @include('/ETPLSliderbar/navigation')
        @else
            @include('navigation')
        @endif
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 col-sm-offset-0 text-right">
                        <input type="hidden" id="filepath" value="<?php echo $menuPath; ?>"/>

                            <a href="<?php echo $menuPath; ?>/create" type="button" class="btn btn-primary mr-5"><i class="material-icons">add</i> Add Permission</a>

                            <a href="<?php echo $menuPath; ?>-deleted-records" type="button" class="btn btn-info"><i class="material-icons">delete_forever</i> Deleted Records</a>

                    </div>
                </div>


                    <div class="row">
                        <div class="col-sm-12 col-sm-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">accessibility</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Module Permission List</h4>
                                    <div class="material-datatables">
                                        <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                            <thead style="font-size:12px;">
                                                <tr>
                                                    <th><b>S.N.</b></th>
                                                    <th><b>Role</b></th>
                                                    <th><b>Module</b></th>
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

        // View module permission
        var filepath = $("#filepath").val();

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: filepath,
            columns: [
                {data: 'DT_RowIndex', name: 'id', "width": "8%"},
                {data: 'role', name: 'role', "width": "17%"},
                {data: 'module', name: 'module', "width": "55%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "20%", className:"text-center"},
            ]
        });

        // Delete module permission
        $(document).on('click', '.delete', function (e){
            e.preventDefault();

            var id = $(this).data('id');

            if (confirm("Are you sure you want to delete this?")){

                $.ajax({
                    type: "DELETE",
                    url: filepath+"/"+id,
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
                // swal({
                //         title: "Are you sure!",
                //         type: "error",
                //         confirmButtonClass: "btn-danger",
                //         confirmButtonText: "Yes!",
                //         showCancelButton: true,
                //     },
                //     function() {
                //         alert('hello');
                //         $.ajax({
                //             type: "POST",
                //             url: "delete",
                //             dataType: "json",
                //             data: {id:id},
                //             success: function (data) {
                //                 console.log(data);
                //             }
                //         });
                // });
            }

            return false;
        });
    });
</script>
@endsection
