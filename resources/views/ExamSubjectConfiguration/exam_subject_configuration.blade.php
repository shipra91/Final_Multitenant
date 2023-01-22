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
                    <div class="col-md-12 col-md-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">school</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Exam Subject Configuration</h4>
                                <form method="POST" class="demo-form" id="examSubjectForm">
                                    <input type="hidden" name="id_institute" value="{{session()->get('institutionId')}}">
                                    <input type="hidden" name="id_academic" value="{{session()->get('academicYear')}}">
                                    <input type="hidden" name="organization" value="{{session()->get('organizationId')}}">
                                    <div class="row">
                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Exam<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="exam" id="examId" data-size="4" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".examError">
                                                    @foreach($examData as $exam)
                                                        <option value="{{ $exam['id_exam'] }}">{{ $exam['name'] }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="examError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Standard<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="standard" id="institutionStandard" data-size="4" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".standardError">


                                                </select>
                                                <div class="standardError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Grade Set<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="gradeSet" id="gradeSet" data-size="4" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".gradeSetError">
                                                    @foreach($gradeSets as $gradeSet)
                                                        <option value="{{ $gradeSet['id'] }}" >{{ $gradeSet['grade_title'] }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="gradeSetError"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="subjectDataDiv">

                                    </div>
                                </form>
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

        $('#examId').on('change', function(){

            var examId = $(this).val();

            $.ajax({
                url: "/exam-master-data",
                type: "POST",
                data: {id: examId},
                success: function(data){
                    var standardDetails = data.standard_details;
                    var option = '';
                    $.each(standardDetails, function(index, value){
                        option += '<option value="' + value['id'] + '">' + value['label'] + '</option>';
                    });
                    $('#institutionStandard').html(option);
                    $('#institutionStandard').selectpicker('refresh');
                }
            });
        });

        $('#institutionStandard').on('change', function(){

            var standardId = $(this).val();
            var examId = $('#examId').val();

            $.ajax({
                url: "/get-exam-timetable-subjects",
                type: "POST",
                data: {standardId: standardId, examId:examId},
                success: function(data){
                    var html = '';
                    console.log(data['gradeTemplate']);

                    if(data['examConfig'].length > 0){

                        html += '<div class="row">';
                        html += '<div class="col-lg-12">';
                        html += '<h5 class="viewStaff">Subject List</h5>';
                        html += '</div>';
                        html += '</div>';

                        $.map(data['examConfig'], function(item, index){

                            html += '<div class="subjectList">';
                            html += '<div class="row">';
                            html += '<div class="col-lg-1 col-lg-offset-0">';
                            html += '<div class="form-group">';
                            html += '<label>'+(++index)+'.</label>';
                            html += '</div>';
                            html += '</div>';

                            html += '<div class="col-lg-3 col-lg-offset-0">';
                            html += '<div class="form-group">';
                            html += '<label class="control-label mt-0">Subject<span class="text-danger">*</span></label>';
                            html += '<input type="text" class="form-control" value="' + item.display_name + '" disabled>';
                            html += '<input type="hidden" name="subject[]" value="' + item.id_subject + '">';
                            html += '</div>';
                            html += '</div>';

                            html += '<div class="col-lg-3 col-lg-offset-0">';
                            html += '<div class="form-group">';
                            html += '<label class="control-label mt-0">Display Name<span class="text-danger">*</span></label>';
                            html += '<input type="text" name="display_name[' + item.id_subject + ']" id="display_name" class="form-control" value="'; if(item.config_display_name == ""){ html += item.display_name }else{ html += item.config_display_name} html += '" required>';
                            html += '</div>';
                            html += '</div>';

                            html += '<div class="col-lg-1 col-lg-offset-0">';
                            html += '<div class="form-group">';
                            html += '<label class="control-label mt-0">Priority<span class="text-danger">*</span></label>';
                            html += '<input type="text" name="priority[' + item.id_subject + ']" class="form-control" value="'+item.priority+'" required>';
                            html += '</div>';
                            html += '</div>';

                            html += '<div class="col-lg-2 col-lg-offset-0">';
                            html += '<div class="form-group">';
                            html += '<label class="control-label mt-0">Subject Part<span class="text-danger">*</span></label>';
                            html += '<select class="selectpicker" name="subject_part[' + item.id_subject + ']" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".partError[' + item.id_subject + ']">';
                            $.map(data['subjectParts'], function(option, key){
                                html += '<option value="'+option.id+'"'; if(option.id === item.subject_part) {html +='selected';} html +='>'+option.part_title+'</option>';
                            });
                            html += '</select>';
                            html += '<div class="partError[' + item.id_subject + ']"></div>';
                            html += '</div>';
                            html += '</div>';

                            html += '<div class="col-lg-2 col-lg-offset-0">';
                            html += '<div class="form-group">';
                            html += '<label class="control-label mt-0">Conversion required?<span class="text-danger">*</span></label>';
                            html += '<select class="selectpicker" name="conversion_required[' + item.id_subject + ']" id="conversion_required" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select Option" required="required" data-parsley-errors-container=".conversionError[' + item.id_subject + ']">';
                            html += '<option value="YES"'; if(item.conversion === 'YES') html +='selected'; html +='>YES</option>';
                            html += '<option value="NO"'; if(item.conversion === 'NO') html +='selected'; html +='>NO</option>';
                            html += '</select>';
                            html += '<div class="conversionError[' + item.id_subject + ']"></div>';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';

                            html += '<div class="row">';
                            html += '<div class="col-lg-2 col-lg-offset-0">';
                            html += '<div class="form-group">';
                            html += '<label class="control-label mt-0">Conversion Value<span id="conversion_value_label" class="text-danger"></span></label>';
                            html += '<input type="text" name="conversion_value[' + item.id_subject + ']" id="conversion_value" class="form-control" value="'+item.conversion_value+'">';
                            html += '</div>';
                            html += '</div>';

                            html += '<div class="col-lg-3 col-lg-offset-0">';
                            html += '<div class="form-group">';
                            html += '<label class="control-label mt-0">Max<span class="text-danger">*</span></label>';
                            html += '<input type="text" name="max_mark[' + item.id_subject + ']" class="form-control" value="'+item.max_mark+'" required>';
                            html += '</div>';
                            html += '</div>';

                            html += '<div class="col-lg-3 col-lg-offset-0">';
                            html += '<div class="form-group">';
                            html += '<label class="control-label mt-0">Pass Mark<span class="text-danger">*</span></label>';
                            html += '<input type="text" name="pass_mark[' + item.id_subject + ']" class="form-control" value="'+item.pass_mark+'" required>';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                        });

                        html += '<div class="row">';
                        html += '<div class="col-lg-12 col-lg-offset-0 text-right">';
                        html += '<button type="submit" id="submit" class="btn btn-finish btn-fill btn-info btn-wd mt-20">Submit</button>';
                        html += '</div>';
                        html += '</div>';
                    }
                    // console.log(html);
                    $(".subjectDataDiv").html(html);
                    $('select').each(function(){
                        $(this).selectpicker('refresh');
                    });

                    $("#gradeSet").val(data['gradeTemplate']);
                    $("#gradeSet").selectpicker('refresh');
                }
            });
        });

        // Check if conversion required
        $('body').delegate("#conversion_required", "change", function(event){
            event.preventDefault();

            var conversion = $(this).val(); //alert(conversion);

            if(conversion === 'YES'){

                $(this).parents('div .subjectList').find("#conversion_value").attr('required', true);
                $(this).parents('div .subjectList').find("#conversion_value_label").text('*');

            }else{

                $(this).parents('div .subjectList').find("#conversion_value").attr('required', false);
                $(this).parents('div .subjectList').find("#conversion_value_label").text('');
            }
        });

        $('body').delegate("input[type='checkbox']", "change", function(event){
            event.preventDefault();

            var checkbox = $(this).val(); //alert(checkbox);

            if(checkbox === 'theory'){

                if($(this).is(':checked')){

                    $(this).parents('div .subjectList').find("#theory_max, #theory_pass").removeClass('d-none');
                    $(this).parents('div .subjectList').find("#theory_max_input, #theory_pass_input").attr('required', true);

                }else{

                    $(this).parents('div .subjectList').find("#theory_max, #theory_pass").addClass('d-none');
                    $(this).parents('div .subjectList').find("#theory_max_input, #theory_pass_input").attr('required', false);
                }
            }

            if(checkbox === 'practical'){

                if($(this).is(':checked')){

                    $(this).parents('div .subjectList').find("#practical_max, #practical_pass").removeClass('d-none');
                    $(this).parents('div .subjectList').find("#practical_max_input, #practical_pass_input").attr('required', true);

                }else{

                    $(this).parents('div .subjectList').find("#practical_max, #practical_pass").addClass('d-none');
                    $(this).parents('div .subjectList').find("#practical_max_input, #practical_pass_input").attr('required', false);
                }
            }
        });

        $('#examSubjectForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save exam subject configuration
        $('body').delegate('#examSubjectForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');

            if($('#examSubjectForm').parsley().isValid()){

                $.ajax({
                    url: "{{ url('/exam-subject-configuration') }}",
                    type: "post",
                    dataType: "json",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        btn.html('Submitting...');
                        btn.attr('disabled', true);
                    },
                    success: function(result){
                        //console.log(result);
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

        // Delete exam subject configuration
        $(document).on('click', '.delete', function (e){
            e.preventDefault();

            var id = $(this).data('id');

            if(confirm("Are you sure you want to delete this?")){

                $.ajax({
                    type: "DELETE",
                    url:"/subject-part/"+id,
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
