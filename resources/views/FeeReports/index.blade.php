@extends('layouts.master')

@section('content')
<div class="wrapper">
    @include('sliderbar')
    <div class="main-panel">
        @include('navigation')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 col-sm-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">insert_chart</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Fee Report</h4>
                                <form method="POST" id="feeReportForm" action="{{ url('/fee-report-data') }}" target="print_popup" onsubmit="window.open('about:blank','print_popup','width=1000,height=800');">
                                    @csrf
                                    <input type="hidden" name="id_institute" value="{{session()->get('institutionId')}}">
                                    <input type="hidden" name="id_academic" value="{{session()->get('academicYear')}}">
                                    <input type="hidden" name="organization" value="{{session()->get('organizationId')}}">
                                        
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Report Type<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="reportType" id="reportType" data-size="4" data-style="select-with-transition" data-live-search="true" title="Select" data-parsley-errors-container=".typeError">
                                                    @foreach($reportType as $type)
                                                        <option value="{{ $type[0] }}">{{ $type[1] }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="typeError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 d-none" id="standardDiv">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Standard<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="standard[]" id="standard" data-size="4" data-style="select-with-transition" data-live-search="true" data-actions-box="true" title="Select" multiple data-parsley-errors-container=".standardError">
                                                    @foreach($standardData as $data)
                                                        <option value="{{ $data['institutionStandard_id']}}">{{ $data['class'] }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="standardError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 d-none" id="categoryDiv">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Fee Category<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="fee_category[]" id="fee_category" data-size="4" data-style="select-with-transition" data-live-search="true" data-actions-box="true" title="Select" multiple data-parsley-errors-container=".categoryError">
                                                    @foreach($feeCategory as $feeCategoryData)
                                                        <option value="{{ $feeCategoryData->id }}">{{ $feeCategoryData->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="categoryError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 d-none" id="fromDateDiv">
                                            <div class="form-group">
                                                <label class="control-label mt-0">From Date<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker startDate" name="from_date" value="{{ $_REQUEST && $_REQUEST['from_date'] ? $_REQUEST['from_date'] : date('d/m/Y')}}">
                                            </div>
                                        </div>

                                        <div class="col-lg-3 d-none" id="toDateDiv">
                                            <div class="form-group">
                                                <label class="control-label mt-0">To Date<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker endDate" name="to_date" value="{{ $_REQUEST && $_REQUEST['to_date'] ? $_REQUEST['to_date'] : date('d/m/Y')}}">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 text-right">
                                            <button type="submit" name="getAttendanceReport" id="getAttendanceReport" class="btn btn-info">Submit</button>
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

        // Hide and show fields based on attendance type
        $("#reportType").on("change", function(event){
            event.preventDefault();

            var reportType = $(this).val();

            if(reportType == 'OUTSTANDING'){

                $("#standardDiv, #categoryDiv").removeClass('d-none');
                $("#fromDateDiv, #toDateDiv").addClass('d-none');

            }else if(reportType == 'FEE_CANCELLATION'){

                $("#standardDiv, #categoryDiv").removeClass('d-none');
                $("#fromDateDiv, #toDateDiv").addClass('d-none');

            }else if(reportType == 'FEE_COLLECTION'){

                $("#standardDiv, #fromDateDiv, #toDateDiv").removeClass('d-none');
                $("#categoryDiv").addClass('d-none');

            }else if(reportType == 'FEE_CONCESSION'){

                $("#standardDiv, #fromDateDiv, #toDateDiv").removeClass('d-none');
                $("#categoryDiv").addClass('d-none');
            }
        });
    });
</script>
@endsection
