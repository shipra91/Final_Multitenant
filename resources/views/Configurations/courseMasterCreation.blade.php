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
                   <div class="col-md-12 col-md-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">local_library</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Add Course</h4>
                                <form method="POST" id="courseForm">
                                    <div id="repeater">
                                        <input type="hidden" name="totalCount" id="totalCount" value="1">
                                        <div class="row" id="section_1" data-id="1">
                                            <div class="col-lg-3 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Board/ Univesrirty<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="board_university[]" id="board_university" required />
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Institution Type<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="institution_type[]" id="institution_type" required />
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Course<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="course[]" id="course" required />
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Stream<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="stream[]" id="stream" required />
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Combination<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="combination[]" id="combination" required />
                                                </div>
                                            </div>
                                            <!-- <div class="col-lg-1 form-group col-lg-offset-0 text-right">
                                                <td><button type="button" id="1" class="btn btn-danger btn-sm remove_button"><i class="material-icons">highlight_off</i></button></td>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-lg-offset-0">
                                            <button id="add_more" type="button" class="btn btn-warning btn-sm"><i class="material-icons">add_circle_outline</i> Add</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-lg-offset-0 text-right">
                                            <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd" id="submit" name="submit">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-md-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">local_library</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Course List</h4>
                                <div class="material-datatables">
                                    <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                        <thead style="font-size:12px;">
                                            <tr>
                                                <th><b>S.N.</b></th>
                                                <th><b>Board/Univesrirty</b></th>
                                                <th><b>Institution Type</b></th>
                                                <th><b>Course</b></th>
                                                <th><b>stream</b></th>
                                                <th><b>Combination</b></th>
                                                <th><b>Actions</b></th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <p class="text-info"><strong>Note:</strong>The course can not be edited or deleted if the course is already mapped</p>
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

        // View course master
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "course-master",
            columns: [
                {data: 'DT_RowIndex', name: 'courseMasterdId', "width": "10%"},
                {data: 'board_university', name: 'board_university', "width": "20%"},
                {data: 'institution_type', name: 'institution_type', "width": "15%"},
                {data: 'course', name: 'course', "width": "10"},
                {data: 'stream', name: 'stream', "width": "15%"},
                {data: 'combination', name: 'combination', "width": "15%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "15%", className:"text-center"},
            ]
        });

        // Add more course master
        var count = $('#totalCount').val();

        $(document).on('click', '#add_more', function(){

            var html = '';
            count++;

            html += '<div class="row" id="section_'+count+'" data-id="'+count+'">';
            html += '<div class="col-lg-3 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Board/ Univesrirty<span class="text-danger">*</span></label>';
            html += '<input type="text" class="form-control" name="board_university[]" id="board_university" required />';
            html += '</div>';
            html += '</div>';
            html += '<div class="col-lg-2 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Institution Type<span class="text-danger">*</span></label>';
            html += '<input type="text" class="form-control" name="institution_type[]" id="institution_type" required />';
            html += '</div>';
            html += '</div>';
            html += '<div class="col-lg-2 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Course<span class="text-danger">*</span></label>';
            html += '<input type="text" class="form-control" name="course[]" id="course" required />';
            html += '</div>';
            html += '</div>';
            html += '<div class="col-lg-2 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Stream<span class="text-danger">*</span></label>';
            html += '<input type="text" class="form-control" name="stream[]" id="stream" required />';
            html += '</div>';
            html += '</div>';
            html += '<div class="col-lg-2 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Combination<span class="text-danger">*</span></label>';
            html += '<input type="text" class="form-control" name="combination[]" id="combination" required />';
            html += '</div>';
            html += '</div>';
            html += ' <div class="col-lg-1 col-lg-offset-0 text-right">';
            html += '<div class="form-group">';
            html += '<td><button type="button" id="'+count+'" class="btn btn-danger btn-sm remove_button mt-15"><i class="material-icons">highlight_off</i></button></td>';
            html += '</div>';
            html += '</div>';

            $('#repeater').append(html);
            $("#totalCount").val(count);
            $(this).find(".master_category"+count+"").selectpicker();
        });

        // Remove add more course master
        $(document).on('click', '.remove_button', function(event){
            event.preventDefault();

            var id = $(this).attr('id');//alert(id);
            console.log(id);
            var totalCount = $('#repeater tr:last').attr('id');

            $(this).closest('div #section_'+id+'').remove();
            totalCount--;
        });

        $("#courseForm").parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save course master
        $('body').delegate('#courseForm', 'submit', function(e){
            e.preventDefault();

            var btn=$('#submit');

            if ($('#courseForm').parsley().isValid()){

                $.ajax({
                    url:"/etpl/course-master",
                    type:"post",
                    dataType:"json",
                    data: new FormData(this),
                    contentType: false,
                    processData:false,
                    beforeSend:function(){
                        btn.html('Submitting...');
                        btn.attr('disabled',true);
                    },
                    success:function(result){
                        console.log(result);
                        btn.html('Submit');
                        btn.attr('disabled',false);

                        if(result['status'] == "200"){

                            if(result.data['signal'] == "success"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function() {
                                    window.location.reload();
                                }).catch(swal.noop)

                            }else if(result.data['signal'] == "exist"){

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

        // Delete Course
        $(document).on('click', '.delete', function (e){
            e.preventDefault();

            var id = $(this).data('id');
            if(confirm("Are you sure you want to delete this?")){

                $.ajax({
                    type: "DELETE",
                    url:"/etpl/course-master/"+id,
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
