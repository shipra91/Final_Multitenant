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
                    <form method="POST" id="eventForm">
                        <input type="hidden" name="eventId" id="eventId" class="form-control" value="{{$selectedData['eventData']->id}}">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">event</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Edit Event</h4>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Event Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="eventName" value="{{$selectedData['eventData']->name}}" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label">Start Date<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker startDate" name="eventStartDate" value="{{$selectedData['eventData']->startDate}}" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label">End Date<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker endDate" name="eventEndDate" value="{{$selectedData['eventData']->endDate}}" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label">Start Time<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control timepicker" name="eventStartTime" value="{{$selectedData['eventData']->start_time}}" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label">End Time<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control timepicker" name="eventEndTime" value="{{$selectedData['eventData']->end_time}}" required />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="control-label form-group">Event Details</label>
                                                <textarea class="ckeditor" name="eventDetails" rows="5">{{$selectedData['eventData']->event_detail}}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label">Event Type<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="eventType" id="eventType" data-style="select-with-transition" title="Select" required="required">
                                                    <option value ="ONLINE" @if($selectedData['eventData']->event_type == 'ONLINE'){{'selected'}} @endif>Online</option>
                                                    <option value ="OFFLINE"  @if($selectedData['eventData']->event_type == 'OFFLINE'){{'selected'}} @endif>Offline</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label">Event Attendance Required?<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="attendanceRequired" id="attendanceRequired" data-style="select-with-transition" title="Select" required="required">
                                                    <option value ="YES" @if($selectedData['eventData']->attendance_required == 'YES'){{'selected'}} @endif>Yes</option>
                                                    <option value ="NO" @if($selectedData['eventData']->attendance_required == 'NO'){{'selected'}} @endif>No</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label">Read Receipt Required?<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="receiptRequired" id="receiptRequired" data-style="select-with-transition" title="Select" required="required">
                                                    <option value ="YES" @if($selectedData['eventData']->receipt_required == 'YES'){{'selected'}} @endif>Yes</option>
                                                    <option value ="NO"  @if($selectedData['eventData']->receipt_required == 'NO'){{'selected'}} @endif>No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-30">
                                        <div class="col-lg-12">
                                            <h4 class="card-title">Applicable To</h4>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group checkbox">
                                                <label><input type="checkbox" name="applicableTo[]" id="staffType" value="STAFF" @if(in_array("STAFF", $selectedData['recepientTypes'])) {{"checked"}} @endif/>Staff</label>
                                            </div>
                                        </div>

                                        <div id="staffDiv" @if(!in_array("STAFF", $selectedData['recepientTypes'])) {{ 'style="display:none"'; }} @endif>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label">Staff Category</label>
                                                    <select class="selectpicker" name="staffCategory[]" id="staffCategory" data-style="select-with-transition" data-live-search="true" title="Select" data-selected-text-format="count > 1" multiple data-actions-box="true">
                                                        @foreach($eventData['staffCategory'] as $staffCategory)
                                                            <option value="{{$staffCategory->id}}" @if(in_array($staffCategory->id, $selectedData['selectedStaffCategory'])) {{"selected"}} @endif>{{ucwords($staffCategory->name)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label">Staff Subcategory</label>
                                                    <select class="selectpicker" name="staffSubcategory[]" id="staffSubcategory" data-style="select-with-transition" data-live-search="true" title="Select" data-selected-text-format="count > 1" multiple data-actions-box="true">
                                                        @foreach($eventData['staffSubcategory'] as $staffSubcategory)
                                                            <option value="{{$staffSubcategory->id}}" @if(in_array($staffSubcategory->id, $selectedData['selectedStaffSubCategory'])) {{"selected"}} @endif>{{ucwords($staffSubcategory->name)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label">Staff</label>
                                                    <select class="selectpicker" name="staff[]" id="staff" data-style="select-with-transition" data-live-search="true" title="Select" multiple data-actions-box="true" data-selected-text-format="count > 1">
                                                        @foreach($selectedData['allStaffs'] as $staff)
                                                            <option value="{{$staff['id']}}" @if(in_array($staff['id'], $selectedData['selectedStaffs'])) {{"selected"}} @endif>{{ucwords($staff['name'])}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group checkbox">
                                                <label><input type="checkbox" name="applicableTo[]" id="studentType" value="STUDENT" @if(in_array("STUDENT", $selectedData['recepientTypes'])) {{ "checked" }} @endif/>Student</label>
                                            </div>
                                        </div>

                                        <div id="studentDiv" @if(!in_array("STUDENT", $selectedData['recepientTypes'])) {{ 'style="display:none"'; }} @endif>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label">Standard</label>
                                                    <select class="selectpicker" name="standard[]" id="standard" data-style="select-with-transition" data-live-search="true" data-size="4" title="Select" multiple data-actions-box="true" data-selected-text-format="count > 1">
                                                        @foreach($eventData['institutionStandards'] as $standard)
                                                            <option value="{{$standard['institutionStandard_id']}}" @if(in_array($standard['institutionStandard_id'], $selectedData['selectedStandards'])) {{"selected"}} @endif>{{$standard['class']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label">Subject</label>
                                                    <select class="selectpicker" name="subject[]" id="subject" data-style="select-with-transition" data-live-search="true" title="Select" data-size="4" multiple data-actions-box="true" data-selected-text-format="count > 1">
                                                        @foreach($eventData['standardSubjects'] as $standardSubject)
                                                            <option value="{{$standardSubject['id']}}" @if(in_array($standardSubject['id'], $selectedData['selectedStandardSubject'])) {{"selected"}} @endif>{{$standardSubject['name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label">Student</label>
                                                    <select class="selectpicker" name="student[]" id="student" data-style="select-with-transition" data-live-search="true" title="Select" data-size="4" multiple data-actions-box="true" data-selected-text-format="count > 1">
                                                        @if(count($selectedData['allStudents']) > 0)
                                                            @foreach($selectedData['allStudents'] as $student)
                                                                <option value="{{$student['id_student']}}" @if(in_array($student['id_student'], $selectedData['selectedStudents'])) {{"selected"}} @endif>{{ucwords($student['name'])}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Update</button>
                                        <a href="{{ url('event') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
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
                                                <input type="file" name="eventAttachment[]" id="eventAttachment" accept="image/*,.pdf,.doc,.docx" multiple />
                                            </span>
                                            <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="material-icons">highlight_off</i></a>
                                        </div>
                                    </div>
                                    <div class="form-group" id="image_preview">

                                    </div>
                                </div>
                            </div>

                            @if(count($selectedData['eventAttachment']) > 0)
                                <div class="card">
                                    <div class="card-content">
                                        <h4 class="card-title">Attachment</h4>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    @foreach($selectedData['eventAttachment'] as $key =>$attachment)
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
                url:"{{url('/get-all-subcategory')}}",
                type:"post",
                dataType:"json",
                data: {catId:catId},
                success:function(result){
                    $("#staffSubcategory").html(result['data']);
                    $("#staffSubcategory").selectpicker('refresh');
                }
            });
        });

        // Get staff based on category and subcategory
        $("#staffSubcategory").on("change", function(event){
            event.preventDefault();

            var catId = $(staffCategory).val();//alert(catId);
            var subCatId = $(this).val();//alert(subCatId);

            $.ajax({
                url:"{{url('/get-all-staff')}}",
                type:"post",
                dataType:"json",
                data: {catId:catId,subCatId:subCatId},
                success:function(result){
                    var arrayData = '';
                    $.each(result, function( index, staff ){
                        arrayData +='<option value="'+staff.id+'">'+staff.name+'</option>';
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
                url:"/event-subjects",
                type:"POST",
                data: {standardId : standardId},
                success: function(data){
                    var options = '';
                    $.map(data, function(item, index){
                        var subject_type = '';
                        if(item.subject_type === "PRACTICAL"){
                            subject_type = ' - '+item.subject_type;
                        }else{
                            subject_type = '';
                        }
                        options += '<option value="'+item.id_institution_subject+'">'+item.display_name+''+ subject_type+'</option>';
                    });

                    $("#subject").html(options);
                    $("#subject").selectpicker('refresh');
                }
            });
        });

        // Get student on subject selection
        $('#subject').on('change', function(){

            var subjectId = $(this).val();
            var standardId = $("#standard").val();

            $.ajax({
                url:"/get-all-student",
                type:"POST",
                data: {subjectId:subjectId, standardId:standardId},
                success: function(data){
                    var studentOptions = '';
                    $.map(data, function(item, index){
                        studentOptions += '<option value="'+item.id_student+'">'+item.name+'</option>';
                    });
                    $("#student").html(studentOptions);
                    $("#student").selectpicker('refresh');
                }
            });
        });

        // Multiple image upload with preview
        var fileArr = [];
        $("#eventAttachment").change(function(){

            // check if fileArr length is greater than 0
            if(fileArr.length > 0) fileArr = [];

            $('#image_preview').html("");
            var total_file = document.getElementById("eventAttachment").files;
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
                if (fileArr[i].name === fileName){
                    fileArr.splice(i, 1);
                }
            }

            document.getElementById('eventAttachment').files = FileListItem(fileArr);
            evt.preventDefault();
        });

        function FileListItem(file){
            file = [].slice.call(Array.isArray(file) ? file : arguments)
            for(var c, b = c = file.length, d = !0; b-- && d;) d = file[b] instanceof File
            if(!d) throw new TypeError("expected argument to FileList is File or array of File objects")
            for(b = (new ClipboardEvent("")).clipboardData || new DataTransfer; c--;) b.items.add(file[c])
            return b.files
        }

        $("#eventForm").parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Update event
        $('body').delegate('#eventForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');
            var id = $("#eventId").val();

            if ($('#eventForm').parsley().isValid()){

                $.ajax({
                    url:"/event/"+id,
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
                                    //window.location.reload();
                                    window.location.replace('/event');
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

