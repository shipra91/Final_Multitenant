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
                                <form method="POST" class="demo-form" id="organizationForm"
                                    enctype="multipart/form-data">
                                    <div class="wizard-header">
                                        <h3 class="wizard-title">Organization/Trust Details</h3>
                                    </div>
                                    <div class="wizard-navigation">
                                        <ul>
                                            <li>
                                                <a href="#basic" data-toggle="tab">Basic Details</a>
                                            </li>
                                            <li>
                                                <a href="#contact" data-toggle="tab">Contact Details </a>
                                            </li>
                                            <li>
                                                <a href="#other" data-toggle="tab">Other Details</a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="tab-content">
                                        <div class="tab-pane wizard-pane" id="basic">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">school</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label">Organization/Trust<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control input" name="organization_name" id="organization_name" autocomplete="off" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">fiber_pin</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label">Pincode<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="pincode" id="pincode" minLength="6" maxlength="6" number="true" autocomplete="off" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">account_balance</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label">Post Office<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control input" name="post_office" id="post_office" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">location_city</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label">City/Taluk<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control input" name="taluk" id="taluk" required />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="city" id="city">
                                                        <input type="hidden" name="state" id="state">
                                                        <input type="hidden" name="country" id="country" value="India">

                                                        <div class="col-lg-6 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons icon-middle">account_balance</i>
                                                                </span>
                                                                <div class="form-group">
                                                                    <label class="control-label">District<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control input" name="district" id="district" required />
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
                                                                    <textarea class="form-control input-address" rows="1" name="organization_address" id="organization_address" required></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4 text-center col-sm-offset-0">
                                                    <div class="fileinput fileinput-new text-center"
                                                        data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail brightness">
                                                            <img src="//cdn.egenius.in/img/placeholder.jpg" alt="Image">
                                                        </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                        <div>
                                                            <span class="btn btn-square btn-info btn-file btn-sm">
                                                                <span class="fileinput-new">Add Logo<span class="text-danger">*</span></span>
                                                                <span class="fileinput-exists">Change</span>
                                                                <input type="file" name="organization_logo" id="organization_logo" class="brightness" required accept="image/*" data-parsley-errors-container=".logoError" />
                                                            </span>
                                                            <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="material-icons">highlight_off</i></a>
                                                        </div>
                                                        <div class="logoError"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane wizard-pane" id="contact">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h5 class="tab-header">Office Details</h5>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-4 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="material-icons icon-middle">mail</i></span>
                                                        <div class="form-group">
                                                            <label class="control-label">Office Email ID<span class="text-danger">*</span></label>
                                                            <input type="email" class="form-control" name="office_email_id" id="office_email_id" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">phone</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Mobile Number<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="office_mobile_number" id="office_mobile_number" number="true" onblur="this" minlength="10" maxlength="10" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">phone</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Landline with Area Code</label>
                                                            <input type="text" class="form-control input-number" name="landline_number" id="landline_number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength='15' />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h5 class="tab-header mt-30">Management Details</h5>
                                                </div>
                                            </div>

                                            <div id="repeater" style="margin-top: -10px;">
                                                <input type="hidden" name="totalCount" id="totalCount" value="1">
                                                <div class="row" id="section_1" data-id="1">
                                                    <div class="col-lg-3 col-lg-offset-0">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons icon-middle">account_circle</i>
                                                            </span>
                                                            <div class="form-group">
                                                                <label class="control-label">Name<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control input" name="management_name[]" required />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-lg-offset-0">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons icon-middle">work</i>
                                                            </span>
                                                            <div class="form-group">
                                                                <label class="control-label">Designation<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control management_designation input" name="management_designation[]" required />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2 col-lg-offset-0">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons icon-middle">phone</i>
                                                            </span>
                                                            <div class="form-group">
                                                                <label class="control-label">Phone No<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" name="management_phoneNumber[]" onblur="this" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" required />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-lg-offset-0">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="material-icons icon-middle">mail</i>
                                                            </span>
                                                            <div class="form-group">
                                                                <label class="control-label">Email ID<span class="text-danger">*</span></label>
                                                                <input type="email" class="form-control" name="management_email_id[]" required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="pull-left">
                                                <div class="form-group">
                                                    <button id="add_more" type="button" class="btn btn-warning btn-sm"><i class="material-icons">add_circle_outline</i> Add More</button>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h5 class="tab-header mt-30">POC (Point Of Contact)</h5>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-1 col-lg-offset-0 text-right">
                                                    <p class="custom-paragraph">Level 1</p>
                                                </div>
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">account_circle</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Name<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control input" name="poc_name1" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">work</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Designation<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control poc_designation input" name="poc_designation1" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">phone</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Phone No<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="poc_phoneNumber1" onblur="this" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">mail</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Email ID<span class="text-danger">*</span></label>
                                                            <input type="email" class="form-control" name="poc_email_Id1" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-1 col-lg-offset-0 text-right">
                                                    <p class="custom-paragraph">Level 2</p>
                                                </div>
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">account_circle</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Name</label>
                                                            <input type="text" class="form-control input" name="poc_name2" />
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
                                                            <input type="text" class="form-control poc_designation input" name="poc_designation2" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">phone</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Phone No</label>
                                                            <input type="text" class="form-control" name="poc_phoneNumber2" onblur="this" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">mail</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Email ID</label>
                                                            <input type="email" class="form-control" name="poc_email_Id2" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-1 col-lg-offset-0 text-right">
                                                    <p class="custom-paragraph">Level 3</p>
                                                </div>
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">account_circle</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Name</label>
                                                            <input type="text" class="form-control input" name="poc_name3" />
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
                                                            <input type="text" class="form-control poc_designation input" name="poc_designation3" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">phone</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Phone No</label>
                                                            <input type="text" class="form-control" name="poc_phoneNumber3" onblur="this" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">mail</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Email ID</label>
                                                            <input type="email" class="form-control" name="poc_email_Id3" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane wizard-pane" id="other" ng-controller="address">
                                            <div class="row">
                                                
                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">insert_link</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Organization & Institution URL same ?<span class="text-danger">*</span></label>
                                                            <select class="selectpicker" name="same_url" id="same_url" data-size="5" data-style="select-with-transition" data-live-search="true" title="Select Organization" required="required" data-parsley-errors-container=".sameUrlError">
                                                                <option value="SINGLE">YES</option>
                                                                <option value="MULTIPLE">NO</option>
                                                            </select>
                                                            <div class="sameUrlError"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">insert_link</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Website URL<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="website_url" required/>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">view_headline</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">GST Number</label>
                                                            <input type="text" class="form-control" name="gst_number" style="text-transform:uppercase;" maxlength='15' minlength='15'>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">view_headline</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">PAN Number</label>
                                                            <input type="text" class="form-control" name="pan_number" style="text-transform:uppercase;" maxlength='10' minlength='10'>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h5 class="tab-header mt-30">Agreement Details</h5>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-4 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">date_range</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">PO Date<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control custom_datepicker" name="po_signed_date" id="po_signed_date" data-style="select-with-transition" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">date_range</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">PO Effective Date<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control datepicker" name="po_effective_date" id="po_effective_date" data-style="select-with-transition" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons icon-middle">view_headline</i>
                                                        </span>
                                                        <div class="form-group">
                                                            <label class="control-label">Contract Period(In Years)<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="contract_period" id="contract_period" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <input type="hidden" name="expiry_po_date" id="expiry_po_date" />
                                                <input type="hidden" name="renewal_period" id="renewal_period" />
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h5 class="tab-header mt-30">Attachment</h5>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-sm-3 text-center form-group">
                                                    <h5 Class="form-imageHeading">GST Copy</h5>
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
                                                                <input type="file" name="gst_attachment" />
                                                            </span>
                                                            <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="material-icons">highlight_off</i></a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3 text-center form-group">
                                                    <h5 Class="form-imageHeading">PAN Copy</h5>
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
                                                                <input type="file" name="pan_attachment" />
                                                            </span>
                                                            <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="material-icons">highlight_off</i></a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3 text-center form-group">
                                                    <h5 Class="form-imageHeading">Reg Cert Copy</h5>
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
                                                                <input type="file" name="registration_attachment" />
                                                            </span>
                                                            <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="material-icons">highlight_off</i></a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3 text-center form-group">
                                                    <h5 Class="form-imageHeading">MOU/PO Copy<span class="text-danger">*</span></h5>
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
                                                                <input type="file" name="po_attachment" required data-parsley-errors-container=".poError" />
                                                            </span>
                                                            <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="material-icons">highlight_off</i></a>
                                                        </div>
                                                        <div class="poError"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="wizard-footer">
                                            <div class="pull-right">
                                                <input type="button" class="btn btn-next btn-fill btn-info btn-wd" name="next" value="Next" />
                                                <button class="btn btn-finish btn-fill btn-info btn-wd" id="submit" name="submit" value="submit">SUBMIT</button>
                                            </div>
                                            <div class="pull-left">
                                                <input type="button" class="btn btn-previous btn-fill btn-danger btn-wd" name="previous" value="Previous" />
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

        $("#organizationForm").parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Pincode
        $('#pincode').autocomplete({
            source: function(request, response){

                var id = $('#pincode').val();

                $.ajax({
                    type: "POST",
                    url: "/etpl/pincode-address",
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
                console.log(names[5]);
                $('#post_office').val(names[0]);
                $('#city').val(names[1]);
                $('#taluk').val(names[2]);
                $('#district').val(names[3]);
                $('#state').val(names[4]);
                $('#pincode').val(names[5]);
            }
        });

        $(document).on('click', '#po_effective_date', function(){
            agreementDates();
        });

        $(document).on('change', '#contract_period', function(){
            agreementDates();
        });

        function agreementDates(){

            var poEffectiveDate = $('#po_effective_date').val();

            if($('#contract_period').val() != ''){
                var contractPeriod = $('#contract_period').val();
            }else{
                var contractPeriod = 0;
            }

            // console.log(contractPeriod);
            const dateValue = poEffectiveDate.split("/");
            var poEffDate = dateValue[1] + '/' + dateValue[0] + '/' + dateValue[2];
            var d = new Date(poEffDate);
            d.setFullYear(d.getFullYear() + parseInt(contractPeriod));
            expiryDate = d.toLocaleDateString();
            const expiryValue = expiryDate.split("/");
            var expiryDate = expiryValue[0] + '/' + expiryValue[1] + '/' + expiryValue[2];
            $('#expiry_po_date').val(expiryDate);

            var expiryPoDate = expiryValue[0] + '/' + expiryValue[1] + '/' + expiryValue[2];
            // console.log('expiryPoDate : '+expiryPoDate);
            var d = new Date(Date.UTC(expiryValue[2], expiryValue[1], expiryValue[0]));
            d.setMonth(d.getMonth() - 3);
            // console.log('d : '+ d);
            renewalDate = d.toLocaleDateString();
            const renewalValue = renewalDate.split("/");
            var renewalPeriodDate = renewalValue[1] + '/' + renewalValue[0] + '/' + renewalValue[2];
            // console.log('renewalPeriodDate : '+renewalPeriodDate);
            $('#renewal_period').val(renewalPeriodDate);
        }

        // Add more management details
        var count = $('#totalCount').val();

        $(document).on('click', '#add_more', function(){

            var html = '';
            count++;

            html += '<div class="row" id="section_' + count + '" data-id="' + count + '">';
            html += '<div class="col-lg-3 col-lg-offset-0">';
            html += '<div class="input-group">';
            html += '<span class="input-group-addon">';
            html += '<i class="material-icons icon-middle">account_circle</i>';
            html += '</span>';
            html += '<div class="form-group">';
            html += '<label class="control-label">Name<span class="text-danger">*</span></label>';
            html += '<td><input type="text" name="management_name[]" class="form-control input" required></td>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-3 col-lg-offset-0">';
            html += '<div class="input-group">';
            html += '<span class="input-group-addon">';
            html += '<i class="material-icons icon-middle">work</i>';
            html += '</span>';
            html += '<div class="form-group">';
            html += '<label class="control-label">Designation<span class="text-danger">*</span></label>';
            html += '<td><input type="text" name="management_designation[]" class="form-control management_designation input" required ></td>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-2 col-lg-offset-0">';
            html += '<div class="input-group">';
            html += '<span class="input-group-addon">';
            html += '<i class="material-icons icon-middle">phone</i>';
            html += '</span>';
            html += '<div class="form-group">';
            html += '<label class="control-label">Phone No<span class="text-danger">*</span></label>';
            html += '<td><input type="text" name="management_phoneNumber[]" class="form-control" onblur="this" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" required></td>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-3 col-lg-offset-0">';
            html += '<div class="input-group">';
            html += '<span class="input-group-addon">';
            html += '<i class="material-icons icon-middle">mail</i>';
            html += '</span>';
            html += '<div class="form-group">';
            html += '<label class="control-label">Email ID<span class="text-danger">*</span></label>';
            html += '<td><input type="email" name="management_email_id[]" class="form-control" required></td>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += ' <div class="col-lg-1 form-group col-lg-offset-0 text-right">';
            html += '<td><button type="button" id="' + count + '" class="btn btn-danger btn-sm remove_button mt-15"><i class="material-icons">highlight_off</i></button></td>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            $('#repeater').append(html);
            $("#totalCount").val(count);

            // Get designation
            $(".management_designation").autocomplete({
                source: function(request, response){
                    $.ajax({
                        url: '{{ url("/etpl/institution-designation") }}',
                        dataType: "json",
                        data: {
                            term: request.term
                        },
                        success: function(data){
                            response($.map(data, function(item){
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

        // Remove management details
        $(document).on('click', '.remove_button', function(event){
            event.preventDefault();

            var id = $(this).attr('id'); //alert(id);
            console.log(id);
            var totalCount = $('#repeater tr:last').attr('id');

            $(this).closest('div #section_' + id + '').remove();
            totalCount--;
        });

        // Save Organization
        $('body').delegate('#organizationForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');

            if ($('#organizationForm').parsley().isValid()){

                $.ajax({
                    url: "/etpl/organization",
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
                                    location.replace('/etpl/organization');
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

        // Get Designation
        $(".management_designation").autocomplete({
            source: function(request, response){
                $.ajax({
                    url: '{{ url("/etpl/institution-designation") }}',
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        response($.map(data, function(item){
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

        $(".poc_designation").autocomplete({
            source: function(request, response){
                $.ajax({
                    url: '{{ url("/etpl/institution-designation") }}',
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function(data){
                        response($.map(data, function(item){
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
</script>
@endsection
