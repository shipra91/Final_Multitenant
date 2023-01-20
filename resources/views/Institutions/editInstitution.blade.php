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
                                <form method="POST" class="demo-form" id="institutionForm"
                                    enctype="multipart/form-data">
                                    <div class="wizard-header">
                                        <h3 class="wizard-title">Edit Institution</h3>
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
                                                <div class="col-sm-7">
                                                    <input type="hidden" name="institutionId" id="institutionId"
                                                        class="form-control" value="{{$selectedInstitution->id}}">
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
                                                                @foreach($organizations as $organization)
                                                                <option value="{{$organization->id}}"
                                                                    @if($selectedInstitution->id_organization
                                                                    ==$organization->id) {{'selected'}}
                                                                    @endif>{{$organization->name}}</option>
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
                                                            <label class="control-label">Institution Name<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" class="form-control input"
                                                                name="institutionName" id="institutionName"
                                                                minlength="2" required
                                                                onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)"
                                                                value="{{$selectedInstitution->name}}" />
                                                        </div>
                                                    </div>

                                                    <div class="input-group p-t-10">
                                                        <div class="form-group label-floating">
                                                            <div class='checkbox col-md-12 input-group'>
                                                                <label>
                                                                    <input type="checkbox" id='checkbox'><span
                                                                        class="organization-sameAs">Address Details Same
                                                                        as Organization</span>
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
                                                                        required
                                                                        value="{{$selectedInstitution->pincode}}" />
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
                                                                        name="postOffice" id="postOffice" required
                                                                        onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)"
                                                                        value="{{$selectedInstitution->post_office}}" />
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
                                                                    <label class="control-label">City/Taluk<span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="taluk"
                                                                        id="taluk" required
                                                                        onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)"
                                                                        value="{{$selectedInstitution->taluk}}" />
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
                                                                    <input type="text" class="form-control"
                                                                        name="district" id="district" required
                                                                        onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)"
                                                                        value="{{$selectedInstitution->district}}" />
                                                                </div>
                                                            </div>
                                                        </div>

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
                                                                        id="institutionAddress"
                                                                        required>{{$selectedInstitution->address}}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4 col-sm-offset-1">
                                                    {{-- <p class="logo-label">Institution Logo</p> --}}
                                                    <div class="fileinput fileinput-new text-center"
                                                        data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail">
                                                            @if($selectedInstitution->institution_logo != "")
                                                            <img class="img"
                                                                src="{{$selectedInstitution->institution_logo}}"
                                                                alt="Image" />
                                                            @else
                                                            <img class="img" src="//cdn.egenius.in/img/placeholder.jpg"
                                                                alt="Image" />
                                                            @endif
                                                        </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail"
                                                            style="height: 180px;"></div>
                                                        <div>
                                                            <span class="btn btn-square btn-info btn-file btn-sm">
                                                                <span class="fileinput-new">Change Institution
                                                                    Logo</span>
                                                                <span class="fileinput-exists">Change</span>
                                                                <input type="file" name="institutionLogo"
                                                                    accept="image/*" />
                                                                <input type="hidden" name="oldInstitutionLogo"
                                                                    value="{{$selectedInstitution->institution_logo}}" />
                                                            </span>
                                                            <a href="#pablo"
                                                                class="btn btn-danger btn-square fileinput-exists btn-sm"
                                                                data-dismiss="fileinput"><i
                                                                    class="material-icons">highlight_off</i></a>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    {{-- <p class="logo-label">Fav Icon</p> --}}
                                                    <div class="fileinput fileinput-new text-center"
                                                        data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail">
                                                            @if($selectedInstitution->fav_icon != "")
                                                            <img class="img" src="{{$selectedInstitution->fav_icon}}"
                                                                alt="Image" />
                                                            @else
                                                            <img class="img" src="//cdn.egenius.in/img/placeholder.jpg"
                                                                alt="Image" />
                                                            @endif
                                                        </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail"
                                                            style="height: 180px;"></div>
                                                        <div>
                                                            <span class="btn btn-square btn-info btn-file btn-sm">
                                                                <span class="fileinput-new">Change Fav Icon</span>
                                                                <span class="fileinput-exists">Change</span>
                                                                <input type="file" name="favIcon" accept="image/*" />
                                                                <input type="hidden" name="oldfavIcon"
                                                                    value="{{$selectedInstitution->fav_icon}}" />
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

                                        <div class="tab-pane  wizard-pane" id="other" ng-controller="other">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h5
                                                        style="padding: 0px 20px; margin-bottom: 0px; color: #5a5a5a; font-weight: 400;">
                                                        Institution Settings</h5>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="m-t-20" id="repeater2">

                                                    @php $countRow = 0;@endphp

                                                    @foreach($institutionCourseDetails as $index => $data)

                                                    @php $countRow++;
                                                    $combinationArray = array();
                                                    $combinationArray = explode(',',$data->combination);
                                                    @endphp

                                                    <div class="row form-group" id="section_{{ $countRow }}"
                                                        data-id="{{ $countRow }}">
                                                        <div class="col-lg-3 form-group col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">school</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label">Board/University<span
                                                                            class="text-danger">*</span></label>
                                                                    <select class="selectpicker board_university"
                                                                        name="board_university[]"
                                                                        id="board_university_{{$countRow}}"
                                                                        data-size="5"
                                                                        data-style="select-with-transition"
                                                                        data-live-search="true" title="Select"
                                                                        required="required"
                                                                        data-parsley-errors-container=".universityError">
                                                                        @foreach($courseMaster as $details)
                                                                        <option value="{{ $details['id'] }}" @if($data->
                                                                            board_university == $details['id'])
                                                                            {{'selected'}} @endif>{{$details['name']}}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <div class="universityError"></div>
                                                                    <input type="hidden"
                                                                        name="institutionCourseMasterId[]"
                                                                        value="{{$data->id}}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3 form-group col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">school</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label">Institution Type<span
                                                                            class="text-danger">*</span></label>
                                                                    <select class="selectpicker"
                                                                        name="institution_type[]"
                                                                        id="institution_type_{{$countRow}}"
                                                                        data-size="5"
                                                                        data-style="select-with-transition"
                                                                        data-live-search="true" required="required"
                                                                        data-parsley-errors-container=".typeError">
                                                                        @foreach($institutionCourseData['institutionTypeDetails'][$index]
                                                                        as $institutionType)
                                                                        <option value="{{$institutionType->id}}"
                                                                            @if($data->institution_type ==
                                                                            $institutionType->id) {{'selected'}}
                                                                            @endif>{{$institutionType->type_name}}
                                                                        </option>
                                                                        @endforeach

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
                                                                    <select class="selectpicker" name="course[]"
                                                                        id="course_{{$countRow}}" data-size="5"
                                                                        data-style="select-with-transition"
                                                                        data-live-search="true" required="required"
                                                                        data-parsley-errors-container=".courseError">
                                                                        @foreach($institutionCourseData['courseDetails'][$index]
                                                                        as $course)
                                                                        <option value="{{$course->id}}" @if($data->
                                                                            course == $course->id) {{'selected'}}
                                                                            @endif>{{$course->name}}</option>
                                                                        @endforeach
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
                                                                    <select class="selectpicker" name="stream[]"
                                                                        id="stream_{{$countRow}}" data-size="5"
                                                                        data-style="select-with-transition"
                                                                        data-live-search="true" required="required"
                                                                        data-parsley-errors-container=".streamError">
                                                                        @foreach($institutionCourseData['streamDetails'][$index]
                                                                        as $stream)
                                                                        <option value="{{$stream->id}}" @if($data->
                                                                            stream == $stream->id) {{'selected'}}
                                                                            @endif>{{$stream->name}}</option>
                                                                        @endforeach
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
                                                                    <select class="selectpicker"
                                                                        name="combination[{{$countRow}}][]"
                                                                        id="combination_{{$countRow}}" data-size="5"
                                                                        data-style="select-with-transition"
                                                                        data-live-search="true" multiple
                                                                        required="required" data-actions-box="true"
                                                                        data-parsley-errors-container=".combinationError">

                                                                        @foreach($institutionCourseData['combinationDetails'][$index]
                                                                        as $combination)

                                                                        <option value="{{$combination->id}}"
                                                                            @if(in_array($combination->id,
                                                                            $combinationArray)) {{'selected'}}
                                                                            @endif>
                                                                            {{$combination->name}} </option>

                                                                        @endforeach
                                                                    </select>
                                                                    <div class="combinationError"></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">event_note</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label">Institution
                                                                        Code</label>
                                                                    <input type="text" class="form-control"
                                                                        name="institution_code[]" id="institution_code"
                                                                        value="{{$data->institution_code}}" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-1 form-group col-lg-offset-0">
                                                            <button type="button" id="{{$data->id}}"
                                                                data-id="{{$countRow}}"
                                                                class="btn btn-danger btn-sm institution_delete_button mt-30"
                                                                @if(count($institutionCourseDetails)==1 )
                                                                {{ "style=display:none"}} @endif><i
                                                                    class="material-icons">highlight_off</i></button>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    <input type="hidden" name="totalCount" id="totalCount"
                                                        class="form-control" value="{{ $countRow }}">
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
                                                                onblur="this"
                                                                value="{{$selectedInstitution->mobile_number}}" />
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
                                                                onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                                value="{{$selectedInstitution->landline_number}}" />
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
                                                            <input type="email" class="form-control" name="institutionEmail" id="institutionEmail"
                                                                value="{{$selectedInstitution->office_email}}" required/>
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
                                                            <input type="text" class="form-control" name="websiteUrl" id="websiteUrl" value="{{$selectedInstitution->website_url}}" required/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h5
                                                        style="padding: 20px 0px 0px 20px; margin-bottom: 0px; color: #5a5a5a; font-weight: 400;">
                                                        POC (Point Of Contact) Detail</h5>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="m-t-20" id="repeater">

                                                    @php $countRow = 0;@endphp

                                                    @foreach($selectedInstitution['poc'] as $index => $data)

                                                    @php $countRow++;@endphp

                                                    <div class="row form-group" id="section_{{ $countRow }}"
                                                        data-id="{{ $countRow }}">
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
                                                                        value="{{$data->name}}" required />
                                                                    <input type="hidden" name="management_id[]"
                                                                        value="{{$data->id}}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3 form-group col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">work</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label">Designation<span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text"
                                                                        class="form-control management_designation"
                                                                        name="management_designation[]"
                                                                        onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)"
                                                                        value="{{$data->poc_designation_name}}"
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
                                                                        name="management_phoneNumber[]" onblur="this"
                                                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                                        minlength="10" maxlength="10"
                                                                        value="{{$data->mobile_number}}" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3 form-group col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">mail</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label">Email ID<span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="email" class="form-control"
                                                                        name="management_email_id[]"
                                                                        value="{{$data->email}}" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-1 form-group col-lg-offset-0">
                                                            <button type="button" id="{{$data->id}}"
                                                                class="btn btn-danger btn-sm delete_button mt-30"
                                                                @if(count($selectedInstitution['poc'])==1 )
                                                                {{ "style=display:none"}} @endif><i
                                                                    class="material-icons">highlight_off</i></button>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    <input type="hidden" name="totalCount" id="totalCount"
                                                        class="form-control" value="{{ $countRow }}">
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
                                                <div class="col-lg-6 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">dashboard</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Modules to Enable<span
                                                                    class="text-danger">*</span></label>
                                                            <select class="selectpicker" name="modules[]" id="modules"
                                                                data-size="5" data-style="select-with-transition"
                                                                data-live-search="true"
                                                                data-selected-text-format="count > 3" title="Select"
                                                                multiple required="required" data-actions-box="true"
                                                                data-parsley-errors-container=".moduleError">
                                                                @foreach($modules as $module)
                                                                <option value="{{$module->id}}" @if(in_array($module->
                                                                    id, $institutionModule)) {{'selected'}}
                                                                    @endif>{{$module->display_name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="moduleError"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane  wizard-pane" id="additional" ng-controller="additional">
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
                                                                required
                                                                value="{{$selectedInstitution->area_partner_name}}" />
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
                                                                onblur="this" required
                                                                value="{{$selectedInstitution->area_partner_phone}}" />
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
                                                                name="areaPartnerEmail" id="areaPartnerEmail" required
                                                                value="{{$selectedInstitution->area_partner_email}}" />
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
                                                                required
                                                                value="{{$selectedInstitution->zonal_partner_name}}" />
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
                                                                onblur="this" required
                                                                value="{{$selectedInstitution->zonal_partner_phone}}" />
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
                                                                name="zonalPartnerEmail" id="zonalPartnerEmail" required
                                                                value="{{$selectedInstitution->zonal_partner_email}}" />
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
                                                    id="submit" name='submit'>Update</button>
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
        triggerAfterFailure: 'input change focusout changed.bs.select'
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
                url: "/organization-details/" + id,
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

    // Add More Institution Settings
    var count = $('#totalCount').val();

    $(document).on('click', '#add_more_mapping', function() {

        var html = '';
        count++;
        html += '<input type="hidden" name="institutionCourseMasterId[]" value="">';
        html += '<div class="row" id="section_' + count + '" data-id="' + count + '">';
        html += '<div class="col-lg-12 col-lg-offset-0">';
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
            '" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select" required="required">';
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
            var boardUniversity = $('#board_university_' + count).val();
            var index = $(this).parents('.row').attr('data-id');
            getCourse(institutionType, boardUniversity, index);
        });

        $('#course_' + count).on('change', function() {
            var course = $(this).val();
            var boardUniversity = $('#board_university_' + count).val();
            var institutionType = $('#institution_type_' + count).val();
            var index = $(this).parents('.row').attr('data-id');
            getStream(course, institutionType, boardUniversity, index);
        });

        $('#stream_' + count).on('change', function() {
            var stream = $(this).val();
            var boardUniversity = $('#board_university_' + count).val();
            var course = $('#course_' + count).val();
            var institutionType = $('#institution_type_' + count).val();
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

        html += '<div class="row form-group" id="section_' + count + '" data-id="' + count + '">';
        html += '<input type="hidden" name="management_id[]" value = "">';
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
        html += '<i class="material-icons icon-middle">work</i>';
        html += '</span>';
        html += '<div class="form-group">';
        html += '<label class="control-label">Designation<span class="text-danger">*</span></label>';
        html +=
            '<input type="text" class="form-control management_designation" name="management_designation[]" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" required>';
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
        html += '<label class="control-label">Email ID</label>';
        html +=
            '<td><input type="email" class="form-control" name="management_email_id[]" required></td>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += ' <div class="col-lg-1 form-group col-lg-offset-0">';
        html += '<td><button type="button" id="' + count +
            '" class="btn btn-danger btn-sm remove_button mt-30"><i class="material-icons">highlight_off</i></button></td>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        $('#repeater').append(html);
        $("#totalCount").val(count);
        $(this).find(".master_category" + count + "").selectpicker();

        // Get Designation
        $(".management_designation").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: '{{ url("institution-designation") }}',
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
    });

    // Remove Add More
    $(document).on('click', '.remove_button', function(event) {
        event.preventDefault();

        var id = $(this).attr('id'); //alert(id);
        var totalCount = $('#repeater tr:last').attr('id');

        $(this).closest('div #section_' + id + '').remove();
        totalCount--;
    });

    // Delete Management Details
    $(document).on('click', '.delete_button', function(event) {
        event.preventDefault();

        var id = $(this).attr('id'); //alert(id);
        var parent = $(this).parents("div #section_" + id);

        var totalCount = $("#repeater").find("#totalCount").val();
        totalCount--;

        if (confirm("Are you sure you want to delete this?")) {

            $.ajax({
                type: "DELETE",
                url: "/institution-poc/" + id,
                dataType: "json",
                data: {
                    id: id
                },
                success: function(result) {

                    if (result['status'] == "200") {

                        if (result.data['signal'] == "success") {

                            swal({
                                title: result.data['message'],
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-success"
                            }).then(function() {
                                $("#repeater").find("#totalCount").val(totalCount);
                                if (totalCount == 1) {
                                    $(".delete_button").css({
                                        'display': 'none'
                                    })
                                }
                                parent.animate({
                                    backgroundColor: "#f1f1f1"
                                }, "slow").animate({
                                    opacity: "hide"
                                }, "slow");
                            }).catch(swal.noop)

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
        return false;
    });

    // Delete institution Setting

    $(document).on('click', '.institution_delete_button', function() {

        var id = $(this).attr('id'); //alert(id);
        var dataId = $(this).attr('data-id');
        var parent = $(this).parents("div #section_" + dataId);
        var totalCount = $("#repeater2").find("#totalCount").val();
        totalCount--;

        if (confirm("Are you sure you want to delete this?")) {

            $.ajax({
                type: "DELETE",
                url: "/etpl/institution-course/" + id,
                dataType: "json",
                data: {
                    id: id
                },
                success: function(result) {
                    if (result['status'] == "200") {

                        if (result.data['signal'] == "success") {

                            swal({
                                title: result.data['message'],
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-success"
                            }).then(function() {
                                $("#repeater2").find("#totalCount").val(totalCount);
                                if (totalCount == 1) {
                                    $(".institution_delete_button").css({
                                        'display': 'none'
                                    })
                                }
                                parent.animate({
                                    backgroundColor: "#f1f1f1"
                                }, "slow").animate({
                                    opacity: "hide"
                                }, "slow");
                            }).catch(swal.noop)

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
        return false;
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

    // Update Institution
    $('body').delegate('#institutionForm', 'submit', function(e) {
        e.preventDefault();

        var btn = $('#submit');
        var id = $("#institutionId").val();
        if ($('#institutionForm').parsley().isValid()) {

            $.ajax({
                url: "/etpl/institution/" + id,
                type: "post",
                dataType: "json",
                data: new FormData(this),
                contentType: false,
                processData: false,
                beforeSend: function() {
                    btn.html('Updating...');
                    btn.attr('disabled', true);
                },
                success: function(result) {
                    // console.log(result);
                    btn.html('Update');
                    btn.attr('disabled', false);

                    if (result['status'] == "200") {

                        if (result.data['signal'] == "success") {

                            swal({
                                title: result.data['message'],
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-success"
                            }).then(function() {
                                location.replace('/etpl/institution');
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
    var totalCount = $('#totalCount').val();

    for (i = 1; i <= totalCount; i++) {

        $('#board_university_' + i).on('change', function() {
            var boardUniversity = $(this).val();
            var index = $(this).parents('.row').attr('data-id');
            getInstitutionType(boardUniversity, index);
        });

        $('#institution_type_' + i).on('change', function() {
            var institutionType = $(this).val();
            var index = $(this).parents('.row').attr('data-id');
            var boardUniversity = $('#board_university_' + index).val();
            getCourse(institutionType, boardUniversity, index);
        });

        $('#course_' + i).on('change', function() {
            var course = $(this).val();
            var index = $(this).parents('.row').attr('data-id');
            var boardUniversity = $('#board_university_' + index).val();
            var institutionType = $('#institution_type_' + index).val();
            getStream(course, institutionType, boardUniversity, index);
        });

        $('#stream_' + i).on('change', function() {
            var stream = $(this).val();
            var index = $(this).parents('.row').attr('data-id');
            var boardUniversity = $('#board_university_' + index).val();
            var course = $('#course_' + index).val();
            var institutionType = $('#institution_type_' + index).val();
            getCombination(stream, course, institutionType, boardUniversity, index);
        });
    }
});
</script>
@endsection