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
                                <form method="POST" class="demo-form" id="staffForm" enctype="multipart/form-data">
                                    <div class="wizard-header">
                                        <h3 class="wizard-title">Add Staff</h3>
                                    </div>
                                    <div class="wizard-navigation">
                                        <ul>
                                            <li>
                                                <a href="#basic" data-toggle="tab">Basic Details</a>
                                            </li>
                                            <li>
                                                <a href="#address" data-toggle="tab">Address/Contact</a>
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
                                        <div class="tab-pane  wizard-pane" id="basic">
                                            <div class="row">
                                                <div class="col-sm-4 col-sm-offset-2">
                                                    <input type="hidden" name="id_institute"
                                                        value="{{session()->get('institutionId')}}">
                                                    <input type="hidden" name="id_academic"
                                                        value="{{session()->get('academicYear')}}">
                                                    <input type="hidden" name="organization"
                                                        value="{{session()->get('organizationId')}}">

                                                    <div class="fileinput fileinput-new text-center"
                                                        data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail">
                                                            <img src="https://cdn.egenius.in/img/placeholder.jpg"
                                                                alt="Image">
                                                        </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                        <div>
                                                            <span class="btn btn-square btn-info btn-file btn-sm">
                                                                <span class="fileinput-new">Add Profile</span>
                                                                <span class="fileinput-exists">Change Profile</span>
                                                                <input type="file" name="staffImage" />
                                                            </span>
                                                            <a href="#pablo"
                                                                class="btn btn-danger btn-square fileinput-exists btn-sm"
                                                                data-dismiss="fileinput"><i
                                                                    class="material-icons">highlight_off</i></a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">account_circle</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Name<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" class="form-control input"
                                                                name="staffName" id="staffName" minlength="2"
                                                                required />
                                                        </div>
                                                    </div>

                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">event</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Date Of Birth<span
                                                                    class="text-danger">*</span></label>
                                                            <input name="staffDob" id="staffDob" type="text"
                                                                class="form-control custom_datepicker"
                                                                data-style="select-with-transition" required
                                                                data-parsley-trigger="change" />
                                                        </div>
                                                    </div>

                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">person</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Staff / Employee ID</label>
                                                            <input type="text" class="form-control" name="employeeId"
                                                                id="employeeId" />
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
                                                            <label class="control-label">Date Of Joining<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" class="form-control datepicker"
                                                                name="joiningDate" id="joiningDate" required
                                                                data-parsley-trigger="change" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">wc</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Gender <span
                                                                    class="text-danger">*</span></label>
                                                            <select class="selectpicker" name="gender" id="gender"
                                                                data-size="5" data-style="select-with-transition"
                                                                data-live-search="true" title="Select"
                                                                required="required"
                                                                data-parsley-errors-container=".genderError">
                                                                @foreach($staffDetails['gender'] as $gender)
                                                                <option value="{{$gender->id}}">
                                                                    {{ucwords($gender->name)}}</option>
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
                                                            <label class="control-label">Blood Group</label>
                                                            <select class="selectpicker" name="bloodGroup"
                                                                id="bloodGroup" data-size="5"
                                                                data-style="select-with-transition"
                                                                data-live-search="true" title="Select">
                                                                @foreach($staffDetails['bloodGroup'] as $bloodGroup)
                                                                <option value="{{$bloodGroup->id}}">
                                                                    {{ucwords($bloodGroup->name)}}</option>
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
                                                            <label class="control-label">Designation</label>
                                                            <select class="selectpicker" name="designation"
                                                                id="designation" data-size="5"
                                                                data-style="select-with-transition"
                                                                data-live-search="true" title="Select">
                                                                @foreach($staffDetails['designation'] as $designation)
                                                                <option value="{{$designation->id}}">
                                                                    {{ucwords($designation->name)}}</option>
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
                                                            <i class="material-icons icon-middle">portrait</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Department</label>
                                                            <select class="selectpicker" name="department"
                                                                id="department" data-size="5"
                                                                data-style="select-with-transition" title="Select">
                                                                @foreach($staffDetails['department'] as $department)
                                                                <option value="{{$department->id}}">
                                                                    {{ucwords($department->name)}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">supervisor_account</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Staff Role<span
                                                                    class="text-danger">*</span></label>
                                                            <select class="selectpicker" name="staffRoll" id="staffRoll"
                                                                data-size="3" data-style="select-with-transition"
                                                                data-live-search="true" title="Select"
                                                                required="required"
                                                                data-parsley-errors-container=".roleError">
                                                                @foreach($staffDetails['role'] as $role)
                                                                <option value="{{$role->id}}">
                                                                    {{ucwords($role->display_name)}}</option>
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
                                                            <label class="control-label">Staff Category<span
                                                                    class="text-danger">*</span></label>
                                                            <select class="selectpicker" name="staffCategory"
                                                                id="staffCategory" data-size="5"
                                                                data-style="select-with-transition"
                                                                data-live-search="true" title="Select Category"
                                                                required="required"
                                                                data-parsley-errors-container=".categoryError">

                                                                @foreach($staffDetails['staffCategory'] as $cat)
                                                                <option value="{{ $cat['id'] }}"
                                                                    data-label="{{ $cat['label'] }}">{{ $cat['name'] }}
                                                                </option>
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
                                                            <label class="control-label">Staff Subcategory</label>
                                                            <select class="selectpicker" name="staffSubcategory"
                                                                id="staffSubcategory" data-size="5"
                                                                data-style="select-with-transition"
                                                                data-live-search="true" title="Select">

                                                            </select>
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
                                                            <label class="control-label">Phone<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="staffPhone"
                                                                id="staffPhone"
                                                                onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                                minlength="10" maxlength="10" number="true"
                                                                onblur="this" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">phone</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Emergency Contact Numbers</label>
                                                            <input type="text" class="form-control" name="emergencyContact" id="emergencyContact" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" number="true" onblur="this" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0 d-none">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">textsms</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">SMS For</label>
                                                            <select class="selectpicker" name="smsFor" id="smsFor"
                                                                data-style="select-with-transition" title="Select">
                                                                <option value="Primary">Primary</option>
                                                                <option value="Secondary">Secondary</option>
                                                                <option value="Both">Both</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">email</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Email<span class="text-danger">*</span></label>
                                                            <input type="email" class="form-control" name="staffEmail"
                                                                id="staffEmail" data-parsley-type="email" required/>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">event_note</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Duration Of Employment</label>
                                                            <input type="text" class="form-control"
                                                                name="employmentDuration" id="employmentDuration" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane  wizard-pane" id="address">
                                            <div class="row">
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">fiber_pin</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Pincode<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="pincode"
                                                                id="pincode" minLength="6" maxlength="6" number="true"
                                                                onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                                required />

                                                            <input type="hidden" name="city" id="city" value="" />
                                                            <input type="hidden" name="state" id="state" value="" />
                                                            <input type="hidden" name="country" id="country"
                                                                value="India" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">account_balance</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Post Office<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="post_office"
                                                                id="post_office" required
                                                                onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">location_city</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">City/Taluk<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" name="taluk" id="taluk"
                                                                class="form-control" required
                                                                onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">account_balance</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">District<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" name="district" id="district"
                                                                class="form-control" required
                                                                onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">location_on</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Address<span
                                                                    class="text-danger">*</span></label>
                                                            <textarea class="form-control" rows="1" name="address"
                                                                id="address" required></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h5 class="staff-formHeader">Family Details</h5>
                                                </div>
                                            </div>

                                            <div id="repeater">
                                                <input type="hidden" name="totalCount" id="totalCount"
                                                    class="form-control" value="1">
                                                <div class="row" id="section_1" data-id="1">
                                                    <div class="col-lg-4 col-lg-offset-0">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons icon-middle">account_circle</i>
                                                            </span>
                                                            <div class="form-group">
                                                                <label class="control-label">Name</label>
                                                                <input type="text" class="form-control"
                                                                    name="familyName[]" id="familyName_1"
                                                                    onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-lg-offset-0">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons icon-middle">phone</i>
                                                            </span>
                                                            <div class="form-group">
                                                                <label class="control-label">Phone</label>
                                                                <input type="text" class="form-control"
                                                                    name="familyPhone[]" id="familyPhone_1"
                                                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                                    minlength="10" maxlength="10" number="true"
                                                                    onblur="this" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-lg-offset-0">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons icon-middle">face</i>
                                                            </span>
                                                            <div class="form-group">
                                                                <label class="control-label">Relation</label>
                                                                <input type="text" class="form-control"
                                                                    name="familyRelation[]" id="familyRelation_1" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-1 col-lg-offset-0 text-right">
                                                        <!-- <button type="button" id="1" class="btn btn-danger btn-sm remove_button mt-30"><i class="material-icons">highlight_off</i></button> -->
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-lg-offset-0">
                                                <button id="add_more" type="button" class="btn btn-warning btn-sm"><i
                                                        class="material-icons">add_circle_outline</i> Add</button>
                                            </div>
                                        </div>

                                        <div class="tab-pane  wizard-pane" id="additional">
                                            <div class="row">
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">language</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Nationality</label>
                                                            <select class="selectpicker" name="nationality"
                                                                id="nationality" data-size="5"
                                                                data-style="select-with-transition"
                                                                data-live-search="true" title="Select">
                                                                @foreach($staffDetails['nationality'] as $nationality)
                                                                <option value="{{$nationality->id}}">
                                                                    {{ucwords($nationality->name)}}</option>
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
                                                            <label class="control-label">Religion</label>
                                                            <select class="selectpicker" name="religion" id="religion"
                                                                data-size="5" data-style="select-with-transition"
                                                                data-live-search="true" title="Select">
                                                                @foreach($staffDetails['religion'] as $religion)
                                                                <option value="{{$religion->id}}">
                                                                    {{ucwords($religion->name)}}</option>
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
                                                            <label class="control-label">Caste Category</label>
                                                            <select class="selectpicker" name="cast" id="cast"
                                                                data-size="5" data-style="select-with-transition"
                                                                data-live-search="true" title="Select">
                                                                @foreach($staffDetails['category'] as $category)
                                                                <option value="{{$category->id}}">
                                                                    {{ucwords($category->name)}}</option>
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
                                                            <label class="control-label">Aadhaar Card Number</label>
                                                            <input type="text" class="form-control" name="aadhaarNumber"
                                                                id="aadhaarNumber" minlength="12" maxlength="12"
                                                                onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
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
                                                            <label class="control-label">PAN Card Number</label>
                                                            <input type="text" class="form-control" name="panNumber"
                                                                id="panNumber" minlength='10' maxlength='10' />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">view_headline</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">PF UAN Number</label>
                                                            <input type="text" class="form-control" name="uanNumber"
                                                                id="uanNumber" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength='12' maxlength='12' />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h5 class="staff-formHeader">Attachments</h5>
                                                </div>
                                            </div>

                                            <div class="row mt-30">
                                                <div class="staff-attachment">
                                                    <div class="col-sm-3">
                                                        <h6 class="file_label">Adhaar Copy</h6>
                                                        <div class="fileinput fileinput-new text-center"
                                                            data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail img-square">
                                                                <img src="https://cdn.egenius.in/img/placeholder.jpg"
                                                                    alt="Image">
                                                            </div>
                                                            <div
                                                                class="fileinput-preview fileinput-exists thumbnail img-square">
                                                            </div>
                                                            <div>
                                                                <span class="btn btn-square btn-info btn-file btn-sm">
                                                                    <span class="fileinput-new">Add</span>
                                                                    <span class="fileinput-exists">Change</span>
                                                                    <input type="file" name="attachmentAadhaar"
                                                                        id="attachmentAadhaar" />
                                                                </span>
                                                                <a href="#pablo"
                                                                    class="btn btn-danger btn-square fileinput-exists btn-sm"
                                                                    data-dismiss="fileinput"><i
                                                                        class="material-icons">highlight_off</i></a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <h6 class="file_label">PAN Copy</h6>
                                                        <div class="fileinput fileinput-new text-center"
                                                            data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail img-square">
                                                                <img src="https://cdn.egenius.in/img/placeholder.jpg"
                                                                    alt="Image">
                                                            </div>
                                                            <div
                                                                class="fileinput-preview fileinput-exists thumbnail img-square">
                                                            </div>
                                                            <div>
                                                                <span class="btn btn-square btn-info btn-file btn-sm">
                                                                    <span class="fileinput-new">Add</span>
                                                                    <span class="fileinput-exists">Change</span>
                                                                    <input type="file" name="attachmentPancard"
                                                                        id="attachmentPancard" />
                                                                </span>
                                                                <a href="#pablo"
                                                                    class="btn btn-danger btn-square fileinput-exists btn-sm"
                                                                    data-dismiss="fileinput"><i
                                                                        class="material-icons">highlight_off</i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane  wizard-pane" id="configurations">
                                            <div class="row">
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">school</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Board<span class="text-danger"
                                                                    id="board_label">*</span></label>
                                                            <select class="selectpicker" name="board[]" id="board"
                                                                data-size="5" data-style="select-with-transition"
                                                                data-live-search="true"
                                                                data-selected-text-format="count > 1"
                                                                title="Select Board" multiple data-actions-box="true"
                                                                data-parsley-errors-container=".belongsToError"
                                                                required>
                                                                @foreach($institutionBoards as $data)
                                                                <option value="{{ $data['id'] }}">{{$data['name']}}
                                                                </option>
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
                                                            <label class="control-label">Recruited as head
                                                                teacher?<span class="text-danger"
                                                                    id="head_label">*</span></label>
                                                            <select class="selectpicker" name="head_teacher"
                                                                id="head_teacher" data-size="5"
                                                                data-style="select-with-transition" title="Select"
                                                                data-parsley-errors-container=".headError" required>
                                                                <option value="YES">Yes</option>
                                                                <option value="NO">No</option>
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
                                                            <label class="control-label">Subject Specialization<span
                                                                    class="text-danger"
                                                                    id="specialization_label">*</span></label>
                                                            <select class="selectpicker" name="subject_specialization[]"
                                                                id="subject_specialization" data-size="5"
                                                                data-style="select-with-transition"
                                                                data-live-search="true"
                                                                data-selected-text-format="count > 1" multiple
                                                                title="Select Subjects"
                                                                data-parsley-errors-container=".specializationError"
                                                                required>
                                                                @foreach($subjects as $data)
                                                                <option value="{{$data['id']}}">
                                                                    {{$data['display_name']}}</option>
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
                                                            <label class="control-label">Working hours?<span
                                                                    class="text-danger">*</span></label>
                                                            <select class="selectpicker" name="working_hour"
                                                                id="working_hour" data-size="5"
                                                                data-style="select-with-transition"
                                                                title="Select Working Hour" required="required"
                                                                data-parsley-errors-container=".timeError">
                                                                <option value="FULL_TIME">Full Time</option>
                                                                <option value="PART_TIME">Part Time</option>
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
                                                <input type='button' class='btn btn-next btn-fill btn-info btn-wd'
                                                    name='next' value='Next' />
                                                <button type='submit' class='btn btn-finish btn-fill btn-success btn-wd'
                                                    id="submit" name='submit'>Submit</button>
                                            </div>
                                            <div class="pull-left">
                                                <input type='button'
                                                    class='btn btn-previous btn-fill btn-default btn-wd' name='previous'
                                                    value='Previous' />
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
$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#staffForm').parsley({
        triggerAfterFailure: 'input change focusout changed.bs.select'
    });

    // Show Data Based On Staff Category
    $("#staffCategory").on("change", function(event) {
        event.preventDefault();

        var staffCategoryLabel = $(this).find(':selected').attr('data-label');

        if (staffCategoryLabel == 'TEACHING') {
            $("#working_hour, #board, #head_teacher, #subject_specialization").attr('required', true);
            $('#board_label, #head_label, #specialization_label').removeClass('d-none');
        } else {

            $("#working_hour, #board, #head_teacher, #subject_specialization").attr('required', false);
            $('#board_label, #head_label, #specialization_label').addClass('d-none');
        }
    });

    // Pincode
    $('#pincode').autocomplete({
        source: function(request, response) {
            var id = $('#pincode').val();
            $.ajax({
                type: "POST",
                url: "/pincode-address",
                dataType: "json",
                data: {
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    response(data);
                    response($.map(data, function(item) {
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
        select: function(event, ui) {
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

    // Get Staff Subcategory
    $("#staffCategory").on("change", function(event) {
        event.preventDefault();

        var catId = $(this).val();

        $.ajax({
            url: "{{url('/get-sub-category')}}",
            type: "post",
            dataType: "json",
            data: {
                catId: catId
            },
            success: function(result) {
                $("#staffSubcategory").html(result['data']);
                $("#staffSubcategory").selectpicker('refresh');
            }
        });
    });

    // Add More Family Details
    var count = $('#totalCount').val();

    $(document).on('click', '#add_more', function() {

        var html = '';
        count++;

        html += '<div class="row" id="section_' + count + '" data-id="' + count + '">';
        html += '<div class="col-lg-4 form-group col-lg-offset-0">';
        html += '<div class="input-group">';
        html += '<span class="input-group-addon">';
        html += '<i class="material-icons icon-middle">account_circle</i>';
        html += '</span>';
        html += '<div class="form-group">';
        html += '<label class="control-label">Name</label>';
        html += '<input type="text" class="form-control" name="familyName[]" id="familyName_' + count +
            '" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" />';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        html += '<div class="col-lg-4 form-group col-lg-offset-0">';
        html += '<div class="input-group">';
        html += '<span class="input-group-addon">';
        html += '<i class="material-icons icon-middle">phone</i>';
        html += '</span>';
        html += '<div class="form-group">';
        html += '<label class="control-label">Phone</label>';
        html += '<input type="text" class="form-control" name="familyPhone[]" id="familyPhone_' +
            count +
            '" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" number="true" onblur="this" />';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        html += '<div class="col-lg-3 form-group col-lg-offset-0">';
        html += '<div class="input-group">';
        html += '<span class="input-group-addon">';
        html += '<i class="material-icons icon-middle">face</i>';
        html += '</span>';
        html += '<div class="form-group">';
        html += '<label class="control-label">Relation</label>';
        html += '<input type="text" class="form-control" name="familyRelation[]" id="familyRelation_' +
            count + '" />';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        html += ' <div class="col-lg-1 form-group col-lg-offset-0 text-right">';
        html += '<button type="button" id="' + count +
            '" class="btn btn-danger btn-sm remove_button mt-30"><i class="material-icons">highlight_off</i></button>';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        $('#repeater').append(html);
        $("#totalCount").val(count);
        //$(this).find(".master_category"+count+"").selectpicker();
    });

    // Remove Family Details
    $(document).on('click', '.remove_button', function(event) {
        event.preventDefault();

        var id = $(this).attr('id'); //alert(id);
        console.log(id);
        var totalCount = $('#repeater tr:last').attr('id');

        $(this).closest('div #section_' + id + '').remove();
        totalCount--;
    });

    // Save Staff
    $('body').delegate('#staffForm', 'submit', function(e) {
        e.preventDefault();

        var btn = $('#submit');
        if ($('#staffForm').parsley().isValid()) {

            $.ajax({
                url: "{{url('/staff')}}",
                type: "post",
                dataType: "json",
                data: new FormData(this),
                contentType: false,
                processData: false,
                beforeSend: function() {
                    btn.html('Submitting...');
                    btn.attr('disabled', true);
                },
                success: function(result) {
                    btn.html('Submit');
                    btn.attr('disabled', false);

                    if (result['status'] == "200") {

                        if (result.data['signal'] == "success") {

                            swal({
                                title: result.data['message'],
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-success"
                            }).then(function() {
                                window.location.replace('/staff');
                            }).catch(swal.noop)

                        } else if (result.data['signal'] == "exist") {

                            swal({
                                title: result.data['message'],
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-warning"
                            });

                        } else {

                            swal({
                                title: result.data['message'],
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-danger"
                            });
                        }

                    } else {

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