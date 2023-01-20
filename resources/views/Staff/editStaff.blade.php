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
                        <div class="wizard-container">
                            <div class="card wizard-card" data-color="mediumaquamarine" id="wizardProfile">
                                <form method="POST" class="demo-form" id="staffForm" enctype="multipart/form-data">
                                    <div class="wizard-header">
                                        <h3 class="wizard-title">Edit Staff</h3>
                                    </div>
                                    <div class="wizard-navigation">
                                        <ul>
                                            <li>
                                                <a href="#basic" data-toggle="tab">Basic Details</a>
                                            </li>
                                            <li>
                                                <a href="#address" data-toggle="tab">Address/ Contact</a>
                                            </li>
                                            <li>
                                                <a href="#additional" data-toggle="tab">Additional Details</a>
                                            </li>
                                            <li>
                                                <a href="#configurations" data-toggle="tab">Configuration</a>
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
                                                    <h5 class="tab-header mt-0">Basic Detail</h5>
                                                </div>
                                                <input type="hidden" name="id_institute" value="{{session()->get('institutionId')}}">
                                                <input type="hidden" name="id_academic" value="{{session()->get('academicYear')}}">
                                                <input type="hidden" name="staffId" id="staffId" class="form-control" value="{{ $selectedStaff->id }}">

                                                <div class="col-sm-4 text-center">
                                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail">
                                                            @if($selectedStaff->staff_image != "")
                                                                <img class="img" src="{{ $selectedStaff->staff_image }}" alt="Image" />
                                                            @else
                                                                <img class="img" src="//cdn.egenius.in/img/placeholder.jpg" alt="Image" />
                                                            @endif
                                                        </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                        <div>
                                                            <span class="btn btn-square btn-info btn-file btn-sm">
                                                                <span class="fileinput-new">Change Profile</span>
                                                                <span class="fileinput-exists">Change Profile</span>
                                                                <input type="file" name="staffImage" />
                                                                <input type="hidden" name="oldstaffImage" value="{{ $selectedStaff->staff_image }}" />
                                                            </span>
                                                            <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="material-icons">highlight_off</i></a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-8">
                                                    <div class="row">
                                                        <div class="col-sm-4 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">account_circle</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label mt-0">First Name<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="staffName" id="staffName" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" value="{{ $selectedStaff->name }}" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">account_circle</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label mt-0">Middle Name</label>
                                                                    <input type="text" class="form-control" name="staffMiddleName" id="staffMiddleName" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" value="{{ $selectedStaff->middle_name }}" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">account_circle</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label mt-0">Last Name<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="staffLastName" id="staffLastName" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" value="{{ $selectedStaff->last_name }}" required/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-4 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">event</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label mt-0">Date Of Birth<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control custom_datepicker" name="staffDob" id="staffDob" value="{{Carbon::createFromFormat('Y-m-d', $selectedStaff->date_of_birth)->format('d/m/Y')}}" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">assignment_ind</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label mt-0">Staff / Employee ID<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="employeeId" id="employeeId" value="{{ $selectedStaff->employee_id }}" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">event</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label mt-0">Date Of Joining<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control datepicker" name="joiningDate" id="joiningDate" value="{{Carbon::createFromFormat('Y-m-d', $selectedStaff->joining_date)->format('d/m/Y')}}" required />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">wc</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Gender<span class="text-danger">*</span></label>
                                                            <select class="selectpicker" name="gender" id="gender" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".genderError">
                                                                @foreach($staffDetails['gender'] as $gender)
                                                                    <option value="{{ $gender->id }}" @if($selectedStaff->id_gender == $gender->id) {{'selected'}} @endif>{{ ucwords($gender->name) }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="genderError"></div>
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
                                                            <select class="selectpicker" name="bloodGroup" id="bloodGroup" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select">
                                                                @foreach($staffDetails['bloodGroup'] as $bloodGroup)
                                                                    <option value="{{ $bloodGroup->id }}" @if($selectedStaff->id_blood_group == $bloodGroup->id) {{'selected'}} @endif>{{ $bloodGroup->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">work</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Designation</label>
                                                            <select class="selectpicker" name="designation" id="designation" data-size="5" data-style="select-with-transition" title="Select">
                                                                @foreach($staffDetails['designation'] as $designation)
                                                                    <option value="{{ $designation->id }}" @if($selectedStaff->id_designation == $designation->id) {{'selected'}} @endif>{{ ucwords($designation->name) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">portrait</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Department</label>
                                                            <select class="selectpicker" name="department" id="department" data-size="5" data-style="select-with-transition" title="Select">
                                                                @foreach($staffDetails['department'] as $department)
                                                                    <option value="{{ $department->id }}" @if($selectedStaff->id_department == $department->id) {{'selected'}} @endif>{{ ucwords($department->name) }}</option>
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
                                                            <i class="material-icons icon-middle">supervisor_account</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Staff Role<span class="text-danger">*</span></label>
                                                            <select class="selectpicker" name="staffRoll" id="staffRoll" data-size="3" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".roleError">
                                                                @foreach($staffDetails['role'] as $role)
                                                                    <option value="{{ $role->id }}" @if($selectedStaff->id_role ==$role->id) {{'selected'}} @endif>{{ ucwords($role->display_name) }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="roleError"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">person</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Staff Category<span class="text-danger">*</span></label>
                                                            <select class="selectpicker" name="staffCategory" id="staffCategory" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".categoryError">
                                                                @foreach($staffDetails['staffCategory'] as $staffCategory)
                                                                    <option value="{{ $staffCategory->id }}" data-label="{{ $staffCategory->label }}" @if($selectedStaff->id_staff_category == $staffCategory->id) {{'selected'}} @endif>{{ ucwords($staffCategory->name) }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="categoryError"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">person</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Staff Subcategory</label>
                                                            <select class="selectpicker" name="staffSubcategory" id="staffSubcategory" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select">
                                                                @foreach($staffDetails['staffSubcategory'] as $staffSubcategory)
                                                                    <option value="{{ $staffSubcategory->id }}" @if($selectedStaff->id_staff_subcategory == $staffSubcategory->id) {{'selected'}} @endif>{{ ucwords($staffSubcategory->name) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">phone</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Phone<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="staffPhone" id="staffPhone" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" number="true" onblur="this" value="{{ $selectedStaff->primary_contact_no }}" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">phone</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Emergency Contact Number</label>
                                                            <input type="text" class="form-control" name="emergencyContact" id="emergencyContact" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" number="true" onblur="this" value="{{ $selectedStaff->secondary_contact_no }}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">email</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Email <span class="text-danger">*</span></label>
                                                            <input type="email" class="form-control" name="staffEmail" id="staffEmail" value="{{ $selectedStaff->email_id }}" data-parsley-type="email" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">event_note</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Duration Of Employment</label>
                                                            <input type="text" class="form-control" name="employmentDuration" id="employmentDuration" value="{{ $selectedStaff->duration_employment }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane wizard-pane" id="address">
                                            <div class="row">
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">fiber_pin</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Pincode<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="pincode" id="pincode" minLength="6" maxlength="6" number="true" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{ $selectedStaff->pincode }}" required />
                                                            <input type="hidden" name="city" id="city" class="form-control" value="{{ $selectedStaff->city }}" />
                                                            <input type="hidden" name="state" id="state" class="form-control" value="{{ $selectedStaff->state }}" />
                                                            <input type="hidden" name="country" id="country" class="form-control" value="India" />
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
                                                            <input type="text" name="post_office" id="post_office" class="form-control" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" value="{{ $selectedStaff->post_office }}" required />
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
                                                            <input type="text" name="taluk" id="taluk" class="form-control" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" value="{{ $selectedStaff->taluk }}" required />
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
                                                            <input type="text" name="district" id="district" class="form-control" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" value="{{ $selectedStaff->district }}" required />
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
                                                            <textarea class="form-control" rows="1" name="address" id="address" required>{{ $selectedStaff->address }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h5 class="tab-header">Family Details</h5>
                                                </div>
                                            </div>

                                            <div id="repeater">
                                                <input type="hidden" name="totalCount" id="totalCount" value="{{ count($selectedStaff['familyDetails']) > 0 ? count($selectedStaff['familyDetails']) : 1 }}">

                                                @if(count($selectedStaff['familyDetails']) > 0)
                                                    @foreach($selectedStaff['familyDetails'] as $count => $familyDetails)
                                                        <div class="row" id="section_{{ $count++ }}" data-id="{{ $count++ }}">
                                                            <div class="col-lg-4 col-lg-offset-0">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="material-icons icon-middle">account_circle</i>
                                                                    </span>
                                                                    <div class="form-group">
                                                                        <label class="control-label mt-0">Name</label>
                                                                        <input type="text" class="form-control" name="familyName[]" id="familyName_1" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" value="{{ $familyDetails->name }}"/>

                                                                        <input type="hidden" name="familyMemberId[]" value="{{ $familyDetails->id }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-4 col-lg-offset-0">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="material-icons icon-middle">phone</i>
                                                                    </span>
                                                                    <div class="form-group">
                                                                        <label class="control-label mt-0">Phone</label>
                                                                        <input type="text" class="form-control" name="familyPhone[]" id="familyPhone_1" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" number="true" onblur="this" value="{{ $familyDetails->phone }}" />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 col-lg-offset-0">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="material-icons icon-middle">face</i>
                                                                    </span>
                                                                    <div class="form-group">
                                                                        <label class="control-label mt-0">Relation</label>
                                                                        <input type="text" class="form-control" name="familyRelation[]" id="familyRelation_1" value="{{ $familyDetails->relation }}" />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-1 col-lg-offset-0 text-right">
                                                                <!-- <button type="button" id="1" class="btn btn-danger btn-sm remove_button mt-30"><i class="material-icons">highlight_off</i></button> -->
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                @else

                                                    <div class="row" id="section_1" data-id="1">
                                                        <div class="col-lg-4 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">account_circle</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label mt-0">Name</label>
                                                                    <input type="text" class="form-control" name="familyName[]" id="familyName_1" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" />
                                                                    <input type="hidden" name="familyMemberId[]" value="">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">phone</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label mt-0">Phone</label>
                                                                    <input type="text" class="form-control" name="familyPhone[]" id="familyPhone_1" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" number="true" onblur="this" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">face</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label mt-0">Relation</label>
                                                                    <input type="text" class="form-control" name="familyRelation[]" id="familyRelation_1" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-1 col-lg-offset-0 text-right">
                                                            <!-- <button type="button" id="1" class="btn btn-danger btn-sm remove_button mt-30"><i class="material-icons">highlight_off</i></button> -->
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="text-left">
                                                <button id="add_more" type="button" class="btn btn-warning btn-sm"><i class="material-icons">add_circle_outline</i> Add</button>
                                            </div>
                                        </div>

                                        <div class="tab-pane wizard-pane" id="additional">
                                            <div class="row">
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">language</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Nationality</label>
                                                            <select class="selectpicker" name="nationality" id="nationality" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select">
                                                                @foreach($staffDetails['nationality'] as $nationality)
                                                                    <option value="{{ $nationality->id }}" @if($selectedStaff->id_nationality == $nationality->id) {{'selected'}} @endif>{{ ucwords($nationality->name) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">people</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Religion</label>
                                                            <select class="selectpicker" name="religion" id="religion" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select">
                                                                @foreach($staffDetails['religion'] as $religion)
                                                                    <option value="{{ $religion->id }}" @if($selectedStaff->id_religion ==$religion->id) {{'selected'}} @endif>{{ ucwords($religion->name) }}</option>
                                                                @endforeach
                                                            </select>
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
                                                            <select class="selectpicker" name="cast" id="cast" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select">
                                                                @foreach($staffDetails['category'] as $category)
                                                                    <option value="{{ $category->id }}" @if($selectedStaff->id_caste_category == $category->id) {{'selected'}} @endif>{{ ucwords($category->name) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">view_headline</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Aadhaar Card Number</label>
                                                            <input type="text" class="form-control" name="aadhaarNumber" id="aadhaarNumber" minlength="12" maxlength="12" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{ $selectedStaff->aadhaar_no }}" />
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
                                                            <label class="control-label mt-0">PAN Card Number</label>
                                                            <input type="text" class="form-control" name="panNumber" id="panNumber" value="{{ $selectedStaff->pancard_no }}" minlength="10" maxlength="10" number="true" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">view_headline</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">PF UAN Number</label>
                                                            <input type="text" class="form-control" name="uanNumber" id="uanNumber" value="{{ $selectedStaff->pf_uan_no }}" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="12" maxlength="12" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h5 class="tab-header">Attachments</h5>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="staff-attachment">
                                                    <div class="col-sm-3 text-center">
                                                        <h6 class="file_label">Adhaar Copy</h6>
                                                        <div class="fileinput fileinput-new text-center"
                                                            data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail img-square">
                                                                @if($selectedStaff->attachment_aadhaar != "")
                                                                    <img class="img" src="{{ $selectedStaff->attachment_aadhaar }}" alt="Image" />
                                                                @else
                                                                <img class="img"
                                                                    src="//cdn.egenius.in/img/placeholder.jpg" alt="Image" />
                                                                @endif
                                                            </div>
                                                            <div
                                                                class="fileinput-preview fileinput-exists thumbnail img-square">
                                                            </div>
                                                            <div>
                                                                <span class="btn btn-square btn-info btn-file btn-sm">
                                                                    <span class="fileinput-new">Change</span>
                                                                    <span class="fileinput-exists">Change</span>
                                                                    <input type="file" name="attachmentAadhaar" />
                                                                    <input type="hidden" name="oldattachmentAadhaar" value="{{ $selectedStaff->attachment_aadhaar }}" />
                                                                </span>
                                                                <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="material-icons">highlight_off</i></a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3 text-center">
                                                        <h6 class="file_label">PAN Copy</h6>
                                                        <div class="fileinput fileinput-new text-center"
                                                            data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail img-square">
                                                                @if($selectedStaff->attachment_pancard != "")
                                                                    <img class="img" src="{{ $selectedStaff->attachment_pancard }}" alt="Image" />
                                                                @else
                                                                    <img class="img" src="//cdn.egenius.in/img/placeholder.jpg" alt="Image" />
                                                                @endif
                                                            </div>
                                                            <div
                                                                class="fileinput-preview fileinput-exists thumbnail img-square">
                                                            </div>
                                                            <div>
                                                                <span class="btn btn-square btn-info btn-file btn-sm">
                                                                    <span class="fileinput-new">Change</span>
                                                                    <span class="fileinput-exists">Change</span>
                                                                    <input type="file" name="attachmentPancard" />
                                                                    <input type="hidden" name="oldattachmentPancard" value="{{ $selectedStaff->attachment_pancard }}" />
                                                                </span>
                                                                <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="material-icons">highlight_off</i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane wizard-pane" id="configurations">
                                            <div class="row">
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">school</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Board<span class="text-danger" id="board_label">*</span></label>
                                                            <input type="hidden" name="selectedBoardId" value="{{ $staffBoard?$staffBoard['id']:'' }}">
                                                            <select class="selectpicker" name="board[]" id="board" data-size="5" data-style="select-with-transition"  data-live-search="true" title="Select" multiple data-actions-box="true" data-parsley-errors-container=".belongsToError" required>
                                                                @foreach($institutionBoards as $data)
                                                                    <option value="{{ $data['id'] }}" @if(in_array($data['id'], $staffBoard)) {{ "selected" }} @endif>{{ $data['name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="belongsToError"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">view_headline</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Recruited as head teacher?<span class="text-danger" id="head_label">*</span></label>
                                                            <select class="selectpicker" name="head_teacher" id="head_teacher" data-style="select-with-transition" title="Select" data-parsley-errors-container=".headError" required>
                                                                <option value="YES" @if($selectedStaff->head_teacher == 'YES') {{ "selected" }} @endif >YES</option>
                                                                <option value="NO" @if($selectedStaff->head_teacher == 'NO') {{ "selected" }} @endif>NO</option>
                                                            </select>
                                                            <div class="headError"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">local_library</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Subject Specialization<span class="text-danger" id="specialization_label">*</span></label>
                                                            <select class="selectpicker" name="subject_specialization[]" id="subject_specialization" data-size="5" data-selected-text-format="count > 1" data-style="select-with-transition" data-live-search="true" multiple title="Select Subjects" data-actions-box="true" data-parsley-errors-container=".specializationError">
                                                                @foreach($subjects as $subject)
                                                                    <option value="{{$subject['id']}}" @if(in_array($subject['id'], $subjectMapping)) {{'selected'}} @endif>{{$subject['display_name']}}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            <div class="specializationError"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">schedule</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label mt-0">Working hours?<span class="text-danger">*</span></label>
                                                            <select class="selectpicker" name="working_hour" id="working_hour" data-size="5" data-style="select-with-transition" title="Select Working Hour" required="required" data-parsley-errors-container=".timeError">
                                                                <option value="FULL_TIME" @if($selectedStaff->working_hours == 'FULL_TIME') {{ "selected" }} @endif>Full Time</option>
                                                                <option value="PART_TIME" @if($selectedStaff->working_hours == 'PART_TIME') {{ "selected" }} @endif>Part Time</option>
                                                            </select>
                                                            <div class="timeError"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane  wizard-pane" id="other">
                                            <div class="row">
                                                @php echo $customFields; @endphp
                                            </div>
                                        </div>

                                        <div class="wizard-footer">
                                            <div class="pull-right">
                                                <input type="button" class="btn btn-next btn-fill btn-info btn-wd" name="next" value="Next" />
                                                <button type="submit" class="btn btn-finish btn-fill btn-success btn-wd" id="submit" name="submit">Submit</button>
                                            </div>
                                            <div class="pull-left">
                                                <input type="button" class="btn btn-previous btn-fill btn-default btn-wd" name="previous" value="Previous" />
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
@endsection

@section('script-content')

<script>
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Show data based on staff category
        $("#staffCategory").on("change", function(event){
            event.preventDefault();

            var staffCategoryLabel = $(this).find(':selected').attr('data-label');

            if(staffCategoryLabel == 'TEACHING'){

                $("#working_hour, #board, #head_teacher, #subject_specialization").attr('required', true);
                $('#board_label, #head_label, #specialization_label').removeClass('d-none');

            }else{

                $("#working_hour, #board, #head_teacher, #subject_specialization").attr('required', false);
                $('#board_label, #head_label, #specialization_label').addClass('d-none');
            }
        });

        // Get pincode
        $('#pincode').autocomplete({

            source: function(request, response){

                var id = $('#pincode').val();

                $.ajax({
                    type: "POST",
                    url: "/pincode-address",
                    dataType: "json",
                    data: {id: id},
                    success: function(data){
                        //console.log(data);
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
                $('#post_office').val(names[0]);
                $('#city').val(names[1]);
                $('#taluk').val(names[2]);
                $('#district').val(names[3]);
                $('#state').val(names[4]);
                $('#pincode').val(names[5]);
            }
        });

        // Get staff subcategory
        $("#staffCategory").on("change", function(event){
            event.preventDefault();

            var catId = $(this).val();

            $.ajax({
                url: "{{url('/get-sub-category')}}",
                type: "post",
                dataType: "json",
                data: {catId: catId},
                success: function(result){
                    $("#staffSubcategory").html(result['data']);
                    $("#staffSubcategory").selectpicker('refresh');
                }
            });
        });

        // Add more family details
        var count = $('#totalCount').val();

        $(document).on('click', '#add_more', function(){

            var html = '';
            count++;

            html += '<div class="row" id="section_' + count + '" data-id="' + count + '">';

            html += '<div class="col-lg-4 form-group col-lg-offset-0">';
            html += '<div class="input-group">';
            html += '<span class="input-group-addon">';
            html += '<i class="material-icons icon-middle">account_circle</i>';
            html += '</span>';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Name</label>';
            html += '<input type="text" class="form-control" name="familyName[]" id="familyName_' + count + '" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" />';
            html += '<input type="hidden" name="familyMemberId[]" value = "">';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-4 form-group col-lg-offset-0">';
            html += '<div class="input-group">';
            html += '<span class="input-group-addon">';
            html += '<i class="material-icons icon-middle">phone</i>';
            html += '</span>';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Phone</label>';
            html += '<input type="text" class="form-control" name="familyPhone[]" id="familyPhone_' + count + '" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" number="true" onblur="this" />';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-3 form-group col-lg-offset-0">';
            html += '<div class="input-group">';
            html += '<span class="input-group-addon">';
            html += '<i class="material-icons icon-middle">face</i>';
            html += '</span>';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Relation</label>';
            html += '<input type="text" class="form-control" name="familyRelation[]" id="familyRelation_' + count + '" />';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-1 col-lg-offset-0 text-right">';
            html += '<div class="form-group">';
            html += '<button type="button" id="' + count + '" class="btn btn-danger btn-sm remove_button mt-25"><i class="material-icons">highlight_off</i></button>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            $('#repeater').append(html);
            $("#totalCount").val(count);
        });

        // Remove family details
        $(document).on('click', '.remove_button', function(event){
            event.preventDefault();

            var id = $(this).attr('id'); //alert(id);
            //console.log(id);
            var totalCount = $('#repeater tr:last').attr('id');

            $(this).closest('div #section_' + id + '').remove();
            totalCount--;
        });

        // Delete family details
        $(document).on('click', '.delete_button', function(){

            var id = $(this).attr('id'); //alert(id);
            var dataId = $(this).attr('data-id');
            var parent = $(this).parents("div #section_" + dataId);

            if(confirm("Are you sure you want to delete this?")){

                $.ajax({
                    type: "DELETE",
                    url: "/staff-Family-detail/" + id,
                    dataType: "json",
                    data: {id: id},
                    success: function(result){

                        if(result['status'] == "200"){

                            if(result.data['signal'] == "success"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function(){
                                    parent.animate({
                                        backgroundColor: "#f1f1f1"
                                    }, "slow").animate({
                                        opacity: "hide"
                                    }, "slow");
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
            }

            return false;
        });

        $('#staffForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Update staff
        $('body').delegate('#staffForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');
            var id = $("#staffId").val();

            if($('#staffForm').parsley().isValid()){

                $.ajax({
                    url: "/staff/" + id,
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
                                }).then(function(){
                                    window.location.replace('/staff');
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
