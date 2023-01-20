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
                        <div class="alert alert-info" role="alert">
                            <strong>Note:</strong> The Fee Heading should be comma separated without whitespace (Eg:Feeheading1,Feeheading2)</p>
                        </div>
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">account_balance_wallet</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Add Fee Heading</h4>
                                <form method="POST" id="feeHeadingForm" action="#">
                                    <div id="repeater">
                                        <input type="hidden" name="totalCount" id="totalCount" value="1">
                                        <div class="row" id="section_1" data-id="1">
                                            <div class="col-lg-4 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Fee Category</label>
                                                    <select class="selectpicker" name="fee_category" id="fee_category" data-style="select-with-transition" data-size="3" title="Select" data-live-search="true">
                                                        @foreach($fee_category as $data)
                                                            <option value="{{$data->id}}">{{$data->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-8 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Fee Heading<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="feeHeading" id="feeHeading_1" required />
                                                </div>
                                            </div>

                                            {{-- <div class="col-lg-1 col-lg-offset-0 text-right">
                                                <button type="button" id="1" class="btn btn-danger btn-sm remove_button mt-30"><i class="material-icons">highlight_off</i></button>
                                            </div> --}}
                                        </div>
                                    </div>

                                    {{--<div class="col-lg-12 col-lg-offset-0 form-group">
                                        <button id="add_more" type="button" class="btn btn-warning btn-sm"><i class="material-icons">add_circle_outline</i> Add</button>
                                    </div>--}}

                                    <div class="row pull-right">
                                        <div class="col-lg-12 col-lg-offset-0 form-group">
                                            <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Submit</button>
                                            <a href="{{url('/etpl/fee-heading')}}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
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

        // Add More Fee Heading
        var count = $('#totalCount').val();

        $(document).on('click', '#add_more', function(){

            var html = '';
            count++;

            html += '<div class="row" id="section_'+count+'" data-id="'+count+'">';
            html += '<div class="col-lg-6 form-group col-lg-offset-0">';
            html += '<div class="input-group">';
            html += '<span class="input-group-addon">';
            html += '<i class="material-icons icon-middle">view_headline</i>';
            html += '</span>';
            html += '<div class="form-group">';
            html += '<label class="control-label">Fee Heading<span class="text-danger">*</span></label>';
            html += '<input type="text" class="form-control" name="feeHeading[]" id="feeHeading_'+count+'" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" required />';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            html += ' <div class="col-lg-1 form-group col-lg-offset-0 text-right">';
            html += '<button type="button" id="'+count+'" class="btn btn-danger btn-sm remove_button mt-30"><i class="material-icons">highlight_off</i></button>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            $('#repeater').append(html);
            $("#totalCount").val(count);
        });

        // Remove Fee Heading
        $(document).on('click', '.remove_button', function(event){
            event.preventDefault();

            var id = $(this).attr('id');//alert(id);
            console.log(id);
            var totalCount = $('#repeater tr:last').attr('id');

            $(this).closest('div #section_'+id+'').remove();
            totalCount--;
        });

        $("#feeHeadingForm").parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save fee heading
        $('body').delegate('#feeHeadingForm', 'submit', function(e){
            e.preventDefault();

            var btn=$('#submit');

            if ($('#feeHeadingForm').parsley().isValid()){

                $.ajax({
                    url:"/etpl/fee-heading",
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
                        //console.log(result);
                        btn.html('Submit');
                        btn.attr('disabled',false);

                        if(result['status'] == "200"){

                            if(result.data['signal'] == "success"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function(){
                                    window.location.replace('/etpl/fee-heading');
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
