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
                    <div class="col-sm-12 col-sm-offset-0">
                        <div class="wizard-container">
                            <div class="card wizard-card" data-color="mediumaquamarine" id="wizardProfile">
                                <form method="POST" class="demo-form" id="studentForm" enctype="multipart/form-data">
                                    
                                        <input type="hidden" name="id_institute" value="{{session()->get('institutionId')}}">
                                        <input type="hidden" name="id_academic" value="{{session()->get('academicYear')}}">
                                        <input type="hidden" name="organization" value="{{session()->get('organizationId')}}">
                                        
                                    <div class="wizard-header">
                                        <h3 class="wizard-title">Add Student</h3>
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
                                                    <h5 class="tab-header mb-30">Personal Detail</h5>
                                                </div>
                                                <div class="col-sm-4 text-center">
                                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail">
                                                            <img src="https://cdn.egenius.in/img/placeholder.jpg" alt="Image">
                                                        </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                        <div>
                                                            <span class="btn btn-circle btn-info btn-file btn-sm">
                                                                <span class="fileinput-new">Add Profile</span>
                                                                <span class="fileinput-exists">Change Profile</span>
                                                                <input type="file" name="student_profile" />
                                                            </span>
                                                            <a href="#pablo" class="btn btn-danger btn-circle fileinput-exists btn-sm" data-dismiss="fileinput"><i class="material-icons">highlight_off</i></a>
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
                                                                    <label class="control-label">First Name<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="student_first_name" id="student_first_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">account_circle</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label">Middle Name</label>
                                                                    <input type="text" class="form-control" name="student_middle_name" id="student_middle_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">account_circle</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label">Last Name<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="student_last_name" id="student_last_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" required/>
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
                                                                    <label class="control-label">USN</label>
                                                                    <input type="text" class="form-control" name="usn" id="usn" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">event</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label">Date of Birth <span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control custom_datepicker" name="date_of_birth" id="date_of_birth" data-parsley-trigger="change" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">cake</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label">Age</label>
                                                                    <input type="text" class="form-control" name="age" id="age" readonly />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h5 class="tab-header mt-30">Father Details</h5>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">account_circle</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">First Name<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="father_first_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">account_circle</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Middle Name</label>
                                                            <input type="text" class="form-control" name="father_middle_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">account_circle</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Last Name<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="father_last_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" required/>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">phone</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Mobile Number<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="father_mobile_number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" number="true" onblur="this" required />
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
                                                            <label class="control-label">Aadhaar Number</label>
                                                            <input type="text" class="form-control" name="father_aadhaar_number" minlength="12" maxlength="12" maxlength='12' minlength='12' onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">school</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Education</label>
                                                            <input type="text" class="form-control" name="father_education" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">work</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Profession</label>
                                                            <input type="text" class="form-control" name="father_profession" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">mail</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Email-ID</label>
                                                            <input type="email" class="form-control" name="father_email_id" />
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
                                                            <label class="control-label">Annual Income</label>
                                                            <input type="text" class="form-control" name="father_annual_income" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h5 class="tab-header mt-30">Mother Details</h5>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">account_circle</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">First Name<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="mother_first_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">account_circle</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Middle Name</label>
                                                            <input type="text" class="form-control" name="mother_middle_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">account_circle</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Last Name<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="mother_last_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" required/>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">phone</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Mobile Number<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="mother_mobile_number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" number="true" onblur="this" required />
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
                                                            <label class="control-label">Aadhaar Number</label>
                                                            <input type="text" class="form-control" name="mother_aadhaar_number" minlength="12" maxlength="12" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">school</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Education</label>
                                                            <input type="text" class="form-control" name="mother_education" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">work</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Profession</label>
                                                            <input type="text" class="form-control" name="mother_profession" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">mail</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Email-ID</label>
                                                            <input type="email" class="form-control" name="mother_email_id" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">view_headline</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Annual Income</label>
                                                            <input type="text" class="form-control" name="mother_annual_income" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h5 class="tab-header mt-30">Guardian Details</h5>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">account_circle</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">First Name</label>
                                                            <input type="text" class="form-control" name="guardian_first_name" nkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">account_circle</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Middle Name</label>
                                                            <input type="text" class="form-control" name="guardian_middle_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">account_circle</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Last Name</label>
                                                            <input type="text" class="form-control" name="guardian_last_name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)"/>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">phone</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Mobile Number</label>
                                                            <input type="text" class="form-control" name="guardian_phone" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" number="true" onblur="this" />
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
                                                            <label class="control-label">Aadhaar Number</label>
                                                            <input type="text" class="form-control" name="guardian_aadhaar_number" minlength="12" maxlength="12" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">mail</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Email-ID</label>
                                                            <input type="email" class="form-control" name="guardian_email_id" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">face</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Relation With Guardian</label>
                                                            <input type="text" class="form-control" name="relation_with_guardian" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" />
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
                                                            <label class="control-label">Address</label>
                                                            <textarea class="form-control mt-10" rows="1" name="guardian_addresss" id="guardian_addresss"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="tab-header mt-30">Address Detail</h5>
                                                </div>
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">fiber_pin</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Pincode<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="student_pincode" id="student_pincode" required />
                                                            <input type="hidden" name="student_city" id="student_city" value="" />
                                                            <input type="hidden" name="student_state" id="student_state" value="" />
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
                                                            <label class="control-label">Post Office<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="student_post_office" id="student_post_office" required onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">location_city</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">City/Taluk<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="student_taluk" id="student_taluk" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">account_balance</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">District<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="student_district" id="student_district" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">location_on</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Address<span class="text-danger">*</span></label>
                                                            <textarea class="form-control" rows="1" name="student_address" id="student_address" required></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane  wizard-pane" id="academic">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="tab-header">Academics Detail</h5>
                                                </div>
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">local_library</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Admission Class<span class="text-danger">*</span></label>
                                                            <select class="selectpicker" name="standard" id="standard" data-style="select-with-transition" data-size="3" title="Select" data-live-search="true" required data-parsley-errors-container=".standardError">
                                                                @foreach($fieldDetails['standard'] as $index => $data)
                                                                    <option value="{{$data['institutionStandard_id']}}">{{$data['class']}} </option>
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
                                                            <label class="control-label">Gender<span class="text-danger">*</span></label>
                                                            <select class="selectpicker" name="gender" id="gender" data-style="select-with-transition" data-size="3" title="Select" data-live-search="true" required data-parsley-errors-container=".genderError">
                                                                @foreach($fieldDetails['gender'] as $data)
                                                                    <option value="{{$data['id']}}">{{$data['name']}}</option>
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
                                                            <label class="control-label">Register Number</label>
                                                            <input type="text" class="form-control" name="register_number" id="register_number" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">view_headline</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Roll Number</label>
                                                            <input type="text" class="form-control" name="rollnumber" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
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
                                                            <label class="control-label">Admission Date<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control custom_datepicker" name="admission_date" id="admission_date" required data-parsley-trigger="change" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">view_headline</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Admission Number</label>
                                                            <input type="text" class="form-control" name="admission_number" id="admission_number" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">school</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">First Language</label>
                                                            <select class="selectpicker" name="first_language" id="first_language" data-style="select-with-transition" data-size="3" title="Select" data-live-search="true">

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
                                                            <label class="control-label">Second Language</label>
                                                            <select class="selectpicker" name="second_language" id="second_language" data-style="select-with-transition" data-size="3" title="Select" data-live-search="true">

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
                                                            <label class="control-label">Third Language</label>
                                                            <select class="selectpicker" name="third_language" id="third_language" data-style="select-with-transition" data-size="3" title="Select" data-live-search="true">

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
                                                            <label class="control-label">Electives</label>
                                                            <select class="selectpicker" name="elective_subject[]" id="elective_subject" data-style="select-with-transition" data-size="3" title="Select" data-live-search="true" multiple data-actions-box="true">

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="tab-header mt-30">Fee Detail</h5>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">view_headline</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Fee Type</label>
                                                            <select class="selectpicker" name="fee_type" id="fee_type" data-style="select-with-transition" data-size="3" title="Select" data-live-search="true">
                                                                @foreach($fieldDetails['fee_type'] as $feeType)
                                                                    <option value="{{$feeType['id']}}">{{$feeType['name']}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane  wizard-pane" id="additional">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="tab-header">Additional Details</h5>
                                                </div>
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">view_headline</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Mother Tongue</label>
                                                            <input type="text" class="form-control" name="mother_tongue" id="mother_tongue" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">view_headline</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">SATS Number</label>
                                                            <input type="text" class="form-control" name="sats_number" id="sats_number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">view_headline</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Student Aadhaar Number</label>
                                                            <input type="text" class="form-control" name="student_aadhaar_number" id="student_aadhaar_number" maxlength='12' minlength='12' onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">language</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Nationality<span class="text-danger">*</span></label>
                                                            <select class="selectpicker" name="nationality" id="nationality" data-style="select-with-transition" data-size="3" data-live-search="true" title="Select" required data-parsley-errors-container=".nationalityError">
                                                                @foreach($fieldDetails['nationality'] as $data)
                                                                    <option value="{{$data['id']}}">{{$data['name']}}</option>
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
                                                            <label class="control-label">Religion<span class="text-danger">*</span></label>
                                                            <select class="selectpicker" name="religion" id="religion" data-style="select-with-transition" data-size="3" data-live-search="true" title="Select" required data-parsley-errors-container=".religionError">
                                                                @foreach($fieldDetails['religion'] as $data)
                                                                    <option value="{{$data['id']}}">{{$data['name']}}</option>
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
                                                            <label class="control-label">Caste<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="caste" id="caste" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">people</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Caste Category</label>
                                                            <select class="selectpicker" name="caste_category" id="caste_category" data-style="select-with-transition" data-size="3" title="Select" data-live-search="true">
                                                                @foreach($fieldDetails['caste_category'] as $data)
                                                                    <option value="{{$data['id']}}">{{$data['name']}}</option>
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
                                                            <label class="control-label">Blood Group</label>
                                                            <select class="selectpicker" name="blood_group" id="blood_group" data-style="select-with-transition" data-size="3" title="Select" data-live-search="true">
                                                                @foreach($fieldDetails['blood_group'] as $data)
                                                                    <option value="{{$data['id']}}">{{$data['name']}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 class="tab-header mt-30">SMS Detail</h5>
                                                </div>
                                                <div class="col-lg-4 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">sms</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">SMS For<span class="text-danger">*</span></label>
                                                            <select class="selectpicker" name="sms_sent_for" id="sms_sent_for" data-style="select-with-transition" data-size="3" data-live-search="true" title="Select" required data-parsley-errors-container=".smsError">
                                                                <option value="Father">FATHER</option>
                                                                <option value="Mother">MOTHER</option>
                                                                <option value="Both">BOTH</option>
                                                            </select>
                                                            <div class="smsError"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane wizard-pane" id="attachments">
                                            <div class="row">
                                                <div class="col-sm-3 text-center form-group">
                                                    <h5 Class="form-imageHeading">Student Aadhaar Card</h5>
                                                    <div class="fileinput fileinput-new text-center"
                                                        data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail img-square">
                                                            <img src="//cdn.egenius.in/img/placeholder.jpg" alt="Image">
                                                        </div>
                                                        <div
                                                            class="fileinput-preview fileinput-exists thumbnail img-square">
                                                        </div>
                                                        <div>
                                                            <span class="btn btn-square btn-info btn-file btn-sm">
                                                                <span class="fileinput-new">Add</span>
                                                                <span class="fileinput-exists">Change</span>
                                                                <input type="file" name="student_aadhaar_card_attachement" />
                                                            </span>
                                                            <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="material-icons">highlight_off</i></a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3 text-center form-group">
                                                    <h5 Class="form-imageHeading">Father Aadhaar Card</h5>
                                                    <div class="fileinput fileinput-new text-center"
                                                        data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail img-square">
                                                            <img src="//cdn.egenius.in/img/placeholder.jpg" alt="Image">
                                                        </div>
                                                        <div
                                                            class="fileinput-preview fileinput-exists thumbnail img-square">
                                                        </div>
                                                        <div>
                                                            <span class="btn btn-square btn-info btn-file btn-sm">
                                                                <span class="fileinput-new">Add</span>
                                                                <span class="fileinput-exists">Change</span>
                                                                <input type="file" name="father_aadhaar_card_attachment" />
                                                            </span>
                                                            <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="material-icons">highlight_off</i></a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3 text-center form-group">
                                                    <h5 Class="form-imageHeading">Mother Aadhaar Card</h5>
                                                    <div class="fileinput fileinput-new text-center"
                                                        data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail img-square">
                                                            <img src="//cdn.egenius.in/img/placeholder.jpg" alt="Image">
                                                        </div>
                                                        <div
                                                            class="fileinput-preview fileinput-exists thumbnail img-square">
                                                        </div>
                                                        <div>
                                                            <span class="btn btn-square btn-info btn-file btn-sm">
                                                                <span class="fileinput-new">Add</span>
                                                                <span class="fileinput-exists">Change</span>
                                                                <input type="file" name="mother_aadhaar_card_attachment" />
                                                            </span>
                                                            <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="material-icons">highlight_off</i></a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3 text-center form-group">
                                                    <h5 Class="form-imageHeading">Father PAN Card</h5>
                                                    <div class="fileinput fileinput-new text-center"
                                                        data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail img-square">
                                                            <img src="//cdn.egenius.in/img/placeholder.jpg" alt="Image">
                                                        </div>
                                                        <div
                                                            class="fileinput-preview fileinput-exists thumbnail img-square">
                                                        </div>
                                                        <div>
                                                            <span class="btn btn-square btn-info btn-file btn-sm">
                                                                <span class="fileinput-new">Add</span>
                                                                <span class="fileinput-exists">Change</span>
                                                                <input type="file" name="father_pan_card_attachment" />
                                                            </span>
                                                            <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="material-icons">highlight_off</i></a>
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
                                                            <img src="//cdn.egenius.in/img/placeholder.jpg" alt="Image">
                                                        </div>
                                                        <div
                                                            class="fileinput-preview fileinput-exists thumbnail img-square">
                                                        </div>
                                                        <div>
                                                            <span class="btn btn-square btn-info btn-file btn-sm">
                                                                <span class="fileinput-new">Add</span>
                                                                <span class="fileinput-exists">Change</span>
                                                                <input type="file" name="mother_pan_card_attachment" />
                                                            </span>
                                                            <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="material-icons">highlight_off</i></a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3 text-center form-group">
                                                    <h5 Class="form-imageHeading">Previous Transfer Certificate</h5>
                                                    <div class="fileinput fileinput-new text-center"
                                                        data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail img-square">
                                                            <img src="//cdn.egenius.in/img/placeholder.jpg" alt="Image">
                                                        </div>
                                                        <div
                                                            class="fileinput-preview fileinput-exists thumbnail img-square">
                                                        </div>
                                                        <div>
                                                            <span class="btn btn-square btn-info btn-file btn-sm">
                                                                <span class="fileinput-new">Add</span>
                                                                <span class="fileinput-exists">Change</span>
                                                                <input type="file" name="previous_tc_attachment" />
                                                            </span>
                                                            <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="material-icons">highlight_off</i></a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3 text-center form-group">
                                                    <h5 Class="form-imageHeading">Previous Study Certificate</h5>
                                                    <div class="fileinput fileinput-new text-center"
                                                        data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail img-square">
                                                            <img src="//cdn.egenius.in/img/placeholder.jpg" alt="Image">
                                                        </div>
                                                        <div
                                                            class="fileinput-preview fileinput-exists thumbnail img-square">
                                                        </div>
                                                        <div>
                                                            <span class="btn btn-square btn-info btn-file btn-sm">
                                                                <span class="fileinput-new">Add</span>
                                                                <span class="fileinput-exists">Change</span>
                                                                <input type="file" name="previous_study_certificate_attachment" />
                                                            </span>
                                                            <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="material-icons">highlight_off</i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane wizard-pane" id="other">
                                            @php echo $customFields; @endphp
                                        </div>

                                        <div class="wizard-footer">
                                            <div class="pull-right">
                                                <input type='button' class='btn btn-next btn-fill btn-info btn-wd' name='next' value='Next' />
                                                <button class='btn btn-finish btn-fill btn-info btn-wd' id='submit' name='submit' value='submit'>Submit</button>
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

            if ((currentmonth < birthMonth) || ((currentmonth == birthMonth) && currentday < birthDay)){
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

        // Get first, second, third, elective language based on standard
        $('#standard').on('change', function(){

            var standardId = $(this).find(":selected").val();
            $.ajax({
                url: "/standard-subjects",
                type: "POST",
                data: {
                    id: standardId
                },
                success: function(data){

                    // Map elective & language
                    var electiveHtml = languageHtml = feeTypeHtml = '';
                    $.map(data['subject']['all_elective_subject'], function(elective, index){
                        electiveHtml += '<option value="' + elective.id + '">' +
                            elective.name + '</option>';
                    });

                    $.map(data['subject']['all_language_subject'], function(language, index){
                        languageHtml += '<option value="' + language.id + '">' +
                            language.name + '</option>';
                    });

                    $.map(data['fee_type'], function(feeType, index){
                        feeTypeHtml += '<option value="' + feeType.id + '">' +
                        feeType.name + '</option>';
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

        // Save student
        $('body').delegate('#studentForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');

            if ($('#studentForm').parsley().isValid()){

                $.ajax({
                    url: "/student",
                    type: "post",
                    dataType: "json",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        btn.html('Submitting...');
                        btn.attr('disabled', true);
                    },
                    success: function(result){

                        btn.html('Submit');
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
