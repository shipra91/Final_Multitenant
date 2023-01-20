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
                <!-- <div class="row">    
                                                 
                    <div class="col-md-6 col-md-offset-3">
                        <div class="card">
                            <div class="col-lg-12 text-center" style="margin-top:-23px;">
                                <form class="navbar-form navbar-left col-lg-12" role="search" action="#" method="POST">
                                    <p class="form-group form-search is-empty ">
                                        <input type="text" class="form-control col-lg-8" name="search" id="search" placeholder=" Search By Name/UID/Phone Number" style="width:400px;">
                                        <span class="material-input"></span>
                                    </p>
                                    <button type="submit" class="btn btn-warning btn-round btn-just-icon">
                                        <i class="material-icons">search</i>
                                        <div class="ripple-container"></div>
                                    </button>
                                </form> 
                            </div>
                            <div class="col-lg-12 text-center" id="buttondiv" style="margin-top: -30px;">
                            </div>
                        </div>
                    </div> 
                </div>

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
                    {{Session::get('role')}}
                    {{Session::get('academicYearLabel')}}
                    {{Auth::user()}}
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
                </div> -->

                <!-- <h3>Counts</h3> -->
                <!-- {{Session::get('role')}}
                {{Session::get('roleId')}}
                {{Session::get('academicYearLabel')}} -->
                @if(Session::get('role') !== "student")
                    <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                
                                <div class="card card-stats">
                                    <div class="card-header" data-background-color="green">
                                        <i class="material-icons">face</i>
                                    </div>
                                    <div class="card-content">
                                        <p class="category">Student Count</p>
                                        <h3 class="card-title">{{ $totalStudent->studentCount }}</h3>
                                    </div>
                                    <!-- <div class="card-footer">
                                        <div class="stats">
                                            <a href="">View Student</a>
                                        </div>
                                    </div> -->
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-6">
                                
                                <div class="card card-stats">
                                    <div class="card-header" data-background-color="yellow">
                                        <i class="material-icons">domain</i>
                                    </div>
                                    <div class="card-content">
                                        <p class="category">Staff Count</p>
                                        <h3 class="card-title">{{ $totalStaff->staffCount }}</h3>
                                    </div>
                                    <!-- <div class="card-footer">
                                        <div class="stats">
                                            <a href="">View Staff</a>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                    </div>
                @endif
                <br>

                <!-- <h3>Today's Birthday</h3>
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
                </div> -->
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('script-content')
    <script>

    </script>
@endsection

