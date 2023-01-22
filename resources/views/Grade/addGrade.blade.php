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
                                        
                    <input type="hidden" name="id_institute" value="{{session()->get('institutionId')}}">
                    <input type="hidden" name="id_academic" value="{{session()->get('academicYear')}}">
                    <input type="hidden" name="organization" value="{{session()->get('organizationId')}}">
                                        
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">assessment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Add Grade</h4>
                                    <div class="row">
                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Title<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="gradeTitle" id="gradeTitle" required />
                                            </div>
                                        </div>
                                    </div>

                                    <div id="repeater">
                                        <input type="hidden" name="totalCount" id="totalCount" value="1">
                                        <div class="row" id="section_1" data-id="1">
                                            <div class="col-lg-3 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Grade Name<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="gradeName[]" id="gradeName" required />
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Range From<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="rangeFrom[]" id="rangeFrom" required />
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Range To<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="rangeTo[]" id="rangeTo" required />
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Average Point</label>
                                                    <input type="text" class="form-control" name="averagePoint[]" id="averagePoint"/>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Remark</label>
                                                    <input type="text" class="form-control" name="remark[]" id="remark"/>
                                                </div>
                                            </div>

                                            {{-- <div class="col-lg-1 form-group col-lg-offset-0 text-right">
                                                <td><button type="button" id="1" class="btn btn-danger btn-xs remove_button"><i class="material-icons">highlight_off</i></button></td>
                                            </div> --}}
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 col-lg-offset-0">
                                            <button id="add_more" type="button" class="btn btn-warning btn-sm"><i class="material-icons">add_circle_outline</i> Add</button>
                                        </div>
                                    </div>

                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Submit</button>
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

            html += '<div class="col-lg-3 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Grade Name<span class="text-danger">*</span></label>';
            html += '<input type="text" class="form-control" name="gradeName[]" id="gradeName" required />';
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
            html += '<input type="text" class="form-control" name="averagePoint[]" id="averagePoint"/>';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-2 col-lg-offset-0">';
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

        // Save grade
		$('body').delegate('#gradeForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');

            if ($('#gradeForm').parsley().isValid()){

                $.ajax({
                    url:"/grade",
                    type:"POST",
                    dataType:"json",
                    data: new FormData(this),
                    contentType: false,
                    processData:false,
                    beforeSend:function(){
                        btn.html('Submitting...');
                        btn.attr('disabled',true);
                    },
                    success:function(result){
                        btn.html('Submit');
                        btn.attr('disabled',false);

                        if(result['status'] == "200"){

                            if(result.data['signal'] == "success"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function(){
                                    // window.location.reload();
                                    window.location.replace('/grade');
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
    });
</script>
@endsection
