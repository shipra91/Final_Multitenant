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
                <form method="POST" id="gradeForm">
                    <input type="hidden" name="idGrade" id="idGrade" value="{{ $selectedData['gradeId'] }}">
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">assessment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Edit Grade</h4>
                                    <div class="row">
                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Title<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="gradeSetTitle" id="gradeSetTitle" value="{{ $selectedData['gradeSetTitle'] }}" required />
                                            </div>
                                        </div>
                                    </div>

                                    <div id="repeater">
                                        <input type="hidden" id="totalCount" value="{{ count($selectedData['gradeDetails']) > 0 ? count($selectedData['gradeDetails']) : 1 }}">

                                        @foreach($selectedData['gradeDetails'] as $count => $gradeDetail)

                                            @php ++$count; @endphp

                                            <div class="row" id="section_{{ $count }}" data-id="{{ $count }}">
                                                <div class="col-lg-2 col-lg-offset-0">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Grade Name<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="gradeName[]" id="gradeName" value="{{ $gradeDetail->grade_name }}" required />
                                                        <input type="hidden" name="gradeDetailId[]" value="{{ $gradeDetail->id }}">
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-lg-offset-0">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Range From<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="rangeFrom[]" id="rangeFrom" value="{{ $gradeDetail->range_from }}"  required />
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-lg-offset-0">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Range To<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="rangeTo[]" id="rangeTo" value="{{ $gradeDetail->range_to }}" required />
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-lg-offset-0">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Average Point</label>
                                                        <input type="text" class="form-control" name="avgPoint[]" id="avgPoint" value="{{ $gradeDetail->avg_point }}"/>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="form-group">
                                                        <label class="control-label mt-0">Remark</label>
                                                        <input type="text" class="form-control" name="remark[]" id="remark" value="{{ $gradeDetail->remark }}"/>
                                                    </div>
                                                </div>

                                                <div class="col-lg-1 col-lg-offset-0 text-right">
                                                    <div class="form-group">
                                                        <button type="button" data-id="{{ $count }}" id="{{ $gradeDetail->id }}" class="btn btn-danger btn-sm delete_button mt-15"><i class="material-icons">delete</i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 col-lg-offset-0">
                                            <button id="add_more" type="button" class="btn btn-warning btn-sm"><i class="material-icons">add_circle_outline</i> Add</button>
                                        </div>
                                    </div>

                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Update</button>
                                        <a href="{{ url('grade') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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

        // Add more grade
        var count = $('#totalCount').val();

        $(document).on('click', '#add_more', function(){

            var html = '';
            count++;

            html += '<div class="row" id="section_'+count+'" data-id="'+count+'">';

            html += '<div class="col-lg-2 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Grade Name<span class="text-danger">*</span></label>';
            html += '<input type="text" class="form-control" name="gradeName[]" id="gradeName" required />';
            html += '<input type="hidden" name="gradeDetailId[]" value="">';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-2 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Range From<span class="text-danger">*</span></label>';
            html += '<input type="text" class="form-control" name="rangeFrom[]" id="rangeFrom" required />';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-2 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Range To<span class="text-danger">*</span></label>';
            html += '<input type="text" class="form-control" name="rangeTo[]" id="rangeTo" required />';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-2 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Average Point</label>';
            html += '<input type="text" class="form-control" name="avgPoint[]" id="avgPoint"/>';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-3 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Remark</label>';
            html += '<input type="text" class="form-control" name="remark[]" id="remark"/>';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-1 col-lg-offset-0 text-right">';
            html += '<div class="form-group">';
            html += '<button type="button" id="'+count+'" class="btn btn-danger btn-sm remove_button mt-15"><i class="material-icons">highlight_off</i></button>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            $('#repeater').append(html);
            $("#totalCount").val(count);
        });

        // Remove more grade
        $(document).on('click', '.remove_button', function(event){
            event.preventDefault();

            var id = $(this).attr('id');//alert(id);
            //console.log(id);
            var totalCount = $('#repeater tr:last').attr('id');

            $(this).closest('div #section_'+id+'').remove();
            totalCount--;
        });

        $("#gradeForm").parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Update grade
        $('body').delegate('#gradeForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');
            var id = $("#idGrade").val();

            if ($('#gradeForm').parsley().isValid()){

                $.ajax({
                    url:"/grade/"+id,
                    type:"POST",
                    dataType:"json",
                    data: new FormData(this),
                    contentType: false,
                    processData:false,
                    beforeSend:function(){
                        btn.html('Updating...');
                        btn.attr('disabled',true);
                    },
                    success:function(result){
                        btn.html('Update');
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

        // Delete grade
        $(document).on('click', '.delete_button', function(){

            var id = $(this).attr('id'); //alert(id);
            var dataId = $(this).attr('data-id');
            var parent = $(this).parents("div #section_" + dataId);

            if (confirm("Are you sure you want to delete this?")){

                $.ajax({
                    type: "DELETE",
                    url: "/grade-detail/" + id,
                    dataType: "json",
                    data: {id: id},
                    success: function(result){

                        if(result['status'] == "200"){

                            if (result.data['signal'] == "success"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function(){
                                    parent.animate({
                                        backgroundColor: "#ff6969"
                                    }, "slow").animate({
                                        opacity: "hide"
                                    }, "slow");
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
