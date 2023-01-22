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
                @if(Helper::checkAccess('batch-creation', 'view'))
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-content">
                                    <form method="GET" class="demo-form" id="getBatchForm">
                                        <input type="hidden" name="id_institute" value="{{session()->get('institutionId')}}">
                                        <input type="hidden" name="id_academic" value="{{session()->get('academicYear')}}">
                                        <input type="hidden" name="organization" value="{{session()->get('organizationId')}}">
                                        <div class="row">
                                            <div class="col-lg-4 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">Standard<span class="text-danger">*</span></label>
                                                    <select class="selectpicker" name="standard" id="standard" data-size="4" data-style="select-with-transition" data-live-search="true" title="Select" required="required" data-parsley-errors-container=".standardError">
                                                        @foreach($institutionStandards as $standard)
                                                            <option value="{{ $standard['institutionStandard_id'] }}" @if($_REQUEST && $_REQUEST['standard'] == $standard['institutionStandard_id']) {{ "selected" }} @endif>{{$standard['class']}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="standardError"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-lg-offset-0">
                                                <div class="form-group">
                                                    <label class="control-label mt-0">No Of Batches<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="batch_no" id="total_batch" value="@php if(isset($_REQUEST['batch_no'])) echo $_REQUEST['batch_no']; @endphp" required />
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-lg-offset-0">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(isset($_GET['standard']))
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">school</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Batch Creation</h4>
                                    <form method="POST" id="studentBatchForm">
                                        <input type="hidden" name="standardId" value="{{ $_REQUEST['standard'] }}"/>
                                        <input type="hidden" name="no_of_batch" value="{{ $_REQUEST['batch_no'] }}"/>
                                        <div class="material-datatables" style="margin-top: -10px;">
                                            <table class="table table-striped table-no-bordered table-hover"
                                                cellspacing="0" width="100%">
                                                <thead style="font-size:12px;">
                                                    <tr>
                                                        <th width="2%"><b>S.N.</b></th>
                                                        <th width="8%"><b>UID</b></th>
                                                        <th width="20%"><b>Student</b></th>
                                                        @for ($i=0;$i<$_REQUEST['batch_no'];$i++)
                                                            @if (array_key_exists($i, $batchDetails))
                                                                <th>
                                                                    <input type="hidden" name="batchId[]" value="{{ $batchDetails[$i]['id'] }}">
                                                                    <input type="text" class="form-control" name="batch[]" placeholder="Enter batch name" value="{{ $batchDetails[$i]['name'] }}" required />
                                                                </th>
                                                            @else
                                                                <th>
                                                                    <input type="hidden" name="batchId[]" value="">
                                                                    <input type="text" class="form-control" name="batch[]" placeholder="Enter batch name" value="" required />
                                                                </th>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($studentData as $index => $student)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $student['UID'] }}</td>
                                                            <td>{{ ucwords($student['name']) }}</td>
                                                            @for ($i=0;$i<$_REQUEST['batch_no'];$i++)
                                                                @if (array_key_exists($i, $batchDetails))
                                                                    <td>
                                                                        <div class="radio">
                                                                            <label>
                                                                                <input type="radio" <?php if($_REQUEST['batch_no'] == $i){ echo "checked";} ?> name="student[{{ $student['id_student'] }}]" value="batch_{{ $i }}" @if(in_array($student['id_student'], $batchDetails[$i]['student'])) {{ "checked" }} @endif>
                                                                            </label>
                                                                        </div>
                                                                    </td>
                                                                @else
                                                                <td>
                                                                    <div class="radio">
                                                                        <label>
                                                                            <input type="radio" <?php if($_REQUEST['batch_no'] == $i){ echo "checked";} ?> name="student[{{ $student['id_student'] }}]" value="batch_{{ $i }}">
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                @endif
                                                            @endfor
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="pull-right mt-10">
                                            @if(Helper::checkAccess('batch-creation', 'create'))
                                                <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd mr-5" id="submit" name="submit">Submit</button>
                                            @endif
                                        </div>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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

        $('#getBatchForm, #studentBatchForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Get total batch based on standard
        $("#standard").on("change", function(event){
            event.preventDefault();

            var standardId = $(this).val();

            $.ajax({
                url: "{{url('/get-batch')}}",
                type: "post",
                dataType: "json",
                data: {standardId: standardId},
                success: function(result){
                    console.log(result);
                    if(result > 0){
                        $("#total_batch").val(result);
                    }else{
                        $("#total_batch").val('');
                    }

                }
            });
        });

        // Save student batch
        $('body').delegate('#studentBatchForm', 'submit', function(e){
            e.preventDefault();

            var btn=$('#submit');

            $.ajax({
                url:"{{url('/batch')}}",
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
                    btn.html('Submit');
                    btn.attr('disabled',false);

                    if(result['status'] == "200"){

                        if(result.data['signal'] == "success"){

                            swal({
                                title: result.data['message'],
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-success"
                            }).then(function() {
                                window.location.reload();
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
        });
    });
</script>
@endsection
