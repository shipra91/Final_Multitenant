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
                                <form method="POST" id="id_form" enctype="multipart/form-data" action="#">
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
                                                <div class="col-sm-4 col-sm-offset-2">
                                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail">
                                                            <img src="https://cdn.egenius.in/img/placeholder.jpg" alt="Image" style="height: 150px;">
                                                        </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail img-circle"></div>
                                                        <div>
                                                            <span class="btn btn-square btn-info btn-file btn-sm">
                                                                <span class="fileinput-new">Add Logo</span>
                                                                <span class="fileinput-exists">Change</span>
                                                                <input type="file" name="image" />
                                                            </span>
                                                            <br />
                                                            <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">school</i>
                                                        </span>
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">Name<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="institutionName" id="institutionName" minlength="2" style="text-transform: capitalize;" required onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" />
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">location_on</i>
                                                        </span>
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">Address<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="institutionAddress" id="institutionAddress" style="text-transform: capitalize;" required />
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">location_city</i>
                                                        </span>
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">City<span class="text-danger">*</span></label>
                                                            <input type="text"` name="city" id="city" style="text-transform: capitalize;" class="form-control" required onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-4 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                        <i class="material-icons">fiber_pin</i>
                                                        </span>
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">Pincode<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="pincode" id="pincode" minLength="6" maxlength="6" number="true" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                        <i class="material-icons">account_balance</i>
                                                        </span>
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">State<span class="text-danger">*</span></label>
                                                            <input type="text" name="state" id="state" style="text-transform: capitalize;" class="form-control" required onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                        <i class="material-icons">language</i>
                                                        </span>
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">Country<span class="text-danger">*</span></label>
                                                            <input type="text" name="country" id="country" style="text-transform: capitalize;" class="form-control" required onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <div class="tab-pane  wizard-pane" id="other" ng-controller="other">
                                            <div class="col-lg-12 col-lg-offset-0">
                                                <div class="row">
													<div class="col-lg-12">
														<h5 style="padding: 10px 30px;font-weight: 500;color: #555;">Institution Type</h5>
													</div>
												</div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-lg-offset-0">
                                                        <div class="col-lg-6 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">school</i>
                                                                </span>
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Institution Type<span class="text-danger">*</span></label>
                                                                    <select class="selectpicker" name="institutionType" id="institutionType" data-size="7" data-style="select-with-transition" title="-Select-" required="required" >
                                                                        <option value="">-Select-</option>
                                                                        <option value="school">School</option>
                                                                        <option value="pu">PU</option>
                                                                        <option value="ug">UG</option>
                                                                        <option value="pg">PG</option>
                                                                    </select> 
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6 col-lg-offset-0" style="padding-bottom: 15px;">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">event_note</i>
                                                                </span>
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Institution Code</label>
                                                                    <input type="text" class="form-control" name="institutionCode" id="institutionCode" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-12 col-lg-offset-0">
                                                        <div class="col-lg-6 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">event_note</i>
                                                                </span>
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Board Type</label>
                                                                    <div class="radio col-lg-4" style="margin-top:10px;">
                                                                        <label>
                                                                            <input type="radio" name="boardType" value="Single" checked="true">Single
                                                                        </label>
                                                                    </div>
                                                                    <div class="radio col-lg-4" style="margin-top:10px;">
                                                                        <label>
                                                                            <input type="radio" name="boardType" value="Multiple">Multiple
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="col-lg-6 col-lg-offset-0" style="padding-bottom: 15px;">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">event_note</i>
                                                                </span>
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Board Selection<span class="text-danger">*</span></label>
                                                                    <div class="form-group label-floating">
                                                                        <select class="selectpicker" name="boardSelection" id="boardSelection" data-size="7" data-style="select-with-transition" title="-Select-" required >
                                                                            <option value="1">1</option>
                                                                            <option value="2">2</option>
                                                                            <option value="3">3</option>
                                                                            <option value="4">4</option>
                                                                        </select> 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-12 col-lg-offset-0">
                                                        <div class="col-lg-6 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">location_on</i>
                                                                </span>
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Board (If Multiple)</label>
                                                                    <input type="text" class="form-control" name="board" id="board"  style="text-transform: capitalize;" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">school</i>
                                                                </span>
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Select University</label>
                                                                    <div class="form-group label-floating">
                                                                        <select class="selectpicker" name="university" id="university" data-size="7" data-style="select-with-transition" title="-Select-">
                                                                            <option value="school">School</option>
                                                                            <option value="pu">PU</option>
                                                                            <option value="ug">UG</option>
                                                                            <option value="pg">PG</option>
                                                                        </select> 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
													<div class="col-lg-12">
														<h5 style="padding: 10px 30px;font-weight: 500;color: #555;">Institution Office Contact</h5>
													</div>
												</div>

                                                <div class="row">
                                                    <div class="col-lg-12 col-lg-offset-0">
                                                        <div class="col-lg-6 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">phone</i>
                                                                </span>
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Contact</label>
                                                                    <input type="text" class="form-control" name="institutionContact" id="institutionContact" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" number="true" onblur="this" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">                                                            <i class="material-icons">email</i></i>
                                                                </span>
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Email</label>
                                                                    <input type="text" class="form-control" name="institutionEmail" id="institutionEmail" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
													<div class="col-lg-12">
														<h5 style="padding: 10px 30px;font-weight: 500;color: #555;">Principal Details</h5>
													</div>
												</div>

                                                <div class="row">
                                                    <div class="col-lg-12 col-lg-offset-0">
                                                        <div class="col-lg-4 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">account_circle</i>
                                                                </span>
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Name<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="principalName" id="principalName" style="text-transform: capitalize;" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">phone</i>
                                                                </span>
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Contact<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="principalContact" id="principalContact" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" number="true" onblur="this" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">                                                            <i class="material-icons">email</i></i>
                                                                </span>
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Email<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="principalEmail" id="principalEmail" required />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
													<div class="col-lg-12">
														<h5 style="padding: 10px 30px;font-weight: 500;color: #555;">Administrator/Coordinator Details</h5>
													</div>
												</div>

                                                <div class="row">
                                                    <div class="col-lg-12 col-lg-offset-0">
                                                        <div class="col-lg-4 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">account_circle</i>
                                                                </span>
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Name<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="administratorName" id="administratorName" style="text-transform: capitalize;" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">phone</i>
                                                                </span>
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Contact<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="administratorContact" id="administratorContact" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" number="true" onblur="this" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4 col-lg-offset-0" style="padding-bottom: 15px;">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">                                                            <i class="material-icons">email</i></i>
                                                                </span>
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Email<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="administratorEmail" id="administratorEmail" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">settings_cell</i>
                                                                </span>
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">SMS Sender ID<span class="text-danger">*</span></label>
                                                                    <div class="form-group label-floating">
                                                                        <select class="selectpicker" name="senderId" id="senderId" data-size="7" data-style="select-with-transition" title="--Select--" required >
                                                                            <option value="1">1</option>
                                                                            <option value="2">2</option>
                                                                            <option value="3">3</option>
                                                                        </select> 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">list</i>
                                                                </span>
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Modules to Enable<span class="text-danger">*</span></label>
                                                                    <div class="form-group label-floating">
                                                                        <select class="selectpicker" name="modules" id="modules" data-size="7" data-style="select-with-transition" title="--Select--" required>
                                                                            <option value="1">1</option>
                                                                            <option value="2">2</option>
                                                                            <option value="3">3</option>
                                                                        </select> 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
													<div class="col-lg-12">
														<h5 style="padding: 10px 30px;font-weight: 500;color: #555;">Preadmission </h5>
													</div>
												</div>

                                                <div class="row">
                                                    <div class="col-lg-12 col-lg-offset-0">
                                                        <div class="col-lg-6 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">event_note</i>
                                                                </span>
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Preadmission Required?</label>
                                                                    <div class="radio col-lg-4" style="margin-top:10px;">
                                                                        <label>
                                                                            <input type="radio" name="preadmissionRequired" value="No" checked="true">No
                                                                        </label>
                                                                    </div>
                                                                    <div class="radio col-lg-4" style="margin-top:10px;">
                                                                        <label>
                                                                            <input type="radio" name="preadmissionRequired" value="Yes">Yes
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="col-lg-6 col-lg-offset-0" style="padding-bottom: 15px;">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">event_note</i>
                                                                </span>
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Preadmission Academic Year<span class="text-danger">*</span></label>
                                                                    <div class="form-group label-floating">
                                                                        <select class="selectpicker" name="PreAcdYear" id="PreAcdYear" data-size="7" data-style="select-with-transition" title="-Select-" required >
                                                                            <option value="1">1</option>
                                                                            <option value="2">2</option>
                                                                            <option value="3">3</option>
                                                                            <option value="4">4</option>
                                                                        </select> 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
													<div class="col-lg-12">
														<h5 style="padding: 10px 30px;font-weight: 500;color: #555;">Attachment</h5>
													</div>
												</div>

                                                <div class="row" style="padding: 0px 30px;">
                                                    <div class="col-sm-4">
                                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail img-square">
                                                                <img src="https://cdn.egenius.in/img/placeholder.jpg" alt="Image">
                                                            </div>
                                                            <div class="fileinput-preview fileinput-exists thumbnail img-square"></div>
                                                            <div>
                                                                <span class="btn btn-square btn-info btn-file btn-sm">
                                                                    <span class="fileinput-new">Digital Signature</span>
                                                                    <span class="fileinput-exists">Change Digital Signature</span>
                                                                    <input type="file" name="digitalSignature" id="digitalSignature" onchange="validate()" />
                                                                </span><br />
                                                                <a href="#pablo" class="btn btn-danger btn-square fileinput-exists btn-sm" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
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
                                                        <h5 style="padding: 10px 30px;font-weight: 500;color: #555;">Business Analyst Details</h5>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-lg-offset-0">
                                                        <div class="col-lg-4 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">account_circle</i>
                                                                </span>
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Name<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="businessAnalystName" id="businessAnalystName" style="text-transform: capitalize;" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">phone</i>
                                                                </span>
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Contact<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="businessAnalystContact" id="businessAnalystContact" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" number="true" onblur="this" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">                                                            <i class="material-icons">email</i></i>
                                                                </span>
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Email<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="businessAnalystEmail" id="businessAnalystEmail" required />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <h5 style="padding: 10px 30px;font-weight: 500;color: #555;">Area Partner Details</h5>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-lg-offset-0">
                                                        <div class="col-lg-4 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">account_circle</i>
                                                                </span>
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Name<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="areaPartnerName" id="areaPartnerName" style="text-transform: capitalize;" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">phone</i>
                                                                </span>
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Contact<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="areaPartnerContact" id="areaPartnerContact" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" number="true" onblur="this" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">                                                            <i class="material-icons">email</i></i>
                                                                </span>
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Email<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="areaPartnerEmail" id="areaPartnerEmail" required />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <h5 style="padding: 10px 30px;font-weight: 500;color: #555;">Zonal Partner Details</h5>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-lg-offset-0">
                                                        <div class="col-lg-4 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">account_circle</i>
                                                                </span>
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Name<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="zonalPartnerName" id="zonalPartnerName" style="text-transform: capitalize;" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">phone</i>
                                                                </span>
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Contact<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="zonalPartnerContact" id="zonalPartnerContact" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" number="true" onblur="this" required />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4 col-lg-offset-0">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="material-icons">                                                            <i class="material-icons">email</i></i>
                                                                </span>
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Email<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="zonalPartnerEmail" id="zonalPartnerEmail" required />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="wizard-footer">
                                            <div class="pull-right">
                                                <input type='button' class='btn btn-next btn-fill btn-info btn-wd' name='next' value='Next' />
                                                <input type='submit' class='btn btn-finish btn-fill btn-info btn-wd' name='finish' value='finish' />
                                            </div>
                                            <div class="pull-left">
                                                <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='Previous' />
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
        demo.initMaterialWizard();
        setTimeout(function() {
            $('.card.wizard-card').addClass('active');
        }, 600);
    });

    $('#digitalSignature').bind('change', function() { 
		if(this.files[0].size > 100000) {
			alert("File Size Should be Less 100 KB");
			$('#digitalSignature').val('');
		}
	});	
</script>
@endsection    