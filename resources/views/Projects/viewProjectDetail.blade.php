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
                                <i class="material-icons">assignment</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Project Details</h4>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Standard</label>
                                            <input type="text" class="form-control" value="{{ $project['className'] }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Subject</label>
                                            <input type="text" class="form-control" value="{{ $project['subjectName'] }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Teacher</label>
                                            <input type="text" class="form-control" value="{{ $project['staffName'] }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Chapter Name</label>
                                            <input type="text" class="form-control" value="{{ $project['projectData']->chapter_name }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Project Name</label>
                                            <input type="text" class="form-control" value="{{ $project['projectData']->name }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Start Date</label>
                                            <input type="text" class="form-control" value="{{ Carbon::createFromFormat('Y-m-d', $project['projectData']->start_date)->format('d/m/Y') }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label mt-0">End Date</label>
                                            <input type="text" class="form-control" value="{{ Carbon::createFromFormat('Y-m-d', $project['projectData']->end_date)->format('d/m/Y') }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Start Time</label>
                                            <input type="text" class="form-control" value="{{ $project['projectData']->start_time }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label mt-0">End Time</label>
                                            <input type="text" class="form-control" value="{{ $project['projectData']->end_time }}" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="control-label">Project Details</label>
                                        <div class="form-group">
                                            <textarea class="ckeditor" name="eventDetails" rows="5" disabled>{{ $project['projectData']->description }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Submission Type</label>
                                            <input type="text" class="form-control" value="{{ $project['projectData']->submission_type }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Grading Required?</label>
                                            <input type="text" class="form-control" value="{{ $project['projectData']->grading_required }}" disabled />
                                        </div>
                                    </div>
                                </div>

                                @if($project['projectData']->grading_required == 'YES')
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Grading Options</label>
                                                <input type="text" class="form-control" value="{{ $project['projectData']->grading_option }}" disabled />
                                            </div>
                                        </div>

                                        @if ($project['projectData']->grading_option == 'GRADE')
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Grade</label>
                                                    <input type="text" class="form-control" value="{{ $project['projectData']->grade }}" disabled />
                                                </div>
                                            </div>
                                        @elseif ($project['projectData']->grading_option == 'MARKS')
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Marks</label>
                                                    <input type="text" class="form-control" value="{{ $project['projectData']->marks }}" disabled />
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Read receipt from recipients required?</label>
                                            <input type="text" class="form-control" value="{{ $project['projectData']->read_receipt }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label mt-0">SMS alert to recipients required?(cost may apply)</label>
                                            <input type="text" class="form-control" value="{{ $project['projectData']->sms_alert }}" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-10">
                                    <div class="col-lg-12">
                                        <div class="alert alert-danger" role="alert">
                                            <strong>Submit Before: {{ Carbon::createFromFormat('Y-m-d', $project['projectData']->end_date)->format('d/m/Y') }} - {{ $project['projectData']->end_time }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="pull-right">
                                            @if(Helper::checkAccess('project', 'edit'))
                                                <a href="/project/{{$project['projectData']->id}}" type="button" class="btn btn-success btn-wd mr-5">Edit</a>
                                            @endif
                                            <a href="{{ url('project') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
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
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            @if(count($project['projectAttachment']) > 0)
                                                @foreach($project['projectAttachment'] as $key => $attachment)
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

        // Delete project
        $('body').delegate(".remove_button", "click", function(event){
            event.preventDefault();

            var projectId = $(this).attr('data-id'); //alert(projectId);

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
                    url:"{{url('/project-remove')}}",
                    type:"post",
                    dataType:"json",
                    data: {projectId:projectId},
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


