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
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">school</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Institution Details</h4>
                                <div class="row">
									<div class="col-lg-12">
										<h5 class="viewStaff">Basic Details</h5>
									</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Organization Name</label>
                                            <input type="text" class="form-control" value ="{{$institution['organization']->name}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Institution Name</label>
                                            <input type="text" class="form-control" value ="{{$institution->name}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Pincode</label>
                                            <input type="text" class="form-control" value ="{{$institution->pincode}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Post Office</label>
                                            <input type="text" class="form-control" value ="{{$institution->post_office}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">City/Taluk</label>
                                            <input type="text" class="form-control" value ="{{$institution->taluk}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">State</label>
                                            <input type="text" class="form-control" value ="{{$institution->state}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">District</label>
                                            <input type="text" class="form-control" value ="{{$institution->district}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Country</label>
                                            <input type="text" class="form-control" value ="{{$institution->country}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Address</label>
                                            <input type="text" class="form-control" value ="{{$institution->address}}" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5 class="viewStaff">Institution Type Details</h5>
                                    </div>
                                </div>

                                @foreach($institutionCourseDetails as $index => $data)
                                    <div class="row">
                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label">Board / University</label>
                                                <input type="text" class="form-control" value ="{{$data['board_university']}}" disabled />
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label">Institution Type</label>
                                                <input type="text" class="form-control" value ="{{$data['institution_type']}}" disabled />
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label">Course</label>
                                                <input type="text" class="form-control" value ="{{$data['course']}}" disabled />
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label">Stream</label>
                                                <input type="text" class="form-control" value ="{{$data['stream']}}" disabled />
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label">Combination</label>
                                                <input type="text" class="form-control" value ="{{$data['combination']}}" disabled />
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <label class="control-label">Institution Code</label>
                                                <input type="text" class="form-control" value ="{{$data['institution_code']}}" disabled />
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5 class="viewStaff">Institution Contact Details</h5>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Contact</label>
                                            <input type="text" class="form-control" value ="{{$institution->mobile_number}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Landline Number</label>
                                            <input type="text" class="form-control" value ="{{$institution->landline_number}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Email</label>
                                            <input type="text" class="form-control" value ="{{$institution->office_email}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Website URL</label>
                                            <input type="text" class="form-control" value ="{{$institution->website_url}}" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5 class="viewStaff">POC (Point Of Contact) Detail</h5>
                                    </div>
                                </div>

                                @foreach($institution['poc'] as $index => $data)
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Name</label>
                                                <input type="text" class="form-control" value="{{$data->name}}" disabled>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Designation</label>
                                                <input type="text" class="form-control" value="{{$data->poc_designation_name}}" disabled>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Phone No</label>
                                                <input type="text" class="form-control" value="{{$data->mobile_number}}" disabled>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Email ID</label>
                                                <input type="text" class="form-control" value="{{$data->email}}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5 class="viewStaff">Area Partner Detail</h5>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Name</label>
                                            <input type="text" class="form-control" value ="{{$institution->area_partner_name}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Contact</label>
                                            <input type="text" class="form-control" value ="{{$institution->area_partner_phone}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Email</label>
                                            <input type="text" class="form-control" value ="{{$institution->area_partner_email}}" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
									<div class="col-lg-12">
										<h5 class="viewStaff">Zonal Partner Details</h5>
									</div>
								</div>

                                <div class="row">
                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Name</label>
                                            <input type="text" class="form-control" value ="{{$institution->zonal_partner_name}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Contact</label>
                                            <input type="text" class="form-control" value ="{{$institution->zonal_partner_phone}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Email</label>
                                            <input type="text" class="form-control" value ="{{$institution->zonal_partner_email}}" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
									<div class="col-lg-12">
										<h5 class="viewStaff"> Module Details</h5>
									</div>
								</div>

                                <div class="row">
                                    <div class="col-lg-12 col-lg-offset-0">
                                        <div class="form-group">
                                            <label class="control-label">Enabled Modules</label>
                                            {{-- <input type="text" class="form-control" value ="{{$institution['module_names']}}" disabled /> --}}
                                            <textarea class="form-control" rows="5" id="comment">{{$institution['module_names']}}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <div class="form-group">
                                            <a href="/etpl/institution/{{$institution->id}}" type="button" rel="tooltip" title="Edit" class="btn btn-success btn-wd mr-5">Edit</a>
                                            <a href="{{ url('/etpl/institution') }}" class="btn btn-fill btn-wd btn btn-danger">Close</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card mb-50">
                            <div class="card-logo">
                                @if($institution->institution_logo != '')
                                    <img class="img" src="{{url($institution->institution_logo)}}" />
                                @else
                                   <img class="img" src="//cdn.egenius.in/img/placeholder.jpg" alt="Image" />
                                @endif
                            </div>
                            <h4 class="institute-attachment">Institution Logo</h4>
                        </div>

                        <div class="card">
                            <div class="card-logo">
                                @if($institution->fav_icon != '')
                                    <img class="img" src="{{url($institution->fav_icon)}}" />
                                @else
                                   <img class="img" src="//cdn.egenius.in/img/placeholder.jpg" alt="Image" />
                                @endif
                            </div>
                            <h4 class="institute-attachment">Fav Icon</h4>
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
