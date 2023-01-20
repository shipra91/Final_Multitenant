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
                                <i class="material-icons">query_builder</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Student Leave Report</h4>
                                <form method="POST" id="leaveReportForm" action="{{ url('/student-leave-report-data') }}" target="print_popup" onsubmit="window.open('about:blank','print_popup','width=1000,height=800');">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Leave Type<span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="leaveType[]" id="leaveType" data-size="4" data-style="select-with-transition" data-live-search="true" title="Select" data-parsley-errors-container=".typeError" multiple>
                                                    <option value="PENDING">PENDING</option>
                                                    <option value="APPROVE">APPROVE</option>
                                                    <option value="REJECT">REJECT</option>
                                                </select>
                                                <div class="typeError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">From Date<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker startDate" name="from_date" value="{{ $_REQUEST && $_REQUEST['from_date'] ? $_REQUEST['from_date'] : date('d/m/Y')}}">
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">To Date<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker endDate" name="to_date" value="{{ $_REQUEST && $_REQUEST['to_date'] ? $_REQUEST['to_date'] : date('d/m/Y')}}">
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <button type="submit" name="leaveReport" id="leaveReport" class="btn btn-info">Submit</button>
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
        });
    </script>
@endsection
