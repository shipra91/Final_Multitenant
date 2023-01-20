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
                    <div class="col-sm-12 col-sm-offset-0">
                        <div class="wizard-container">
                            <div class="card wizard-card" data-color="mediumaquamarine" id="wizardProfile">
                                <form method="POST" class="demo-form" id="institutionForm" enctype="multipart/form-data">
                                    <div class="wizard-header">
                                        <h3 class="wizard-title">Institution Details</h3>
                                    </div>
                                    <div class="wizard-navigation">
                                        <ul>
                                            <li>
                                                <a href="#about" data-toggle="tab">Basic Details</a>
                                            </li>
                                            <li>
                                                <a href="#other" data-toggle="tab">Other Details</a>
                                            </li>
                                            <li>
                                                <a href="#additional" data-toggle="tab">Additional Details</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane  wizard-pane" id="about">
                                            <div class="row">
                                                <input type="hidden" name="senderId" id="senderId" value="EGENIUS" />
                                                <input type="hidden" name="entityId" id="entityId" value="123" />
                                                <input type="hidden" name="city" id="city" />
                                                <input type="hidden" name="state" id="state" />
                                                <input type="hidden" name="country" id="country" value="India" />
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">school</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Organization<span
                                                                    class="text-danger">*</span></label>
                                                            <select class="selectpicker" name="organizationName"
                                                                id="organizationName" data-size="5"
                                                                data-style="select-with-transition"
                                                                data-live-search="true" title="Select Organization"
                                                                required="required"
                                                                data-parsley-errors-container=".organizationError">
                                                                @foreach($organizations as $data)
                                                                <option value="{{ $data->id }}">{{ucwords($data->name)}}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            <div class="organizationError"></div>
                                                        </div>
                                                    </div>

                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">school</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Institution Name <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control input" name="institutionName" id="institutionName" minlength="2" required onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" />
                                                        </div>
                                                    </div>

                                                    <div class="input-group p-t-10">
                                                        <div class="form-group label-floating">
                                                            <div class='checkbox col-md-12 input-group'>
                                                                <label>
                                                                    <input type="checkbox" id='checkbox'><span class="organization-sameAs">Address Details Same as Organization</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-6 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">fiber_pin</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label">Pincode<span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control"
                                                                        name="pincode" id="pincode" minLength="6"
                                                                        maxlength="6" number="true"
                                                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                                        required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i
                                                                        class="material-icons icon-middle">account_balance</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label">Post Office<span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control"
                                                                        name="postOffice" id="postOffice"
                                                                        onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)"
                                                                        required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i
                                                                        class="material-icons icon-middle">location_city</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label">City/Taluk<span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text" ` name="taluk" id="taluk"
                                                                        class="form-control" required
                                                                        onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i
                                                                        class="material-icons icon-middle">account_balance</i>
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
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-12 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i
                                                                        class="material-icons icon-middle">location_on</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label">Address<span
                                                                            class="text-danger">*</span></label>
                                                                    <textarea class="form-control" rows="1"
                                                                        name="institutionAddress"
                                                                        id="institutionAddress" required></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4 text-center col-sm-offset-1">
                                                    <div class="row form-group">
                                                        <div class="col-lg-12">
                                                            <div class="fileinput fileinput-new text-center"
                                                                data-provides="fileinput">
                                                                <div class="fileinput-new thumbnail">
                                                                    <img src="https://cdn.egenius.in/img/placeholder.jpg"
                                                                        alt="Image">
                                                                </div>
                                                                <div
                                                                    class="fileinput-preview fileinput-exists thumbnail">
                                                                </div>
                                                                <div>
                                                                    <span
                                                                        class="btn btn-square btn-info btn-file btn-sm">
                                                                        <span class="fileinput-new">Institution Logo
                                                                            <span class="text-danger">*</span></span>
                                                                        <span class="fileinput-exists">Change
                                                                            Logo</span>
                                                                        <input type="file" name="institutionLogo"
                                                                            accept="image/*" required
                                                                            data-parsley-errors-container=".logoError" />
                                                                    </span>
                                                                    <a href="#pablo"
                                                                        class="btn btn-danger btn-square fileinput-exists btn-sm"
                                                                        data-dismiss="fileinput"><i
                                                                            class="material-icons">highlight_off</i></a>
                                                                </div>
                                                                <div class="logoError"></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row form-group">
                                                        <div class="col-lg-12">
                                                            <div class="fileinput fileinput-new text-center"
                                                                data-provides="fileinput">
                                                                <div class="fileinput-new thumbnail">
                                                                    <img src="https://cdn.egenius.in/img/placeholder.jpg"
                                                                        alt="Image">
                                                                </div>
                                                                <div
                                                                    class="fileinput-preview fileinput-exists thumbnail">
                                                                </div>
                                                                <div>
                                                                    <span
                                                                        class="btn btn-square btn-info btn-file btn-sm">
                                                                        <span class="fileinput-new">Fav Icon <span
                                                                                class="text-danger">*</span></span>
                                                                        <span class="fileinput-exists">Change Fav
                                                                            Icon</span>
                                                                        <input type="file" name="favIcon" id="favIcon"
                                                                            accept="image/*" required
                                                                            data-parsley-errors-container=".fabError" />
                                                                    </span>
                                                                    <a href="#pablo"
                                                                        class="btn btn-danger btn-square fileinput-exists btn-sm"
                                                                        data-dismiss="fileinput"><i
                                                                            class="material-icons">highlight_off</i></a>
                                                                </div>
                                                                <div class="fabError"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane  wizard-pane" id="other" ng-controller="other">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h5
                                                        style="padding: 0px 20px; margin-bottom: 0px; color: #5a5a5a; font-weight: 400;">
                                                        Institution Settings</h5>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12 col-lg-offset-0">
                                                    <div class="m-t-20" id="repeater2">
                                                        <input type="hidden" name="totalCount" id="totalCount"
                                                            class="form-control" value="1">
                                                        <div class="row" id="section_1" data-id="1">
                                                            <div class="col-lg-3 form-group col-lg-offset-0">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="material-icons icon-middle">school</i>
                                                                    </span>
                                                                    <div class="form-group">
                                                                        <label
                                                                            class="control-label">Board/University<span
                                                                                class="text-danger">*</span></label>
                                                                        <select class="selectpicker board_university"
                                                                            name="board_university[]"
                                                                            id="board_university_1" data-size="5"
                                                                            data-style="select-with-transition"
                                                                            data-live-search="true"
                                                                            title="Select Option" required="required"
                                                                            data-parsley-errors-container=".universityError">
                                                                            @foreach($courseMaster as $data)
                                                                            <option value="{{ $data['id'] }}">
                                                                                {{$data['name']}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <div class="universityError"></div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 form-group col-lg-offset-0">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="material-icons icon-middle">school</i>
                                                                    </span>
                                                                    <div class="form-group">
                                                                        <label class="control-label">Institution
                                                                            Type<span
                                                                                class="text-danger">*</span></label>
                                                                        <select class="selectpicker institution_type"
                                                                            name="institution_type[]"
                                                                            id="institution_type_1" data-size="5"
                                                                            data-style="select-with-transition"
                                                                            data-live-search="true"
                                                                            title="Select Option" required="required"
                                                                            data-parsley-errors-container=".typeError">

                                                                        </select>
                                                                        <div class="typeError"></div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 form-group col-lg-offset-0">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="material-icons icon-middle">school</i>
                                                                    </span>
                                                                    <div class="form-group">
                                                                        <label class="control-label">Course<span
                                                                                class="text-danger">*</span></label>
                                                                        <select class="selectpicker course"
                                                                            name="course[]" id="course_1" data-size="5"
                                                                            data-style="select-with-transition"
                                                                            data-live-search="true" title="Select"
                                                                            required="required"
                                                                            data-parsley-errors-container=".courseError">
                                                                            <!-- @foreach($organizations as $data)
                                                                                <option value="{{ $data->id }}">{{ucwords($data->name)}}</option>
                                                                            @endforeach -->
                                                                        </select>
                                                                        <div class="courseError"></div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 form-group col-lg-offset-0">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="material-icons icon-middle">school</i>
                                                                    </span>
                                                                    <div class="form-group">
                                                                        <label class="control-label">Stream<span
                                                                                class="text-danger">*</span></label>
                                                                        <select class="selectpicker stream"
                                                                            name="stream[]" id="stream_1" data-size="5"
                                                                            data-style="select-with-transition"
                                                                            data-live-search="true" title="Select"
                                                                            required="required"
                                                                            data-parsley-errors-container=".streamError">
                                                                            <!-- @foreach($organizations as $data)
                                                                                <option value="{{ $data->id }}">{{ucwords($data->name)}}</option>
                                                                            @endforeach -->
                                                                        </select>
                                                                        <div class="streamError"></div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 form-group col-lg-offset-0">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="material-icons icon-middle">school</i>
                                                                    </span>
                                                                    <div class="form-group">
                                                                        <label class="control-label">Combination<span
                                                                                class="text-danger">*</span></label>
                                                                        <select class="selectpicker combination"
                                                                            name="combination[1][]" id="combination_1"
                                                                            data-size="5"
                                                                            data-style="select-with-transition"
                                                                            data-live-search="true" title="Select"
                                                                            required="required" multiple
                                                                            data-actions-box="true"
                                                                            data-parsley-errors-container=".combinationError">
                                                                            <!-- @foreach($organizations as $data)
                                                                                <option value="{{ $data->id }}">{{ucwords($data->name)}}</option>
                                                                            @endforeach -->
                                                                        </select>
                                                                        <div class="combinationError"></div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 col-lg-offset-0">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i
                                                                            class="material-icons icon-middle">event_note</i>
                                                                    </span>
                                                                    <div class="form-group">
                                                                        <label class="control-label">Institution
                                                                            Code</label>
                                                                        <input type="text" class="form-control"
                                                                            name="institution_code[]"
                                                                            id="institution_code" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- <div class="col-lg-1 form-group col-lg-offset-0">
                                                                <button type="button" id="1" class="btn btn-danger btn-sm first_button remove_button d-none"><i class="material-icons">highlight_off</i></button>
                                                            </div> --}}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="m-l-30">
                                                    <button id="add_more_mapping" type="button"
                                                        class="btn btn-warning btn-sm"><i
                                                            class="material-icons">add_circle_outline</i> Add
                                                        More</button>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h5
                                                        style="padding: 20px 0px 0px 20px; margin-bottom: 0px; color: #5a5a5a; font-weight: 400;">
                                                        Institution Office Contact Detail</h5>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">phone</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Contact</label>
                                                            <input type="text" class="form-control"
                                                                name="institutionContact" id="institutionContact"
                                                                onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                                minlength="10" maxlength="10" number="true"
                                                                onblur="this" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">phone</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Landline Number</label>
                                                            <input type="text" class="form-control"
                                                                name="landlineNumber" id="landlineNumber"
                                                                onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
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
                                                            <input type="email" class="form-control" name="institutionEmail" id="institutionEmail" required/>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">insert_link</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Website URL without Protocol <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="websiteUrl" id="websiteUrl" required/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <h5
                                                        style="padding: 20px 0px 0px 20px; margin-bottom: 0px; color: #5a5a5a; font-weight: 400;">
                                                        POC (Point Of Contact) Detail</h5>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12 col-lg-offset-0">
                                                    <div class="m-t-20" id="repeater1">
                                                        <input type="hidden" name="totalCount" id="totalCount"
                                                            class="form-control" value="1">
                                                        <div class="row" id="section_1" data-id="1">
                                                            <div class="col-lg-3 form-group col-lg-offset-0">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i
                                                                            class="material-icons icon-middle">account_circle</i>
                                                                    </span>
                                                                    <div class="form-group">
                                                                        <label class="control-label">Name<span
                                                                                class="text-danger">*</span></label>
                                                                        <input type="text" class="form-control"
                                                                            name="management_name[]"
                                                                            onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)"
                                                                            required />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 form-group col-lg-offset-0">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i
                                                                            class="material-icons icon-middle">bookmark</i>
                                                                    </span>
                                                                    <div class="form-group">
                                                                        <label class="control-label">Designation<span
                                                                                class="text-danger">*</span></label>
                                                                        <input type="text"
                                                                            class="form-control management_designation"
                                                                            name="management_designation[]"
                                                                            onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)"
                                                                            required />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-2 form-group col-lg-offset-0">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="material-icons icon-middle">phone</i>
                                                                    </span>
                                                                    <div class="form-group">
                                                                        <label class="control-label">Phone No<span
                                                                                class="text-danger">*</span></label>
                                                                        <input type="text" class="form-control"
                                                                            name="management_phoneNumber[]"
                                                                            onblur="this"
                                                                            onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                                            minlength="10" maxlength="10" required />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 form-group col-lg-offset-0">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <i class="material-icons icon-middle">mail</i>
                                                                    </span>
                                                                    <div class="form-group">
                                                                        <label class="control-label">Email-ID<span
                                                                                class="text-danger">*</span></label>
                                                                        <input type="email" class="form-control"
                                                                            name="management_email_id[]" required />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            {{-- <div class="col-lg-1 form-group col-lg-offset-0">
                                                                <button type="button" id="1" class="btn btn-danger btn-sm first_button remove_button d-none"><i class="material-icons">highlight_off</i></button>
                                                            </div> --}}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="m-l-30">
                                                    <button id="add_more" type="button"
                                                        class="btn btn-warning btn-sm"><i
                                                            class="material-icons">add_circle_outline</i> Add
                                                        More</button>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h5
                                                        style="padding: 20px 0px 0px 20px; margin-bottom: 0px; color: #5a5a5a; font-weight: 400;">
                                                        Modules Detail</h5>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12 col-lg-offset-0">
                                                    <div class="col-lg-6 col-lg-offset-0">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons icon-middle">dashboard</i>
                                                            </span>
                                                            <div class="form-group">
                                                                <label class="control-label">Modules to Enable<span
                                                                        class="text-danger">*</span></label>
                                                                <select class="selectpicker" name="modules[]"
                                                                    id="modules" data-size="5"
                                                                    data-style="select-with-transition"
                                                                    data-live-search="true"
                                                                    data-selected-text-format="count > 3" title="Select"
                                                                    multiple required="required" data-actions-box="true"
                                                                    data-parsley-errors-container=".moduleError">
                                                                    @foreach($module as $moduleName)
                                                                    <option value="{{$moduleName->id}}">
                                                                        {{ucwords($moduleName->display_name)}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="moduleError"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane  wizard-pane" id="additional" ng-controller="additional">
                                            <div class="col-lg-12 col-lg-offset-0">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <h5
                                                            style="padding: 0px 20px; margin-bottom: 0px; color: #5a5a5a; font-weight: 400;">
                                                            Area Partner Details</h5>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4 col-lg-offset-0">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons icon-middle">account_circle</i>
                                                            </span>
                                                            <div class="form-group">
                                                                <label class="control-label">Name<span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    name="areaPartnerName" id="areaPartnerName"
                                                                    onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)"
                                                                    required />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-lg-offset-0">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons icon-middle">phone</i>
                                                            </span>
                                                            <div class="form-group">
                                                                <label class="control-label">Contact<span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    name="areaPartnerContact" id="areaPartnerContact"
                                                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                                    minlength="10" maxlength="10" number="true"
                                                                    onblur="this" required />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-lg-offset-0">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons icon-middle">
                                                                    <i class="material-icons">email</i>
                                                                </i>
                                                            </span>
                                                            <div class="form-group">
                                                                <label class="control-label">Email<span
                                                                        class="text-danger">*</span></label>
                                                                <input type="email" class="form-control"
                                                                    name="areaPartnerEmail" id="areaPartnerEmail"
                                                                    required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <h5
                                                            style="padding: 20px 0px 0px 20px; margin-bottom: 0px; color: #5a5a5a; font-weight: 400;">
                                                            Zonal Partner Details</h5>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-4 col-lg-offset-0">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons icon-middle">account_circle</i>
                                                            </span>
                                                            <div class="form-group">
                                                                <label class="control-label">Name<span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    name="zonalPartnerName" id="zonalPartnerName"
                                                                    onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)"
                                                                    required />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-lg-offset-0">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons icon-middle">phone</i>
                                                            </span>
                                                            <div class="form-group">
                                                                <label class="control-label">Contact<span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    name="zonalPartnerContact" id="zonalPartnerContact"
                                                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                                    minlength="10" maxlength="10" number="true"
                                                                    onblur="this" required />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-lg-offset-0">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons icon-middle">email</i>
                                                            </span>
                                                            <div class="form-group">
                                                                <label class="control-label">Email<span
                                                                        class="text-danger">*</span></label>
                                                                <input type="email" class="form-control"
                                                                    name="zonalPartnerEmail" id="zonalPartnerEmail"
                                                                    required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

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

    $('#institutionForm').parsley({
        triggerAfterFailure: 'input keyup change focusout changed.bs.select'
    });
    
    // Pincode
    $('#pincode').autocomplete({
        source: function(request, response) {
            var id = $('#pincode').val();
            $.ajax({
                type: "POST",
                url: "/etpl/pincode-address",
                dataType: "json",
                data: {
                    id: id
                },
                success: function(data) {
                    // console.log(data);
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
            $('#postOffice').val(names[0]);
            $('#city').val(names[1]);
            $('#taluk').val(names[2]);
            $('#district').val(names[3]);
            $('#state').val(names[4]);
            $('#pincode').val(names[5]);
        }
    });

    // Add More Institution Settings
    var count = $('#totalCount').val();

    $(document).on('click', '#add_more_mapping', function() {

        var html = '';
        count++;

        html += '<div class="row" id="section_' + count + '" data-id="' + count + '">';
        html += '<div class="col-lg-3 form-group col-lg-offset-0">';
        html += '<div class="input-group">';
        html += '<span class="input-group-addon">';
        html += '<i class="material-icons icon-middle">school</i>';
        html += '</span>';
        html += '<div class="form-group">';
        html +=
            '<label class="control-label">Board/University<span class="text-danger">*</span></label>';
        html +=
            '<select class="selectpicker board_university" name="board_university[]" id="board_university_' +
            count + '" data-id="' + count +
            '" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" data-parsley-required="required">';
        <?php foreach($courseMaster as $data){ ?>
        html += '<option value="<?php echo $data['id'];?>"><?php echo $data['name'];?></option>';
        <?php } ?>
        html += '</select>';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        html += '<div class="col-lg-3 form-group col-lg-offset-0">';
        html += '<div class="input-group">';
        html += '<span class="input-group-addon">';
        html += '<i class="material-icons icon-middle">school</i>';
        html += '</span>';
        html += '<div class="form-group">';
        html +=
            '<label class="control-label">Institution Type<span class="text-danger">*</span></label>';
        html +=
            '<select class="selectpicker institution_type" name="institution_type[]" id="institution_type_' +
            count +
            '" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required"></select>';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        html += '<div class="col-lg-3 form-group col-lg-offset-0">';
        html += '<div class="input-group">';
        html += '<span class="input-group-addon">';
        html += '<i class="material-icons icon-middle">school</i>';
        html += '</span>';
        html += '<div class="form-group">';
        html += '<label class="control-label">Course<span class="text-danger">*</span></label>';
        html += '<select class="selectpicker course" name="course[]" id="course_' + count +
            '" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required"></select>';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        html += '<div class="col-lg-3 form-group col-lg-offset-0">';
        html += '<div class="input-group">';
        html += '<span class="input-group-addon">';
        html += '<i class="material-icons icon-middle">school</i>';
        html += '</span>';
        html += '<div class="form-group">';
        html += '<label class="control-label">Stream<span class="text-danger">*</span></label>';
        html += '<select class="selectpicker stream" name="stream[]" id="stream_' + count +
            '" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required"></select>';
        html += '</div>';
        html += '</div>';
        html += '</div>'

        html += '<div class="col-lg-3 form-group col-lg-offset-0">';
        html += '<div class="input-group">';
        html += '<span class="input-group-addon">';
        html += '<i class="material-icons icon-middle">school</i>';
        html += '</span>';
        html += '<div class="form-group">';
        html += '<label class="control-label">Combination<span class="text-danger">*</span></label>';
        html += '<select class="selectpicker combination" name="combination[' + count +
            '][]" id="combination_' + count +
            '" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required" multiple data-actions-box="true"></select>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '<div class="col-lg-3 col-lg-offset-0">';
        html += '<div class="input-group">';
        html += '<span class="input-group-addon">';
        html += '<i class="material-icons icon-middle">event_note</i>';
        html += '</span>';
        html += '<div class="form-group">';
        html += '<label class="control-label">Institution Code</label>';
        html +=
            '<input type="text" class="form-control" name="institution_code[]" id="institution_code" />';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        html += ' <div class="col-lg-1 form-group col-lg-offset-0">';
        html += '<td><button type="button" id="' + count +
            '" class="btn btn-danger btn-sm remove_button1"><i class="material-icons">highlight_off</i></button></td>';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        $('#repeater2').append(html);
        $("#totalCount").val(count);
        $(".board_university").selectpicker();
        $(".institution_type").selectpicker();
        $(".course").selectpicker();
        $(".stream").selectpicker();
        $(".combination").selectpicker();

        $('#board_university_' + count).on('change', function() {
            var boardUniversity = $(this).val();
            var index = $(this).parents('.row').attr('data-id');
            getInstitutionType(boardUniversity, index);
        });

        $('#institution_type_' + count).on('change', function() {
            var institutionType = $(this).val();
            var boardUniversity = $('#board_university_1').val();
            var index = $(this).parents('.row').attr('data-id');
            getCourse(institutionType, boardUniversity, index);
        });

        $('#course_' + count).on('change', function() {
            var course = $(this).val();
            var boardUniversity = $('#board_university_1').val();
            var institutionType = $('#institution_type_1').val();
            var index = $(this).parents('.row').attr('data-id');
            getStream(course, institutionType, boardUniversity, index);
        });

        $('#stream_' + count).on('change', function() {
            var stream = $(this).val();
            var boardUniversity = $('#board_university_1').val();
            var course = $('#course_1').val();
            var institutionType = $('#institution_type_1').val();
            var index = $(this).parents('.row').attr('data-id');
            getCombination(stream, course, institutionType, boardUniversity, index);
        });

    });

    // Remove Institution Settings
    $(document).on('click', '.remove_button1', function(event) {
        event.preventDefault();

        var id = $(this).attr('id'); //alert(id);
        var totalCount = $('#repeater2 tr:last').attr('id');

        $(this).closest('div #section_' + id + '').remove();
        totalCount--;
    });

    // Add More Management Details
    var count = $('#totalCount').val();

    $(document).on('click', '#add_more', function() {

        var html = '';
        count++;

        html += '<div class="row" id="section_' + count + '" data-id="' + count + '">';
        html += '<div class="col-lg-3 form-group col-lg-offset-0">';
        html += '<div class="input-group">';
        html += '<span class="input-group-addon">';
        html += '<i class="material-icons icon-middle">account_circle</i>';
        html += '</span>';
        html += '<div class="form-group">';
        html += '<label class="control-label">Name<span class="text-danger">*</span></label>';
        html +=
            '<td><input type="text" class="form-control" name="management_name[]" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" required></td>';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        html += '<div class="col-lg-3 form-group col-lg-offset-0">';
        html += '<div class="input-group">';
        html += '<span class="input-group-addon">';
        html += '<i class="material-icons icon-middle">bookmark</i>';
        html += '</span>';
        html += '<div class="form-group">';
        html += '<label class="control-label">Designation<span class="text-danger">*</span></label>';
        html += '<td>';
        html +=
            '<input type="text" class="form-control management_designation" id="management_designation_' +
            count +
            '" name="management_designation[]" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" required>';
        html += '</td>';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        html += '<div class="col-lg-2 form-group col-lg-offset-0">';
        html += '<div class="input-group">';
        html += '<span class="input-group-addon">';
        html += '<i class="material-icons icon-middle">phone</i>';
        html += '</span>';
        html += '<div class="form-group">';
        html += '<label class="control-label">Phone No<span class="text-danger">*</span></label>';
        html +=
            '<td><input type="text" class="form-control" name="management_phoneNumber[]" onblur="this" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" required></td>';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        html += '<div class="col-lg-3 form-group col-lg-offset-0">';
        html += '<div class="input-group">';
        html += '<span class="input-group-addon">';
        html += '<i class="material-icons icon-middle">mail</i>';
        html += '</span>';
        html += '<div class="form-group">';
        html += '<label class="control-label">Email ID<span class="text-danger">*</span></label>';
        html +=
            '<td><input type="email" class="form-control" name="management_email_id[]" required></td>';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        html += ' <div class="col-lg-1 form-group col-lg-offset-0">';
        html += '<td><button type="button" id="' + count +
            '" class="btn btn-danger btn-sm remove_button"><i class="material-icons">highlight_off</i></button></td>';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        $('#repeater1').append(html);
        $("#totalCount").val(count);
        $(this).find(".master_category" + count + "").selectpicker();


        // Get Designation
        $("#management_designation_" + count).autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: '{{ url("/etpl/institution-designation") }}',
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            var code = item.split("@");
                            return {
                                label: code[0],
                                value: code[0],
                                data: item
                            }
                        }));
                    }
                });
            },
            autoFocus: true,
            minLength: 2,
        });

        var $sections = $('.tab-pane  wizard-pane');

        function navigateTo(index) {
            // Mark the current section with the class 'current'
            $sections
                .removeClass('current')
                .eq(index)
                .addClass('current');
            // Show only the navigation buttons that make sense for the current section:
            $('.wizard-footer .btn-previous').toggle(index > 0);
            var atTheEnd = index >= $sections.length - 1;
            $('.wizard-footer .btn-next').toggle(!atTheEnd);
            $('.wizard-footer [type=submit]').toggle(atTheEnd);
        }

        function curIndex() {
            // Return the current index by looking at which section has the class 'current'
            return $sections.index($sections.filter('.current'));
        }

        // btn-previous button is easy, just go back
        $('.wizard-footer .btn-previous').click(function() {
            navigateTo(curIndex() - 1);
        });

        // Next button goes forward iff current block validates
        $('.wizard-footer .btn-next').click(function() {
            $('.demo-form').parsley().whenValidate({
                group: 'block-' + curIndex()
            }).done(function() {
                navigateTo(curIndex() + 1);
            });
        });

    });

    // Remove Management Details
    $(document).on('click', '.remove_button', function(event) {
        event.preventDefault();

        var id = $(this).attr('id'); //alert(id);
        var totalCount = $('#repeater1 tr:last').attr('id');

        $(this).closest('div #section_' + id + '').remove();
        totalCount--;
    });

    // Save Institution
    $('body').delegate('#institutionForm', 'submit', function(e) {
        e.preventDefault();

        var btn = $('#submit');
        if ($('#institutionForm').parsley().isValid()) {

            $.ajax({
                url: "/etpl/institution",
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
                                location.replace('/institution');
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

    // Same As Organization
    $(document).on('change', '#organizationName', function(event) {

        if ($('#checkbox').is(":checked")) {

            $('#checkbox').prop('checked', false);

            $("#institutionAddress").val('');
            $("#pincode").val('');
            $("#postOffice").val('');
            $("#city").val('');
            $("#state").val('');
            $("#district").val('');
            $("#taluk").val('');
            $("#country").val('');
        }
    });

    $('#checkbox').change(function() {

        if ($(this).is(":checked")) {

            var id = $('#organizationName').val();

            $.ajax({
                type: "GET",
                url: "/etpl/organization-details/" + id,
                dataType: "json",
                data: {
                    id: id
                },
                success: function(result) {
                    $("#institutionAddress").val(result['address']);
                    $("#pincode").val(result['pincode']);
                    $("#postOffice").val(result['post_office']);
                    $("#city").val(result['city']);
                    $("#state").val(result['state']);
                    $("#district").val(result['district']);
                    $("#taluk").val(result['taluk']);
                    $("#country").val(result['country']);
                }
            });

        } else {

            $("#institutionAddress").val('');
            $("#pincode").val('');
            $("#postOffice").val('');
            $("#city").val('');
            $("#state").val('');
            $("#district").val('');
            $("#taluk").val('');
            $("#country").val('');
        }
    });

    // Get Designation
    $(".management_designation").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '{{ url("/etpl/institution-designation") }}',
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        var code = item.split("@");
                        return {
                            label: code[0],
                            value: code[0],
                            data: item
                        }
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 2,
    });

    function getInstitutionType(boardUniversity, index) {

        $.ajax({
            url: "/etpl/course-master-instType",
            type: "POST",
            dataType: "json",
            data: {
                name: boardUniversity
            },
            success: function(data) {
                // console.log(data);
                var select = $('#institution_type_' + index);
                select.empty();
                for (var i = 0; i < data.length; i++) {
                    select.append('<option value="' +
                        data[i]['id'] +
                        '">' +
                        data[i]['label'] +
                        '</option>');
                }
                select.selectpicker('refresh');
            }
        });
    }

    function getCourse(institutionType, boardUniversity, index) {

        $.ajax({
            url: "/etpl/course-master-course",
            type: "POST",
            dataType: "json",
            data: {
                institutionType: institutionType,
                boardUniversity: boardUniversity
            },
            success: function(data) {
                // console.log(data);
                var select = $('#course_' + index);
                select.empty();

                for (var i = 0; i < data.length; i++) {
                    select.append('<option value="' +
                        data[i]['id'] +
                        '">' +
                        data[i]['label'] +
                        '</option>');
                }
                select.selectpicker('refresh');
            }
        });
    }

    function getStream(course, institutionType, boardUniversity, index) {

        $.ajax({
            url: "/etpl/course-master-stream",
            type: "POST",
            dataType: "json",
            data: {
                course: course,
                boardUniversity: boardUniversity,
                institutionType: institutionType
            },
            success: function(data) {
                // console.log(data);
                var select = $('#stream_' + index);
                select.empty();

                for (var i = 0; i < data.length; i++) {
                    select.append('<option value="' +
                        data[i]['id'] +
                        '">' +
                        data[i]['label'] +
                        '</option>');
                }
                select.selectpicker('refresh');
            }
        });
    }

    function getCombination(stream, course, institutionType, boardUniversity, index) {

        $.ajax({
            url: "/etpl/course-master-combination",
            type: "POST",
            dataType: "json",
            data: {
                stream: stream,
                boardUniversity: boardUniversity,
                course: course,
                institutionType: institutionType
            },
            success: function(data) {
                // console.log(data);
                var select = $('#combination_' + index);
                select.empty();

                for (var i = 0; i < data.length; i++) {
                    select.append('<option value="' +
                        data[i]['id'] +
                        '">' +
                        data[i]['label'] +
                        '</option>');
                }
                select.selectpicker('refresh');
            }
        });
    }

    $('#board_university_1').on('change', function() {
        var boardUniversity = $(this).val();
        var index = $(this).parents('.row').attr('data-id');
        getInstitutionType(boardUniversity, index);
    });

    $('#institution_type_1').on('change', function() {
        var institutionType = $(this).val();
        var boardUniversity = $('#board_university_1').val();
        var index = $(this).parents('.row').attr('data-id');
        getCourse(institutionType, boardUniversity, index);
    });

    $('#course_1').on('change', function() {
        var course = $(this).val();
        var boardUniversity = $('#board_university_1').val();
        var institutionType = $('#institution_type_1').val();
        var index = $(this).parents('.row').attr('data-id');
        getStream(course, institutionType, boardUniversity, index);
    });

    $('#stream_1').on('change', function() {
        var stream = $(this).val();
        var boardUniversity = $('#board_university_1').val();
        var course = $('#course_1').val();
        var institutionType = $('#institution_type_1').val();
        var index = $(this).parents('.row').attr('data-id');
        getCombination(stream, course, institutionType, boardUniversity, index);
    });
});
</script>
@endsection