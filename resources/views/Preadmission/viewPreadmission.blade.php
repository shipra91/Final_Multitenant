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
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">face</i>
                            </div>
                            <div class="card-content">
                                <div class="back back1" style="float:right;">
                                    <button onclick="window.history.go(-1)" class="btn btn-info"><i class="material-icons">arrow_back</i></button>
                                </div>

                                <h4 class="card-title">View Student Details</h4>

                                <div class="row">
									<div class="col-lg-12">
										<h5 class="viewStaff-firstChild">Basic Details</h5>
									</div>
								</div>

                                <div class="row">
                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Application No</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->application_number}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Date Of Birth</label>
                                            <input type="text" class="form-control" value ="{{Carbon::createFromFormat('Y-m-d', $preadmissionDetails->date_of_birth)->format('d-m-Y')}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Age</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->current_age}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Gender</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->gender}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Standard</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->standard}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Mother Tongue</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->mother_tongue}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Student Aadhaar No</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->student_aadhaar_number}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Caste</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->caste}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Caste Category</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->caste_category}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Blood Group</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->blood_group}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Nationality</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->nationality}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Religion</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->religion}}" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5 class="viewStaff">Address and Contact Details</h5>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">City</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->city}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">State</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->state}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Taluk</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->taluk}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Pincode</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->pincode}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Post Office</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->post_office}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-9 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Adress</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->address}}" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5 class="viewStaff">Father Details</h5>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Name</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->father_name}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Mobile Number</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->father_mobile_number}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Aadhaar Number</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->father_aadhaar_number}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Education</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->father_education}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Profession</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->father_profession}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Email-ID</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->father_email}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Annual Income</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->father_annual_income}}" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5 class="viewStaff">Mother Details</h5>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Name</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->mother_name}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Mobile Number</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->mother_mobile_number}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Aadhaar Number</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->mother_aadhaar_number}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Education</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->mother_education}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Profession</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->mother_profession}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Email-ID</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->mother_email}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Annual Income</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->mother_annual_income}}" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5 class="viewStaff">Guardian Details</h5>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Name</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->guardian_name}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Mobile Number</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->guardian_contact_no}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Aadhaar Number</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->guardian_aadhaar_no}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Email-ID</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->guardian_email}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Relation With Guardian</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->guardian_relation}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-9 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Address</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->guardian_address}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">SMS Sent For</label>
                                            <input type="text" class="form-control" value ="{{$preadmissionDetails->sms_for}}" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5 class="viewStaff">Other Details</h5>
                                    </div>
                                </div>

                                <div class="row" id="other">
                                    @foreach($customFieldDetails as $custom)
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">{{$custom->custom_field_name}}</label>
                                                <input type="text" class="form-control" value="{{$custom->field_value}}" disabled>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="row">
                                    <div class="col-lg-12" style="text-align:right;">
                                        @if($preadmissionDetails->application_status == 'PENDING' || $preadmissionDetails->application_status == 'CORRECTION_REQUEST' )
                                            {{-- <button type="button" class="btn btn-fill btn-info pull-center btn-sm" data-toggle="modal" data-target="#approve_application" value="Approve"><i class="material-icons">check_circle_outline</i> Approve</button>

                                            <button type="button" class="btn btn-fill btn-info pull-center btn-sm" data-toggle="modal" data-target="#reject_application" value="Reject"><i class="material-icons">highlight_off</i> Reject</button>

                                            <button type="button" class="btn btn-fill btn-info pull-center btn-sm" data-toggle="modal" data-target="#correction_application" value="Correction Needed"><i class="material-icons">info_outline</i> Correction request</button> --}}

                                            <a href="/preadmission/{{$preadmissionDetails->id}}" type="button" rel="tooltip" title="Edit" class="btn btn-success btn-sm"><i class="material-icons">edit</i></a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-profile">
                            <div class="card-logo">
                                @if($preadmissionDetails->attachment_student_photo != '')
                                    <img class="img" src="{{url($preadmissionDetails->attachment_student_photo)}}" />
                                @else
                                    <img src="//cdn.egenius.in/img/placeholder.jpg" class="img" />
                                @endif
                            </div>

                            <h4 class="card-name">{{ucwords($preadmissionDetails->name)}}</h4>

                            <div class="card-content border-top">
                                <div class="row">
                                    <div class="col-md-12 mb-10">
                                        <h6 class="view-details">Student Aadhaar Card</h6>
                                        @if($preadmissionDetails->attachment_student_aadhaar != '')
                                            <a href="{{url($preadmissionDetails->attachment_student_aadhaar)}}" target="_blank"><button class="btn btn-info btn-sm m0">Download&nbsp;<i class="material-icons">file_download</i><div class="ripple-container"></div></button></a>
                                        @else
                                            <span class="badge badge-warning">Not uploaded</span>
                                        @endif
                                    </div>

                                    <div class="col-md-12 mb-10">
                                        <h6 class="view-details">Father Aadhaar Card</h6>
                                        @if($preadmissionDetails->attachment_father_aadhaar != '')
                                            <a href="{{url($preadmissionDetails->attachment_father_aadhaar)}}" target="_blank"><button class="btn btn-info btn-sm m0">Download&nbsp;<i class="material-icons">file_download</i><div class="ripple-container"></div></button></a>
                                        @else
                                            <span class="badge badge-warning">Not uploaded</span>
                                        @endif
                                    </div>

                                    <div class="col-md-12 mb-10">
                                        <h6 class="view-details">Mother Aadhaar Card</h6>
                                        @if($preadmissionDetails->attachment_mother_aadhaar != '')
                                            <a href="{{url($preadmissionDetails->attachment_mother_aadhaar)}}" target="_blank"><button class="btn btn-info btn-sm m0">Download&nbsp;<i class="material-icons">file_download</i><div class="ripple-container"></div></button></a>
                                        @else
                                            <span class="badge badge-warning">Not uploaded</span>
                                        @endif
                                    </div>

                                    <div class="col-md-12 mb-10">
                                        <h6 class="view-details">Father PAN Card</h6>
                                        @if($preadmissionDetails->attachment_father_pancard != '')
                                            <a href="{{url($preadmissionDetails->attachment_father_pancard)}}" target="_blank"><button class="btn btn-info btn-sm m0">Download&nbsp;<i class="material-icons">file_download</i><div class="ripple-container"></div></button></a>
                                        @else
                                            <span class="badge badge-warning">Not uploaded</span>
                                        @endif
                                    </div>

                                    <div class="col-md-12 mb-10">
                                        <h6 class="view-details">Mother PAN Card</h6>
                                        @if($preadmissionDetails->attachment_mother_pancard != '')
                                            <a href="{{url($preadmissionDetails->attachment_mother_pancard)}}" target="_blank"><button class="btn btn-info btn-sm m0">Download&nbsp;<i class="material-icons">file_download</i><div class="ripple-container"></div></button></a>
                                        @else
                                            <span class="badge badge-warning">Not uploaded</span>
                                        @endif
                                    </div>

                                    <div class="col-md-12 mb-10">
                                        <h6 class="view-details">Prevoius TC</h6>
                                        @if($preadmissionDetails->attachment_previous_tc != '')
                                            <a href="{{url($preadmissionDetails->attachment_previous_tc)}}" target="_blank"><button class="btn btn-info btn-sm m0">Download&nbsp;<i class="material-icons">file_download</i><div class="ripple-container"></div></button></a>
                                        @else
                                            <span class="badge badge-warning">Not uploaded</span>
                                        @endif
                                    </div>

                                    <div class="col-md-12 mb-10">
                                        <h6 class="view-details">Prevoius Study Certificate</h6>
                                        @if($preadmissionDetails->attachment_previous_study_certificate != '')
                                            <a href="{{url($preadmissionDetails->attachment_previous_study_certificate)}}" target="_blank"><button class="btn btn-info btn-sm m0">Download&nbsp;<i class="material-icons">file_download</i><div class="ripple-container"></div></button></a>
                                        @else
                                            <span class="badge badge-warning">Not uploaded</span>
                                        @endif
                                    </div>

                                    @foreach($customFileDetails as $fileValue)
                                        <div class="col-md-12 mb-10">
                                            <h6 class="view-details">{{$fileValue->custom_field_name}}</h6>
                                            @if($fileValue->field_value != 'NULL' && $fileValue->field_value != '')
                                                <a href="{{$fileValue->field_value}}" target="_blank"><button class="btn btn-info btn-sm m0" >Download&nbsp;<i class="material-icons">file_download</i><div class="ripple-container"></div></button></a>
                                            @else
                                                <span class="badge badge-warning">Not uploaded</span>
                                            @endif
                                        </div>
                                    @endforeach
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
