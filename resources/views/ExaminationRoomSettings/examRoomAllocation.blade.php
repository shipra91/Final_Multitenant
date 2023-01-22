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
                @if(Helper::checkAccess('exam-room', 'create'))
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">school</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Exam Room Settings</h4>
                                    <form method="POST" class="demo-form" id="examRoomSettingForm">
                                        <input type="hidden" name="id_institute" value="{{session()->get('institutionId')}}">
                                        <input type="hidden" name="id_academic" value="{{session()->get('academicYear')}}">
                                        <input type="hidden" name="organization" value="{{session()->get('organizationId')}}">
                                        <div id="repeater">
                                            <input type="hidden" name="totalCount" id="totalCount" value="1">
                                            <div class="row" id="section_1" data-id="1">
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Exam<span class="text-danger">*</span></label>
                                                        <select name="exam[]" id="exam_1" class="selectpicker" data-live-search="true" data-style="select-with-transition" data-size="5" required title="Select" data-parsley-errors-container=".examError">
                                                            @foreach($examDetails as $exam)
                                                                <option value="{{$exam['id']}}">{{$exam['exam_name']}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="examError"></div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0" id="idStandard">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Standard<span class="text-danger">*</span></label>
                                                        <select name="standard[]" id="standard_1" class="selectpicker" data-live-search="true" data-style="select-with-transition" data-selected-text-format="count > 1" data-size="5" required title="Select" data-parsley-errors-container=".standardError">

                                                        </select>
                                                        <div class="standardError"></div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Subject<span class="text-danger">*</span></label>
                                                        <select class="selectpicker" name="subject[]" id="subject_1" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" data-selected-text-format="count > 1" required="required" data-parsley-errors-container=".subjectError">

                                                        </select>
                                                        <div class="subjectError"></div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Room No<span class="text-danger">*</span></label>
                                                        <select class="selectpicker" name="roomNo[]" id="roomNo_1" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" data-selected-text-format="count > 1" required="required" data-parsley-errors-container=".roomError">
                                                            @foreach($rooms as $room)
                                                                <option value="{{$room['id']}}">{{$room['display_name']}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="roomError"></div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Roll No<span class="text-danger">*</span></label>
                                                        <select class="selectpicker" name="roll_no[1][]" id="roll_no_1" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" data-selected-text-format="count > 1" required="required" multiple data-actions-box="true" data-parsley-errors-container=".rollError">

                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Internal Invigilator</label>
                                                        <input type="text" class="form-control" name="internalInvigilator[]" id="internalInvigilator_1" />
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">External Invigilator</label>
                                                        <input type="text" class="form-control" name="externalInvigilator[]" id="externalInvigilator_1" />
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-lg-offset-0">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Count</label>
                                                        <input type="text" class="form-control" name="count[]" id="count_1" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <button id="add_more" type="button" class="btn btn-warning btn-sm"><i class="material-icons">add_circle_outline</i> Add</button>
                                        </div>

                                        <div class="form-group pull-right submit mt-0">
                                            <button type="submit" class="btn btn-info btn-wd" id="submit" name="submit">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(Helper::checkAccess('exam-room', 'view'))
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">school</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Exam Room Settings List</h4>
                                    <div class="material-datatables">
                                            <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                            <thead style="font-size:12px;">
                                                <tr>
                                                    <th><b>S.N.</b></th>
                                                    <th><b>Room No</b></th>
                                                    <th><b>Exam Name</b></th>
                                                    <th><b>Count</b></th>
                                                    <th><b>Internal Invigilator</b></th>
                                                    <th><b>External Invigilator</b></th>
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

        $('#examRoomSettingForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // View exam room settings
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "exam-room",
            columns: [
                {data: 'DT_RowIndex', name: 'id', "width": "10%"},
                {data: 'room_no', name: 'room_no', "width": "15%"},
                {data: 'exam_name', name: 'exam_name', "width": "15%"},
                {data: 'count', name: 'count', "width": "10%"},
                {data: 'internal_invigilator', name: 'internal_invigilator', "width": "20%"},
                {data: 'external_invigilator', name: 'external_invigilator',"width": "20%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "10%", className:"text-center"},
            ]
        });

        function getStandards(examId, index){

            $.ajax({
                url: "/exam-master-data",
                type: "POST",
                data: {
                    id: examId
                },
                success: function(data){
                    var standardDetails = data.standard_details;
                    var select = $('#standard_' + index);
                    select.empty();
                    for (var i = 0; i < standardDetails.length; i++){
                        select.append('<option value="' +
                            standardDetails[i]['id'] +
                            '">' +
                            standardDetails[i]['label'] +
                            '</option>');
                    }
                    select.selectpicker('refresh');
                }
            });
        }

        function getSubjects(examId, standardId, index){

            $.ajax({
                url: "/get-exam-subject",
                type: "POST",
                data: {
                    standardId: standardId,
                    examId: examId
                },
                success: function(data){
                    var select = $('#subject_' + index);
                    select.empty();
                    for (var i = 0; i < data.length; i++){
                        select.append('<option value="' +
                            data[i].id +
                            '">' +
                            data[i].name +
                            '</option>');
                    }
                    select.selectpicker('refresh');
                }
            });
        }

        function getStudents(subjectId, standardId, index){

            $.ajax({
                url: "/get-subject-students",
                type: "POST",
                data: {
                    standardId: standardId,
                    subjectId: subjectId
                },
                success: function(data){
                    var select = $('#roll_no_' + index);
                    select.empty();

                    for (var i = 0; i < data.length; i++){
                        select.append('<option value="' +
                            data[i].id_student +
                            '">' +
                            data[i].name +
                            '</option>');
                    }
                    select.selectpicker('refresh');
                }
            });
        }

        // Add more exam room settings
        var count = $('#totalCount').val();

        $(document).on('click', '#add_more', function(){

            var html = '';
            count++;

            html += '<div class="row" id="section_' + count + '" data-id="' + count + '">';
            html += '<div class="col-lg-3 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Exam<span class="text-danger">*</span></label>';
            html += '<select name="exam[]" id="exam_' + count + '" class="selectpicker" data-live-search="true" data-style="select-with-transition" data-size="5" required title="Select">';
            <?php foreach($examDetails as $exam){?>
            html += '<option value="<?php echo $exam['id'];?>"><?php echo $exam['exam_name'];?></option>';
            <?php } ?>
            html += '</select>';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-3 col-lg-offset-0" id="idStandard">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Standard<span class="text-danger">*</span></label>';
            html += '<select name="standard[]" id="standard_' + count + '" class="selectpicker" data-live-search="true" data-style="select-with-transition" data-selected-text-format="count > 1" data-size="5" required title="Select">';
            html += '</select>';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-3 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Subject<span class="text-danger">*</span></label>';
            html += '<select class="selectpicker" name="subject[]" id="subject_' + count + '" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" data-selected-text-format="count > 1" required="required">';
            html += '</select>';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-3 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Room No<span class="text-danger">*</span></label>';
            html += '<select class="selectpicker" name="roomNo[]" id="roomNo_' + count + '" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" data-selected-text-format="count > 1" required="required">';
            <?php foreach($rooms as $room){?>
            html += '<option value="<?php echo $room['id'];?>"><?php echo $room['display_name'];?> </option>';
            <?php } ?>
            html += '</select>';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-3 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Roll No<span class="text-danger">*</span></label>';
            html += '<select class="selectpicker" name="roll_no[' + count + '][]" id="roll_no_' + count + '" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" data-selected-text-format="count > 1" required="required" multiple data-actions-box="true"></select>';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-3 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Internal Invigilator</label>';
            html += '<input type="text" class="form-control" name="internalInvigilator[]" id="internalInvigilator_' + count + '" />';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-3 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">External Invigilator</label>';
            html += '<input type="text" class="form-control" name="externalInvigilator[]" id="externalInvigilator_' + count + '" />';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-2 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Count</label>';
            html += '<input type="text" class="form-control" name="count[]" id="count_' + count + '" readonly />';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-1 col-lg-offset-0 text-right">';
            html += '<div class="form-group">';
            html += '<button type="button" id="' + count + '" class="btn btn-danger btn-sm remove_button mt-15"><i class="material-icons">highlight_off</i></button>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            $('#repeater').append(html);
            $("#totalCount").val(count);
            $('.selectpicker').selectpicker();

            $('#exam_' + count).on('change', function(){

                var examId = $(this).find(":selected").val();
                var index = $(this).parents('.row').attr('data-id');

                getStandards(examId, index);
            });

            $('#standard_' + count).on('change', function(){

                var standardId = $(this).find(":selected").val();
                var examId = $('#exam_1').val();
                var index = $(this).parents('.row').attr('data-id');

                getSubjects(examId, standardId, index);
            });

            $('#subject_' + count).on('change', function(){

                var subjectId = $(this).find(":selected").val();
                var standardId = $('#standard_1').val();
                var index = $(this).parents('.row').attr('data-id');

                getStudents(subjectId, standardId, index);
            });

            $('#roll_no_' + count).on('change', function(){

                var count = $(this).find(":selected").length;
                var index = $(this).parents('.row').attr('data-id');

                $('#count_' + index).val(count);
            });
        });

        // Remove exam room settings
        $(document).on('click', '.remove_button', function(event){
            event.preventDefault();

            var id = $(this).attr('id'); //alert(id);
            console.log(id);
            var totalCount = $('#repeater tr:last').attr('id');

            $(this).closest('div #section_' + id + '').remove();
            totalCount--;
        });

        $('#exam_1').on('change', function(){

            var examId = $(this).find(":selected").val();
            var index = $(this).parents('.row').attr('data-id');

            getStandards(examId, index);
        });

        $('#standard_1').on('change', function(){

            var standardId = $(this).find(":selected").val();
            var examId = $('#exam_1').val();
            var index = $(this).parents('.row').attr('data-id');

            getSubjects(examId, standardId, index);
        });

        $('#subject_1').on('change', function(){

            var subjectId = $(this).find(":selected").val();
            var standardId = $('#standard_1').val();
            var index = $(this).parents('.row').attr('data-id');

            getStudents(subjectId, standardId, index);
        });

        $('#roll_no_1').on('change', function(){

            var count = $(this).find(":selected").length;
            var index = $(this).parents('.row').attr('data-id');
            $('#count_1').val(count);
        });

        // Save exam room settings
        $('body').delegate('#examRoomSettingForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');

            $.ajax({
                url: "exam-room",
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

                    if(result['status'] == "200"){

                        if (result.data['signal'] == "success"){

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
        });

        // Delete exam room setting
        $(document).on('click', '.delete', function(e){
            e.preventDefault();

            var id = $(this).data('id');
            var idRoom = $(this).attr('data-room');
            var idExam = $(this).attr('data-exam');

            if(confirm("Are you sure you want to delete this?")){

                $.ajax({
                    type: "DELETE",
                    url: "/exam-room/" + id,
                    dataType: "json",
                    data: {
                        id: id,
                        idRoom: idRoom,
                        idExam: idExam
                    },
                    success: function(result){

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
