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
                                            <input type="text" class="form-control" value="{{ucwords($selectedData['applicationData']->title)}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="control-label">Student</label>
                                            <input type="text" class="form-control" value="{{ucwords($selectedData['students']->name)}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="control-label">From Date</label>
                                            <input type="text" class="form-control" value="{{$selectedData['applicationData']->fromDate}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="control-label">To Date</label>
                                            <input type="text" class="form-control" value="{{$selectedData['applicationData']->toDate}}" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="control-label form-group">Application Details</label>
                                            <textarea class="ckeditor" name="leaveDetail" rows="5" disabled>{{$selectedData['applicationData']->leave_detail}}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="control-label form-group">Leave Status</label>
                                            <input type="text" class="form-control" value="{{$selectedData['applicationData']->leave_status}}" disabled />
                                        </div>
                                    </div>
                                </div>

                                @if ($selectedData['applicationData']->leave_status == 'REJECT')
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="control-label form-group">Reason of Rejection</label>
                                                <textarea class="form-control" rows="3" disabled>{{$selectedData['applicationData']->rejected_reason}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="pull-right">
                                            <a href="/leave-management/{{$selectedData['applicationData']->id}}" type="button" rel="tooltip" title="Edit" class="btn btn-success btn-wd mr-5">Edit</a>
                                            <a href="{{ url('leave-management') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
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
                                <div class="text-center">
                                    @if(count($selectedData['applicationAttachment']) > 0)
                                        <a href="/leave-management-download/{{$selectedData['applicationData']->id}}" class="btn btn-info btn-sm"><i class="material-icons">file_download</i> Download</a>
                                    @else
                                        <span class="badge badge-warning">No attachment found</span>
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
@endsection

@section('script-content')
<script>
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
</script>
@endsection


