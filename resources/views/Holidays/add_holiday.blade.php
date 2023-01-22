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
                                        
                        <input type="hidden" name="id_institute" value="{{session()->get('institutionId')}}">
                        <input type="hidden" name="id_academic" value="{{session()->get('academicYear')}}">
                        <input type="hidden" name="organization" value="{{session()->get('organizationId')}}">
                                        
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">school</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Add Holiday</h4>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Holiday Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="holiday_title" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
<<<<<<< HEAD
                                                <label class="control-label mt-0">Start Date<span class="text-danger">*</span></label>
=======
                                                <label class="control-label">Start Date<span class="text-danger">*</span></label>
>>>>>>> main
                                                <input type="text" class="form-control datepicker startDate" name="start_date" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
<<<<<<< HEAD
                                                <label class="control-label mt-0">End Date<span class="text-danger">*</span></label>
=======
                                                <label class="control-label">End Date<span class="text-danger">*</span></label>
>>>>>>> main
                                                <input type="text" class="form-control datepicker endDate" name="end_date" required autocomplete="off"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
<<<<<<< HEAD
                                            <label class="control-label">Holiday Details</label>
                                            <div class="form-group">
=======
                                            <div class="form-group">
                                                <label class="control-label form-group">Holiday Details</label>
>>>>>>> main
                                                <textarea class="ckeditor" name="holiday_details" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-20">
                                        <div class="col-lg-12">
                                            <h4 class="card-title">Applicable To</h4>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group checkbox">
                                                <label><input type="checkbox" name="applicableTo[]" id="staffType" value="STAFF" />Staff</label>
                                            </div>
                                        </div>

                                        <div id="staffDiv" style="display:none">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Staff Category</label>
                                                    <select class="selectpicker" name="staffCategory[]" id="staffCategory" data-style="select-with-transition" data-live-search="true" title="Select" data-selected-text-format="count > 1" multiple data-actions-box="true">
                                                        @foreach($holidayData['staffCategory'] as $staffCategory)
                                                            <option value="{{$staffCategory->id}}">{{ucwords($staffCategory->name)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Staff Subcategory</label>
                                                    <select class="selectpicker" name="staffSubcategory[]" id="staffSubcategory" data-style="select-with-transition" data-live-search="true" title="Select SubCategory" data-selected-text-format="count > 1" multiple data-actions-box="true">

                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group checkbox">
                                                <label><input type="checkbox" name="applicableTo[]" id="studentType" value="STUDENT" />Student</label>
                                            </div>
                                        </div>

                                        <div id="studentDiv" style="display:none">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Standard</label>
                                                    <select class="selectpicker" name="standard[]" id="standard" data-style="select-with-transition" data-live-search="true" data-size="5" title="Select" multiple data-actions-box="true" data-selected-text-format="count > 1">
                                                        @foreach($holidayData['institutionStandards'] as $standard)
                                                            <option value="{{$standard['institutionStandard_id']}}">{{$standard['class']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Submit</button>
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
<<<<<<< HEAD
            if(fileArr.length > 0) fileArr = [];

            $('#image_preview').html("");
            var total_file = document.getElementById("attachment").files;
            if(!total_file.length) return;

            for(var i = 0; i < total_file.length; i++){
=======
            if (fileArr.length > 0) fileArr = [];

            $('#image_preview').html("");
            var total_file = document.getElementById("attachment").files;
            if (!total_file.length) return;

            for (var i = 0; i < total_file.length; i++){
>>>>>>> main

                var extension = total_file[i].name.substr((total_file[i].name.lastIndexOf('.') + 1));
                var fileType = '';
                // console.log(extension);

                fileArr.push(total_file[i]);

<<<<<<< HEAD
                if(extension != "pdf" && extension != "docs" && extension != "doc" && extension != "docx"){

                    fileType += '<div class="img_div" id="img_div' + i + '">';
                    fileType += '<img src="' + URL.createObjectURL(event.target.files[i]) + '" class="multiple_image img-responsive" title="' + total_file[i].name + '">';
                    fileType += '<div class="middle_div"><button id="action-icon" value="img_div' + i + '" class="btn btn-danger btn-xs" role="' + total_file[i].name + '"><i class="material-icons">delete</i></button></div></div>';
=======
                if (extension != "pdf" && extension != "docs" && extension != "doc" && extension != "docx"){

                    fileType += '<div class="img_div" id="img_div' + i + '">';
                    fileType += '<img src="' + URL.createObjectURL(event.target.files[i]) +
                        '" class="multiple_image img-responsive" title="' + total_file[i].name +
                        '">';
                    fileType += '<div class="middle_div"><button id="action-icon" value="img_div' + i +
                        '" class="btn btn-danger btn-xs" role="' + total_file[i].name +
                        '"><i class="fa fa-trash"></i></button></div></div>';
>>>>>>> main

                }else if (extension == "pdf"){

                    fileType += '<div class="img_div" id="img_div' + i + '">';
<<<<<<< HEAD
                    fileType += '<img src="https://cdn-icons-png.flaticon.com/512/337/337946.png" class="multiple_image img-responsive" title="' + total_file[i].name + '">';
                    fileType += '<div class="middle_div"><button id="action-icon" value="img_div' + i + '" class="btn btn-danger btn-xs" role="' + total_file[i].name + '"><i class="material-icons">delete</i></button></div></div>';
=======
                    fileType +=
                        '<img src="https://listimg.pinclipart.com/picdir/s/336-3361375_pdf-svg-png-icon-free-download-adobe-acrobat.png" class="multiple_image img-responsive" title="' +
                        total_file[i].name +
                        '">';
                    fileType += '<div class="middle_div"><button id="action-icon" value="img_div' + i +
                        '" class="btn btn-danger btn-xs" role="' + total_file[i].name +
                        '"><i class="fa fa-trash"></i></button></div></div>';
>>>>>>> main

                }else if (extension == "docs" || extension == "doc" || extension == "docx"){

                    fileType += '<div class="img_div" id="img_div' + i + '">';
<<<<<<< HEAD
                    fileType += '<img src="https://cdn-icons-png.flaticon.com/512/337/337932.png" class="multiple_image img-responsive" title="' + total_file[i].name + '">';
                    fileType += '<div class="middle_div"><button id="action-icon" value="img_div' + i + '" class="btn btn-danger btn-xs" role="' + total_file[i].name + '"><i class="material-icons">delete</i></button></div></div>';
=======
                    fileType +=
                        '<img src="https://www.pngitem.com/pimgs/m/181-1816575_google-docs-png-five-feet-apart-google-docs.png" class="multiple_image img-responsive" title="' +
                        total_file[i].name +
                        '">';
                    fileType += '<div class="middle_div"><button id="action-icon" value="img_div' + i +
                        '" class="btn btn-danger btn-xs" role="' + total_file[i].name +
                        '"><i class="fa fa-trash"></i></button></div></div>';
>>>>>>> main
                }

                $('#image_preview').append(fileType);
            }
        });

        $('body').on('click', '#action-icon', function(evt){
<<<<<<< HEAD

            var divName = this.value;
            var fileName = $(this).attr('role');

            $(`#${divName}`).remove();
            for(var i = 0; i < fileArr.length; i++){
                if(fileArr[i].name === fileName){
=======
            var divName = this.value;
            var fileName = $(this).attr('role');
            $(`#${divName}`).remove();

            for (var i = 0; i < fileArr.length; i++){
                if (fileArr[i].name === fileName){
>>>>>>> main
                    fileArr.splice(i, 1);
                }
            }

            document.getElementById('attachment').files = FileListItem(fileArr);
            evt.preventDefault();
        });

        function FileListItem(file){
            file = [].slice.call(Array.isArray(file) ? file : arguments)
<<<<<<< HEAD
            for(var c, b = c = file.length, d = !0; b-- && d;) d = file[b] instanceof File
            if(!d) throw new TypeError("expected argument to FileList is File or array of File objects")
            for(b = (new ClipboardEvent("")).clipboardData || new DataTransfer; c--;) b.items.add(file[c])
=======
            for (var c, b = c = file.length, d = !0; b-- && d;) d = file[b] instanceof File
            if (!d) throw new TypeError("expected argument to FileList is File or array of File objects")
            for (b = (new ClipboardEvent("")).clipboardData || new DataTransfer; c--;) b.items.add(file[c])
>>>>>>> main
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

        // Save holiday
        $('body').delegate('#holidayForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');

<<<<<<< HEAD
            if($('#holidayForm').parsley().isValid()){
=======
            if ($('#holidayForm').parsley().isValid()){
>>>>>>> main

                $.ajax({
                    url:"/holiday",
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
                                    // window.location.reload();
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

