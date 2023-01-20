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
                                <i class="material-icons">face</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Visitor Report</h4>
                                <form method="POST" id="visitorReportForm" action="{{ url('/visitor-report-data') }}" target="print_popup" onsubmit="window.open('about:blank','print_popup','width=1000,height=800');">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Visitor Type <span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="visitorType" id="visitorType" data-size="4" data-style="select-with-transition" data-live-search="true" title="Select" data-parsley-errors-container=".typeError">
                                                    <option value="VISITOR">VISITOR</option>
                                                    <option value="SCHEDULED_VISITOR">SCHEDULED VISITOR</option>
                                                </select>
                                                <div class="typeError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="control-label mt-0">Status Type <span class="text-danger">*</span></label>
                                                <select class="selectpicker" name="status_type[]" id="status_type" data-size="4" data-style="select-with-transition" data-live-search="true" data-actions-box="true" title="Select" multiple data-parsley-errors-container=".statusError">
                                                    <option value="CANCELLED">CANCELLED/REJECTED</option>
                                                    <option value="SUCCESS">SUCCESS</option>
                                                </select>
                                                <div class="statusError"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="control-label mt-0">From Date <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker startDate" name="from_date" value="{{ $_REQUEST && $_REQUEST['from_date'] ? $_REQUEST['from_date'] : date('d/m/Y')}}">
                                            </div>
                                        </div>

                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="control-label mt-0">To Date <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control datepicker endDate" name="to_date" value="{{ $_REQUEST && $_REQUEST['to_date'] ? $_REQUEST['to_date'] : date('d/m/Y')}}">
                                            </div>
                                        </div>

                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <button type="submit" name="visitorReport" id="visitorReport" class="btn btn-info">Submit</button>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="row">
                                        <div class="col-lg-12 text-right">
                                            <button type="submit" name="visitorReport" id="visitorReport" class="btn btn-info">Submit</button>
                                        </div>
                                    </div> --}}
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
