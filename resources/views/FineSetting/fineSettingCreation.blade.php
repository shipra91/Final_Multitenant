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
                @if(count($fineSettingDetails['fine_setting_details']) == 0)
                    @if(Helper::checkAccess('fine-setting', 'create'))
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                        <i class="material-icons">local_library</i>
                                    </div>
                                    <form method="GET" action="{{ url('fine-setting/create') }}">
                                        <div class="card-content">
                                            <div class="col-lg-4 col-lg-offset-0">
                                                <div class="form-group">
                                                    <select name="fine_options" id="fine_options" class="selectpicker" data-live-search="true" data-style="select-with-transition" data-size="5" required title="Select Options">
                                                        @foreach($fineOptionDetails as $options)
                                                            <option value="{{$options->label}}" @if($_REQUEST && $_REQUEST['fine_options'] == $options->label ) {{ 'selected'}} @endif>{{$options->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-fill btn-info pull-left btn-sm" style="margin-top: -19px;"  name="submit" value="submit" >Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($fineSettingDetails['label_fine_option'])
                        @if(Helper::checkAccess('fine-setting', 'create'))
                            <div class="row">
                                <div class="alert alert-danger" role="alert">
                                    <strong>Note:</strong> Once you add the setting add option will be disabled.
                                </div>
                                <form method="POST" id="fineSettingForm">
                                    <input type="hidden" name="fine_option" value={{$fineSettingDetails['label_fine_option']}}>
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                                <i class="material-icons">subject</i>
                                            </div>
                                            <div class="card-content">
                                                <h4 class="card-title">Add Setting</h4>
                                                
                                                <div id="repeater">
                                                    <input type="hidden" name="totalCount" id="totalCount" value="1">

                                                    @if(count($fineSettingDetails['fine_setting'])>0)

                                                        @foreach($fineSettingDetails['fine_setting'] as $setting)
                                                            <div class="row" id="section_1" data-id="1">
                                                                <div class="col-lg-4 col-lg-offset-0">
                                                                    <div class="form-group">
                                                                        <label class="control-label mt-0">Number Of Days<span class="text-danger">*</span></label>
                                                                        <input type="text" class="form-control" name="number_of_days[]" id="number_of_days" value="{{$setting->number_of_days}}" required />
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-4 col-lg-offset-0">
                                                                    <div class="form-group">
                                                                        <label class="control-label mt-0">Setting Type<span class="text-danger">*</span></label>
                                                                        <select class="selectpicker setting_type " name="setting_type[]" data-size="5" data-style="select-with-transition" data-live-search="true" required="required">
                                                                            @foreach($fineSettingDetails['setting_types'] as $types)
                                                                                <option value="{{ $types }}" @if($setting->setting_type == $types) {{'selected'}} @endif >{{$types}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-3 col-lg-offset-0">
                                                                    <div class="form-group">
                                                                        <label class="control-label mt-0">Amount<span class="text-danger">*</span></label>
                                                                        <input type="text" class="form-control" name="amount[]" id="amount" value="{{$setting->amount}}" required />
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-1 form-group col-lg-offset-0 text-right">
                                                                    <td><button type="button" id="1" class="btn btn-danger btn-sm remove_button"><i class="material-icons">highlight_off</i></button></td>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                    @else

                                                        <div class="row" id="section_1" data-id="1">
                                                            <div class="col-lg-4 col-lg-offset-0">
                                                                <div class="form-group">
                                                                    <label class="control-label mt-0">Number Of Days<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="number_of_days[]" id="number_of_days" required />
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-4 col-lg-offset-0">
                                                                <div class="form-group">
                                                                    <label class="control-label mt-0">Setting Type<span class="text-danger">*</span></label>
                                                                    <select class="selectpicker setting_type " name="setting_type[]" data-size="5" data-style="select-with-transition" data-live-search="true" required="required">
                                                                        @foreach($fineSettingDetails['setting_types'] as $types)
                                                                            <option value="{{ $types }}" >{{$types}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 col-lg-offset-0">
                                                                <div class="form-group">
                                                                    <label class="control-label mt-0">Amount<span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="amount[]" id="amount" required />
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-1 form-group col-lg-offset-0 text-right">
                                                                <button type="button" id="1" class="btn btn-danger btn-xs remove_button mt-20"><i class="material-icons">highlight_off</i></button>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-10 col-lg-offset-0">
                                                        <button id="add_more" type="button" class="btn btn-warning btn-sm"><i class="material-icons">add_circle_outline</i> Add More</button>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-12 text-right">
                                                        <button type="submit" class="btn btn-next btn-fill btn-info btn-wd mr-5" name="submit" id="submit" value="submit">Submit</button>
                                                        <a type='button' class='btn btn-finish btn-fill btn-danger btn-wd' href="{{url('fine-setting')}}">Close</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                    @endif

                @else
                    @if(Helper::checkAccess('fine-setting', 'view'))
                        <div class="row">
                            <div class="col-sm-12 col-sm-offset-0">
                                <div class="alert alert-danger" role="alert">
                                    <strong>Note:</strong> If you want to add the new setting, please delete the existing setting.
                                </div>
                            </div>
                            <div class="col-sm-12 col-sm-offset-0">
                                <div class="card">
                                    <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                        <i class="material-icons">account_balance_wallet</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Fine Setting</h4>

                                        <div class="toolbar"></div>
                                        <div class="material-datatables">
                                            <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" style="width:100%">
                                                <thead style="font-size:12px;">
                                                    <tr>
                                                        <th><b>S.N.</b></th>
                                                        <th><b>Setting Type</b></th>
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
                    @endif
                @endif
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

        // View fine setting
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "fine-setting",
            columns: [
                {data: 'DT_RowIndex', name: 'created_at', "width": "10%"},
                {data: 'label', name: 'label', "width": "65%"},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "25%", className:"text-center"},
            ]
        });

        // Add more fine setting details
        var count = $('#totalCount').val();

        $(document).on('click', '#add_more', function(){

            var html = '';
            count++;

            html += '<div class="row" id="section_'+count+'" data-id="'+count+'">';

            html += '<div class="col-lg-4 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Number Of Days<span class="text-danger">*</span></label>';
            html += '<input type="text" class="form-control" name="number_of_days[]" id="number_of_days" required />';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-4 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Setting Type<span class="text-danger">*</span></label>';
            html += '<select class="selectpicker setting_type" name="setting_type[]" data-size="5" data-style="select-with-transition" data-live-search="true" required="required">';
            <?php
            if($fineSettingDetails['label_fine_option']) {
            foreach($fineSettingDetails['setting_types'] as $types){ ?>
                html += '<option value="<?php echo $types; ?>" ><?php echo $types; ?></option>';
            <?php
                }
            } ?>
            html += '</select>';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-3 col-lg-offset-0">';
            html += '<div class="form-group">';
            html += '<label class="control-label mt-0">Amount<span class="text-danger">*</span></label>';
            html += '<input type="text" class="form-control" name="amount[]" id="amount" required />';
            html += '</div>';
            html += '</div>';

            html += '<div class="col-lg-1 form-group col-lg-offset-0 text-right">';
            html += '<button type="button" id="'+count+'" class="btn btn-danger btn-xs remove_button mt-20"><i class="material-icons">highlight_off</i></button>';
            html += '</div>';
            html += '</div>';

            $('#repeater').append(html);
            $("#totalCount").val(count);
            $(this).find(".master_category"+count+"").selectpicker();
            $('.setting_type').selectpicker();
        });

        // Remove fine settings
        $(document).on('click', '.remove_button', function(event){
            event.preventDefault();

            var id = $(this).attr('id');//alert(id);
            //console.log(id);
            var totalCount = $('#repeater tr:last').attr('id');

            $(this).closest('div #section_'+id+'').remove();
            totalCount--;
        });

        $("#fineSettingForm").parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save fine settings
		$('body').delegate('#fineSettingForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');

            if ($('#fineSettingForm').parsley().isValid()){

                $.ajax({
                    url:"/fine-setting",
                    type:"POST",
                    dataType:"json",
                    data: new FormData(this),
                    contentType: false,
                    processData:false,
                    beforeSend:function(){
                        btn.html('Submitting...');
                        btn.attr('disabled',true);
                    },
                    success:function(result){
                        btn.html('Submit');
                        btn.attr('disabled',false);

                        if(result['status'] == "200"){

                            if(result.data['signal'] == "success"){
                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function() {
                                    window.location.replace('/fine-setting');
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

        // Delete fine settings
        $(document).on('click', '.delete', function (e){
            e.preventDefault();

            var label = $(this).attr('data-label');

            if(confirm("Are you sure you want to delete this?")){

                $.ajax({
                    type: "DELETE",
                    url:"/fine-setting/"+label,
                    dataType: "json",
                    data: {label:label},
                    success: function (result){

                        if(result['status'] == "200"){

                            if(result.data['signal'] == "success"){

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
            }

            return false;
        });
    });
</script>
@endsection

