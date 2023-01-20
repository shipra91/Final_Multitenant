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
                                <i class="material-icons">event</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Event Details</h4>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Event Name</label>
                                            <input type="text" class="form-control" value="{{$selectedData['eventData']->name}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label">Start Date</label>
                                            <input type="text" class="form-control" value="{{$selectedData['eventData']->startDate}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label">End Date</label>
                                            <input type="text" class="form-control" value="{{$selectedData['eventData']->endDate}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label">Start Time</label>
                                            <input type="text" class="form-control" value="{{$selectedData['eventData']->start_time}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label">End Time</label>
                                            <input type="text" class="form-control" value="{{$selectedData['eventData']->end_time}}" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="control-label form-group">Event Details</label>
                                            <textarea class="ckeditor" name="eventDetails" rows="5" disabled>{{$selectedData['eventData']->event_detail}}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="control-label">Event Type</label>
                                            <input type="text" class="form-control" value="{{$selectedData['eventData']->event_type}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="control-label">Event Attendance Required?</label>
                                            <input type="text" class="form-control" value="{{$selectedData['eventData']->attendance_required}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="control-label">Read Receipt Required?</label>
                                            <input type="text" class="form-control" value="{{$selectedData['eventData']->receipt_required}}" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        @if($selectedData['recepientTypes'])
                                            <div class="row mt-30">
                                                <div class="col-lg-12">
                                                    <h4 class="card-title">Applicable To</h4>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <ol type="1" class="pl-15">
                                                        @foreach($selectedData['recepientTypes'] as $index => $recepient)
                                                            <li class="applicableToDetail">{{ $recepient }}
                                                                @if($recepient === "STAFF")
                                                                    <ol type="i" class="pl-15">
                                                                        @if(count($eventData['staffSubcategory']) > 0)
                                                                            @foreach($eventData['staffSubcategory'] as $staffSubcategory)
                                                                                @if(in_array($staffSubcategory->id, $selectedData['selectedStaffSubCategory']))
                                                                                    <li class="applicableTo_li">{{ ucwords($staffSubcategory->name) }}</li>
                                                                                @endif
                                                                            @endforeach
                                                                        @else
                                                                            @foreach($eventData['staffCategory'] as $staffCategory)
                                                                                @if(in_array($staffCategory->id, $selectedData['selectedStaffCategory']))
                                                                                    <li class="">{{ ucwords($staffCategory->name) }}</li>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    </ol>
                                                                @else
                                                                    <ol type="i" class="pl-15">
                                                                        @foreach($eventData['institutionStandards'] as $standard)
                                                                            @if(in_array($standard['institutionStandard_id'], $selectedData['selectedStandards']))
                                                                                <li class="applicableTo_li">{{ $standard['class'] }}</li>
                                                                            @endif
                                                                        @endforeach
                                                                    </ol>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ol>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="pull-right">
                                            @if(Helper::checkAccess('event', 'edit'))
                                                <a href="/event/{{$selectedData['eventData']->id}}" type="button" class="btn btn-success btn-wd mr-5">Edit</a>
                                            @endif
                                            <a href="{{ url('event') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
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
                                    @if(count($selectedData['eventAttachment']) > 0)
                                        <a href="/event-download/{{$selectedData['eventData']->id}}" class="btn btn-info btn-sm"><i class="material-icons">file_download</i> Download</a>
                                    @else
                                        <span class="badge badge-warning">No attachment found</span>
                                    @endif
                                </div> --}}

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            @if(count($selectedData['eventAttachment']) > 0)
                                                @foreach($selectedData['eventAttachment'] as $key => $attachment)
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

        // Delete event
        $('body').delegate(".remove_button", "click", function(event){
            event.preventDefault();

            var eventId = $(this).attr('data-id'); //alert(eventId);

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
                    url:"{{url('/event-remove')}}",
                    type:"post",
                    dataType:"json",
                    data: {eventId:eventId},
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

