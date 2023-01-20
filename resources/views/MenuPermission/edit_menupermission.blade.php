@php
    if(Auth::user()->type === 'developer')
        $menuPath = '/etpl/module-permission';
    else
        $menuPath = '/menu-permission';
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
                <form method="POST" class="demo-form" enctype="multipart/form-data" id="menuPermissionForm">
                    <div class="row">
                        <div class="col-sm-12 col-sm-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">accessibility</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Edit Role Menu Permission</h4>
                                    <div class="row">
                                        <input type="hidden" id="filepath" value="<?php echo $menuPath; ?>"/>
                                        <div class="col-lg-4 col-lg-offset-0">
                                            <div class="form-group">
                                                <input type="hidden" name="role_name" id="role_id" value="{{ $allData['roleData']->id }}">
                                                <input type="text" value="{{ $allData['roleData']->display_name }}" class="form-control" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                @foreach($allData['modules'] as $index => $data)
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="heading_{{ $index }}">
                                            <h4 class="panel-title">
                                                <a role="button" class="h4" data-toggle="collapse" data-parent="#accordion" href="#collapse_{{ $index }}" aria-expanded="true" aria-controls="collapse_{{ $index }}">
                                                    <i class="more-less material-icons">expand_more</i>
                                                    {{ $data['display_name'] }}
                                                </a>
                                            </h4>
                                        </div>

                                        <div id="collapse_{{ $index }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_{{ $index }}">
                                            <div class="panel-body" id="{{ $data['display_name'] }}">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="no-border fw-500">Permissions</th>
                                                            <th class="checkbox no-border">
                                                                <label class="fw-500">
                                                                    <input type="checkbox" class="viewAll" value="{{ $data['module_label'] }}"/>View
                                                                </label>
                                                            </th>
                                                            <th class="checkbox no-border">
                                                                <label class="fw-500">
                                                                    <input type="checkbox" class="viewOwnAll" value="{{ $data['module_label'] }}"/>View Own
                                                                </label>
                                                            </th>
                                                            <th class="checkbox no-border">
                                                                <label class="fw-500">
                                                                    <input type="checkbox" class="createAll" value="{{ $data['module_label'] }}"/>Create
                                                                </label>
                                                            </th>
                                                            <th class="checkbox no-border">
                                                                <label class="fw-500">
                                                                    <input type="checkbox" class="editAll" value="{{ $data['module_label'] }}"/>Edit
                                                                </label>
                                                            </th>
                                                            <th class="checkbox no-border">
                                                                <label class="fw-500">
                                                                    <input type="checkbox" class="deleteAll" value="{{ $data['module_label'] }}"/>Delete
                                                                </label>
                                                            </th>
                                                            <th class="checkbox no-border">
                                                                <label class="fw-500">
                                                                    <input type="checkbox" class="exportAll" value="{{ $data['module_label'] }}"/>Export
                                                                </label>
                                                            </th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @if(count($data['sub_modules']) > 0)
                                                            @foreach($data['sub_modules'] as $key => $submodule)
                                                                <tr>
                                                                    <td class="no-border">
                                                                        <input type="hidden" name="module[]" value="{{ $submodule['id'] }}">
                                                                        {{ $submodule['display_name'] }}
                                                                    </td>
                                                                    <td class="checkbox no-border">
                                                                        <label class="fw-500"><input type="checkbox" class="view_{{ $data['module_label'] }}" name="action[{{ $submodule['id'] }}][]" value="view" @if($submodule['permission']['view'] == "YES") {{ "checked" }} @endif /></label>
                                                                    </td>
                                                                    <td class="checkbox no-border">
                                                                        <label class="fw-500"><input type="checkbox" class="viewOwn_{{ $data['module_label'] }}" name="action[{{ $submodule['id'] }}][]" value="viewOwn" @if($submodule['permission']['view_own'] == "YES") {{ "checked" }} @endif /></label>
                                                                    </td>
                                                                    <td class="checkbox no-border">
                                                                        <label class="fw-500"><input type="checkbox" class="create_{{ $data['module_label'] }}" name="action[{{ $submodule['id'] }}][]" value="create" @if($submodule['permission']['create'] == "YES") {{ "checked" }} @endif /></label>
                                                                    </td>
                                                                    <td class="checkbox no-border">
                                                                        <label class="fw-500"><input type="checkbox" class="edit_{{ $data['module_label'] }}" name="action[{{ $submodule['id'] }}][]" value="edit" @if($submodule['permission']['edit'] == "YES") {{ "checked" }} @endif /></label>
                                                                    </td>
                                                                    <td class="checkbox no-border">
                                                                        <label class="fw-500"><input type="checkbox" class="delete_{{ $data['module_label'] }}" name="action[{{ $submodule['id'] }}][]" value="delete" @if($submodule['permission']['delete'] == "YES") {{ "checked" }} @endif /></label>
                                                                    </td>
                                                                    <td class="checkbox no-border">
                                                                        <label class="fw-500"><input type="checkbox" class="export_{{ $data['module_label'] }}" name="action[{{ $submodule['id'] }}][]" value="export" @if($submodule['permission']['export'] == "YES") {{ "checked" }} @endif /></label>
                                                                    </td>
                                                                </tr>
                                                            @endforeach

                                                        @else

                                                            <tr>
                                                                <td class="no-border">
                                                                    <input type="hidden" name="module[]" value="{{ $data['id'] }}">
                                                                    {{ $data['display_name'] }}
                                                                </td>
                                                                <td class="checkbox no-border">
                                                                    <label class="fw-500"><input type="checkbox" class="view_{{ $data['module_label'] }}" name="action[{{ $data['id'] }}][]" value="view" @if($data['permission']['view'] == "YES") {{ "checked" }} @endif /></label>
                                                                </td>
                                                                <td class="checkbox no-border">
                                                                    <label class="fw-500"><input type="checkbox" class="viewOwn_{{ $data['module_label'] }}" name="action[{{ $data['id'] }}][]" value="viewOwn" @if($data['permission']['view_own'] == "YES") {{ "checked" }} @endif /></label>
                                                                </td>
                                                                <td class="checkbox no-border">
                                                                    <label class="fw-500"><input type="checkbox" class="create_{{ $data['module_label'] }}" name="action[{{ $data['id'] }}][]" value="create" @if($data['permission']['create'] == "YES") {{ "checked" }} @endif /></label>
                                                                </td>
                                                                <td class="checkbox no-border">
                                                                    <label class="fw-500"><input type="checkbox" class="edit_{{ $data['module_label'] }}" name="action[{{ $data['id'] }}][]" value="edit" @if($data['permission']['edit'] == "YES") {{ "checked" }} @endif /></label>
                                                                </td>
                                                                <td class="checkbox no-border">
                                                                    <label class="fw-500"><input type="checkbox" class="delete_{{ $data['module_label'] }}" name="action[{{ $data['id'] }}][]" value="delete" @if($data['permission']['delete'] == "YES") {{ "checked" }} @endif /></label>
                                                                </td>
                                                                <td class="checkbox no-border">
                                                                    <label class="fw-500"><input type="checkbox" class="export_{{ $data['module_label'] }}" name="action[{{ $data['id'] }}][]"
                                                                    value="export" @if($data['permission']['export'] == "YES") {{ "checked" }} @endif /></label>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Update</button>
                                <a href="{{ url('menu-permission') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </form>
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

        $('#menuPermissionForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Update role menu permission
        var filepath = $("#filepath").val();
        $('body').delegate('#menuPermissionForm', 'submit', function(e){
            e.preventDefault();

            var btn=$('#submit');

            if ($('#menuPermissionForm').parsley().isValid()){

                $.ajax({
                    url: filepath,
                    type: "post",
                    dataType: "json",
                    data: new FormData(this),
                    contentType: false,
                    processData:false,
                    beforeSend:function(){
                        btn.html('Updating...');
                        btn.attr('disabled',true);
                    },
                    success:function(result){
                        btn.html('Update');
                        btn.attr('disabled',false);

                        if(result['status'] == "200"){

                            if(result.data['signal'] == "success"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function() {
                                    window.location.replace(filepath);
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

        // Select all checkbox
        $(document).delegate(".viewAll", "change", function(event){
            event.preventDefault();

            var moduleName = $(this).val();

            if($(this).is(":checked")){
                $(".view_"+moduleName).prop("checked",true);
            }else{
                $(".view_"+moduleName).prop("checked",false);
            }
        });

        $(document).delegate(".viewOwnAll", "change", function(event){
            event.preventDefault();

            var moduleName = $(this).val();

            if($(this).is(":checked")){
                $(".viewOwn_"+moduleName).prop("checked",true);
            }else{
                $(".viewOwn_"+moduleName).prop("checked",false);
            }
        });

        $(document).delegate(".createAll", "change", function(event){
            event.preventDefault();

            var moduleName = $(this).val();

            if($(this).is(":checked")){
                $(".create_"+moduleName).prop("checked",true);
            }else{
                $(".create_"+moduleName).prop("checked",false);
            }
        });

        $(document).delegate(".editAll", "change", function(event){
            event.preventDefault();

            var moduleName = $(this).val();

            if($(this).is(":checked")){
                $(".edit_"+moduleName).prop("checked",true);
            }
            else{
                $(".edit_"+moduleName).prop("checked",false);
            }
        });

        $(document).delegate(".exportAll", "change", function(event){
            event.preventDefault();

            var moduleName = $(this).val();

            if($(this).is(":checked")){
                $(".export_"+moduleName).prop("checked",true);
            }else{
                $(".export_"+moduleName).prop("checked",false);
            }
        });

        $(document).delegate(".deleteAll", "change", function(event){
            event.preventDefault();

            var moduleName = $(this).val();

            if($(this).is(":checked")){
                $(".delete_"+moduleName).prop("checked",true);
            }else{
                $(".delete_"+moduleName).prop("checked",false);
            }
        });
    });
</script>
@endsection
