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
                <div class="row">
                    <form method="POST" class="demo-form" id="visitorForm">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                    <i class="material-icons">face</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Student Time Table</h4>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th colspan="10" style="text-align: center;"><span>Class Timetable - <b>{{ $timetableData['student_name'] }} </b></span></th>
                                                    </tr>

                                                    <tr>
                                                        <th class="text-center"><b>DAY / PERIOD</b></th>
                                                        @foreach($timetableData['days'] as $data)
                                                            <th class="text-center"><b>{{ $data }}</b></th>
                                                        @endforeach
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach($timetableData['periodData'] as $index => $periodData)
                                                        <tr>
                                                            <td class="text-center"><b>{{ $periodData['name'] }}</b></td>
                                                            @foreach($timetableData['classTimetable'][$index]['timetable'] as $index => $timetable)
                                                               
                                                            <td>
                                                                <p class="text-center standard-color mb-5"><span class="fw-400">{{ $timetable['staff_name'] }}</span></p>
                                                                <p class="text-center subject-color mb-5"><span class="fw-400">{{ $timetable['subject'] }}</span></p>
                                                                <p class="text-center time-color mb-5"><span class="fw-400">{{ $timetable['start_time'] }} - {{ $timetable['end_time'] }}</span></p>
                                                                <p class="text-center room-color mb-5"><span class="fw-400">{{ $timetable['room_name'] }} </span></p>
                                                            </td>
                                                               
                                                            @endforeach
                                                        </tr>
                                                    @endforeach

                                                  
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row mt-10">
                                        <div class="col-md-12">
                                            <div class="pull-right">
                                                <a href="" class="btn btn-finish btn-fill btn-wd btn btn-success"><i class="material-icons">print</i> Print</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
