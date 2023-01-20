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
                                <h4 class="card-title">Add Module</h4>
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
                                                    <input name="module_label" type="text" class="form-control" required>
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
                                                    <input name="display_name" type="text" class="form-control" required>
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
                                                            <option value="{{$data->id}}">{{$data->display_name}}</option>
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
                                                    <input name="icon" type="text" class="form-control" required>
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
                                                    <input name="file_path" type="text" class="form-control" required>
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
                                                    <input name="page_name" type="text" class="form-control" required>
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
                                                        <option value="Web">Web</option>
                                                        <option value="App">App</option>
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
                                                        <option value="No" selected>No</option>
                                                        <option value="Yes">Yes</option>
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
                                                        <option value="No" selected>No</option>
                                                        <option value="Yes">Yes</option>
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
                                                        <option value="No" selected>No</option>
                                                        <option value="Yes">Yes</option>
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

                <div class="row mt-20">
                    <div class="col-sm-12 col-sm-offset-0">  
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">event</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">View Modules</h4>
                                <div class="toolbar">
                                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                                </div>
                                <div class="material-datatables">
                                    <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" width="100%">
                                        <thead style="font-size:12px;">
                                            <tr>
                                                <th><b>S.N.</b></th>
                                                <th><b>Module Label</b></th>
                                                <th><b>Display Name</b></th>
                                                <th><b>Parent Module</b></th>
                                                <th><b>File Path</b></th>
                                                <th><b>Icon</b></th>
                                                <th><b>Page Name</b></th>
                                                <th><b>Type</b></th>
                                                <th><b>Action</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
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
    $(document).ready(function() {
                
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#moduleForm').parsley({
            triggerAfterFailure: 'input keyup change focusout changed.bs.select'
        });

        // View module
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "/etpl/module",
            columns: [
                {data: 'DT_RowIndex', name: 'created_at', className:"text-center", width:"10%"},
                {data: 'module_label', name: 'module_label', width:"20%"},
                {data: 'display_name', name: 'display_name', width:"25%"},
                {data: 'parent_display_name', name: 'parent_display_name', width:"15%"},
                {data: 'file_path', name: 'file_path', width:"10%"},
                {data: 'icon', name: 'icon', width:"10%"},
                {data: 'page', name: 'page', width:"10%"},
                {data: 'type', name: 'type', width:"10%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, className:"text-center", width:"20%"},
            ]
        });
        
        // Save New Group
        $('body').delegate('#moduleForm', 'submit', function(e) { 
            e.preventDefault();

            var btn=$('#submit');
            if ($('#moduleForm').parsley().isValid()) {

                $.ajax({
                    url:"/etpl/module",  
                    type:"post", 
                    dataType:"json",
                    data: new FormData(this), 
                    contentType: false,
                    processData:false, 
                    beforeSend:function() { 
                        btn.html('Submitting...'); 
                        btn.attr('disabled',true);
                    },   
                    success:function(result) {
                        btn.html('Submit'); 
                        btn.attr('disabled',false);

                        if(result['status'] == "200"){
                            if(result.data['signal'] == "success") { 
                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function() {
                                    window.location.reload();
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

        
        
        $(document).on('click', '.delete', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                type: "DELETE",
                url:"/etpl/module/"+id, 
                dataType: "json",
                data: {id:id},
                success: function (result) {
                    if(result['status'] == "200"){
                        if(result.data['signal'] == "success") { 
                            swal({
                                title: result.data['message'],
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-success"
                            }).then(function() {
                                window.location.reload();
                            }).catch(swal.noop)

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
        });
    });
</script>
@endsection    