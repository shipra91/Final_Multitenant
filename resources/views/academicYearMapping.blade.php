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
                                        <h3 class="wizard-title">Academic Year Mapping</h3>
                                    </div>
                                    <div class="wizard-navigation">
                                        <ul>
                                            <li>
                                                <a href="#about" data-toggle="tab">Add Academic Year Mapping</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane  wizard-pane" id="about">
                                            <div class="row">
                                                <div class="col-lg-4 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">school</i>
                                                        </span>
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">Select Institute</label>
                                                            <div class="form-group label-floating">
                                                                <select class="selectpicker" name="institute" id="institute" data-size="7" data-style="select-with-transition" title="-Select-">
                                                                    <option value="school">School</option>
                                                                    <option value="pu">PU</option>
                                                                    <option value="ug">UG</option>
                                                                    <option value="pg">PG</option>
                                                                </select> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">school</i>
                                                        </span>
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">Select Academic Year</label>
                                                            <div class="form-group label-floating">
                                                                <select class="selectpicker" name="academicYear" id="academicYear" data-size="7" data-style="select-with-transition" title="-Select-">
                                                                    <option value="school">School</option>
                                                                    <option value="pu">PU</option>
                                                                    <option value="ug">UG</option>
                                                                    <option value="pg">PG</option>
                                                                </select> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-lg-offset-0">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">event_note</i>
                                                        </span>
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">Default Year</label>
                                                            <div class="radio col-lg-4" style="margin-top:10px;">
                                                                <label>
                                                                    <input type="radio" name="default_year" value="No" checked="true">No
                                                                </label>
                                                            </div>
                                                            <div class="radio col-lg-4" style="margin-top:10px;">
                                                                <label>
                                                                    <input type="radio" name="default_year" value="Yes">Yes
                                                                </label>
                                                            </div>
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