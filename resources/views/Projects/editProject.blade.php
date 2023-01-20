@php
    use Carbon\Carbon;
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
                    <form method="POST" class="demo-form" id="projectForm">
                        
                        <input type="hidden" name="id_institute" value="{{session()->get('institutionId')}}">
                        <input type="hidden" name="id_academic" value="{{session()->get('academicYear')}}">
                        <input type="hidden" name="organization" value="{{session()->get('organizationId')}}">
                                        
                        <input type="hidden" name="project_id" id="project_id" value="{{$project->id}}">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                        <i class="material-icons">assignment</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Edit Project</h4>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Standard<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="project_class" id="project_class" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".standardError">
                                                        @foreach($projectDetails['standard'] as $standard)
                                                            <option value="{{ $standard['institutionStandard_id'] }}" @if($project->id_standard == $standard['institutionStandard_id']) {{'selected'}} @endif>{{ $standard['class'] }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="standardError"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Subject<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="project_subject" id="project_subject" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".subjectError">
                                                        @foreach($projectDetails['subject'] as $subject)
                                                            <option value="{{ $subject['id'] }}" @if($project->id_subject == $subject['id']) {{'selected'}} @endif>{{ $subject['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="subjectError"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Student<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="student[]" id="student" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-actions-box="true" multiple data-parsley-errors-container=".studentError">
                                                        @foreach($projectDetails['student'] as $student)
                                                            <option value="{{ $student->id_student }}" @if(in_array($student->id_student, $projectDetails['project_asigned_students'])) {{'selected'}} @endif>{{ $student->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="studentError"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label">Teacher<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="project_staff" id="project_staff" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".teacherError">
                                                        @foreach($projectDetails['staff'] as $staff)
                                                            <option value="{{ $staff->id }}" @if($project->id_staff == $staff->id) {{'selected'}} @endif>{{ $staff->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="teacherError"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label">Chapter Name</label>
                                                    <input type="text" class="form-control" name="project_chapter_name" value="{{$project->chapter_name}}" />
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label">Start Date</label>
                                                    <input type="text" class="form-control datepicker startDate" name="project_start_date" value="{{ Carbon::createFromFormat('Y-m-d', $project->start_date)->format('d/m/Y') }}" data-parsley-trigger="change" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label">End Date<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control datepicker endDate" name="project_end_date" value="{{  Carbon::createFromFormat('Y-m-d', $project->end_date)->format('d/m/Y') }}" data-parsley-trigger="change" required autocomplete="off"/>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label">Start Time</label>
                                                    <input type="text" class="form-control timepicker" name="project_start_time" value="{{$project->start_time}}" data-parsley-trigger="change" />
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label">End Time<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control timepicker" name="project_end_time" value="{{$project->end_time}}" data-parsley-trigger="change" required />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Project Name<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="project_name" value="{{$project->name}}" required />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Project Details</label>
                                                    <div class="form-group">
                                                        <textarea class="ckeditor" name="project_details"ows="5">{{$project->description}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="control-label">Submission Type<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="submission_type" id="submission_type" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".typeError">
                                                        <option value="ONLINE" @if($project->submission_type == 'ONLINE'){{'selected'}} @endif>ONLINE</option>
                                                        <option value="OFFLINE" @if($project->submission_type == 'OFFLINE'){{'selected'}} @endif>OFFLINE</option>
                                                    </select>
                                                    <div class="typeError"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="control-label">Grading Required?<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="grading_required" id="grading_required" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".gradeError">
                                                        <option value="YES" @if($project->grading_required == 'YES'){{'selected'}} @endif>YES</option>
                                                        <option value="NO" @if($project->grading_required == 'NO'){{'selected'}} @endif>NO</option>
                                                    </select>
                                                    <div class="gradeError"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6" id="grading_options">
                                                <div class="form-group">
                                                    <label class="control-label">Grading Options?<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="grading_option" id="grading_option" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" data-parsley-errors-container=".gradeOptionError">
                                                        <option value="GRADE" @if($project->grading_option == 'GRADE'){{'selected'}} @endif>GRADE</option>
                                                        <option value="MARKS" @if($project->grading_option == 'MARKS'){{'selected'}} @endif>MARKS</option>
                                                    </select>
                                                    <div class="gradeOptionError"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6" id="grade">
                                                <div class="form-group">
                                                    <label class="control-label">Grade</label>
                                                    <input type="text" class="form-control" name="project_grade" placeholder="Mention grade here (eg:A+,A,B...)" value="{{$project->grade}}" />
                                                </div>
                                            </div>

                                            <div class="col-lg-6" id="marks">
                                                <div class="form-group">
                                                    <label class="control-label">Marks</label>
                                                    <input type="text" class="form-control" name="project_mark" placeholder="Mention max mark here" value="{{$project->marks}}" />
                                                    <input type="hidden" id="grading_option_value" value="{{ $project->grading_option }}">
                                                    <input type="hidden" id="grading_required_value" value="{{ $project->grading_required }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="control-label">Read receipt from recipients required?<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="read_receipt" id="read_receipt" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".receiptError">
                                                        <option value="YES" @if($project->read_receipt == 'YES'){{'selected'}} @endif>YES</option>
                                                        <option value="NO" @if($project->read_receipt == 'NO'){{'selected'}} @endif>NO</option>
                                                    </select>
                                                    <div class="receiptError"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="control-label">SMS alert to recipients required?*cost may apply<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="sms_alert" id="sms_alert" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".smsError">
                                                        <option value="YES" @if($project->sms_alert == 'YES'){{'selected'}} @endif>YES</option>
                                                        <option value="NO" @if($project->sms_alert == 'NO'){{'selected'}} @endif>NO</option>
                                                    </select>
                                                    <div class="smsError"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="pull-right">
                                            <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Update</button>
                                            <a href="{{url('project')}}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
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
                                                    <input type="file" name="attachmentProject[]" id="attachmentProject" accept="image/*,.pdf,.doc,.docx" multiple />
                                                </span>
                                                <a href="#pablo"
                                                    class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="material-icons">highlight_off</i>
                                                </a>
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
        $("#attachmentProject").change(function(){
            // check if fileArr length is greater than 0
            if (fileArr.length > 0) fileArr = [];

            $('#image_preview').html("");
            var total_file = document.getElementById("attachmentProject").files;
            if (!total_file.length) return;
            for (var i = 0; i < total_file.length; i++) {

                var extension = total_file[i].name.substr((total_file[i].name.lastIndexOf('.') + 1));
                var fileType = '';
                // console.log(extension);

                fileArr.push(total_file[i]);

                if (extension != "pdf" && extension != "docs" && extension != "doc" && extension !=
                    "docx") {

                    fileType += '<div class="img_div" id="img_div' + i + '">';
                    fileType += '<img src="' + URL.createObjectURL(event.target.files[i]) +
                        '" class="multiple_image img-responsive" title="' + total_file[i].name +
                        '">';
                    fileType += '<div class="middle_div"><button id="action-icon" value="img_div' + i +
                        '" class="btn btn-danger btn-xs" role="' + total_file[i].name +
                        '"><i class="fa fa-trash"></i></button></div></div>';

                } else if (extension == "pdf") {

                    fileType += '<div class="img_div" id="img_div' + i + '">';
                    fileType +=
                        '<img src="https://listimg.pinclipart.com/picdir/s/336-3361375_pdf-svg-png-icon-free-download-adobe-acrobat.png" class="multiple_image img-responsive" title="' +
                        total_file[i].name +
                        '">';
                    fileType += '<div class="middle_div"><button id="action-icon" value="img_div' + i +
                        '" class="btn btn-danger btn-xs" role="' + total_file[i].name +
                        '"><i class="fa fa-trash"></i></button></div></div>';

                } else if (extension == "docs" || extension == "doc" || extension == "docx") {

                    fileType += '<div class="img_div" id="img_div' + i + '">';
                    fileType +=
                        '<img src="https://www.pngitem.com/pimgs/m/181-1816575_google-docs-png-five-feet-apart-google-docs.png" class="multiple_image img-responsive" title="' +
                        total_file[i].name +
                        '">';
                    fileType += '<div class="middle_div"><button id="action-icon" value="img_div' + i +
                        '" class="btn btn-danger btn-xs" role="' + total_file[i].name +
                        '"><i class="fa fa-trash"></i></button></div></div>';
                }
                $('#image_preview').append(fileType);
            }
        });

        $('body').on('click', '#action-icon', function(evt){
            var divName = this.value;
            var fileName = $(this).attr('role');
            $(`#${divName}`).remove();

            for (var i = 0; i < fileArr.length; i++) {
                if (fileArr[i].name === fileName) {
                    fileArr.splice(i, 1);
                }
            }
            document.getElementById('attachmentProject').files = FileListItem(fileArr);
            evt.preventDefault();
        });

        function FileListItem(file){
            file = [].slice.call(Array.isArray(file) ? file : arguments)
            for (var c, b = c = file.length, d = !0; b-- && d;) d = file[b] instanceof File
            if (!d) throw new TypeError("expected argument to FileList is File or array of File objects")
            for (b = (new ClipboardEvent("")).clipboardData || new DataTransfer; c--;) b.items.add(file[c])
            return b.files
        }

        // Get subject based on standard selection
        $('#project_class').on('change', function(){

            var standardId = $(this).find(":selected").val();

            $.ajax({
                url: "/project-subjects",
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
                        options += '<option value="' + item.id_institution_subject + '">' + item.display_name + '' + subject_type + '</option>';
                    });

                    $("#project_subject").html(options);
                    $("#project_subject").selectpicker('refresh');
                }
            });
        });

        // Get staff based on subject selection
        $('#project_subject').on('change', function(){

            var subjectId = $(this).val();
            var standardId = $("#project_class").val();

            $.ajax({
                url: "/standard-subject-staff-student",
                type: "POST",
                data: {subjectId: subjectId, standardId: standardId},
                success: function(data){
                    var staffOptions = '';
                    var studentOptions = '';
                    $.map(data['staff'], function(item, index){
                        staffOptions += '<option value="' + item.id + '">' + item.name + '</option>';
                    });
                    $.map(data['student'], function(item, index) {
                        studentOptions += '<option value="' + item.id + '">' + item.name + '</option>';
                    });

                    $("#project_staff").html(staffOptions);
                    $("#project_staff").selectpicker('refresh');
                    $("#student").html(studentOptions);
                    $("#student").selectpicker('refresh');
                }
            });
        });

        $('#projectForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Update project
        $('body').delegate('#projectForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');
            var id = $("#project_id").val();

            if($('#projectForm').parsley().isValid()){

                $.ajax({
                    url: "/project/" + id,
                    type: "POST",
                    dataType: "json",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        btn.html('Updating...');
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
                                    window.location.replace('/project');
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

        var gradingRequiredValue = $('#grading_required_value').val();
        var gradingOptionValue = $('#grading_option_value').val();

        if(gradingRequiredValue == "YES"){
            $('#grading_options').show();
            if(gradingOptionValue == "GRADE"){
                $('#grade').show();
                $('#marks').hide();
            }else if (gradingOptionValue == "MARKS"){
                $('#grade').hide();
                $('#marks').show();
            }
        }else{
            $('#grading_options').hide();
            $('#marks').hide();
            $('#grade').hide();
        }

        $('#grading_required').on('change', function(){

            var gradingRequired = $(this).val();
            var gradingOption = $('#grading_option').val();

            if(gradingRequired == "YES"){
                $('#grading_options').show();
                if(gradingOption == "GRADE"){
                    $('#grade').show();
                    $('#marks').hide();
                }else if (gradingOption == "MARKS"){
                    $('#grade').hide();
                    $('#marks').show();
                }
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
