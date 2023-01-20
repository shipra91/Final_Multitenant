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
                    <form method="POST" id="galleryForm">
                        <input type="hidden" name="galleryId" id="galleryId" value="{{$selectedData['galleryData']->id}}">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">photo</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Edit Gallery</h4>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="control-label">Gallery Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="galleryName" value="{{$selectedData['galleryData']->title}}" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="control-label">Date<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker" name="galleryDate" value="{{$selectedData['galleryData']->date}}" required />
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="control-label form-group">Gallery Details</label>
                                                <textarea class="ckeditor" name="galleryDetails" rows="5">{{$selectedData['galleryData']->description}}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label class="control-label">Upload Cover Image</label>
                                            <div class="form-group">
                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail">
                                                        @if($selectedData['galleryData']->cover_image != "")
                                                            <img class="img" src="{{$selectedData['galleryData']->cover_image}}"
                                                            alt="Image" />
                                                        @else
                                                            <img class="img" src="https://cdn.egenius.in/img/placeholder.jpg"
                                                            alt="Image" />
                                                        @endif
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                    <div>
                                                        <span class="btn btn-square btn-info btn-file btn-sm">
                                                            <span class="fileinput-new">Select file</span>
                                                            <span class="fileinput-exists">Change</span>
                                                            <input type="file" name="coverImage" accept="image/*" />
                                                            <input type="hidden" name="oldCoverImage" value="{{$selectedData['galleryData']->cover_image}}" />
                                                        </span>
                                                        <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="material-icons">highlight_off</i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label class="control-label">Gallery Image</label>
                                            <div class="form-group">
                                                <div class="get_image_preview mt-10">
                                                    <ul>
                                                        @foreach($selectedData['galleryAttachment'] as $attachment)
                                                            @if($attachment)
                                                                <li>
                                                                    <a href="{{ $attachment['file_url'] }}" data-toggle="lightbox" data-gallery="example-gallery">
                                                                        <img src="{{ $attachment['file_url'] }}" class="rounded">
                                                                    </a>
                                                                    <div class="remove_button" data-id="{{ $attachment['id'] }}">
                                                                        <i class="material-icons remove-button-icon">close</i>
                                                                    </div>
                                                                </li>
                                                                @else
                                                            <img src="https://cdn.egenius.in/img/placeholder.jpg" class="rounded">
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-20">
                                        <div class="col-lg-12">
                                            <h4 class="card-title">Audience</h4>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group checkbox">
                                                <label><input type="checkbox" name="audience_type[]" id="staffType" value="STAFF" @if(in_array("STAFF", $selectedData['audienceType'])) {{"checked"}} @endif />Staff</label>
                                            </div>
                                        </div>

                                        <div id="staffDiv" @if(!in_array("STAFF", $selectedData['audienceType'])) {{ 'style="display:none"'; }} @endif>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="control-label">Staff Category</label>
                                                    <select class="selectpicker" name="staffCategory[]" id="staffCategory" data-style="select-with-transition" data-live-search="true" title="Select" data-selected-text-format="count > 1" multiple data-actions-box="true">
                                                        @foreach($gallerydata['staffCategory'] as $staffCategory)
                                                            <option value="{{$staffCategory->id}}" @if(in_array($staffCategory->id, $selectedData['selectedStaffCategory'])) {{"selected"}} @endif>{{ucwords($staffCategory->name)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="control-label">Staff Subcategory</label>
                                                    <select class="selectpicker" name="staffSubcategory[]" id="staffSubcategory" data-style="select-with-transition" data-live-search="true" title="Select" data-selected-text-format="count > 1" multiple data-actions-box="true">
                                                        @foreach($gallerydata['staffSubcategory'] as $staffSubcategory)
                                                            <option value="{{$staffSubcategory->id}}" @if(in_array($staffSubcategory->id, $selectedData['selectedStaffSubCategory'])) {{"selected"}} @endif>{{ucwords($staffSubcategory->name)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group checkbox">
                                                <label><input type="checkbox" name="audience_type[]" id="studentType" value="STUDENT" @if(in_array("STUDENT", $selectedData['audienceType'])) {{ "checked" }} @endif />Student</label>
                                            </div>
                                        </div>

                                        <div id="studentDiv" @if(!in_array("STUDENT", $selectedData['audienceType'])) {{ 'style="display:none"'; }} @endif>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="control-label">Standard</label>
                                                    <select class="selectpicker" name="standard[]" id="standard" data-style="select-with-transition" data-live-search="true" data-size="5" title="Select" data-selected-text-format="count > 1" multiple data-actions-box="true" data-container="body">
                                                        @foreach($gallerydata['institutionStandards'] as $standard)
                                                            <option value="{{$standard['institutionStandard_id']}}" @if(in_array($standard['institutionStandard_id'], $selectedData['selectedStandards'])) {{"selected"}} @endif>{{$standard['class']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Update</button>
                                        <a href="{{ url('gallery') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
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
                                    <h4 class="card-title">Upload Gallery Image</h4>
                                    <div class="text-center">
                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                            <span class="btn btn-square btn-info btn-file btn-sm">
                                                <span class="fileinput-new">Add</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="galleryImg[]" id="galleryImg" accept="image/*" multiple />
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

        $(document).on('click', '[data-toggle="lightbox"]', function(event){
            event.preventDefault();
            $(this).ekkoLightbox();
        });

        // Multiple image upload with preview
        var fileArr = [];
        $("#galleryImg").change(function(){

            // check if fileArr length is greater than 0
            if (fileArr.length > 0) fileArr = [];

            $('#image_preview').html("");
            var total_file = document.getElementById("galleryImg").files;
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

            document.getElementById('galleryImg').files = FileListItem(fileArr);
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

        // Delete gallery
        $('body').delegate(".remove_button", "click", function(event){
            event.preventDefault();

            var parent = $(this).parents('li');
            var galleryImageId = $(this).attr('data-id');//alert(galleryImageId);

            swal({
				title: 'Are you sure?',
				type: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Yes, delete it!',
				cancelButtonText: 'No,Cancel',
				confirmButtonClass: "btn btn-success",
				cancelButtonClass: "btn btn-danger",
				buttonsStyling: false
			}).then(function(){
                $.ajax({
                    url:"{{url('/gallery-image-remove')}}",
                    type:"post",
                    dataType:"json",
                    data: {galleryImageId:galleryImageId},
                    success:function(result){
                        if(result['status'] == "200"){

                            if(result.data['signal'] == "success"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function() {
                                    parent.fadeOut();
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
            },function(dismiss){
				// dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
				if (dismiss === 'cancel'){
					swal({
						title: 'Cancelled',
						type: 'error',
						confirmButtonClass: "btn btn-info",
						buttonsStyling: false
					}).then(function(){
					    //location.reload();
				    }).catch(swal.noop)
				}
			})
        });

        $("#galleryForm").parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Update gallery
        $('body').delegate('#galleryForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');
            var id = $("#galleryId").val();

            if ($('#galleryForm').parsley().isValid()){

                $.ajax({
                    url:"/gallery/"+id,
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
                                    window.location.reload();
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

