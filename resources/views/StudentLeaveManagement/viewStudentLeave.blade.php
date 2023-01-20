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
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">query_builder</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Leave Application Details</h4>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Title</label>
                                            <input type="text" class="form-control" value="{{ ucwords($selectedData['applicationData']->title) }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Student</label>
                                            <input type="text" class="form-control" value="{{ ucwords($selectedData['studentName']) }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="control-label mt-0">From Date</label>
                                            <input type="text" class="form-control" value="{{ $selectedData['applicationData']->fromDate }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="control-label mt-0">To Date</label>
                                            <input type="text" class="form-control" value="{{ $selectedData['applicationData']->toDate }}" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="control-label">Application Details<span class="text-danger">*</span></label>
                                        <div class="form-group">
                                            <textarea class="ckeditor" name="leaveDetail" rows="5" disabled>{{ $selectedData['applicationData']->leave_detail }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Leave Status</label>
                                            <input type="text" class="form-control" value="{{ $selectedData['applicationData']->leave_status }}" disabled />
                                        </div>
                                    </div>
                                </div>

                                @if($selectedData['applicationData']->leave_status == 'REJECT')
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="control-label form-group">Reason of Rejection</label>
                                                <textarea class="form-control" rows="3" disabled>{{ $selectedData['applicationData']->rejected_reason }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="pull-right">
                                            @if(Helper::checkAccess('leave', 'edit'))
                                                <a href="/leave-management/{{ $selectedData['applicationData']->id }}" type="button" class="btn btn-success btn-wd mr-5">Edit</a>
                                            @endif
                                            <a href="{{ url('leave-management') }}" class="btn btn-danger btn-wd">Close</a>
                                        </div>
                                    </div>
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
                                {{-- <div class="text-center">
                                    @if(count($selectedData['applicationAttachment']) > 0)
                                        <a href="/leave-management-download/{{$selectedData['applicationData']->id}}" class="btn btn-info btn-sm"><i class="material-icons">file_download</i> Download</a>
                                    @else
                                        <span class="badge badge-warning">No attachment found</span>
                                    @endif
                                </div> --}}

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            @if(count($selectedData['applicationAttachment']) > 0)
                                                @foreach($selectedData['applicationAttachment'] as $key => $attachment)
                                                    @if($attachment['extension'] =="pdf")
                                                        <div class="img_div" id="img_div">
                                                            <img src="https://cdn-icons-png.flaticon.com/512/337/337946.png" class="multiple_image img-responsive" title="">
                                                            <div class="middle_div">
                                                                <button id="action-icon" value="" class="btn btn-danger btn-xs remove_button" role="" data-id="{{ $attachment['id'] }}"><i class="material-icons">delete</i></button>
                                                            </div>
                                                        </div>
                                                    @elseif($attachment['extension'] == "doc" || $attachment['extension'] == "docx")
                                                        <div class="img_div" id="img_div">
                                                            <img src="https://cdn-icons-png.flaticon.com/512/337/337932.png" class="multiple_image img-responsive" title="">
                                                            <div class="middle_div">
                                                                <button id="action-icon" value="" class="btn btn-danger btn-xs remove_button" role="" data-id="{{ $attachment['id'] }}"><i class="material-icons">delete</i></button>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="img_div" id="img_div">
                                                            <img src="{{ $attachment['file_url'] }}" class="multiple_image img-responsive" title="">
                                                            <div class="middle_div">
                                                                <button id="action-icon" value="" class="btn btn-danger btn-xs remove_button" role="" data-id="{{ $attachment['id'] }}"><i class="material-icons">delete</i></button>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @else
                                                <div class="text-center">
                                                    <span class="badge badge-warning">No attachment found</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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

        // Delete leave application
        $('body').delegate(".remove_button", "click", function(event){
            event.preventDefault();

            var applicationId = $(this).attr('data-id'); //alert(applicationId);

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
                    url:"{{url('/leave-management-remove')}}",
                    type:"post",
                    dataType:"json",
                    data: {applicationId:applicationId},
                    success:function(result){

                        if(result['status'] == "200"){

                            if(result.data['signal'] == "success"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function() {
                                    window.location.reload();
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
    });
</script>
@endsection


