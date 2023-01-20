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
                    <div class="col-md-6">
                        <div class="card card-chart" style="padding-top:8px;">
                            <div class="card-header" data-background-color="green" data-header-animation="true">
                                <div class="ct-chart" id="multipleBarsChart"></div>
                            </div>
                            <div class="card-content">
                                <div class="card-actions">
                                    <button type="button" class="btn btn-simple fix-broken-card">
                                        <i class="material-icons">build</i> Fix Header!
                                    </button>
                                    <button type="button" class="btn  btn-simple" rel="tooltip" data-placement="bottom" title="Refresh">
                                        <i class="material-icons">refresh</i>
                                    </button>
                                </div>
                                <h4 class="card-title">Student Attendance Status</h4>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">access_time</i> updated today
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- {{Session::get('role')}}
                    {{Auth::user()}} -->
                    <div class="col-md-6">
                        <div class="card card-chart" style="padding-top:8px;">
                            <div class="card-header" data-background-color="blue" data-header-animation="true">
                                <div class="ct-chart" id="multipleBarsChart1"></div>
                            </div>
                            <div class="card-content">
                                <div class="card-actions">
                                    <button type="button" class="btn btn-simple fix-broken-card">
                                        <i class="material-icons">build</i> Fix Header!
                                    </button>
                                    <button type="button" class="btn  btn-simple" rel="tooltip" data-placement="bottom" title="Refresh">
                                        <i class="material-icons">refresh</i>
                                    </button>
                                </div>
                                <h4 class="card-title">Staff Daily Status</h4>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">access_time</i> updated today
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h3>Counts</h3>

                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        
                        <div class="card card-stats">
                            <div class="card-header" data-background-color="green">
                                <i class="material-icons">face</i>
                            </div>
                            <div class="card-content">
                                <p class="category">Student Count</p>
                                <h3 class="card-title">0</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <a href="">View Student</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6">
                        
                        <div class="card card-stats">
                            <div class="card-header" data-background-color="yellow">
                                <i class="material-icons">domain</i>
                            </div>
                            <div class="card-content">
                                <p class="category">Staff Count</p>
                                <h3 class="card-title">0</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <a href="">View Staff</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6">
                        
                        <div class="card card-stats">
                            <div class="card-header" data-background-color="mediumaquamarine">
                                <i class="material-icons">store</i>
                            </div>
                            <div class="card-content">
                                <p class="category" style="font-size:11px;">Student Absent Count </p>
                                <h3 class="card-title">0</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <a href="">View Absenties</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6">
                        
                        <div class="card card-stats">
                            <div class="card-header" data-background-color="blue">
                                <i class="material-icons">store</i>
                            </div>
                            <div class="card-content">
                                <p class="category" style="font-size:12px;">Staff Absent Count</p>
                                <h3 class="card-title">0</h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <a href="">View Absenties</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>

                <h3>Today's Birthday</h3>
                <br>

                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="card">
                            <div class="card-content" style="padding:0px 20px;">
                                <div class="alert alert-yellow alert-with-icon" data-notify="container">
                                    <i class="material-icons" data-notify="icon">cake</i>
                                    
                                    
                                    <span data-notify="message" ><br><br>
                                        Today there are -- birthdays
                                        <a href="birthday.php">
                                            <i class="material-icons" style="color:white;margin-left:8px;">visibility</i> 
                                        </a>
                                    </span>
                                    <div class="stats" style="float:right;margin-top:-7px;">
                                        <p  style="color:white;" id="date"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <br />
                        <div class="nav-center">
                            <ul class="nav nav-pills nav-pills-mediumaquamarine nav-pills-icons" role="tablist">			
                                <li class="active">
                                    <a href="#demo" role="tab" data-toggle="tab">
                                        <i class="material-icons">query_builder</i>All
                                    </a>
                                </li>
                                <li class="">
                                    <a href="#description-1" role="tab" data-toggle="tab">
                                        <i class="material-icons">query_builder</i> Circular
                                    </a>
                                </li>
                                <li class="">
                                    <a href="#schedule-1" role="tab" data-toggle="tab">
                                        <i class="material-icons">assignment</i> Assignments
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane  wizard-pane active" id="demo">
                                <div class="card" >
                                    <div class="card-header">
                                        <h4 class="card-title">All Notifications</h4>
                                    </div>
                                    <div class="card-content" >
                                        <table id="expand" class="table table-hover table-responsive">
                                            <thead></thead>
                                            <tbody>
                                                <tr class="">
                                                    <td> 
                                                        <div id="expand">
                                                            
                                                            <a href="1">
                                                                <i class="material-icons">more_horiz</i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <table id="expand1" class="table table-hover table-responsive">
                                            <thead></thead>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <a id="loadm" href="">
                                                <i class="material-icons">more_horiz</i> Load More
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane  wizard-pane" id="description-1">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Circular Notifications</h4>
                                    </div>
                                    <div class="card-content">
                                        <table class="table table-hover table-responsive">
                                            <thead></thead>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="card-footer">
                                        <div class="stats">
                                            <a href="">
                                                <i class="material-icons">more_horiz</i> Load More
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="tab-pane  wizard-pane" id="schedule-1">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Assignments Notifications</h4>
                                    </div>
                                    <div class="card-content">
                                        <table class="table table-hover table-responsive">
                                            <thead></thead>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <a href="assignment.php">
                                                <i class="material-icons">more_horiz</i> Load More
                                            </a>
                                        </div>
                                    </div>
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

    </script>
@endsection

