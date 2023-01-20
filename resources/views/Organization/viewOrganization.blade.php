<?php
use Carbon\Carbon;
?>
@php

@endphp

@extends('layouts.master')

@section('content')
<div class="wrapper">
    @include('ETPLSliderbar/sliderbar')
    <div class="main-panel">
        @include('ETPLSliderbar/navigation')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">school</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Organization Details</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Address</label>
                                            <input type="text" class="form-control" value ="{{$organization->address}}" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">PIN Code</label>
                                            <input type="text" class="form-control" value ="{{$organization->pincode}}" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Post Office</label>
                                            <input type="text" class="form-control" value ="{{$organization->post_office}}" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">City</label>
                                            <input type="text"  class="form-control" value="{{$organization->city}}" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Taluk</label>
                                            <input type="text" class="form-control" value="{{$organization->taluk}}"  disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">District</label>
                                            <input type="text" class="form-control" value="{{$organization->district}}" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">State</label>
                                            <input type="text" class="form-control" value="{{$organization->state}}" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Country</label>
                                            <input class="form-control" value ="{{$organization->country}}" disabled>
                                        </div>
                                    </div>
                                </div>

                                <h5 class="viewStaff">Office Details</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Email Id</label>
                                            <input type="text" class="form-control" style="text-transform: capitalize;" value ="{{$organization->office_email}}" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Mobile Phone</label>
                                            <input type="text" class="form-control" value="{{$organization->mobile_number}}" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Landline with Area Code</label>
                                            <input type="text" class="form-control" style="text-transform: capitalize;" value="{{$organization->landline_number}}" disabled>
                                        </div>
                                    </div>
                                </div>

                                <h5 class="viewStaff">Management Details</h5>
                                @foreach($organizationManagement as $index => $data)
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Name</label>
                                                <input type="text" class="form-control" value="{{$data->name}}" disabled>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Designation</label>
                                                <input type="text" class="form-control" value="{{$data->designation_name}}" disabled>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Phone No</label>
                                                <input type="text" class="form-control" style="text-transform: capitalize;" value="{{$data->mobile_number}}" disabled>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Email ID</label>
                                                <input type="text" class="form-control" value="{{$data->email}}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <h5 class="viewStaff">POC (Person Of Contact)</h5>
                                <div class="row mt-10">
                                    <div class="col-lg-12 form-group col-lg-offset-0">
                                        <p class="mb-4 fw-400">Level 1</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Name</label>
                                            <input type="text" class="form-control" value="{{$organization->poc_name1}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Designation</label>
                                            <input type="text" class="form-control" value="{{$organization->poc_designation_name1}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Phone No</label>
                                            <input type="text" class="form-control" value="{{$organization->poc_contact_number1}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Email ID</label>
                                            <input type="text" class="form-control" value="{{$organization->poc_email1}}" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 form-group col-lg-offset-0">
                                        <p class="mb-4 fw-400">Level 2</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Name</label>
                                            <input type="text" class="form-control" value="{{$organization->poc_name2}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Designation</label>
                                            <input type="text" class="form-control" value="{{$organization->poc_designation_name2}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Phone No</label>
                                            <input type="text" class="form-control" value="{{$organization->poc_contact_number2}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Email ID</label>
                                            <input type="text" class="form-control" value="{{$organization->poc_email2}}" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 form-group col-lg-offset-0">
                                        <p class="mb-4 fw-400">Level 3</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Name</label>
                                            <input type="text" class="form-control" value="{{$organization->poc_name3}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Designation</label>
                                            <input type="text" class="form-control" value="{{$organization->poc_designation_name3}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Phone No</label>
                                            <input type="text" class="form-control" value="{{$organization->poc_contact_number3}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Email ID</label>
                                            <input type="text" class="form-control" value="{{$organization->poc_email3}}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <!-- <h4 class="card-title"><b>Website Details</b></h4> -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Website URL</label>
                                            <input type="text" class="form-control" value="{{$organization->website_url}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label mt-0">GST Number</label>
                                            <input type="text" class="form-control" value="{{$organization->gst_number}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label mt-0">PAN Number</label>
                                            <input type="text" class="form-control" style="text-transform: capitalize;" value="{{$organization->pan_number}}" disabled>
                                        </div>
                                    </div>
                                </div>

                                <h5 class="viewStaff">Agreement Details</h5>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label">PO Date</label>
                                            <input type="text" class="form-control" value="{{Carbon::createFromFormat('Y-m-d', $organization->po_signed_date)->format('d-m-Y')}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">PO Effective Date</label>
                                            <input type="text" class="form-control" value="{{Carbon::createFromFormat('Y-m-d', $organization->po_effective_date	)->format('d-m-Y')}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label">Contract Period</label>
                                            <input type="text" class="form-control" value="{{$organization->contract_period}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label">PO Expiry Date</label>
                                            <input type="text" class="form-control"  value="{{Carbon::createFromFormat('Y-m-d', $organization->po_expiry_date)->format('d-m-Y')}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Renewal Reminder Date</label>
                                            <input type="text" class="form-control" style="text-transform: capitalize;"  value="{{Carbon::createFromFormat('Y-m-d', $organization->yearly_renewal_period)->format('d-m-Y')}}" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <div class="form-group">
                                            <a href="/etpl/organization/{{$organization->id}}" type="button" rel="tooltip" title="Edit" class="btn btn-success btn-wd mr-5">Edit</a>
                                            <a href="{{ url('/etpl/organization') }}" class="btn btn-fill btn-wd btn btn-danger">Close</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-logo">
                                @if($organization->logo != '')
                                    <img class="img" src="{{url($organization->logo)}}" />
                                @else
                                    <img src="//cdn.egenius.in/img/placeholder.jpg" class="img" />
                                @endif
                            </div>
                            <h4 class="card-name text-center">{{ucwords($organization->name)}}</h4>
                            <div class="card-content border-top text-center">
                                <div class="row">
                                    <div class="col-md-12 mb-10">
                                        <h6 class="view-details">GST File</h6>
                                        @if($organization->gst_attachment != '')
                                            <a href="{{url($organization->gst_attachment)}}" target="_blank"><button class="btn btn-info btn-sm m0">Download&nbsp;<i class="material-icons">file_download</i><div class="ripple-container"></div></button></a>
                                        @else
                                            <span class="badge badge-warning">Not uploaded</span>
                                        @endif
                                    </div>

                                    <div class="col-md-12 mb-10">
                                        <h6 class="view-details">PAN Attachment</h6>
                                        @if($organization->pan_attachment != '')
                                            <a href="{{url($organization->pan_attachment)}}" target="_blank"><button class="btn btn-info btn-sm m0">Download&nbsp;<i class="material-icons">file_download</i><div class="ripple-container"></div></button></a>
                                        @else
                                            <span class="badge badge-warning">Not uploaded</span>
                                        @endif
                                    </div>

                                    <div class="col-md-12 mb-10">
                                        <h6 class="view-details">Registration Certificate</h6>
                                        @if($organization->registration_certificate != '')
                                            <a href="{{url($organization->registration_certificate)}}" target="_blank"><button class="btn btn-info btn-sm m0">Download&nbsp;<i class="material-icons">file_download</i><div class="ripple-container"></div></button></a>
                                        @else
                                            <span class="badge badge-warning">Not uploaded</span>
                                        @endif
                                    </div>

                                    <div class="col-md-12 mb-10">
                                        <h6 class="view-details">MOU/PO Attachment</h6>
                                        @if($organization->po_attachment != '')
                                            <a href="{{url($organization->po_attachment)}}" target="_blank"><button class="btn btn-info btn-sm m0">Download&nbsp;<i class="material-icons">file_download</i><div class="ripple-container"></div></button></a>
                                        @else
                                            <span class="badge badge-warning">Not uploaded</span>
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

</script>
@endsection
