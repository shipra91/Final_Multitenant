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
                    <form method="POST" class="demo-form" id="homeworkForm">
                                        
                        <input type="hidden" name="id_institute" value="{{session()->get('institutionId')}}">
                        <input type="hidden" name="id_academic" value="{{session()->get('academicYear')}}">
                        <input type="hidden" name="organization" value="{{session()->get('organizationId')}}">
                                        
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Add Homework</h4>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Standard<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="homework_class" id="homework_class" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".homeworkError">
                                                    @foreach($standards as $standard)
                                                        <option value="{{ $standard['institutionStandard_id'] }}">{{ $standard['class'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="homeworkError"></div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Subject<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="homework_subject" id="homework_subject" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".subjectError">

                                                </select>
                                                <div class="subjectError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Teacher<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="homework_staff" id="homework_staff" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".teacherError">

                                                </select>
                                                <div class="teacherError"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Chapter Name</label>
                                                <input type="text" class="form-control" name="homework_chapter_name" />
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="control-label mt-0">Homework Name<span class="text-danger">*</span></label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="homework_name" required />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Start Date<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker startDate" name="homework_start_date" data-parsley-trigger="change" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">End Date<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker endDate" name="homework_end_date" data-parsley-trigger="change" required autocomplete="off" />
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Start Time<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control timepicker" name="homework_start_time" data-parsley-trigger="change" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">End Time<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control timepicker" name="homework_end_time" data-parsley-trigger="change" required />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="control-label">Homework Details</label>
                                            <div class="form-group">
                                                <textarea class="ckeditor" name="homework_details" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Submission Type<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="submission_type" id="submission_type" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".typeError">
                                                    <option value="ONLINE">ONLINE</option>
                                                    <option value="OFFLINE">OFFLINE</option>
                                                </select>
                                                <div class="typeError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Grade/Marks Adding Option Required?<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="grading_required" id="grading_required" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".gradeError">
                                                    <option value="YES">YES</option>
                                                    <option value="NO">NO</option>
                                                </select>
                                                <div class="gradeError"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6" id="grading_options">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Grading Options?<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="grading_option" id="grading_option" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" data-parsley-errors-container=".gradeOptionError">
                                                    <option value="GRADE">GRADE</option>
                                                    <option value="MARKS">MARKS</option>
                                                </select>
                                                <div class="gradeOptionError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6" id="grade">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Grade</label>
                                                <input type="text" class="form-control" name="homework_grade" placeholder="Mention grade here (eg:A+,A,B...)" />
                                            </div>
                                        </div>

                                        <div class="col-lg-6" id="marks">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Marks</label>
                                                <input type="text" class="form-control" name="homework_mark" placeholder="Mention max mark here" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Read receipt from recipients required?<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="read_receipt" id="read_receipt" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".receiptError">
                                                    <option value="YES">YES</option>
                                                    <option value="NO">NO</option>
                                                </select>
                                                <div class="receiptError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label mt-0">SMS alert to recipients required?(cost may apply)<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="sms_alert" id="sms_alert" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".smsError">
                                                    <option value="YES">YES</option>
                                                    <option value="NO">NO</option>
                                                </select>
                                                <div class="smsError"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Submit</button>
                                        <a href="{{ url('homework') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">attachment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Attachment</h4>
                                    <div class="text-center">
                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                            <span class="btn btn-square btn-info btn-file btn-sm">
                                                <span class="fileinput-new">Add</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="attachmentHomework[]" id="attachmentHomework" accept="image/*,.pdf,.doc,.docx" multiple />
                                            </span>
                                            <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="material-icons">highlight_off</i></a>
                                        </div>
                                    </div>

                                    <div class="form-group" id="image_preview">

                                    </div>
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

        // Multiple file upload with preview
        var fileArr = [];
        $("#attachmentHomework").change(function(){
            // check if fileArr length is greater than 0
            if (fileArr.length > 0) fileArr = [];

            $('#image_preview').html("");
            var total_file = document.getElementById("attachmentHomework").files;
            if(!total_file.length) return;
            for(var i = 0; i < total_file.length; i++){

                var extension = total_file[i].name.substr((total_file[i].name.lastIndexOf('.') + 1));
                var fileType = '';
                // console.log(extension);

                fileArr.push(total_file[i]);

                if(extension != "pdf" && extension != "docs" && extension != "doc" && extension != "docx"){

                    fileType += '<div class="img_div" id="img_div' + i + '">';
                    fileType += '<img src="' + URL.createObjectURL(event.target.files[i]) + '" class="multiple_image img-responsive" title="' + total_file[i].name + '">';
                    fileType += '<div class="middle_div"><button id="action-icon" value="img_div' + i + '" class="btn btn-danger btn-xs" role="' + total_file[i].name + '"><i class="material-icons">delete</i></button></div></div>';

                }else if (extension == "pdf"){

                    fileType += '<div class="img_div" id="img_div' + i + '">';
                    fileType += '<img src="https://cdn-icons-png.flaticon.com/512/337/337946.png" class="multiple_image img-responsive" title="' + total_file[i].name + '">';
                    fileType += '<div class="middle_div"><button id="action-icon" value="img_div' + i + '" class="btn btn-danger btn-xs" role="' + total_file[i].name + '"><i class="material-icons">delete</i></button></div></div>';

                }else if (extension == "docs" || extension == "doc" || extension == "docx"){

                    fileType += '<div class="img_div" id="img_div' + i + '">';
                    fileType += '<img src="https://cdn-icons-png.flaticon.com/512/337/337932.png" class="multiple_image img-responsive" title="' + total_file[i].name + '">';
                    fileType += '<div class="middle_div"><button id="action-icon" value="img_div' + i + '" class="btn btn-danger btn-xs" role="' + total_file[i].name + '"><i class="material-icons">delete</i></button></div></div>';
                }
                $('#image_preview').append(fileType);
            }
        });

        $('body').on('click', '#action-icon', function(evt){

            var divName = this.value;
            var fileName = $(this).attr('role');

            $(`#${divName}`).remove();

            for(var i = 0; i < fileArr.length; i++){
                if(fileArr[i].name === fileName){
                    fileArr.splice(i, 1);
                }
            }
            document.getElementById('attachmentHomework').files = FileListItem(fileArr);
            evt.preventDefault();
        });

        function FileListItem(file){
            file = [].slice.call(Array.isArray(file) ? file : arguments)
            for(var c, b = c = file.length, d = !0; b-- && d;) d = file[b] instanceof File
            if(!d) throw new TypeError("expected argument to FileList is File or array of File objects")
            for(b = (new ClipboardEvent("")).clipboardData || new DataTransfer; c--;) b.items.add(file[c])
            return b.files
        }

        // Get subject based on standard selection
        $('#homework_class').on('change', function(){

            var standardId = $(this).val();

            $.ajax({
                url: "/assignment-subjects",
                type: "POST",
                data: {standardId: standardId},
                success: function(data){
                    var options = '';
                    $.map(data, function(item, index){
                        var subject_type = '';
                        if(item.subject_type === "PRACTICAL"){
                            subject_type = ' - ' + item.subject_type;
                        }else{
                            subject_type = '';
                        }
                        options += '<option value="' + item.id + '">' + item.display_name + '' + subject_type + '</option>';
                    });
                    $("#homework_subject").html(options);
                    $("#homework_subject").selectpicker('refresh');
                }
            });
        });

        // Get staff based on subject selection
        $('#homework_subject').on('change', function(){

            var subjectId = $(this).val();
            var standardId = $("#homework_class").val();

            $.ajax({
                url: "/standard-subject-staffs",
                type: "POST",
                data: {subjectId: subjectId,standardId: standardId},
                success: function(data){
                    var options = '';
                    $.map(data, function(item, index){
                        options += '<option value="' + item.id + '">' + item.name + '</option>';
                    });
                    $("#homework_staff").html(options);
                    $("#homework_staff").selectpicker('refresh');
                }
            });
        });

        $('#homeworkForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save homework
        $('body').delegate('#homeworkForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');

            if ($('#homeworkForm').parsley().isValid()){

                $.ajax({
                    url: "/homework",
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
                                    //window.location.reload();
                                    window.location.replace('/homework');
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

                        }else {

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

        $('#grading_options').hide();
        $('#marks').hide();
        $('#grade').hide();

        $('#grading_required').on('change', function(){

            var gradingRequired = $(this).val();

            if(gradingRequired == "YES"){
                $('#grading_options').show();
            }else{
                $('#grading_options').hide();
                $('#marks').hide();
                $('#grade').hide();
            }
        });

        $('#grading_option').on('change', function(){

            var gradingOption = $(this).val();

            if(gradingOption == "GRADE"){
                $('#grade').show();
                $('#marks').hide();
            }else{
                $('#grade').hide();
                $('#marks').show();
            }
        });
    });
</script>
@endsection
