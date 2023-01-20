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
                    <form method="POST" id="holidayForm">
                        <input type="hidden" name="holidayId" id="holidayId" value="{{ $selectedData['holidayData']->id }}" />
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">school</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Edit Holiday</h4>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Holiday Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="holiday_title" value="{{ $selectedData['holidayData']->title }}" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label">Start Date<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker startDate" name="start_date" value="{{ $selectedData['holidayData']->startDate }}" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label">End Date<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker endDate" name="end_date" value="{{ $selectedData['holidayData']->endDate }}" required autocomplete="off"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="control-label form-group">Holiday Details</label>
                                                <textarea class="ckeditor" name="holiday_details" rows="5">{{ $selectedData['holidayData']->description }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-20">
                                        <div class="col-lg-12">
                                            <h4 class="card-title">Applicable To</h4>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group checkbox">
                                                <label><input type="checkbox" name="applicableTo[]" id="staffType" value="STAFF" @if(in_array("STAFF", $selectedData['recepientTypes'])) {{"checked"}} @endif />Staff</label>
                                            </div>
                                        </div>

                                        <div id="staffDiv" @if(!in_array("STAFF", $selectedData['recepientTypes'])) style="display:none;" @endif>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="control-label">Staff Category</label>
                                                    <select class="selectpicker" name="staffCategory[]" id="staffCategory" data-style="select-with-transition" data-live-search="true" title="Select" data-selected-text-format="count > 1" multiple data-actions-box="true">
                                                        @foreach($holidayData['staffCategory'] as $staffCategory)
                                                            <option value="{{$staffCategory->id}}" @if(in_array($staffCategory->id, $selectedData['selectedStaffCategory'])) {{"selected"}} @endif>{{ucwords($staffCategory->name)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="control-label">Staff Subcategory</label>
                                                    <select class="selectpicker" name="staffSubcategory[]" id="staffSubcategory" data-style="select-with-transition" data-live-search="true" title="Select SubCategory" data-selected-text-format="count > 1" multiple data-actions-box="true">
                                                        @foreach($holidayData['staffSubcategory'] as $staffSubcategory)
                                                            <option value="{{$staffSubcategory->id}}" @if(in_array($staffSubcategory->id, $selectedData['selectedStaffSubCategory'])) {{"selected"}} @endif>{{ucwords($staffSubcategory->name)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group checkbox">
                                                <label><input type="checkbox" name="applicableTo[]" id="studentType" value="STUDENT" @if(in_array("STUDENT", $selectedData['recepientTypes'])) {{"checked"}} @endif />Student</label>
                                            </div>
                                        </div>

                                        <div id="studentDiv" @if(!in_array("STUDENT", $selectedData['recepientTypes'])) style="display:none;" @endif>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="control-label">Standard</label>
                                                    <select class="selectpicker" name="standard[]" id="standard" data-style="select-with-transition" data-live-search="true" data-size="5" title="Select" multiple data-actions-box="true" data-selected-text-format="count > 1">
                                                        @foreach($holidayData['institutionStandards'] as $standard)
                                                            <option value="{{$standard['institutionStandard_id']}}" @if(in_array($standard['institutionStandard_id'], $selectedData['selectedStandards'])) {{"selected"}} @endif>{{$standard['class']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Update</button>
                                        <a href="{{ url('holiday') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
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
                                                <input type="file" name="attachment[]" id="attachment" accept="image/*,.pdf,.doc,.docx" multiple />
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
        $("#attachment").change(function(){

            // check if fileArr length is greater than 0
            if (fileArr.length > 0) fileArr = [];

            $('#image_preview').html("");
            var total_file = document.getElementById("attachment").files;
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

            document.getElementById('attachment').files = FileListItem(fileArr);
            evt.preventDefault();
        });

        function FileListItem(file){
            file = [].slice.call(Array.isArray(file) ? file : arguments)
            for (var c, b = c = file.length, d = !0; b-- && d;) d = file[b] instanceof File
            if (!d) throw new TypeError("expected argument to FileList is File or array of File objects")
            for (b = (new ClipboardEvent("")).clipboardData || new DataTransfer; c--;) b.items.add(file[c])
            return b.files
        }

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

        $('#holidayForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Update holiday
        $('body').delegate('#holidayForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');
            var id = $("#holidayId").val();

            if ($('#holidayForm').parsley().isValid()){

                $.ajax({
                    url:"/holiday/"+id,
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
                                    window.location.replace('/holiday');
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

