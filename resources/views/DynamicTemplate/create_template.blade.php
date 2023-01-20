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
                    <div class="col-md-12 col-md-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">web</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Add Template</h4>
                                <form method="POST" id="templateForm" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Template Category <span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="template_category" id="template_category" data-size="4" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".templateCategory">
                                                    @foreach($templateCategory as $category)
                                                        <option value="{{ $category['label'] }}">{{ $category['display_name'] }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="templateCategory"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Select Single Token Type</label>
                                                <select class="selectpicker" name="single_token_type" id="single_token_type" data-size="4" data-style="select-with-transition" data-live-search="true" title="Select">
                                                    @foreach($tokens as $token)
                                                        <optgroup label="{{ ucwords($token['entity']) }}">
                                                            @foreach($token['columns'] as $column){
                                                                <option value="[#{{ $token['entity']}}.{{ $column }}#]">{{ ucwords(str_replace("_", " ", $column)) }}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Tokens for manual entry</label>
                                                <select class="selectpicker" name="manual_entry_tokan" id="manual_entry_tokan" data-size="4" data-style="select-with-transition" data-live-search="true" title="Select Token">
                                                    @foreach($manualTokens as $token)
                                                        <option value="[${{ $token }}]">{{ ucwords(str_replace("_", " ", $token)) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-lg-12">
                                                <label class="control-label mt-0">Template Name<span class="text-danger">*</span></label>
                                                <input type="text" name="template_name" class="form-control" required />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="control-label form-group mb-8">Template Description<span class="text-danger">*</span></label>
                                                <textarea class="ckeditor" name="template_description" required></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row pull-right">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit">Submit</button>
                                                <a href="{{url('/etpl/dynamic-template')}}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
                                            </div>
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

        $("#single_token_type, #manual_entry_tokan").change(function(event){
            event.preventDefault();

            var tag_keyword = $(this).val();
            CKEDITOR.instances['template_description'].insertHtml(tag_keyword);
        });

        $('#templateForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save template
        $('body').delegate('#templateForm', 'submit', function(e){
            e.preventDefault();

            var btn=$('#submit');

            if ($('#templateForm').parsley().isValid()){

            $.ajax({
                url:"{{ url('/etpl/dynamic-template') }}",
                type:"post",
                dataType:"json",
                data: new FormData(this),
                contentType: false,
                processData:false,
                beforeSend:function(){
                    btn.html('Submitting...');
                    btn.attr('disabled',true);
                },
                success:function(result){
                    console.log(result);
                    btn.html('Submit');
                    btn.attr('disabled',false);

                        if(result['status'] == "200"){

                            if(result.data['signal'] == "success"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function() {
                                    window.location.replace('/etpl/dynamic-template');
                                }).catch(swal.noop)

                            }else if(result.data['signal'] == "exist"){

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
    });
</script>
@endsection
