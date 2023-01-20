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
                    <div class="col-sm-12 col-sm-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">query_builder</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Calender</h4>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-lg-2 col-lg-offset-10">
                                            <div class="colorBox">
                                                <div class="boxDiv" style="background-color:#ff9f89;"></div>
                                                <div class="boxDesc"> - Holidays</div>
                                            </div>
                                            <div class="colorBox">
                                                <div class="boxDiv" style="background-color:#257e4a;"></div>
                                                <div class="boxDesc"> - Events</div>
                                            </div>
                                            <!-- <div class="colorBox">
                                                <div class="boxDiv" style="background-color:#ee82ee;"></div>
                                                <div class="boxDesc"> - Birthdays</div>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-30">
                                    <div class="col-lg-12">
                                        <div id="calendar"></div>
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

        // var calendar = $('#calendar').fullCalendar({});
        var calendar = $('#calendar').fullCalendar({
            editable:false,
            header:{
                left:'prev,next today',
                center:'title',
                right:'month,agendaWeek,agendaDay'
            },
            events:'/calender',
            selectable:true,
            selectHelper: true,
            
        });
        
    });
</script>
@endsection
