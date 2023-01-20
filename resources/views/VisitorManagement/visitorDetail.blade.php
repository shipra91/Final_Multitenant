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
                    <div class="col-sm-12 col-sm-offset-0 text-right">
                        <a href="{{url('visitor')}}" class="btn btn-finish btn-fill btn-wd btn btn-info"><i class="material-icons">arrow_back</i> Back</a>
                    </div>
                </div>
                <div class="row">
                    <form method="POST" class="demo-form" id="visitorForm">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">face</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Visit Details</h4>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h5 class="viewStaff-firstChild">Visitor Detail</h5>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Visit Type</label>
                                                <input type="text" class="form-control" value="{{ $visitorData->type }}" disabled/>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Full Name</label>
                                                <input type="text" class="form-control" name="full_name" value="{{ $visitorData->visitor_name }}" disabled/>
                                            </div>
                                        </div>

                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Gender</label>
                                                <input type="text" class="form-control" name="full_name" value="{{ $visitorData->gender }}" disabled/>
                                            </div>
                                        </div>

                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Phone</label>
                                                <input type="text" class="form-control" name="visitor_phone" value="{{ $visitorData->visitor_contact }}" disabled/>
                                            </div>
                                        </div>

                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Age</label>
                                                <input type="text" class="form-control" name="visitor_age" value="{{ $visitorData->visitor_age }}" disabled/>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Address</label>
                                                <textarea class="form-control" name="visitor_address" disabled>{{ $visitorData->visitor_address }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h5 class="viewStaff">Meeting Detail</h5>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Person To Meet</label>
                                                <input type="text" class="form-control" name="full_name" value="{{ $visitorData->person_to_meet }}" disabled/>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 @if($visitorData->person_to_meet !== 'OTHERS') {{ 'd-none' }} @endif" id="otherPersonDiv">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Other Person Name</label>
                                                <input type="text" class="form-control" name="other_person" id="other_person" value="{{ $visitorData->concerned_person }}" autocomplete="off" />
                                                <input type="hidden" name="visitorId" id="visitorId" value="{{ $visitorData->id }}"/>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Purpose of visit</label>
                                                <input type="text" class="form-control" name="visit_purpose" disabled  value="{{ $visitorData->visit_purpose }}" autocomplete="off" />
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Visitor Type <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="full_name" value="{{ $visitorData->visitor_type }}" disabled/>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 @if($visitorData->visitor_type !== 'OTHERS') {{ 'd-none' }} @endif" id="otherTypeDiv">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Other Type <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="other_type" id="other_type" value="{{ $visitorData->visitor_type_name }}" autocomplete="off" />
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Meeting Date & Time<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datetimepicker" name="meeting_date" data-parsley-trigger="change" value="{{ $visitorData->startTime }}" disabled autocomplete="off" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
