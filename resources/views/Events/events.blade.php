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
                    <form method="POST" id="eventForm">
                        <input type="hidden" name="id_institute" value="{{session()->get('institutionId')}}">
                        <input type="hidden" name="id_academic" value="{{session()->get('academicYear')}}">
                        <input type="hidden" name="organization" value="{{session()->get('organizationId')}}">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">event</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Add Event</h4>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Event Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="eventName" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Start Date<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker startDate" name="eventStartDate" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">End Date<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker endDate" name="eventEndDate" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Start Time<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control timepicker" name="eventStartTime" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">End Time<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control timepicker" name="eventEndTime" required />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label class="control-label">Event Details</label>
                                            <div class="form-group">
                                                <textarea class="ckeditor" name="eventDetails" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Event Type<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="eventType" id="eventType" data-style="select-with-transition" title="Select" required="required">
                                                    <option value ="ONLINE">Online</option>
                                                    <option value ="OFFLINE">Offline</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Event Attendance Required?<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="attendanceRequired" id="attendanceRequired" data-style="select-with-transition" title="Select" required="required">
                                                    <option value ="YES">Yes</option>
                                                    <option value ="NO">No</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Read Receipt Required?<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="receiptRequired" id="receiptRequired" data-style="select-with-transition" title="Select" required="required">
                                                    <option value ="YES">Yes</option>
                                                    <option value ="NO">No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-20">
                                        <div class="col-lg-12">
                                            <h4 class="card-title">Applicable To</h4>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group checkbox">
                                                <label><input type="checkbox" name="recipientType[]" id="staffType" value="STAFF" />Staff</label>
                                            </div>
                                        </div>

                                        <div id="staffDiv" style="display:none">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Staff Category</label>
                                                    <select class="selectpicker" name="staffCategory[]" id="staffCategory" data-style="select-with-transition" data-live-search="true" title="Select" data-selected-text-format="count > 1" multiple data-actions-box="true">
                                                        @foreach($eventdata['staffCategory'] as $staffCategory)
                                                            <option value="{{$staffCategory->id}}">{{ucwords($staffCategory->name)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Staff Subcategory</label>
                                                    <select class="selectpicker" name="staffSubcategory[]" id="staffSubcategory" data-style="select-with-transition" data-live-search="true" title="Select" data-selected-text-format="count > 1" multiple data-actions-box="true">

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Staff</label>
                                                    <select class="selectpicker" name="staff[]" id="staff" data-style="select-with-transition" data-live-search="true" title="Select" data-selected-text-format="count > 1" data-actions-box="true" multiple data-actions-box="true">

                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group checkbox">
                                                <label><input type="checkbox" name="recipientType[]" id="studentType" value="STUDENT" />Student</label>
                                            </div>
                                        </div>

                                        <div id="studentDiv" style="display:none">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Standard</label>
                                                    <select class="selectpicker" name="standard[]" id="standard" data-style="select-with-transition" data-live-search="true" data-size="5" title="Select" data-selected-text-format="count > 1" multiple data-actions-box="true" data-container="body">
                                                        @foreach($eventdata['institutionStandards'] as $standard)
                                                            <option value="{{$standard['institutionStandard_id']}}">{{$standard['class']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Subject</label>
                                                    <select class="selectpicker" name="subject[]" id="subject" data-style="select-with-transition" data-live-search="true" title="Select" data-size="5" data-selected-text-format="count > 1" multiple data-actions-box="true" data-container="body">

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Student</label>
                                                    <select class="selectpicker" name="student[]" id="student" data-style="select-with-transition" data-live-search="true" title="Select" data-selected-text-format="count > 1" data-actions-box="true" data-container="body" multiple>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Submit</button>
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
                        console.log(item);
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

            for (var i = 0; i < fileArr.length; i++){
                if (fileArr[i].name === fileName){
                    fileArr.splice(i, 1);
                }
            }

            document.getElementById('eventAttachment').files = FileListItem(fileArr);
            evt.preventDefault();
        });

        function FileListItem(file){
            file = [].slice.call(Array.isArray(file) ? file : arguments)
            for (var c, b = c = file.length, d = !0; b-- && d;) d = file[b] instanceof File
            if (!d) throw new TypeError("expected argument to FileList is File or array of File objects")
            for (b = (new ClipboardEvent("")).clipboardData || new DataTransfer; c--;) b.items.add(file[c])
            return b.files
        }

        $("#eventForm").parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save event
        $('body').delegate('#eventForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');

            if ($('#eventForm').parsley().isValid()){

                $.ajax({
                    url:"/event",
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

