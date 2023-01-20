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
                    <div class="col-sm-12 col-sm-offset-0 text-right">
                        <a href="{{ url('/etpl/dynamic-template') }}" class="btn btn-finish btn-fill btn-wd btn btn-info"><i class="material-icons">arrow_back</i> Back</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-md-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">web</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Template Details</h4>
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label class="control-label">Template Category</label>
                                        <input type="text" class="form-control" value="{{ $templateData->template_category }}" disabled />
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label class="control-label">Template Name</label>
                                        <input type="text" class="form-control" value="{{ $templateData->template_name }}" disabled />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label class="control-label mb-20">Template Description</label>
                                        <textarea name="template_description" class="form-control ckeditor" required>{{ $templateData->template_content }}</textarea>
                                    </div>
                                </div>

                                {{-- <div class="pull-right">
                                    <a href="{{ url('/etpl/dynamic-template') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
                                </div>
                                <div class="clearfix"></div> --}}
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

        $("#single_token_type").change(function(event){
            event.preventDefault();

            var tag_keyword = $(this).val();
            CKEDITOR.instances['template_description'].insertHtml(tag_keyword);
        });
    });
</script>
@endsection
