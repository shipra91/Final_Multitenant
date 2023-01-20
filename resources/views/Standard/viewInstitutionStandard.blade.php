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
                    <div class="col-sm-12 col-sm-offset-0 text-right">
                        <a href="{{url('institution-standard')}}" class="btn btn-finish btn-fill btn-wd btn btn-info"><i class="material-icons">arrow_back</i> Back</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-md-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">local_library</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Standard Details</h4>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label">Board</label>
                                            <input type="text" class="form-control" value="{{$institutionStandardDetails['board']}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label">Course</label>
                                            <input type="text" class="form-control" value="{{$institutionStandardDetails['course']}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label">Stream</label>
                                            <input type="text" class="form-control" value="{{$institutionStandardDetails['stream']}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label">Stream</label>
                                            <input type="text" class="form-control" value="{{$institutionStandardDetails['combination']}}" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label">Standard</label>
                                            <input type="text" class="form-control" value="{{$institutionStandardDetails['standard']}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label">Division</label>
                                            <input type="text" class="form-control" value="{{$institutionStandardDetails['division']}}" disabled />
                                        </div>
                                    </div>

                                    @if($institutionStandardDetails['standard_type'] != 'general')
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label">Year</label>
                                                <input type="text" class="form-control" value="{{$institutionStandardDetails['year']}}" disabled />
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label">Sem</label>
                                                <input type="text" class="form-control" value="{{$institutionStandardDetails['sem']}}" disabled />
                                            </div>
                                        </div>
                                    @endif
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

