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
                @if(Helper::checkAccess('institution-subject', 'create'))
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">local_library</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Institution Subject Mapping</h4>
                                    <form method="POST" class="demo-form" id="institutionSubjectForm">
                                        
                                        <input type="hidden" name="id_institute" value="{{session()->get('institutionId')}}">
                                        <input type="hidden" name="id_academic" value="{{session()->get('academicYear')}}">
                                        <input type="hidden" name="organization" value="{{session()->get('organizationId')}}">
                                        
                                        <div id="repeater">
                                            <input type="hidden" name="totalCount" id="totalCount" value="1">
                                            <div class="row" id="section_1" data-id="1">
                                                <div class="col-lg-4 col-lg-offset-0">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Subject<span class="text-danger">*</span></label>
                                                        <select class="selectpicker subject" name="subject[]" id="subject_1" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" data-parsley-errors-container=".subjectError" required="required">
                                                            @foreach($subjectDetails as $subject)
                                                                <option value="{{$subject['id']}}">{{$subject['name']}} </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="subjectError"></div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-lg-offset-0">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Display Name <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control display_name" name="display_name[]" id="display_name_1" required />
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Subject Type<span class="text-danger">*</span></label>
                                                        <select class="selectpicker" name="subject_type[1][]" id="subject_type_1" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" required="required" multiple data-actions-box="true" data-parsley-errors-container=".subjectTypeError">
                                                            <option value="THEORY">THEORY</option>
                                                            <option value="PRACTICAL">PRACTICAL</option>
                                                        </select>
                                                        <div class="subjectTypeError"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <div class="row">
                                        <div class="col-lg-12 col-lg-offset-0">
                                            <button id="add_more" type="button" class="btn btn-warning btn-sm"><i class="material-icons">add_circle_outline</i> Add</button>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 col-lg-offset-0">
                                            <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd pull-right" id="submit" name="submit">Submit</button>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(Helper::checkAccess('institution-subject', 'view'))
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">local_library</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Subject Mapping List</h4>
                                    <div class="material-datatables">
                                        <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                            <thead style="font-size:12px;">
                                                <tr>
                                                    <th><b>S.N.</b></th>
                                                    <th><b>Subject Name</b></th>
                                                    <th><b>Display Name</b></th>
                                                    <th><b>Subject Type</b></th>
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

        // View subject mapping
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "institution-subject",
            columns: [
                {data: 'DT_RowIndex', name: 'id', "width": "10%"},
                {data: 'subject_name', name: 'name', "width": "25%"},
                {data: 'display_name', name: 'display_name', "width": "25%"},
                {data: 'subject_type', name: 'subject_type', "width": "25%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "15%"},
            ]
        });

        // Add more subject mapping
        var count = $('#totalCount').val();

        $(document).on('click', '#add_more', function(){

            var html = '';
            count++;

            html += '<div class="row" id="section_' + count + '" data-id="' + count + '">';
            html += '<div class="col-lg-4 col-lg-offset-0">';
            html += '<div class="form-group ">';
            html += '<label class="control-label mt-0">Subject<span class="text-danger">*</span></label>';
            html += '<select class="selectpicker subject" name="subject[]" id="subject_' + count + '" data-size="4" data-style="select-with-transition" data-live-search="true" title="Select" required="required">';
            html +='<?php foreach($subjectDetails as $subject) {?>';
            html += '<option value="<?php echo $subject['id'];?>"><?php echo $subject['name'];?></option>';
            html += '<?php } ?>';
            html += '</select>';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-4 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Display Name<span class="text-danger">*</span></label>';
            html += '<input type="text" class="form-control display_name" name="display_name[]" id="display_name_' + count + '" required/>';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-3 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Subject Type<span class="text-danger">*</span></label>';
            html += '<select class="selectpicker" name="subject_type[' + count + '][]" id="subject_type_' + count + '" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-actions-box="true" multiple>';
            html += '<option value="THEORY">THEORY</option>';
            html += '<option value="PRACTICAL">PRACTICAL</option>';
            html += '</select>';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-1 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<td><button type="button" id="' + count + '" class="btn btn-danger btn-sm remove_button mt-15"><i class="material-icons">highlight_off</i></button></td>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            $('#repeater').append(html);
            $("#totalCount").val(count);
            $('.selectpicker').selectpicker();
        });

        // Remove subject mapping
        $(document).on('click', '.remove_button', function(event){
            event.preventDefault();

            var id = $(this).attr('id'); //alert(id);
            console.log(id);
            var totalCount = $('#repeater tr:last').attr('id');

            $(this).closest('div #section_' + id + '').remove();
            totalCount--;
        });

        $('#institutionSubjectForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save subject mapping
        $('body').delegate('#institutionSubjectForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');

            if($('#institutionSubjectForm').parsley().isValid()){

                $.ajax({
                    url: "/institution-subjects",
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

        // Delete subject mapping
        $(document).on('click', '.delete', function(e){
            e.preventDefault();

            var id = $(this).data('id');

            if(confirm("Are you sure you want to delete this?")){
                $.ajax({
                    type: "DELETE",
                    url: "/institution-subject/" + id,
                    dataType: "json",
                    data: {
                        id: id
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
        });

        $('body').delegate('.subject', 'change', function(){

            var subjectId = $(this).find(":selected").val();
            var parentDiv = $(this).parents('.row'); //.attr('data-id'); alert(parentDiv);
            var dataId = parentDiv.attr('data-id');

            $.ajax({
                url: "/subjects",
                type: "POST",
                data: {id: subjectId},
                success: function(data){
                    parentDiv.find('#display_name_' + dataId).val(data.name);
                }
            });
        });
    });
</script>
@endsection
