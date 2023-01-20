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
                    <form method="POST" class="demo-form" id="assignmentForm">
                        <input type="hidden" name="id_institute" value="{{session()->get('institutionId')}}">
                        <input type="hidden" name="id_academic" value="{{session()->get('academicYear')}}">
                        <input type="hidden" name="organization" value="{{session()->get('organizationId')}}">
                        <input type="hidden" name="assignment_id" id="assignment_id" value="{{$assignment['assignmentData']->id}}">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Edit Assignment</h4>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Standard<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="assignment_class" id="assignment_class" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".assignmentError">
                                                    @foreach($assignmentDetails['standard'] as $standard)
                                                        <option value="{{ $standard['institutionStandard_id'] }}" @if($assignment['assignmentData']->id_standard == $standard['institutionStandard_id']) {{'selected'}} @endif>{{ $standard['class'] }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="assignmentError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Subject<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="assignment_subject" id="assignment_subject" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".subjectError">
                                                    @foreach($assignmentDetails['subject'] as $subject)
                                                        <option value="{{ $subject['id'] }}" @if($assignment['assignmentData']->id_subject == $subject['id'] ) {{'selected'}} @endif>{{ $subject['name'] }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="subjectError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Teacher<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="assignment_staff" id="assignment_staff" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".teacherError">
                                                    @foreach($assignmentDetails['staff'] as $staff)
                                                        <option value="{{ $staff->id }}" @if($assignment['assignmentData']->id_staff == $staff->id) {{'selected'}} @endif>{{ $staff->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="teacherError"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label">Chapter Name</label>
                                                <input type="text" class="form-control" name="assignment_chapter_name" value="{{$assignment['assignmentData']->chapter_name}}" />
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label">Assignment Title<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="assignment_name" value="{{$assignment['assignmentData']->name}}" required />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label">Start Date<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker startDate" name="assignment_start_date" value="{{ Carbon::createFromFormat('Y-m-d', $assignment['assignmentData']->start_date)->format('d/m/Y') }}" />
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label">End Date<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker endDate" name="assignment_end_date" value="{{  Carbon::createFromFormat('Y-m-d', $assignment['assignmentData']->end_date)->format('d/m/Y') }}" required autocomplete="off"/>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label">Start Time<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control timepicker" name="assignment_start_time" value="{{$assignment['assignmentData']->start_time}}" />
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label">End Time<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control timepicker" name="assignment_end_time" value="{{$assignment['assignmentData']->end_time}}" required />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Assignment Details</label>
                                                <div class="form-group">
                                                    <textarea class="ckeditor" name="assignment_details" rows="5">{{$assignment['assignmentData']->description}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label">Submission Type<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="submission_type" id="submission_type" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".typeError">
                                                    <option value="ONLINE" @if($assignment['assignmentData']->submission_type == 'ONLINE'){{'selected'}} @endif>ONLINE</option>
                                                    <option value="OFFLINE" @if($assignment['assignmentData']->submission_type == 'OFFLINE'){{'selected'}} @endif>OFFLINE</option>
                                                </select>
                                                <div class="typeError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label">Grade/Marks Adding Option Required?<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="grading_required" id="grading_required" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".gradeError">
                                                    <option value="YES" @if($assignment['assignmentData']->grading_required == 'YES'){{'selected'}} @endif>YES</option>
                                                    <option value="NO" @if($assignment['assignmentData']->grading_required == 'NO'){{'selected'}} @endif>NO</option>
                                                </select>
                                                <div class="gradeError"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <input type="hidden" id="grading_required_value" value="{{ $assignment['assignmentData']->grading_required }}">
                                        <div class="col-lg-6" id="grading_options">
                                            <div class="form-group">
                                                <label class="control-label">Grading Options?</label>
                                                <select class="selectpicker" name="grading_option" id="grading_option" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" data-parsley-errors-container=".gradeOptionError">
                                                    <option value="GRADE" @if($assignment['assignmentData']->grading_option == 'GRADE'){{'selected'}} @endif>GRADE</option>
                                                    <option value="MARKS" @if($assignment['assignmentData']->grading_option == 'MARKS'){{'selected'}} @endif>MARKS</option>
                                                </select>
                                                <div class="gradeOptionError"></div>
                                            </div>
                                        </div>

                                        <input type="hidden" id="grading_option_value" value="{{ $assignment['assignmentData']->grading_option }}">
                                        <div class="col-lg-6" id="grade">
                                            <div class="form-group">
                                                <label class="control-label">Grade</label>
                                                <input type="text" class="form-control" name="assignment_grade" placeholder="Mention grade here (eg:A+,A,B...)" />
                                            </div>
                                        </div>

                                        <div class="col-lg-6" id="marks">
                                            <div class="form-group">
                                                <label class="control-label">Marks</label>
                                                <input type="text" class="form-control" name="assignment_mark" placeholder="Mention max mark here" value="{{$assignment['assignmentData']->marks}}" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label">Read receipt from recipients required?<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="read_receipt" id="read_receipt" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".receiptError">
                                                    <option value="YES" @if($assignment['assignmentData']->read_receipt == 'YES'){{'selected'}} @endif>YES</option>
                                                    <option value="NO" @if($assignment['assignmentData']->read_receipt == 'NO'){{'selected'}} @endif>NO</option>
                                                </select>
                                                <div class="receiptError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label">SMS alert to recipients required?(cost may apply)<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="sms_alert" id="sms_alert" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".smsError">
                                                    <option value="YES" @if($assignment['assignmentData']->sms_alert == 'YES'){{'selected'}} @endif>YES</option>
                                                    <option value="NO" @if($assignment['assignmentData']->sms_alert == 'NO'){{'selected'}} @endif>NO</option>
                                                </select>
                                                <div class="smsError"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Update</button>
                                        <a href="{{ url('assignment') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
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
                                    <h4 class="card-title">Upload Attachment</h4>
                                    <div class="text-center">
                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                            <span class="btn btn-square btn-info btn-file btn-sm">
                                                <span class="fileinput-new">Add</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="attachmentAssignment[]" id="attachmentAssignment" accept="image/*,.pdf,.doc,.docx" multiple />
                                            </span>
                                            <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="material-icons">highlight_off</i></a>
                                        </div>
                                    </div>

                                    <div class="form-group" id="image_preview">

                                    </div>
                                </div>
                            </div>

                            @if(count($assignment['assignmentAttachment']) > 0)
                                <div class="card">
                                    <div class="card-content">
                                        <h4 class="card-title">Attachment</h4>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <ul>
                                                        @foreach($assignment['assignmentAttachment'] as $key =>$attachment)

                                                            @if($attachment['extension'] =="pdf")
                                                                <div class="img_div" id="img_div">
                                                                    <img src="https://cdn-icons-png.flaticon.com/512/337/337946.png" class="multiple_image img-responsive" title="">
                                                                </div>
                                                            @elseif($attachment['extension'] =="doc" || $attachment['extension'] =="docx")
                                                                <div class="img_div" id="img_div">
                                                                    <img src="https://cdn-icons-png.flaticon.com/512/337/337932.png" class="multiple_image img-responsive" title="">
                                                                </div>
                                                            @else
                                                                <div class="img_div" id="img_div">
                                                                    <img src="{{ $attachment['file_url'] }}" class="multiple_image img-responsive" title="">
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
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
        $("#attachmentAssignment").change(function(){
            // check if fileArr length is greater than 0
            if(fileArr.length > 0) fileArr = [];

            $('#image_preview').html("");
            var total_file = document.getElementById("attachmentAssignment").files;
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

                }else if(extension == "pdf"){

                    fileType += '<div class="img_div" id="img_div' + i + '">';
                    fileType += '<img src="https://cdn-icons-png.flaticon.com/512/337/337946.png" class="multiple_image img-responsive" title="' + total_file[i].name + '">';
                    fileType += '<div class="middle_div"><button id="action-icon" value="img_div' + i + '" class="btn btn-danger btn-xs" role="' + total_file[i].name + '"><i class="material-icons">delete</i></button></div></div>';

                }else if(extension == "docs" || extension == "doc" || extension == "docx"){

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
                if (fileArr[i].name === fileName){
                    fileArr.splice(i, 1);
                }
            }

            document.getElementById('attachmentAssignment').files = FileListItem(fileArr);
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
        $('#assignment_class').on('change', function(){

            var standardId = $(this).find(":selected").val();

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

                    $("#assignment_subject").html(options);
                    $("#assignment_subject").selectpicker('refresh');
                }
            });
        });

        // Get staff based on subject selection
        $('#assignment_subject').on('change', function(){

            var subjectId = $(this).find(":selected").val();
            var standardId = $("#assignment_class").val();

            $.ajax({
                url: "/standard-subject-staffs",
                type: "POST",
                data: {subjectId: subjectId, standardId: standardId},
                success: function(data){
                    var options = '';
                    $.map(data, function(item, index){
                        options += '<option value="' + item.id + '">' + item.name + '</option>';
                    });
                    $("#assignment_staff").html(options);
                    $("#assignment_staff").selectpicker('refresh');
                }
            });
        });

        $('#assignmentForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Update assignment
        $('body').delegate('#assignmentForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');
            var id = $("#assignment_id").val();

            if ($('#assignmentForm').parsley().isValid()){

                $.ajax({
                    url: "/assignment/" + id,
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
                        btn.html('Update');
                        btn.attr('disabled', false);

                        if(result['status'] == "200"){

                            if(result.data['signal'] == "success"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function() {
                                    //window.location.reload();
                                    window.location.replace('/assignment');
                                }).catch(swal.noop)

                            }else if (result.data['signal'] == "exist"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-warning"
                                });

                            } else{

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

        if (gradingRequiredValue == "YES"){

            $('#grading_options').show();

            if(gradingOptionValue == "GRADE"){

                $('#grade').show();
                $('#marks').hide();

            }else if(gradingOptionValue == "MARKS"){

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
