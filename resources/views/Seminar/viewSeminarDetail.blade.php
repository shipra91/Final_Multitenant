
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
                            <i class="material-icons">school</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">Seminar Details</h4>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label mt-0">Seminar Topic</label>
                                        <input type="text" class="form-control" value="{{ $seminarDetails['seminarData']->seminar_topic }}" disabled />
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label mt-0">Start Date</label>
                                        <input type="text" class="form-control" value="{{ $seminarDetails['seminarData']->start_date }}" disabled />
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label mt-0">End Date</label>
                                        <input type="text" class="form-control" value="{{ $seminarDetails['seminarData']->end_date }}" disabled />
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label mt-0">Start Time</label>
                                        <input type="text" class="form-control" value="{{ $seminarDetails['seminarData']->start_time }}" disabled />
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label mt-0">End Time</label>
                                        <input type="text" class="form-control" value="{{ $seminarDetails['seminarData']->end_time }}" disabled />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <label class="control-label">Seminar Details</label>
                                    <div class="form-group">
                                        <textarea class="ckeditor" name="eventDetails" rows="5" disabled>{{ $seminarDetails['seminarData']->description }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label mt-0">Max Marks</label>
                                        <input type="text" class="form-control" value="{{ $seminarDetails['seminarData']->max_marks }}" disabled />
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label mt-0">SMS alert to recipients required</label>
                                        <input type="text" class="form-control" value="{{ $seminarDetails['seminarData']->sms_alert }}" disabled />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    @if($seminarDetails['studentStaffData'])
                                        <div class="row mt-10">
                                            <div class="col-lg-12">
                                                <h4 class="card-title mb-0 font-15">Conducted By</h4>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <ol type="1" class="pl-15">
                                                    @foreach($seminarDetails['studentStaffData'] as $index => $conductedBy)
                                                        <li class="applicableToDetail">{{ $conductedBy->name }}</li>
                                                    @endforeach
                                                </ol>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-lg-6">
                                    @if($seminarDetails['mentors'])
                                        <div class="row mt-10">
                                            <div class="col-lg-12">
                                                <h4 class="card-title mb-0 font-15">Mentored By</h4>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <ol type="1" class="pl-15">
                                                    @foreach($seminarDetails['mentors'] as $index => $mentoredBy)
                                                        <li class="applicableToDetail">{{ $mentoredBy }}</li>
                                                    @endforeach
                                                </ol>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    @if($seminarDetails['recipientTypes'])
                                        <div class="row mt-10">
                                            <div class="col-lg-12">
                                                <h4 class="card-title mb-0 font-15">Invities</h4>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <ol type="1" class="pl-15">
                                                    @foreach($seminarDetails['recipientTypes'] as $index => $recipientType)
                                                        <li class="applicableToDetail">{{ $recipientType }}</li>
                                                    @endforeach
                                                </ol>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                @foreach($seminarDetails['recipientTypes'] as $index => $recipientType)
                                    @if($recipientType == 'STUDENT')
                                        <div class="col-lg-6">
                                            <h4 class="card-title mb-0 font-15">Standard</h4>
                                            <ol type="1" class="pl-15">
                                                @foreach($seminarDetails['standardDetails'] as $index => $standard)
                                                    <li class="applicableToDetail">{{ $standard }}</li>
                                                @endforeach
                                            </ol>
                                        </div>

                                        <div class="col-lg-6">
                                            <h4 class="card-title mb-0 font-15">Subject</h4>
                                            <ol type="1" class="pl-15">
                                                @foreach($seminarDetails['subjectDetails'] as $index => $subject)
                                                    <li class="applicableToDetail">{{ $subject }}</li>
                                                @endforeach
                                            </ol>
                                        </div>
                                    @endif

                                    @if($recipientType == 'STAFF')
                                        <div class="col-lg-6">
                                            <h4 class="card-title mb-0 font-15">Category</h4>
                                            <ol type="1" class="pl-15">
                                                @foreach($seminarDetails['categoryDetails'] as $index => $category)
                                                    <li class="applicableToDetail">{{ $category }}</li>
                                                @endforeach
                                            </ol>
                                        </div>

                                        <div class="col-lg-6">
                                            <h4 class="card-title mb-0 font-15">SubCategory</h4>
                                            <ol type="1" class="pl-15">
                                                @foreach($seminarDetails['subCategoryDetails'] as $index => $subCategory)
                                                    <li class="applicableToDetail">{{ $subCategory }}</li>
                                                @endforeach
                                            </ol>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-right">
                                        @if(Helper::checkAccess('seminar', 'edit'))
                                            <a href="/seminar/{{$seminarDetails['seminarData']->id}}" type="button" class="btn btn-success btn-wd mr-5">Edit</a>
                                        @endif
                                        <a href="{{ url('seminar') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
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
                                        @if(count($seminarDetails['seminarAttachment']) > 0)
                                            @foreach($seminarDetails['seminarAttachment'] as $key => $attachment)
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

        var seminarId = $(this).attr('data-id'); //alert(seminarId);

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
                url:"{{url('/seminar-remove')}}",
                type:"post",
                dataType:"json",
                data: {seminarId:seminarId},
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


