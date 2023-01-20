@php

@endphp

@extends('layouts.master')

@section('content')
<style>
    .table>thead>tr>th {
        font-size: 14px;
    }

    td p{
        font-size: 13px;
    }

    @media print {
        .table thead tr th,.table tbody tr td {
            border-width: 1px !important;
            border-style: solid !important;
            border: 1px solid #ddd !important;
            font-size: 10px!important;
            -webkit-print-color-adjust:exact ;
        }
    }
</style>
<div class="wrapper">
    @include('sliderbar')
    <div class="main-panel">
        @include('navigation')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 col-sm-offset-0 text-right">
                        <button class="btn btn btn-wd btn btn-success mr-5" id="printButton" onclick="window.print()"><i class="material-icons">print</i> Print</button>
                        <a href="{{url('staff-time-table')}}" class="btn btn-finish btn-fill btn-wd btn btn-info"><i class="material-icons">arrow_back</i> Back</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table class="table table-bordered table-striped" id="staffTimeTable">
                                            <thead>
                                                <tr>
                                                    <th colspan="10" style="text-align: center;"><span class="fw-600">Class Timetable - {{ ucwords($timetableData['staff_name']) }}</span></th>
                                                </tr>

                                                <tr>
                                                    <th class="text-center"><span class="fw-600">DAY / PERIOD</span></th>
                                                    @foreach($timetableData['days'] as $data)
                                                        <th class="text-center"><span class="fw-600">{{ $data }}</span></th>
                                                    @endforeach
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach($timetableData['periodData'] as $index => $periodData)
                                                    <tr>
                                                        <td class="text-center"><span class="fw-400">{{ ucwords($periodData['name']) }}</span></td>
                                                        @foreach($timetableData['classTimetable'][$index]['timetable'] as $index => $timetable)
                                                            <td>
                                                                <p class="text-center standard-color mb-5"><span class="fw-400">{{ $timetable['standard'] }}</span></p>
                                                                <p class="text-center subject-color mb-5"><span class="fw-400">{{ $timetable['subject'] }}</span></p>
                                                                <p class="text-center time-color mb-5"><span class="fw-400">{{ $timetable['start_time'] }} - {{ $timetable['end_time'] }}</span></p>
                                                                <p class="text-center room-color mb-5"><span class="fw-400">{{ ucwords($timetable['room_name']) }} </span></p>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
</script>
@endsection
