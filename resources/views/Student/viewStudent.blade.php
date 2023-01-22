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
                                <h4 class="card-title">Student Details</h4>
                                <div class="row">
									<div class="col-lg-12">
										<h5 class="viewStaff-firstChild mb-10">Basic Details</h5>
									</div>
								</div>

                                <div class="row">
                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">First Name</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->name }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Middle Name</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->middle_name }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Last Name</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->last_name }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">USN</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->usn }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Standard</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->standard }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">UID</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->egenius_uid }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Date Of Birth</label>
                                            <input type="text" class="form-control" value ="{{Carbon::createFromFormat('Y-m-d', $studentDetails->date_of_birth)->format('d-m-Y')}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Age</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->current_age }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Gender</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->gender }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Register Number</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->register_number }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Roll Number</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->roll_number }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Admission Date</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->admission_date }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Admission Number</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->admission_number }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">First Language</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->first_language }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Second Language</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->second_language }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Third Language</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->third_language }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Elective Subject</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->elective }}" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5 class="viewStaff mb-10">Additional Details</h5>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Mother Tongue</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->mother_tongue }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">SATs Number</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->sats_number }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Student Aadhaar Number</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->student_aadhaar_number }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Nationality</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->nationality }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Religion</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->religion }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Caste</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->caste }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Blood Group</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->blood_group }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Fee Type</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->fee_type }}" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5 class="viewStaff mb-10">Address and Contact Details</h5>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Adress</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->address }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">City</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->city }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Area</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->area }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Taluk</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->taluk }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">State</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->state }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Pincode</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->pincode }}" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5 class="viewStaff mb-10">Father Details</h5>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">First Name</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->father_name }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Middle Name</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->father_middle_name }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Last Name</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->father_last_name }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Mobile Number</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->father_mobile_number }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Aadhaar Number</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->father_aadhaar_number }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Education</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->father_education }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Profession</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->father_profession }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Email-ID</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->father_email }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Annual Income</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->father_annual_income }}" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5 class="viewStaff mb-10">Mother Details</h5>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">First Name</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->mother_name }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Middle Name</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->mother_middle_name }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Last Name</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->mother_last_name }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Mobile Number</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->mother_mobile_number }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Aadhaar Number</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->mother_aadhaar_number }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Education</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->mother_education }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Profession</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->mother_profession }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Email-ID</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->mother_email }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Annual Income</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->mother_annual_income }}" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5 class="viewStaff mb-10">Guardian Details</h5>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">First Name</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->guardian_name }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Middle Name</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->guardian_middle_name }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Last Name</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->guardian_last_name }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Mobile Number</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->guardian_contact_no }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Aadhaar Number</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->guardian_aadhaar_no }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Email-ID</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->guardian_email }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Relation With Guardian</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->guardian_relation }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-9 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Address</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->guardian_address }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label mt-0">SMS Sent For</label>
                                            <input type="text" class="form-control" value ="{{ $studentDetails->sms_for }}" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5 class="viewStaff mb-10">Other Details</h5>
                                    </div>
                                </div>

                                <div class="row" id="other">
                                    @foreach($customFieldDetails as $custom)
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label mt-0">{{$custom->custom_field_name}}</label>
                                                <input type="text" class="form-control" value="{{ $custom->field_value }}" disabled>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="pull-right">
                                            @if(Helper::checkAccess('student', 'edit'))
                                                <a href="/student/{{$studentDetails->id_student}}" type="button" class="btn btn-success btn-wd mr-5">Edit</a>
                                            @endif
                                            <a href="{{ url('all-student') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
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
                                @if($studentDetails->attachment_student_photo != '')
                                    <img class="img" src="{{url($studentDetails->attachment_student_photo)}}" />
                                @else
                                    <img src="//cdn.egenius.in/img/placeholder.jpg" class="img" />
                                @endif
                            </div>

                            {{-- <h4 class="card-name text-center">{{ ucwords($studentDetails->name) . ' ' . ucwords($studentDetails->middle_name) . ' ' . ucwords($studentDetails->last_name) }}</h4> --}}
                            <h4 class="card-name text-center">{{ ucwords($studentDetails['studentName']) }}</h4>

                            <div class="card-content border-top text-center">
                                <div class="row">
                                    <div class="col-md-12 mb-10">
                                        <h6 class="view-details">Student Aadhaar Card</h6>
                                        @if($studentDetails->attachment_student_aadhaar != '')
                                            <a href="{{url($studentDetails->attachment_student_aadhaar)}}" target="_blank"><button class="btn btn-info btn-sm m0">Download&nbsp;<i class="material-icons">file_download</i><div class="ripple-container"></div></button></a>
                                        @else
                                            <span class="badge badge-warning">Not uploaded</span>
                                        @endif
                                    </div>

                                    <div class="col-md-12 mb-10">
                                        <h6 class="view-details">Father Aadhaar Card</h6>
                                        @if($studentDetails->attachment_father_aadhaar != '')
                                            <a href="{{url($studentDetails->attachment_father_aadhaar)}}" target="_blank"><button class="btn btn-info btn-sm m0">Download&nbsp;<i class="material-icons">file_download</i><div class="ripple-container"></div></button></a>
                                        @else
                                            <span class="badge badge-warning">Not uploaded</span>
                                        @endif
                                    </div>

                                    <div class="col-md-12 mb-10">
                                        <h6 class="view-details">Mother Aadhaar Card</h6>
                                        @if($studentDetails->attachment_mother_aadhaar != '')
                                            <a href="{{url($studentDetails->attachment_mother_aadhaar)}}" target="_blank"><button class="btn btn-info btn-sm m0">Download&nbsp;<i class="material-icons">file_download</i><div class="ripple-container"></div></button></a>
                                        @else
                                            <span class="badge badge-warning">Not uploaded</span>
                                        @endif
                                    </div>

                                    <div class="col-md-12 mb-10">
                                        <h6 class="view-details">Father PAN Card</h6>
                                        @if($studentDetails->attachment_father_pancard != '')
                                            <a href="{{url($studentDetails->attachment_father_pancard)}}" target="_blank"><button class="btn btn-info btn-sm m0">Download&nbsp;<i class="material-icons">file_download</i><div class="ripple-container"></div></button></a>
                                        @else
                                            <span class="badge badge-warning">Not uploaded</span>
                                        @endif
                                    </div>

                                    <div class="col-md-12 mb-10">
                                        <h6 class="view-details">Mother PAN Card</h6>
                                        @if($studentDetails->attachment_mother_pancard != '')
                                            <a href="{{url($studentDetails->attachment_mother_pancard)}}" target="_blank"><button class="btn btn-info btn-sm m0">Download&nbsp;<i class="material-icons">file_download</i><div class="ripple-container"></div></button></a>
                                        @else
                                            <span class="badge badge-warning">Not uploaded</span>
                                        @endif
                                    </div>

                                    <div class="col-md-12 mb-10">
                                        <h6 class="view-details">Prevoius TC</h6>
                                        @if($studentDetails->attachment_previous_tc != '')
                                            <a href="{{url($studentDetails->attachment_previous_tc)}}" target="_blank"><button class="btn btn-info btn-sm m0">Download&nbsp;<i class="material-icons">file_download</i><div class="ripple-container"></div></button></a>
                                        @else
                                            <span class="badge badge-warning">Not uploaded</span>
                                        @endif
                                    </div>

                                    <div class="col-md-12 mb-10">
                                        <h6 class="view-details">Prevoius Study Certificate</h6>
                                        @if($studentDetails->attachment_previous_study_certificate != '')
                                            <a href="{{url($studentDetails->attachment_previous_study_certificate)}}" target="_blank"><button class="btn btn-info btn-sm m0">Download&nbsp;<i class="material-icons">file_download</i><div class="ripple-container"></div></button></a>
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
