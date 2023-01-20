@php 

@endphp

@extends('layouts.master')

@section('content')
<style>
    .moving-tab {
        display:none!important;
    }
</style>
<div class="wrapper">
    @include('sliderbar')
    <div class="main-panel">
        @include('navigation')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 col-sm-offset-0">  
                        <div class="wizard-container">
                            <div class="card wizard-card" data-color="mediumaquamarine" id="wizardProfile">
                                <form method="POST" id="id_form" enctype="multipart/form-data" action="#">
                                    <div class="wizard-header"> 
                                        <h3 class="wizard-title">Academic Year Details</h3>
                                    </div>
                                    <div class="wizard-navigation">
                                        <ul>
                                            <li>
                                                <a href="#about" data-toggle="tab">Add Academic Year</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane  wizard-pane" id="about">
                                            <div class="row">
                                                <div class="col-lg-4 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                        <i class="material-icons">event_note</i>
                                                        </span>
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">Name<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="academicYearName" id="academicYearName" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                        <i class="material-icons">event</i>
                                                        </span>
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">From Date<span class="text-danger">*</span></label>
                                                            <input name="fromDate" id="fromDate" type="text" class="form-control datepicker" data-style="select-with-transition" data-size="7" value="" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                        <i class="material-icons">event</i>
                                                        </span>
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">To Date<span class="text-danger">*</span></label>
                                                            <input name="toDate" id="toDate" type="text" class="form-control datepicker" data-style="select-with-transition" data-size="7" value="" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wizard-footer" style="padding-top: 175px;">
                                            <div class="text-right">
                                                <button type="submit" class='btn btn-finish btn-fill btn-success btn-wd' name='finish'>Submit</button>
                                            </div>  
                                            <div class="clearfix"></div>
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
        demo.initMaterialWizard();
        setTimeout(function() {
            $('.card.wizard-card').addClass('active');
        }, 600);
    });
</script>
@endsection    