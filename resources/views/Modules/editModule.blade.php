@php 

@endphp

@extends('layouts.master')

@section('content')
<div class="wrapper">
    @if(Auth::user()->type === 'developer')
        @include('/ETPLSliderbar/sliderbar')
    @else
        @include('sliderbar')
    @endif
    <div class="main-panel">
        @if(Auth::user()->type === 'developer')
            @include('/ETPLSliderbar/navigation')
        @else
            @include('navigation')
        @endif
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 col-sm-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">event</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Edit Module</h4>
                                <div class="toolbar">
                                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                                </div>
                                
                                <form method="POST" class="demo-form" enctype="multipart/form-data" id="moduleForm">
                                    
                                    <div class="row">

                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">date_range</i>
                                                </span>
                                                <div class="form-group">
                                                    <label class="control-label">Module Label <span class="text-danger">*</span></label>
                                                    <input name="module_label" type="text" class="form-control" value="{{$selectedModule->module_label}}" required>
                                                    <input name="module_id" id="module_id" type="hidden" value="{{$selectedModule->id}}" required>
                                                </div>
                                            </div>
                                        </div>                                                
                                                
                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">date_range</i>
                                                </span>
                                                <div class="form-group">
                                                    <label class="control-label">Module Display Name <span class="text-danger">*</span></label>
                                                    <input name="display_name" type="text" class="form-control" value="{{$selectedModule->display_name}}" required>
                                                </div>
                                            </div>
                                        </div>                                              
                                                
                                        <div class="col-lg-4 form-group col-lg-offset-0">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons icon-middle">school</i>
                                                </span>
                                                <div class="form-group">
                                                    <label class="control-label">Parent Modules</label>
                                                    <select name='parent_id' class="selectpicker" data-style="select-with-transition" data-size="5" data-live-search="true" title="Select Parent Module">
                                                        @foreach($modules as $index => $data)
                                                            <option value="{{$data->id}}" @if($selectedModule->id_parent == $data->id) {{'selected'}} @endif>{{$data->display_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                            
                                    <div class="row">
                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">date_range</i>
                                                </span>
                                                <div class="form-group">
                                                    <label class="control-label">Icon <span class="text-danger">*</span></label>
                                                    <input name="icon" type="text" class="form-control" value="{{$selectedModule->icon}}" required>
                                                </div>
                                            </div>
                                        </div>                                                
                                                
                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">date_range</i>
                                                </span>
                                                <div class="form-group">
                                                    <label class="control-label">File Url <span class="text-danger">*</span></label>
                                                    <input name="file_path" type="text" class="form-control" value="{{$selectedModule->file_path}}" required>
                                                </div>
                                            </div>
                                        </div>  

                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">date_range</i>
                                                </span>
                                                <div class="form-group">
                                                    <label class="control-label">Page Name <span class="text-danger">*</span></label>
                                                    <input name="page_name" type="text" class="form-control" value="{{ $selectedModule->page }}" required>
                                                </div>
                                            </div>
                                        </div>      

                                    </div> 
                                            
                                    <div class="row">        
                                        
                                        <div class="col-lg-3 form-group col-lg-offset-0">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons icon-middle">school</i>
                                                </span>
                                                <div class="form-group">
                                                    <label class="control-label">Type<span class="text-danger">*</span></label>
                                                    <select name='access_type' class="selectpicker" data-style="select-with-transition"  data-size="5" title="Select Type" data-live-search="true" data-parsley-errors-container=".typeError" required>
                                                        <option value="Web" @if($selectedModule->type == 'Web') {{'selected'}} @endif>Web</option>
                                                        <option value="App" @if($selectedModule->type == 'App') {{'selected'}} @endif>App</option>
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
                                                    <label class="control-label">Custom Field Required ? <span class="text-danger">*</span></label>
                                                    <select name='is_custom_field_required' class="selectpicker" data-style="select-with-transition"  data-size="5" title="Select Option" data-live-search="true" data-parsley-errors-container=".customError" required>
                                                        <option value="No" @if($selectedModule->is_custom_field_required == 'No') {{'selected'}} @endif>No</option>
                                                        <option value="Yes" @if($selectedModule->is_custom_field_required == 'Yes') {{'selected'}} @endif>Yes</option>
                                                    </select>
                                                    <div class="customError"></div>
                                                </div>
                                            </div>
                                        </div>     
                                        
                                        <div class="col-lg-3 form-group col-lg-offset-0">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons icon-middle">school</i>
                                                </span>
                                                <div class="form-group">
                                                    <label class="control-label">Is SMS Mapped ? <span class="text-danger">*</span></label>
                                                    <select name='sms_mapped' class="selectpicker" data-style="select-with-transition" data-size="5" title="Select Type" data-live-search="true" data-parsley-errors-container=".smsError" required>
                                                        <option value="No" @if($selectedModule->is_sms_mapped == 'No') {{'selected'}} @endif>No</option>
                                                        <option value="Yes" @if($selectedModule->is_sms_mapped == 'Yes') {{'selected'}} @endif>Yes</option>
                                                    </select>
                                                    <div class="smsError"></div>
                                                </div>
                                            </div>
                                        </div>      
                                        
                                        <div class="col-lg-3 form-group col-lg-offset-0">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons icon-middle">school</i>
                                                </span>
                                                <div class="form-group">
                                                    <label class="control-label">Is Email Mapped ? <span class="text-danger">*</span></label>
                                                    <select name='email_mapped' class="selectpicker" data-style="select-with-transition" data-size="5" title="Select Type" data-live-search="true" data-parsley-errors-container=".emailError" required>
                                                        <option value="No" @if($selectedModule->is_email_mapped == 'No') {{'selected'}} @endif>No</option>
                                                        <option value="Yes" @if($selectedModule->is_email_mapped == 'Yes') {{'selected'}} @endif>Yes</option>
                                                    </select>
                                                    <div class="emailError"></div>
                                                </div>
                                            </div>
                                        </div> 

                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <button type='submit' class='btn btn-finish btn-fill btn-info btn-wd' id="submit" name='submit'>Submit</button>
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

        $('#moduleForm').parsley({
            triggerAfterFailure: 'input keyup change focusout changed.bs.select'
        });
        
        // Save New Group
        $('body').delegate('#moduleForm', 'submit', function(e) { 
            e.preventDefault();

            var btn = $('#submit');
            var id = $("#module_id").val();
            if ($('#moduleForm').parsley().isValid()) {

                $.ajax({
                    url:"/etpl/module/"+id,  
                    type:"post", 
                    dataType:"json",
                    data: new FormData(this), 
                    contentType: false,
                    processData:false, 
                    beforeSend:function() { 
                        btn.html('Updating...'); 
                        btn.attr('disabled',true);
                    },   
                    success:function(result) { 
                        // console.log(result);
                        btn.html('Update'); 
                        btn.attr('disabled',false);

                        if(result['status'] == "200"){
                            if(result.data['signal'] == "success") { 
                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function() {
                                    window.location.replace('/etpl/module/create');
                                }).catch(swal.noop)

                            }else if(result.data['signal'] == "exist") { 

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