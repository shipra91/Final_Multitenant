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
                                            <label class="control-label mt-0">Board</label>
                                            <input type="text" class="form-control" value="{{ $institutionStandardDetails['board'] }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Course</label>
                                            <input type="text" class="form-control" value="{{ $institutionStandardDetails['course'] }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Stream</label>
                                            <input type="text" class="form-control" value="{{ $institutionStandardDetails['stream'] }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Stream</label>
                                            <input type="text" class="form-control" value="{{ $institutionStandardDetails['combination'] }}" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Standard</label>
                                            <input type="text" class="form-control" value="{{ $institutionStandardDetails['standard'] }}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Division</label>
                                            <input type="text" class="form-control" value="{{ $institutionStandardDetails['division'] }}" disabled />
                                        </div>
                                    </div>

                                    @if($institutionStandardDetails['standard_type'] != 'general')
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Year</label>
                                                <input type="text" class="form-control" value="{{ $institutionStandardDetails['year'] }}" disabled />
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Sem</label>
                                                <input type="text" class="form-control" value="{{ $institutionStandardDetails['sem'] }}" disabled />
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="pull-right">
                                            {{-- @if(Helper::checkAccess('institution-standard', 'edit'))
                                                <a href="/seminar/{{$seminarDetails['seminarData']->id}}" type="button" class="btn btn-success btn-wd mr-5">Edit</a>
                                            @endif --}}
                                            <a href="{{ url('institution-standard') }}" class="btn btn-danger btn-wd">Close</a>
                                        </div>
                                    </div>
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

