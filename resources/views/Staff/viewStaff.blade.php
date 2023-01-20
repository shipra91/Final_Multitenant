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
                                <h4 class="card-title">Staff Details</h4>
                                <div class="row">
									<div class="col-lg-12">
										<h5 class="viewStaff-firstChild">Basic Details</h5>
									</div>
								</div>

                                <div class="row">
                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Name</label>
                                            <input type="text" class="form-control" value ="{{ucwords($staffData->name)}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Date Of Birth</label>
                                            <input type="text" class="form-control" value ="{{$staffData->date_of_birth}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Staff / Employee ID</label>
                                            <input type="text" class="form-control" value ="{{$staffData->employee_id}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Date Of Joining</label>
                                            <input type="text" class="form-control" value ="{{$staffData->joining_date}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Gender</label>
                                            <input type="text" class="form-control" value ="{{$staffData->gender}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Blood Group</label>
                                            <input type="text" class="form-control" value ="{{$staffData->bloodGroup}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Designation</label>
                                            <input type="text" class="form-control" value ="{{ucwords($staffData->designation)}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Department</label>
                                            <input type="text" class="form-control" value ="{{ucwords($staffData->department)}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Staff Roll</label>
                                            <input type="text" class="form-control" value ="{{ucwords($staffData->role)}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Staff Category</label>
                                            <input type="text" class="form-control" value ="{{ucwords($staffData->staffCategory)}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Staff Subcategory</label>
                                            <input type="text" class="form-control" value ="{{ucwords($staffData->staffSubcategory)}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Phone No</label>
                                            <input type="text" class="form-control" value ="{{$staffData->primary_contact_no}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Emergency Phone No</label>
                                            <input type="text" class="form-control" value ="{{$staffData->secondary_contact_no}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Email</label>
                                            <input type="text" class="form-control" value ="{{$staffData->email_id}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Duration Of Employment</label>
                                            <input type="text" class="form-control" value ="{{$staffData->duration_employment}}" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5 class="viewStaff">Address</h5>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Pincode</label>
                                            <input type="text" class="form-control" value ="{{$staffData->pincode}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Post Office</label>
                                            <input type="text" class="form-control" value ="{{$staffData->post_office}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">City/Taluk</label>
                                            <input type="text" class="form-control" value ="{{ucwords($staffData->taluk)}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">District</label>
                                            <input type="text" class="form-control" value ="{{ucwords($staffData->district)}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-8 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Address</label>
                                            <input type="text" class="form-control" value ="{{$staffData->address}}" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5 class="viewStaff">Family Details</h5>
                                    </div>
                                </div>

                                @foreach($staffData['familyDetails'] as $index => $data)
                                    <div class="row">
                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label">Name</label>
                                                <input type="text" class="form-control" value ="{{$data->name}}" disabled />
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label">Phone</label>
                                                <input type="text" class="form-control" value ="{{$data->phone}}" disabled />
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label">Relation</label>
                                                <input type="text" class="form-control" value ="{{$data->relation}}" disabled />
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5 class="viewStaff">Additional Details</h5>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Nationality</label>
                                            <input type="text" class="form-control" value ="{{ucwords($staffData->nationality)}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Religion</label>
                                            <input type="text" class="form-control" value ="{{ucwords($staffData->religion)}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Cast</label>
                                            <input type="text" class="form-control" value ="{{ucwords($staffData->cast)}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Aadhaar Card Number</label>
                                            <input type="text" class="form-control" value ="{{$staffData->aadhaar_no}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">PAN Card Number</label>
                                            <input type="text" class="form-control" value ="{{$staffData->pancard_no}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">PF UAN Number</label>
                                            <input type="text" class="form-control" value ="{{$staffData->pf_uan_no}}" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5 class="viewStaff">Configuration</h5>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Board</label>
                                            <input type="text" class="form-control" value ="{{ $staffData['selectedBoard'] }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Subject Specialization</label>
                                            <input type="text" class="form-control" value ="{{ $staffData['selectedSubject'] }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Recruited as head teacher?</label>
                                            <input type="text" class="form-control" value ="{{$staffData->head_teacher}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Working hours?</label>
                                            @php
                                                if($staffData->working_hours == 'FULL_TIME'){
                                                    $workingHours = 'Full Time';
                                                }else{
                                                    $workingHours = 'Part Time';
                                                }
                                            @endphp
                                            <input type="text" class="form-control" value ="{{$workingHours}}" disabled />
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
                                    <div class="col-md-12">
                                        <div class="pull-right">
                                            <a href="/staff/{{$staffData->id}}" type="button" class="btn btn-success btn-wd mr-5">Edit</a>
                                            <a href="{{ url('staff') }}" class="btn btn-wd btn btn-danger">Close</a>
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
                                @if($staffData->staff_image != '')
                                    <img class="img" src="{{url($staffData->staff_image)}}" />
                                @else
                                    <img src="//cdn.egenius.in/img/placeholder.jpg" class="img" />
                                @endif
                            </div>

                            <h4 class="card-name text-center">{{ucwords($staffData->name)}}</h4>

                            <div class="card-content border-top text-center">
                                <div class="row">
                                    <div class="col-md-12 mb-10">
                                        <h6 class="view-details">Aadhaar Card</h6>
                                        @if($staffData->attachment_aadhaar != '')
                                            <a href="{{url($staffData->attachment_aadhaar)}}" target="_blank"><button class="btn btn-info btn-sm m0">Download&nbsp;<i class="material-icons">file_download</i><div class="ripple-container"></div></button></a>
                                        @else
                                            <span class="badge badge-warning">Not uploaded</span>
                                        @endif
                                    </div>

                                    <div class="col-md-12 mb-10">
                                        <h6 class="view-details">PAN Card</h6>
                                        @if($staffData->attachment_pancard != '')
                                            <a href="{{url($staffData->attachment_pancard)}}" target="_blank"><button class="btn btn-info btn-sm m0">Download&nbsp;<i class="material-icons">file_download</i><div class="ripple-container"></div></button></a>
                                        @else
                                            <span class="badge badge-warning">Not uploaded</span>
                                        @endif
                                    </div>

                                    @foreach($customFileDetails as $fileValue)
                                        <div class="col-md-12 mb-10">
                                            <h6 class="view-details">{{$fileValue->custom_field_name}}</h6>
                                            @if($fileValue->field_value != 'NULL' && $fileValue->field_value != '')
                                                <a href="{{$fileValue->field_value}}" target="_blank"><button class="btn btn-info btn-sm m0">Download&nbsp;<i class="material-icons">file_download</i><div class="ripple-container"></div></button></a>
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
