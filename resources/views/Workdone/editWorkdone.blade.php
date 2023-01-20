<?php
    use Carbon\Carbon;
?>
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
                    <form method="POST" id="workdoneForm">
                        
                        <input type="hidden" name="id_institute" value="{{session()->get('institutionId')}}">
                        <input type="hidden" name="id_academic" value="{{session()->get('academicYear')}}">
                        <input type="hidden" name="organization" value="{{session()->get('organizationId')}}">
                                 
                        <input type="hidden" name ="workdone_id" id ="workdone_id" value ="{{$workdone->id}}">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Edit Workdone</h4>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Standard<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="workdone_class" id="workdone_class" data-style="select-with-transition" data-live-search="true" title="Select" data-actions-box="true" data-size="5" required="required" data-parsley-errors-container=".standardError">
                                                    @foreach($workdoneDetails['standard'] as $standard)
                                                        <option value="{{ $standard['institutionStandard_id'] }}" @if($workdone->id_standard == $standard['institutionStandard_id'] ) {{'selected'}} @endif>{{ $standard['class'] }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="standardError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Subject<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="workdone_subject" id="workdone_subject" data-style="select-with-transition" data-live-search="true" title="Select" data-actions-box="true" data-size="5" required="required" data-parsley-errors-container=".subjectError">
                                                    @foreach($workdoneDetails['subject'] as $subject)
                                                        <option value="{{ $subject['id'] }}" @if($workdone->id_subject == $subject['id'] ) {{'selected'}} @endif>{{ $subject['name'] }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="subjectError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Teacher<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="workdone_staff" id="workdone_staff" data-style="select-with-transition" data-live-search="true" title="Select" data-actions-box="true" data-size="5" required="required" data-parsley-errors-container=".staffError">
                                                    @foreach($workdoneDetails['staff'] as $staff)
                                                        <option value="{{ $staff->id }}" @if($workdone->id_staff == $staff->id ) {{'selected'}} @endif>{{ $staff->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="staffError"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label">Date<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker" name="workdone_date" value="{{  Carbon::createFromFormat('Y-m-d', $workdone->date)->format('d/m/Y') }}" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label">Start Time<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control timepicker" name="workdone_start_time" value="{{$workdone->start_time}}" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label">End Time<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control timepicker" name="workdone_end_time" value="{{$workdone->end_time}}" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="control-label">Chapter Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="chapter_name" value="{{$workdone->workdone_topic}}" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="control-label form-group">Workdone Details</label>
                                                <textarea class="ckeditor" name="workdone_details" rows="5">{{$workdone->description}}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Update</button>
                                        <a href="{{ url('workdone') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
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
                                                <input type="file" name="attachmentWorkdone[]" id="attachmentWorkdone" accept="image/*,.pdf,.doc,.docx" multiple />
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
        $("#attachmentWorkdone").change(function(){

            // check if fileArr length is greater than 0
            if (fileArr.length > 0) fileArr = [];

            $('#image_preview').html("");
            var total_file = document.getElementById("attachmentWorkdone").files;
            if (!total_file.length) return;

            for (var i = 0; i < total_file.length; i++){

                var extension = total_file[i].name.substr((total_file[i].name.lastIndexOf('.') + 1));
                var fileType = '';
                // console.log(extension);

                fileArr.push(total_file[i]);

                if (extension != "pdf" && extension != "docs" && extension != "doc" && extension != "docx"){

                    fileType += '<div class="img_div" id="img_div' + i + '">';
                    fileType += '<img src="' + URL.createObjectURL(event.target.files[i]) +
                        '" class="multiple_image img-responsive" title="' + total_file[i].name +
                        '">';
                    fileType += '<div class="middle_div"><button id="action-icon" value="img_div' + i +
                        '" class="btn btn-danger btn-xs" role="' + total_file[i].name +
                        '"><i class="fa fa-trash"></i></button></div></div>';

                }else if (extension == "pdf"){

                    fileType += '<div class="img_div" id="img_div' + i + '">';
                    fileType +=
                        '<img src="https://listimg.pinclipart.com/picdir/s/336-3361375_pdf-svg-png-icon-free-download-adobe-acrobat.png" class="multiple_image img-responsive" title="' +
                        total_file[i].name +
                        '">';
                    fileType += '<div class="middle_div"><button id="action-icon" value="img_div' + i +
                        '" class="btn btn-danger btn-xs" role="' + total_file[i].name +
                        '"><i class="fa fa-trash"></i></button></div></div>';

                }else if (extension == "docs" || extension == "doc" || extension == "docx"){

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

            for (var i = 0; i < fileArr.length; i++){
                if (fileArr[i].name === fileName){
                    fileArr.splice(i, 1);
                }
            }

            document.getElementById('attachmentWorkdone').files = FileListItem(fileArr);
            evt.preventDefault();
        });

        function FileListItem(file){
            file = [].slice.call(Array.isArray(file) ? file : arguments)
            for (var c, b = c = file.length, d = !0; b-- && d;) d = file[b] instanceof File
            if (!d) throw new TypeError("expected argument to FileList is File or array of File objects")
            for (b = (new ClipboardEvent("")).clipboardData || new DataTransfer; c--;) b.items.add(file[c])
            return b.files
        }

        // Get subject on standard selection
        $('#workdone_class').on('change', function(){

            var standardId = $(this).val();

            $.ajax({
                url:"/assignment-subjects",
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

                    $("#workdone_subject").html(options);
                    $("#workdone_subject").selectpicker('refresh');
                }
            });
        });

        // Get staff on subject selection
        $('#workdone_subject').on('change', function(){

            var subjectId = $(this).val();
            var standardId = $("#workdone_class").val();

            $.ajax({
                url:"/standard-subject-staffs",
                type:"POST",
                data: {subjectId : subjectId, standardId : standardId },
                success: function(data){
                    var options = '';
                    $.map(data, function(item, index){
                        options += '<option value="'+item.id+'">'+item.name+'</option>';
                    });

                    $("#workdone_staff").html(options);
                    $("#workdone_staff").selectpicker('refresh');
                }
            });
        });

        $('#workdoneForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Update workdone
        $('body').delegate('#workdoneForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');
            var id = $("#workdone_id").val();

            $.ajax({
                url:"/workdone/"+id,
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
                                window.location.replace('/workdone');
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
        });
    });
</script>
@endsection
