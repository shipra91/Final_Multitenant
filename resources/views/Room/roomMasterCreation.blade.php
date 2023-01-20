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
                @if(Helper::checkAccess('room-master', 'create'))
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">school</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Add Room Master</h4>
                                    <form method="POST" class="demo-form" id="roomMasterForm">
                                        <div id="repeater">
                                            <input type="hidden" name="totalCount" id="totalCount" value="1">
                                            <div id="section_1" data-id="1">
                                                <div class="row">
                                                    <div class="col-lg-3 col-lg-offset-0">
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Building Name<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="building_name[]" id="building_name_1" required />
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-lg-offset-0">
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Block Name</label>
                                                            <input type="text" class="form-control" name="block_name[]" id="block_name_1" />
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-lg-offset-0">
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Floor Number</label>
                                                            <input type="text" class="form-control" name="floor_number[]" id="floor_number_1" />
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-lg-offset-0">
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Room Number<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="room_number[]" id="room_number_1" required />
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-lg-offset-0">
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Display Name<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="display_name[]" id="display_name_1" required />
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-lg-offset-0">
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Regular Capacity</label>
                                                            <input type="text" class="form-control" name="regular_capacity[]" id="regular_capacity_1" />
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-lg-offset-0">
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Exam Capacity</label>
                                                            <input type="text" class="form-control" name="exam_capacity[]" id="exam_capacity_1" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <button id="add_more" type="button" class="btn btn-warning btn-sm"><i class="material-icons">add_circle_outline</i> Add</button>
                                        </div>

                                        <div class="pull-right">
                                            <div class="form-group mt-0">
                                                <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd" id="submit" name="submit">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(Helper::checkAccess('room-master', 'view'))
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">school</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Room List</h4>
                                    <div class="material-datatables">
                                        <table class="table table-striped table-no-bordered table-hover data-table"
                                            cellspacing="0" width="100%" style="width:100%">
                                            <thead style="font-size:12px;">
                                                <tr>
                                                    <th><b>S.N.</b></th>
                                                    <th><b>Building</b></th>
                                                    <th><b>Block</b></th>
                                                    <th><b>Floor No</b></th>
                                                    <th><b>Room No</b></th>
                                                    <th><b>Display Name</b></th>
                                                    <th><b>Regular Capacity</b></th>
                                                    <th><b>Exam Capacity</b></th>
                                                    <th><b>Action</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- <p class="text-info"><strong>Note:</strong>The subject can not be edited or deleted if the subject is already mapped</p> -->
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
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

        // View room master
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "room-master",
            columns: [
                {data: 'DT_RowIndex',name: 'id', "width": "8%"},
                {data: 'building_name', name: 'building_name', "width": "12%"},
                {data: 'block_name', name: 'block_name', "width": "10%"},
                {data: 'floor_number', name: 'floor_number', "width": "10%"},
                {data: 'room_number', name: 'room_number', "width": "10%"},
                {data: 'display_name', name: 'display_name', "width": "15%"},
                {data: 'regular_capacity', name: 'regular_capacity', "width": "15%"},
                {data: 'exam_capacity', name: 'exam_capacity', "width": "15%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "5%"},
            ]
        });

        // Add more room master
        var count = $('#totalCount').val();

        $(document).on('click', '#add_more', function(){

            var html = '';
            count++;

            html += '<div id="section_' + count + '" data-id="' + count + '">';
            html += '<div class="row">';
            html += '<div class="col-lg-3 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Building Name<span class="text-danger">*</span></label>';
            html += '<input type="text" class="form-control" name="building_name[]" id="building_name_' + count + '" required/>';
            html += '</div>';
            html += '</div>';
            html += '<div class="col-lg-3 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Block Name</label>';
            html += '<input type="text" class="form-control" name="block_name[]" id="block_name_' + count + '" />';
            html += '</div>';
            html += '</div>';
            html += '<div class="col-lg-3 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Floor Number</label>';
            html += '<input type="text" class="form-control" name="floor_number[]" id="floor_number_' + count + '" />';
            html += '</div>';
            html += '</div>';
            html += '<div class="col-lg-3 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Room Number<span class="text-danger">*</span></label>';
            html += '<input type="text" class="form-control" name="room_number[]" id="room_number_' + count + '" required/>';
            html += '</div>';
            html += '</div>';
            html += '<div class="col-lg-3 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Display Name<span class="text-danger">*</span></label>';
            html += '<input type="text" class="form-control" name="display_name[]" id="display_name_' + count + '" required />';
            html += '</div>';
            html += '</div>';
            html += '<div class="col-lg-3 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Regular Capacity</label>';
            html += '<input type="text" class="form-control" name="regular_capacity[]" id="regular_capacity_' + count + '" />';
            html += '</div>';
            html += '</div>';
            html += '<div class="col-lg-3 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Exam Capacity</label>';
            html += '<input type="text" class="form-control" name="exam_capacity[]" id="exam_capacity_' + count + '" />';
            html += '</div>';
            html += '</div>';
            html += ' <div class="col-lg-3 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<td><button type="button" id="' + count + '" class="btn btn-danger btn-sm remove_button mt-15"><i class="material-icons">highlight_off</i></button></td>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            $('#repeater').append(html);

            $('.from_date,.to_date').datetimepicker({
                format: 'DD/MM/YYYY',
            });

            $("#totalCount").val(count);
            $('.selectpicker').selectpicker();
        });

        // Remove room master
        $(document).on('click', '.remove_button', function(event){
            event.preventDefault();

            var id = $(this).attr('id'); //alert(id);
            var totalCount = $('#repeater div:last').attr('id');
            $(this).closest('div #section_' + id).remove();
            totalCount--;
        });

        $('#roomMasterForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save room master
        $('body').delegate('#roomMasterForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');

            if ($('#roomMasterForm').parsley().isValid()){

                $.ajax({
                    url: "/room-master",
                    type: "POST",
                    dataType: "json",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        btn.html('Submitting...');
                        btn.attr('disabled', true);
                    },
                    success: function(result){
                        btn.html('Submit');
                        btn.attr('disabled', false);

                        if (result['status'] == "200"){

                            if(result.data['signal'] == "success"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function() {
                                    window.location.reload();
                                }).catch(swal.noop)

                            }else if (result.data['signal'] == "exist"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-warning"
                                });

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
        });

        // Delete Subject
        // $(document).on('click', '.delete', function(e) {
        //     e.preventDefault();

        //     var id = $(this).data('id');

        //     $.ajax({
        //         type: "DELETE",
        //         url: "/institution-subject/" + id,
        //         dataType: "json",
        //         data: {
        //             id: id
        //         },
        //         success: function(result) {

        //             if (result['status'] == "200") {

        //                 if (result.data['signal'] == "success") {

        //                     swal({
        //                         title: result.data['message'],
        //                         buttonsStyling: false,
        //                         confirmButtonClass: "btn btn-success"
        //                     }).then(function() {
        //                         window.location.reload();
        //                     }).catch(swal.noop)

        //                 } else {

        //                     swal({
        //                         title: result.data['message'],
        //                         buttonsStyling: false,
        //                         confirmButtonClass: "btn btn-danger"
        //                     });
        //                 }

        //             } else {

        //                 swal({
        //                     title: 'Server error',
        //                     buttonsStyling: false,
        //                     confirmButtonClass: "btn btn-danger"
        //                 })
        //             }
        //         }
        //     });
        // });

        // $('body').delegate('.subject', 'change', function() {
        //     var subjectId = $(this).find(":selected").val();
        //     var parentDiv = $(this).parents('.row'); //.attr('data-id'); alert(parentDiv);
        //     var dataId = parentDiv.attr('data-id');
        //     $.ajax({
        //         url: "/subjects",
        //         type: "POST",
        //         data: {
        //             id: subjectId
        //         },
        //         success: function(data) {
        //             parentDiv.find('#display_name_' + dataId).val(data.name);

        //         }
        //     });
        // });
    });
</script>
@endsection
