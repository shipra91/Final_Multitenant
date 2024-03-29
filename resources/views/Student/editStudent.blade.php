
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
                    <div class="col-sm-12 col-sm-offset-0">
                        <div class="alert alert-danger" role="alert">
                            <strong>Note:</strong> If you edit the student fee type, concession and additional amount will be deleted for this student.
                        </div>
                    </div>
                    <div class="col-sm-12 col-sm-offset-0">
                        <div class="wizard-container">
                            <div class="card wizard-card" data-color="mediumaquamarine" id="wizardProfile">
                                <form method="POST" class="demo-form" id="studentForm" enctype="multipart/form-data">

                                    <input type="hidden" name="id_institute" value="{{session()->get('institutionId')}}">
                                    <input type="hidden" name="id_academic" value="{{session()->ge('academicYear')}}">
                                    <input type="hidden" name="organization" value="{{session()->get('organizationId')}}">

                                    <div class="wizard-header">
                                        <h3 class="wizard-title">Edit Student</h3>                                        
                                    </div>
                                    <div class="wizard-navigation">
                                        <ul>
                                            <li>
                                                <a href="#basic" data-toggle="tab">Basic Details</a>
                                            </li>
                                            <li>
                                                <a href="#academic" data-toggle="tab">Academic/Fee Config </a>
                                            </li>
                                            <li>
                                                <a href="#additional" data-toggle="tab">Additional Details </a>
                                            </li>
                                            <li>
                                                <a href="#attachments" data-toggle="tab">Attachments</a>
                                            </li>
                                            <li>
                                                <a href="#other" data-toggle="tab">Other Details</a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="tab-content">
                                        <div class="tab-pane wizard-pane" id="basic">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="tab-header mt-0">Personal Detail</h5>
                                                </div>
                                                <div class="col-sm-4 text-center">
                                                    <div class="fileinput fileinput-new text-center"
                                                        data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail img-square">
                                                            @if($data->attachment_student_photo != "")
                                                                <img class="img" src="{{$data->attachment_student_photo}}" alt="Image" />
                                                            @else
                                                                <img src="//cdn.egenius.in/img/placeholder.jpg" alt="Image" />
                                                            @endif
                                                        </div>
                                                        <div
                                                            class="fileinput-preview fileinput-exists thumbnail img-square">
                                                        </div>
                                                        <div>
                                                            <span class="btn btn-square btn-info btn-file btn-sm">
                                                                <span class="fileinput-new">Change</span>
                                                                <span class="fileinput-exists">Change</span>
                                                                <input type="file" name="student_profile" />
                                                            </span>
                                                            <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="material-icons">highlight_off</i></a>
                                                            <input type="hidden" name="old_student_profile" value="{{$data->attachment_student_photo}}" />
                                                            <input type="hidden" name="idFeeCategory" id="idFeeCategory" value="3a3d9600-dfc8-475e-88cc-3f734d1b8c18">
                                                            <input type="hidden" name="student_id" id="student_id" value="{{ $data->id_student }}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-8">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">account_circle</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label mt-0">First Name<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control input" name="student_first_name" id="student_first_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" value="{{$data->name}}" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">account_circle</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label mt-0">Middle Name</label>
                                                                    <input type="text" class="form-control input" name="student_middle_name" id="student_middle_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" value="{{$data->middle_name}}" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">account_circle</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label mt-0">Last Name<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control input" name="student_last_name" id="student_last_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" value="{{$data->last_name}}" required/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">person</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label mt-0">USN</label>
                                                                    <input type="text" class="form-control" name="usn" id="usn" value="{{$data->usn}}" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">event</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label mt-0">Date of Birth <span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control custom_datepicker" name="date_of_birth" id="date_of_birth" value="{{Carbon::createFromFormat('Y-m-d', $data->date_of_birth)->format('d/m/Y')}}" data-parsley-trigger="change" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">cake</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label mt-0">Age</label>
                                                                    <input type="text" class="form-control" name="age" id="age" value="{{$data->current_age}}" readonly />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h5 class="tab-header">Father Details</h5>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">account_circle</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">First Name<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="father_first_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" value="{{$data->father_name}}" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">account_circle</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Middle Name</label>
                                                            <input type="text" class="form-control" name="father_middle_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" value="{{$data->father_middle_name}}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">account_circle</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Last Name<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="father_last_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" value="{{$data->father_last_name}}" required/>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">phone</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Mobile Number<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="father_mobile_number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" number="true" onblur="this" value="{{$data->father_mobile_number}}" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">view_headline</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Aadhaar Number</label>
                                                            <input type="text" class="form-control" name="father_aadhaar_number" minlength="12" maxlength="12" maxlength='12' minlength='12' onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{$data->father_aadhaar_number}}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">school</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Education</label>
                                                            <input type="text" class="form-control" name="father_education" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" value="{{$data->father_education}}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">work</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Profession</label>
                                                            <input type="text" class="form-control" name="father_profession" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" value="{{$data->father_profession}}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">mail</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Email-ID</label>
                                                            <input type="email" class="form-control" name="father_email_id" value="{{$data->father_email}}" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">view_headline</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Annual Income</label>
                                                            <input type="text" class="form-control" name="father_annual_income" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{$data->father_annual_income}}" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h5 class="tab-header">Mother Details</h5>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">account_circle</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">First Name<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="mother_first_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" value="{{$data->mother_name}}" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">account_circle</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Middle Name</label>
                                                            <input type="text" class="form-control" name="mother_middle_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" value="{{$data->mother_middle_name}}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">account_circle</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Last Name<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="mother_last_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" value="{{$data->mother_last_name}}" required/>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">phone</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Mobile Number<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="mother_mobile_number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" number="true" onblur="this" value="{{$data->mother_mobile_number}}" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">view_headline</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Aadhaar Number</label>
                                                            <input type="text" class="form-control" name="mother_aadhaar_number" minlength="12" maxlength="12" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{$data->mother_aadhaar_number}}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">school</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Education</label>
                                                            <input type="text" class="form-control" name="mother_education" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" value="{{$data->mother_education}}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">work</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Profession</label>
                                                            <input type="text" class="form-control" name="mother_profession" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" value="{{$data->mother_profession}}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">mail</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Email-ID</label>
                                                            <input type="email" class="form-control" name="mother_email_id" value="{{$data->mother_email}}" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">view_headline</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Annual Income</label>
                                                            <input type="text" class="form-control" name="mother_annual_income" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{$data->mother_annual_income}}" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h5 class="tab-header">Guardian Details</h5>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">account_circle</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">First Name</label>
                                                            <input type="text" class="form-control" name="guardian_first_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" value="{{$data->guardian_name}}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">account_circle</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Middle Name</label>
                                                            <input type="text" class="form-control" name="guardian_middle_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" value="{{$data->guardian_middle_name}}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">account_circle</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Last Name</label>
                                                            <input type="text" class="form-control" name="guardian_last_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" value="{{$data->guardian_last_name}}"/>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">phone</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Mobile Number</label>
                                                            <input type="text" class="form-control" name="guardian_phone" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" number="true" onblur="this" value="{{$data->guardian_contact_no}}" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-4 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">view_headline</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Aadhaar Number</label>
                                                            <input type="text" class="form-control" name="guardian_aadhaar_number" minlength="12" maxlength="12" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{$data->guardian_aadhaar_no}}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">mail</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Email-ID</label>
                                                            <input type="email" class="form-control" name="guardian_email_id" value="{{$data->guardian_email}}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">face</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Relation With Guardian</label>
                                                            <input type="text" class="form-control" name="relation_with_guardian" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" value="{{$data->guardian_relation}}" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">location_on</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Address</label>
                                                            <textarea class="form-control" rows="1" name="guardian_addresss" id="guardian_addresss">{{$data->guardian_address}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="tab-header">Address Detail</h5>
                                                </div>
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="material-icons icon-middle">fiber_pin</i></span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Pincode<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="student_pincode" id="student_pincode" value="{{$data->pincode}}" required />

                                                            <input type="hidden" name="student_city" id="student_city" value="{{$data->city}}" />
                                                            <input type="hidden" name="student_state" id="student_state" value="{{$data->state}}" />
                                                            <input type="hidden" name="student_country" id="student_country" value="India" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">account_balance</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Post Office<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="student_post_office" id="student_post_office" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" value="{{$data->post_office}}" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">location_city</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">City/Taluk<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="student_taluk" id="student_taluk" value="{{$data->taluk}}" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">account_balance</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">District<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="student_district" id="student_district" value="{{$data->district}}" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">location_on</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Address<span class="text-danger">*</span></label>
                                                            <textarea class="form-control" rows="1" name="student_address" id="student_address" required>{{$data->address}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane wizard-pane" id="academic">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="tab-header mt-0">Academics Detail</h5>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">local_library</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Admission Class<span class="text-danger">*</span></label>
                                                            <select class="selectpicker" name="standard" id="standard" data-style="select-with-transition" data-size="5" title="Select" data-live-search="true" required data-parsley-errors-container=".standardError">
                                                                @foreach($fieldDetails['standard'] as $index => $class)
                                                                    <option value="{{$class['institutionStandard_id']}}"@if($data->id_standard == $class['institutionStandard_id'] ) {{"selected" }} @endif>{{$class['class']}} </option>
                                                                @endforeach
                                                            </select>
                                                            <div class="standardError"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">wc</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Gender<span class="text-danger">*</span></label>
                                                            <select class="selectpicker" name="gender" id="gender" data-style="select-with-transition" data-size="5" title="Select" data-live-search="true" required data-parsley-errors-container=".genderError">
                                                                @foreach($fieldDetails['gender'] as $genderFields)
                                                                    <option value="{{$genderFields['id']}}" @if($data->id_gender == $genderFields['id'] ) {{ "selected" }} @endif>{{$genderFields['name']}}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="genderError"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">view_headline</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Register Number</label>
                                                            <input type="text" class="form-control" name="register_number" id="register_number" value="{{$data->register_number}}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">view_headline</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Roll Number</label>
                                                            <input type="text" class="form-control" name="rollnumber" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{$data->roll_number}}" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">event</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Admission Date<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control custom_datepicker" name="admission_date" id="admission_date" value="{{Carbon::createFromFormat('Y-m-d', $data->admission_date)->format('d/m/Y')}}" data-parsley-trigger="change" requied />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">view_headline</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Admission Number</label>
                                                            <input type="text" class="form-control" name="admission_number" id="admission_number" value="{{$data->admission_number}}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">school</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">First Language</label>
                                                            <select class="selectpicker" name="first_language" id="first_language" data-style="select-with-transition" data-size="5" title="Select" data-live-search="true">
                                                                @foreach($data->standard_subjects['all_language_subject']
                                                                as $language)
                                                                    <option value="{{ $language['id'] }}" @if($language['id'] == $data->id_first_language){{'selected'}} @endif> {{ $language['name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">school</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Second Language</label>
                                                            <select class="selectpicker" name="second_language" id="second_language" data-style="select-with-transition" data-size="5" title="Select" data-live-search="true">
                                                                @foreach($data->standard_subjects['all_language_subject']
                                                                as $language)
                                                                    <option value="{{ $language['id'] }}" @if($language['id'] == $data->id_second_language) {{'selected'}} @endif>{{ $language['name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">school</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Third Language</label>
                                                            <select class="selectpicker" name="third_language" id="third_language" data-style="select-with-transition" data-size="5" title="Select" data-live-search="true">
                                                                @foreach($data->standard_subjects['all_language_subject']
                                                                as $language)
                                                                    <option value="{{ $language['id'] }}" @if($language['id'] == $data->id_third_language){{'selected'}} @endif>{{ $language['name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">school</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Electives</label>
                                                            <select class="selectpicker" name="elective_subject[]" id="elective_subject" data-style="select-with-transition" data-size="5" title="Select" data-live-search="true" multiple data-actions-box="true">
                                                                @foreach($data->standard_subjects['all_elective_subject']
                                                                as $elective)
                                                                    <option value="{{ $elective['id'] }}" @if (array_intersect(explode('||', $elective['id']), $data->selected_elective)) {{ "selected" }} @endif>{{ $elective['name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="tab-header">Fee Detail</h5>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">view_headline</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Fee Type</label>
                                                            <select class="selectpicker" name="fee_type" id="fee_type" data-style="select-with-transition" data-size="5" title="Select" data-live-search="true">
                                                                @foreach($fieldDetails['fee_type'] as $feeType)
                                                                    <option value="{{$feeType->id}}" @if($data->id_fee_type == $feeType->id ){{ "selected" }} @endif>{{$feeType->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane wizard-pane" id="additional">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="tab-header mt-0">Additional Details</h5>
                                                </div>
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">view_headline</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Mother Tongue</label>
                                                            <input type="text" class="form-control" name="mother_tongue" id="mother_tongue" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" value="{{$data->mother_tongue}}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">view_headline</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">SATS Number</label>
                                                            <input type="text" class="form-control" name="sats_number" id="sats_number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{$data->sats_number}}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">view_headline</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Student Aadhaar Number</label>
                                                            <input type="text" class="form-control" name="student_aadhaar_number" id="student_aadhaar_number" maxlength='12' minlength='12' onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{$data->student_aadhaar_number}}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">language</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Nationality<span class="text-danger">*</span></label>
                                                            <select class="selectpicker" name="nationality" id="nationality" data-style="select-with-transition" data-size="5" data-live-search="true" title="Select" required data-parsley-errors-container=".nationalityError">
                                                                @foreach($fieldDetails['nationality'] as $fields)
                                                                    <option value="{{$fields['id']}}" @if($data->id_nationality == $fields['id'] ) {{ "selected" }}@endif>{{$fields['name']}}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="nationalityError"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">people</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Religion<span class="text-danger">*</span></label>
                                                            <select class="selectpicker" name="religion" id="religion" data-style="select-with-transition" data-size="5" data-live-search="true" title="Select" required data-parsley-errors-container=".religionError">
                                                                @foreach($fieldDetails['religion'] as $fields)
                                                                    <option value="{{$fields['id']}}" @if($data->id_religion == $fields['id'] ) {{ "selected" }} @endif>{{$fields['name']}}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="religionError"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">people</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Caste<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="caste" id="caste" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" value="{{$data->caste}}" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">people</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Caste Category</label>
                                                            <select class="selectpicker" name="caste_category" id="caste_category" data-style="select-with-transition" data-size="5" title="Select" data-live-search="true">
                                                                @foreach($fieldDetails['caste_category'] as $fields)
                                                                    <option value="{{$fields['id']}}" @if($data->id_caste_category == $fields['id'] ){{ "selected" }} @endif>{{$fields['name']}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">opacity</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Blood Group</label>
                                                            <select class="selectpicker" name="blood_group" id="blood_group" data-style="select-with-transition" data-size="5" title="Select" data-live-search="true">
                                                                @foreach($fieldDetails['blood_group'] as $fields)
                                                                    <option value="{{$fields['id']}}" @if($data->id_blood_group == $fields['id'] ) {{ "selected" }} @endif>{{$fields['name']}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- <div class="tab-pane wizard-pane" id="contact">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="tab-header">SMS Detail</h5>
                                                </div>
                                                <div class="col-lg-4 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">sms</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">SMS For<span
                                                                    class="text-danger">*</span></label>
                                                            <select class="selectpicker" name="sms_sent_for"
                                                                id="sms_sent_for" data-style="select-with-transition"
                                                                data-size="3" data-live-search="true" title="Select"
                                                                required data-parsley-errors-container=".smsError">
                                                                <option value="Father" @if($data->sms_for == 'Father' )
                                                                    {{ "selected" }} @endif >FATHER</option>
                                                                <option value="Mother" @if($data->sms_for == 'Mother' )
                                                                    {{ "selected" }} @endif>MOTHER</option>
                                                                <option value="Both" @if($data->sms_for == 'Both' )
                                                                    {{ "selected" }} @endif>BOTH</option>
                                                            </select>
                                                            <div class="smsError"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}

                                        <div class="tab-pane wizard-pane" id="attachments">
                                            <div class="row">
                                                <div class="col-sm-3 text-center form-group">
                                                    <h5 Class="form-imageHeading">Student Aadhaar Card</h5>
                                                    <div class="fileinput fileinput-new text-center"
                                                        data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail img-square">
                                                            @if($data->attachment_student_aadhaar != "")
                                                                <img class="img" src="{{$data->attachment_student_aadhaar}}" alt="Image" />
                                                            @else
                                                                <img src="//cdn.egenius.in/img/placeholder.jpg" alt="Image" />
                                                            @endif
                                                        </div>
                                                        <div
                                                            class="fileinput-preview fileinput-exists thumbnail img-square">
                                                        </div>
                                                        <div>
                                                            <span class="btn btn-square btn-info btn-file btn-sm">
                                                                <span class="fileinput-new">Change</span>
                                                                <span class="fileinput-exists">Change</span>
                                                                <input type="file" name="student_aadhaar_card_attachement" />
                                                            </span>
                                                            <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="material-icons">highlight_off</i></a>
                                                            <input type="hidden" name="old_student_aadhaar_card_attachement" value="{{$data->attachment_student_aadhaar}}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3 text-center form-group">
                                                    <h5 Class="form-imageHeading">Father Aadhaar Card</h5>
                                                    <div class="fileinput fileinput-new text-center"
                                                        data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail img-square">
                                                            @if($data->attachment_father_aadhaar != "")
                                                                <img class="img" src="{{$data->attachment_father_aadhaar}}" alt="Image" />
                                                            @else
                                                                <img src="//cdn.egenius.in/img/placeholder.jpg" alt="Image" />
                                                            @endif
                                                        </div>
                                                        <div
                                                            class="fileinput-preview fileinput-exists thumbnail img-square">
                                                        </div>
                                                        <div>
                                                            <span class="btn btn-square btn-info btn-file btn-sm">
                                                                <span class="fileinput-new">Change</span>
                                                                <span class="fileinput-exists">Change</span>
                                                                <input type="file" name="father_aadhaar_card_attachment" />
                                                            </span>
                                                            <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="material-icons">highlight_off</i></a>
                                                            <input type="hidden" name="old_father_aadhaar_card_attachment" value="{{$data->attachment_father_aadhaar}}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3 text-center form-group">
                                                    <h5 Class="form-imageHeading">Mother Aadhaar Card</h5>
                                                    <div class="fileinput fileinput-new text-center"
                                                        data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail img-square">
                                                            @if($data->attachment_mother_aadhaar != "")
                                                                <img class="img" src="{{$data->attachment_mother_aadhaar}}" alt="Image" />
                                                            @else
                                                                <img src="//cdn.egenius.in/img/placeholder.jpg" alt="Image" />
                                                            @endif
                                                        </div>
                                                        <div
                                                            class="fileinput-preview fileinput-exists thumbnail img-square">
                                                        </div>
                                                        <div>
                                                            <span class="btn btn-square btn-info btn-file btn-sm">
                                                                <span class="fileinput-new">Change</span>
                                                                <span class="fileinput-exists">Change</span>
                                                                <input type="file" name="mother_aadhaar_card_attachment" />
                                                            </span>
                                                            <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="material-icons">highlight_off</i></a>
                                                            <input type="hidden" name="old_mother_aadhaar_card_attachment" value="{{$data->attachment_mother_aadhaar}}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3 text-center form-group">
                                                    <h5 Class="form-imageHeading">Father PAN Card</h5>
                                                    <div class="fileinput fileinput-new text-center"
                                                        data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail img-square">
                                                            @if($data->attachment_father_pancard != "")
                                                                <img class="img" src="{{$data->attachment_father_pancard}}" alt="Image" />
                                                            @else
                                                                <img src="//cdn.egenius.in/img/placeholder.jpg" alt="Image" />
                                                            @endif
                                                        </div>
                                                        <div
                                                            class="fileinput-preview fileinput-exists thumbnail img-square">
                                                        </div>
                                                        <div>
                                                            <span class="btn btn-square btn-info btn-file btn-sm">
                                                                <span class="fileinput-new">Change</span>
                                                                <span class="fileinput-exists">Change</span>
                                                                <input type="file" name="father_pan_card_attachment" />
                                                            </span>
                                                            <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="material-icons">highlight_off</i></a>
                                                            <input type="hidden" name="old_father_pan_card_attachment" value="{{$data->attachment_father_pancard}}" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-3 text-center form-group">
                                                    <h5 Class="form-imageHeading">Mother PAN Card</h5>
                                                    <div class="fileinput fileinput-new text-center"
                                                        data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail img-square">
                                                            @if($data->attachment_mother_pancard != "")
                                                                <img class="img" src="{{$data->attachment_mother_pancard}}" alt="Image" />
                                                            @else
                                                                <img src="//cdn.egenius.in/img/placeholder.jpg" alt="Image" />
                                                            @endif
                                                        </div>
                                                        <div
                                                            class="fileinput-preview fileinput-exists thumbnail img-square">
                                                        </div>
                                                        <div>
                                                            <span class="btn btn-square btn-info btn-file btn-sm">
                                                                <span class="fileinput-new">Change</span>
                                                                <span class="fileinput-exists">Change</span>
                                                                <input type="file" name="mother_pan_card_attachment" />
                                                            </span>
                                                            <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="material-icons">highlight_off</i></a>
                                                            <input type="hidden" name="old_mother_pan_card_attachment" value="{{$data->attachment_mother_pancard}}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3 text-center form-group">
                                                    <h5 Class="form-imageHeading">Previous Transfer Certificate</h5>
                                                    <div class="fileinput fileinput-new text-center"
                                                        data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail img-square">
                                                            @if($data->attachment_previous_tc != "")
                                                                <img class="img" src="{{$data->attachment_previous_tc}}" alt="Image" />
                                                            @else
                                                                <img src="//cdn.egenius.in/img/placeholder.jpg" alt="Image" />
                                                            @endif
                                                        </div>
                                                        <div
                                                            class="fileinput-preview fileinput-exists thumbnail img-square">
                                                        </div>
                                                        <div>
                                                            <span class="btn btn-square btn-info btn-file btn-sm">
                                                                <span class="fileinput-new">Change</span>
                                                                <span class="fileinput-exists">Change</span>
                                                                <input type="file" name="previous_tc_attachment" />
                                                            </span>
                                                            <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="material-icons">highlight_off</i></a>
                                                            <input type="hidden" name="old_previous_tc_attachment" value="{{$data->attachment_previous_tc}}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3 text-center form-group">
                                                    <h5 Class="form-imageHeading">Previous Study Certificate</h5>
                                                    <div class="fileinput fileinput-new text-center"
                                                        data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail img-square">
                                                            @if($data->attachment_previous_study_certificate != "")
                                                            <img class="img"
                                                                src="{{$data->attachment_previous_study_certificate}}" alt="Image" />
                                                            @else
                                                                <img src="//cdn.egenius.in/img/placeholder.jpg" alt="Image" />
                                                            @endif
                                                        </div>
                                                        <div
                                                            class="fileinput-preview fileinput-exists thumbnail img-square">
                                                        </div>
                                                        <div>
                                                            <span class="btn btn-square btn-info btn-file btn-sm">
                                                                <span class="fileinput-new">Change</span>
                                                                <span class="fileinput-exists">Change</span>
                                                                <input type="file" name="previous_study_certificate_attachment" />
                                                            </span>
                                                            <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="material-icons">highlight_off</i></a>
                                                            <input type="hidden" name="old_previous_study_certificate_attachment" value="{{$data->attachment_student_photo}}" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane  wizard-pane" id="other">
                                            @php echo $customFields; @endphp
                                        </div>

                                        <div class="wizard-footer">
                                            <div class="pull-right">
                                                <input type='button' class='btn btn-next btn-fill btn-info btn-wd' name='next' value='Next' />
                                                <button class='btn btn-finish btn-fill btn-info btn-wd' id='submit' name='submit' value='submit'>Update</button>
                                            </div>
                                            <div class="pull-left">
                                                <input type='button' class='btn btn-previous btn-fill btn-danger btn-wd' name='previous' value='Previous' />
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fee assign modal -->
<div class="modal fade" id="CustomModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Custom Fee Assign</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="customAssignForm">
                    <input type="hidden" name="custom_standard_id" id="custom_standard_id" />
                    <input type="hidden" name="custom_fee_category_id" id="custom_fee_category_id" />
                    <input type="hidden" name="institute_id" id="institute_id" value="{{ session()->get('institutionId') }}" />
                    <input type="hidden" name="academic_id" id="academic_id" value="{{ session()->get('academicYear') }}" />
                    <input type="hidden" name="custom_student_id" id="custom_student_id" />
                    <input type="hidden" name="custom_fee_type" id="custom_fee_type" />

                    <div class="contentBody">

                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-success mr-5" id="submitAddition">Submit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
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

        // Student age calculation
        $("#date_of_birth").on('dp.change', function(e){

            var dateOfBirth = $(this).val();
            var dates = dateOfBirth.split("/");
            var currentDate = new Date();

            var birthDay = dates[0];
            var birthMonth = dates[1];
            var birthYear = dates[2];

            var currentday = currentDate.getDate();
            var currentmonth = currentDate.getMonth() + 1;
            var currentyear = currentDate.getFullYear();
            var age = currentyear - birthYear;

            if((currentmonth < birthMonth) || ((currentmonth == birthMonth) && currentday < birthDay)) {
                age--;
            }

            $('#age').val(age);
        });

        // Pincode
        $('#student_pincode').autocomplete({

            source: function(request, response){

                var id = $('#student_pincode').val();

                $.ajax({
                    type: "POST",
                    url: "/pincode-address",
                    dataType: "json",
                    data: {
                        id: id
                    },
                    success: function(data){
                        console.log(data);
                        response(data);
                        response($.map(data, function(item){
                            var code = item.split("@");
                            var code1 = item.split("|");
                            return {
                                label: code1[0],
                                value: code1[5],
                                data: item
                            }
                        }));
                    }
                });
            },
            autoFocus: true,
            minLength: 3,
            select: function(event, ui){
                var names = ui.item.data.split("|");
                //console.log(names[5]);
                $('#student_post_office').val(names[0]);
                $('#student_city').val(names[1]);
                $('#student_taluk').val(names[2]);
                $('#student_district').val(names[3]);
                $('#student_state').val(names[4]);
                $('#student_pincode').val(names[5]);
            }
        });

        //  Get first, second, third, elective language based on standard
        $('#standard').on('change', function(){

            var standardId = $(this).find(":selected").val();

            $.ajax({
                url: "/standard-subjects",
                type: "POST",
                data: {id: standardId},
                success: function(data){
                    // Map elective & language
                    var electiveHtml = languageHtml = feeTypeHtml = '';
                    $.map(data['subject']['all_elective_subject'], function(elective, index){
                        electiveHtml += '<option value="' + elective.id + '">' + elective.name + '</option>';
                    });

                    $.map(data['subject']['all_language_subject'], function(language, index){
                        languageHtml += '<option value="' + language.id + '">' + language.name + '</option>';
                    });

                    $.map(data['fee_type'], function(feeType, index){
                        feeTypeHtml += '<option value="' + feeType.id + '">' + feeType.name + '</option>';
                    });

                    $('#first_language').html(languageHtml);
                    $('#first_language').selectpicker('refresh');
                    $('#second_language').html(languageHtml);
                    $('#second_language').selectpicker('refresh');
                    $('#third_language').html(languageHtml);
                    $('#third_language').selectpicker('refresh');
                    $('#elective_subject').html(electiveHtml);
                    $('#elective_subject').selectpicker('refresh');
                    $('#fee_type').html(feeTypeHtml);
                    $('#fee_type').selectpicker('refresh');
                }
            });
        });

        $('#studentForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Update student
        $('body').delegate('#studentForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');
            var id = $("#student_id").val();

            if($('#studentForm').parsley().isValid()){

                $.ajax({
                    url: "/student/" + id,
                    type: "post",
                    dataType: "json",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        btn.html('Updating...');
                        btn.attr('disabled', true);
                    },
                    success: function(result){
                        // console.log(result);
                        btn.html('Update');
                        btn.attr('disabled', false);

                        if(result['status'] == "200"){

                            if(result.data['signal'] == "success"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function() {
                                    window.location.reload();
                                }).catch(swal.noop)

                            }else if (result.data['signal'] == "exist"){

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
