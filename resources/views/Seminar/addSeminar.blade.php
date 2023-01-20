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
                    <form method="POST" id="seminarForm">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">school</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Add Seminar</h4>
                                    <div class="row mt-30">
                                        <div class="col-lg-10 col-lg-offset-1">
                                            <h4 class="card-title text-center font-15">Seminar Conducted By</h4>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">search</i>
                                                </span>
                                                <div class="form-group">
                                                    <input type="text" class="form-control autocomplete" id="autocomplete" placeholder="Search staff/student name here" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 col-lg-offset-0">
                                            <table class="table table-striped table-no-bordered table-hover mt-20 mb-30">
                                                <thead style="font-size:12px;">
                                                    <tr>
                                                        <th width="10%"><b>UID</b></th>
                                                        <th width="30%"><b>Name</b></th>
                                                        <th width="30%"><b>Standard</b></th>
                                                        <th width="20%"><b>Type</b></th>
                                                        <th width="10%"><b>Remove</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="selectedStudent">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Start Date<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker startDate" name="seminar_start_date" data-parsley-trigger="change" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">End Date<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker endDate"  name="seminar_end_date" data-parsley-trigger="change" required autocomplete="off"/>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Start Time<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control timepicker" name="seminar_start_time" data-parsley-trigger="change" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">End Time<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control timepicker" name="seminar_end_time" data-parsley-trigger="change" required />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Mentored By<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="mentors[]" id="mentors" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-actions-box="true" data-selected-text-format="count > 1" multiple data-parsley-errors-container=".mentoredError">
                                                    @foreach($details['teachingStaffs'] as $staffs)
                                                        <option value="{{$staffs->id}}">{{$staffs->name}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="mentoredError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Seminar Topic<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="seminar_topic" required />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="control-label">Seminar Details</label>
                                            <div class="form-group">
                                                <textarea class="ckeditor" name="description" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Maximum Marks</label>
                                                <input type="text" class="form-control" name="max_mark" placeholder="Mention max mark here" />
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label mt-0">SMS alert to recipients required? (cost may apply)<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="sms_alert" id="sms_alert" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".smsError">
                                                    <option value="YES"> YES</option>
                                                    <option value="NO"> NO</option>
                                                </select>
                                                <div class="smsError"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-20">
                                        <div class="col-lg-12">
                                            <h4 class="card-title">Invities</h4>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group checkbox">
                                                <label><input type="checkbox" name="applicableTo[]" id="staffType" value="STAFF" />Staff</label>
                                            </div>
                                        </div>

                                        <div id="staffDiv" style="display:none">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Staff Category</label>
                                                    <select class="selectpicker" name="staffCategory[]" id="staffCategory" data-style="select-with-transition" data-live-search="true" title="Select" data-selected-text-format="count > 1" multiple data-actions-box="true" data-parsley-errors-container=".catError">
                                                        @foreach($details['staffCategory'] as $staffCategory)
                                                            <option value="{{$staffCategory->id}}">{{ucwords($staffCategory->name)}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="catError"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Staff Subcategory</label>
                                                    <select class="selectpicker" name="staffSubcategory[]" id="staffSubcategory" data-style="select-with-transition" data-live-search="true" title="Select" data-selected-text-format="count > 1" multiple data-actions-box="true" data-parsley-errors-container=".subcatError">

                                                    </select>
                                                    <div class="subcatError"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Staff</label>
                                                    <select class="selectpicker" name="staff[]" id="staff" data-style="select-with-transition" data-live-search="true" title="Select" multiple data-actions-box="true" data-selected-text-format="count > 1" data-parsley-errors-container=".staffError">

                                                    </select>
                                                    <div class="staffError"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group checkbox">
                                                <label><input type="checkbox" name="applicableTo[]" id="studentType" value="STUDENT" />Student</label>
                                            </div>
                                        </div>

                                        <div id="studentDiv" style="display:none">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Standard</label>
                                                    <select class="selectpicker" name="standard[]" id="standard" data-style="select-with-transition" data-live-search="true" data-size="5" title="Select" multiple data-actions-box="true" data-selected-text-format="count > 1" data-parsley-errors-container=".standardError">
                                                        @foreach($details['institutionStandards'] as $standard)
                                                            <option value="{{ $standard['institutionStandard_id'] }}">{{ $standard['class'] }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="standardError"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Subject</label>
                                                    <select class="selectpicker" name="subject[]" id="subject" data-style="select-with-transition" data-live-search="true" title="Select" data-size="5" multiple data-actions-box="true" data-selected-text-format="count > 1" data-parsley-errors-container=".subjectError">

                                                    </select>
                                                    <div class="subjectError"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Student</label>
                                                    <select class="selectpicker" name="student[]" id="student" data-style="select-with-transition" data-live-search="true" title="Select" multiple data-actions-box="true" data-selected-text-format="count > 1" data-parsley-errors-container=".studentError">

                                                    </select>
                                                    <div class="studentError"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5"
                                            id="submit" name="submit">Submit</button>
                                        <a href="{{ url('seminar') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
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
                                                <input type="file" name="seminarAttachment[]" id="seminarAttachment" accept="image/*,.pdf,.doc,.docx" multiple />
                                            </span>
                                            <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput">
                                                <i class="material-icons">highlight_off</i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="form-group" id="image_preview">

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

        // Multiple image upload with preview
        var fileArr = [];
        $("#seminarAttachment").change(function(){

            // check if fileArr length is greater than 0
            if (fileArr.length > 0) fileArr = [];

            $('#image_preview').html("");
            var total_file = document.getElementById("seminarAttachment").files;
            if (!total_file.length) return;

            for (var i = 0; i < total_file.length; i++){

                var extension = total_file[i].name.substr((total_file[i].name.lastIndexOf('.') + 1));
                var fileType = '';
                // console.log(extension);

                fileArr.push(total_file[i]);

                if(extension != "pdf" && extension != "docs" && extension != "doc" && extension != "docx"){

                    fileType += '<div class="img_div" id="img_div' + i + '">';
                    fileType += '<img src="' + URL.createObjectURL(event.target.files[i]) + '" class="multiple_image img-responsive" title="' + total_file[i].name + '">';
                    fileType += '<div class="middle_div"><button id="action-icon" value="img_div' + i + '" class="btn btn-danger btn-xs" role="' + total_file[i].name + '"><i class="fa fa-trash"></i></button></div></div>';

                }else if (extension == "pdf"){

                    fileType += '<div class="img_div" id="img_div' + i + '">';
                    fileType += '<img src="https://cdn-icons-png.flaticon.com/512/337/337946.png" class="multiple_image img-responsive" title="' + total_file[i].name + '">';
                    fileType += '<div class="middle_div"><button id="action-icon" value="img_div' + i + '" class="btn btn-danger btn-xs" role="' + total_file[i].name + '"><i class="fa fa-trash"></i></button></div></div>';

                }else if (extension == "docs" || extension == "doc" || extension == "docx"){

                    fileType += '<div class="img_div" id="img_div' + i + '">';
                    fileType += '<img src="https://cdn-icons-png.flaticon.com/512/337/337932.png" class="multiple_image img-responsive" title="' + total_file[i].name + '">';
                    fileType += '<div class="middle_div"><button id="action-icon" value="img_div' + i + '" class="btn btn-danger btn-xs" role="' + total_file[i].name + '"><i class="fa fa-trash"></i></button></div></div>';
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

            document.getElementById('seminarAttachment').files = FileListItem(fileArr);
            evt.preventDefault();
        });

        function FileListItem(file){
            file = [].slice.call(Array.isArray(file) ? file : arguments)
            for (var c, b = c = file.length, d = !0; b-- && d;) d = file[b] instanceof File
            if (!d) throw new TypeError("expected argument to FileList is File or array of File objects")
            for (b = (new ClipboardEvent("")).clipboardData || new DataTransfer; c--;) b.items.add(file[c])
            return b.files
        }

        // Get student details
        $('#autocomplete').autocomplete({

            source: function(request, response){

                $.ajax({
                    type: "POST",
                    url: '{{ url("staff-student-search") }}',
                    dataType: "json",
                    data: {term: request.term},
                    success: function(data){
                        response(data);
                        response($.map(data, function(item){
                            var code = item.split("@");
                            // console.log(code);
                            var code1 = item.split("|");
                            return {
                                label: code[0],
                                value: code[0],
                                data: item
                            }
                        }));
                    }
                });
            },
            autoFocus: true,
            minLength: 2,
            select: function(event, ui){
                var names = ui.item.data.split("@");
                // console.log(names);
                var insert = true;
                var length = $('#selectedStudent tr').length;

                if(length > 0){

                    $('#selectedStudent tr').each(function(){

                        if($(this).attr("id") == names[1]){

                            swal({
                                title: "Student Already Added!",
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-success"
                            }).catch(swal.noop)
                            $("#autocomplete").val("");
                            insert = false;
                        }
                    });
                }

                if(insert == true){

                    $("#selectedStudent").append('<tr id=' + names[1] +
                        '><input type="hidden" name="conducted_by[]" value="' + names[1] +
                        '" /><input type="hidden" name="conducted_by_type[]" value="' + names[6] +
                        '" /><td>' + names[5] + '</td><td>' + names[2] + '</td><td>' + names[3] +
                        '</td><td>' + names[6] +
                        '</td><td><button type="button" rel="tooltip" class="btn btn-danger btn-xs deleteStudent" data-id = ' +
                        names[1] +
                        ' title=""  data-original-title="delete"><i class="material-icons">close</i><div class="ripple-container"></div></button></td></tr>'
                    );

                    $("#autocomplete").val("");
                }

                return false;
            }
        });

        // Remove student
        $("body").delegate(".deleteStudent", "click", function(event){
            event.preventDefault();

            var studentId = $(this).attr('data-id');

            $("#selectedStudent tr#" + studentId).remove();
            var length = $('#selectedStudent tr').length;
            if(length == 0){
                $("#modalAbsent").modal('hide');
            }
        });

        $('#staffType').click(function(){
            $("#staffDiv").toggle(this.checked);
        });

        $('#studentType').click(function(){
            $("#studentDiv").toggle(this.checked);
        });

        // Get staff subcategory
        $("#staffCategory").on("change", function(event){
            event.preventDefault();

            var catId = $(this).val();

            $.ajax({
                url: "{{url('/get-all-subcategory')}}",
                type: "post",
                dataType: "json",
                data: {catId: catId},
                success: function(result){
                    $("#staffSubcategory").html(result['data']);
                    $("#staffSubcategory").selectpicker('refresh');
                }
            });
        });

        // Get staff based on category and subcategory
        $("#staffSubcategory").on("change", function(event){
            event.preventDefault();

            var catId = $(staffCategory).val(); //alert(catId);
            var subCatId = $(this).val(); //alert(subCatId);

            $.ajax({
                url: "{{url('/get-all-staff')}}",
                type: "post",
                dataType: "json",
                data: {catId: catId, subCatId: subCatId},
                success: function(result){
                    var arrayData = '';
                    $.each(result, function(index, staff){
                        arrayData += '<option value="' + staff.id + '">' + staff.name +'</option>';
                    });
                    $("#staff").html(arrayData);
                    $("#staff").selectpicker('refresh');
                }
            });
        });

        // Get subject on standard selection
        $('#standard').on('change', function(){

            var standardId = $(this).val();

            $.ajax({
                url: "/event-subjects",
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

                        options += '<option value="' + item.id_institution_subject +'">' + item.display_name + '' + subject_type + '</option>';
                    });

                    $("#subject").html(options);
                    $("#subject").selectpicker('refresh');
                }
            });
        });

        // Get Student On Subject Selection
        $('#subject').on('change', function(){

            var subjectId = $(this).val();
            var standardId = $("#standard").val();

            $.ajax({
                url: "/get-all-student",
                type: "POST",
                data: {subjectId: subjectId, standardId: standardId},
                success: function(data){
                    var studentOptions = '';
                    $.map(data, function(item, index){
                        studentOptions += '<option value="' + item.id_student + '">' + item.name + '</option>';
                    });
                    $("#student").html(studentOptions);
                    $("#student").selectpicker('refresh');
                }
            });
        });

        $('#seminarForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save seminar
        $('body').delegate('#seminarForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');

            if($('#seminarForm').parsley().isValid()){

                $.ajax({
                    url: "/seminar",
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

        $('#resubmission_date').hide();
        $('#resubmission_time').hide();

        $('#resubmission_required').on('change', function(){

            var resubmissionRequired = $(this).val();

            if(resubmissionRequired == "YES"){
                $('#resubmission_date').show();
                $('#resubmission_time').show();
            }else{
                $('#resubmission_date').hide();
                $('#resubmission_time').hide();
            }
        });
    });
</script>
@endsection
