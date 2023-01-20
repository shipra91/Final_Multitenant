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
                        <a href="{{ url('grade') }}" type="button" class="btn btn-primary"><i class="material-icons">menu</i> All Grade</a>
                        <!-- <button type="button" class="btn btn-info restoreAll">Restore All</button> -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-sm-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">assessment</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Grade List</h4>
                                <div class="material-datatables">
                                    <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                        <thead style="font-size:12px;">
                                            <tr>
                                                <th><b>S.N.</b></th>
                                                <th><b>Grade Set Title</b></th>
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

        // Deleted records list
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "grade-deleted-records",
            columns: [
                {data: 'DT_RowIndex', name: 'created_at', "width": "8%"},
                {data: 'gradeTitle', name: 'gradeTitle', "width": "77%", className:"capitalize"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "15%", className:"text-center"},
            ]
        });

        // Restore records
        $(document).on('click', '.restore', function (e){
            e.preventDefault();

            var id = $(this).data('id');

            $.ajax({
                type: "GET",
                url:"/grade/restore/"+id,
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
