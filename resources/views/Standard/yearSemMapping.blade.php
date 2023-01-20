@php
    use Carbon\Carbon;
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
                    <div class="col-md-12 col-md-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">school</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Semester/ Trimester Mapping</h4>
                                <form method="POST" class="demo-form" id="yearSemForm">
                                    
                                    <input type="hidden" name="id_institute" value="{{session()->get('institutionId')}}">
                                    <input type="hidden" name="id_academic" value="{{session()->get('academicYear')}}">
                                    <input type="hidden" name="organization" value="{{session()->get('organizationId')}}">
                                        
                                    @if(count($yearSemDetails['all_year'])>0)
                                        <input type="hidden" id="year_array" name="year_array" value="{{ implode(',', $yearSemDetails['all_year']) }}">

                                        @foreach($yearSemDetails['year_sem'] as $index=> $details)

                                            @php $yearLabel = str_replace(' ', '_', $details['year']['year_name']); @endphp

                                            <h6 class="fw-400">{{$details['year']['year_name']}}</h6>
                                            <div id="repeater_{{$yearLabel}}">
                                                <input type="hidden" name="totalCount_{{ $yearLabel }}" id="totalCount_{{ $yearLabel }}" value="{{ count($details['year']['sem'])>0?count($details['year']['sem']):1 }}">

                                                @foreach($details['year']['sem'] as $key => $yearSem)

                                                    <div class="row" id="section_{{$yearLabel}}_{{ $key + 1 }}" data-id="{{$yearLabel}}_{{ $key + 1 }}">
                                                        <input type="hidden" name="semId_{{ $yearLabel }}[]" value="{{ $yearSem['sem_id'] }}">

                                                        <div class="col-lg-4 col-lg-offset-0">
                                                            <div class="form-group">
                                                                <label class="control-label mt-0">Display Name<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" name="semester_{{$yearLabel}}[]" id="semester_{{$yearLabel}}" value="{{$yearSem['sem_name']}}" required />
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3 col-lg-offset-0">
                                                            <div class="form-group">
                                                                <label class="control-label mt-0">From Date<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control datepicker" name="from_date_{{$yearLabel}}[]" id="from_date_{{$yearLabel}}" data-style="select-with-transition" value="{{$yearSem['from_date']}}" required />
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3 col-lg-offset-0">
                                                            <div class="form-group">
                                                                <label class="control-label mt-0">To Date<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control datepicker" name="to_date_{{$yearLabel}}[]" id="to_date_{{$yearLabel}}" data-style="select-with-transition" value="{{$yearSem['to_date']}}" required />
                                                            </div>
                                                        </div>

                                                        @if($yearSem['sem_name'] == '')
                                                            <div class="col-lg-1 col-lg-offset-0 text-right">
                                                                <div class="form-group">
                                                                    <button type="button" id="{{$yearLabel}}_{{$key + 1}}" class="btn btn-danger btn-sm remove_button mt-15"><i class="material-icons">highlight_off</i></button>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12 col-lg-offset-0">
                                                    <button id="add_more_{{$yearLabel}}" type="button" class="btn btn-warning btn-sm"><i class="material-icons">add_circle_outline</i> Add</button>
                                                </div>
                                            </div>
                                        @endforeach

                                        @if(Helper::checkAccess('year-sem-mapping', 'create'))
                                            <div class="row">
                                                <div class="col-lg-12 col-lg-offset-0 text-right">
                                                    <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd" id="submit" name="submit">Submit</button>
                                                </div>
                                            </div>
                                        @endif
                                    @else
                                        <h4 class="text-center"><b>No Data Available</b></h4>
                                    @endif
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

        // Add More semester/ trimester mapping
        let year = $("#year_array").val();
        const yearArray = year.split(",");
        // console.log(yearArray);
        yearArray.forEach(function(year) {

            var year = year.replace(' ', '_');
            var count = $('#totalCount_' + year + '').val();

            $(document).on('click', '#add_more_' + year + '', function(){

                var html = '';
                count++;

                html += '<div class="row" id="section_' + year + '_' + count + '" data-id="' + year + '_' + count + '">';

                html += '<input type="hidden" name="semId_' + year + '[]">';
                html += '<div class="col-lg-4 col-lg-offset-0">';
                html += '<div class="form-group">';
                html += '<label class="control-label mt-0">Display Name<span class="text-danger">*</span></label>';
                html += '<input type="text" class="form-control" name="semester_' + year + '[]" id="semester_' + year + '" required />';
                html += '</div>';
                html += '</div>';

                html += '<div class="col-lg-3 col-lg-offset-0">';
                html += '<div class="form-group">';
                html += '<label class="control-label mt-0">From Date<span class="text-danger">*</span></label>';
                html += '<input type="text" class="form-control datepicker from_date" name="from_date_' + year + '[]" id="from_date_' + year + '" data-style="select-with-transition" required />';
                html += '</div>';
                html += '</div>';

                html += '<div class="col-lg-3 col-lg-offset-0">';
                html += '<div class="form-group">';
                html += '<label class="control-label mt-0">To Date<span class="text-danger">*</span></label>';
                html += '<input type="text" class="form-control datepicker to_date" name="to_date_' + year + '[]" id="to_date_' + year + '" data-style="select-with-transition" required />';
                html += '</div>';
                html += '</div>';

                html += '<div class="col-lg-1 col-lg-offset-0 text-right">';
                html += '<div class="form-group">';
                html += '<button type="button" id="' + year + '_' + count + '" class="btn btn-danger btn-sm remove_button mt-15"><i class="material-icons">highlight_off</i></button>';
                html += '</div>';
                html += '</div>';
                html += '</div>';

                $('#repeater_' + year + '').append(html);
                $('.from_date,.to_date').datetimepicker({
                    format: 'DD/MM/YYYY',
                });
                $("#totalCount_" + year + "").val(count);
                $(this).find(".master_category" + count + "").selectpicker();
            });
        });

        // Remove semester/trimester mapping
        $(document).on('click', '.remove_button', function(event){
            event.preventDefault();

            var id = $(this).attr('id');
            var data = id.split("_");
            var year = data[0] + '_' + data[1];
            var totalCount = $("#totalCount_" + year).val();

            $(this).closest('div #section_' + id + '').remove();
            totalCount--;
            $("#totalCount_" + year + "").val(totalCount);
        });

        $('#yearSemForm').parsley({
            triggerAfterFailure: 'input change focusout changed.bs.select'
        });

        // Save semester/ trimester mapping
        $('body').delegate('#yearSemForm', 'submit', function(e){
            e.preventDefault();

            var btn = $('#submit');

            if ($('#yearSemForm').parsley().isValid()){

                $.ajax({
                    url: "/year-sem-mapping",
                    type: "post",
                    dataType: "json",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        btn.html('Submitting...');
                        btn.attr('disabled', true);
                    },
                    success: function(result){
                        console.log(result);
                        btn.html('Submit');
                        btn.attr('disabled', false);

                        if(result['status'] == "200"){

                            if(result.data['signal'] == "success"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-success"
                                }).then(function() {
                                    window.location.reload();
                                }).catch(swal.noop)

                            }else if (result.data['signal'] == "exist"){

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-warning"
                                });

                            }else {

                                swal({
                                    title: result.data['message'],
                                    buttonsStyling: false,
                                    confirmButtonClass: "btn btn-danger"
                                });
                            }

                        }else{

                            swal({
                                title: 'Server error',
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-danger"
                            })
                        }
                    }
                });
            }
        });

        // Delete semester/trimester mapping
        $(document).on('click', '.delete', function(e){
            e.preventDefault();

            var id = $(this).data('id');

            $.ajax({
                type: "DELETE",
                url: "/course-master/" + id,
                dataType: "json",
                data: {
                    id: id
                },
                success: function(result){

                    if(result['status'] == "200"){

                        if(result.data['signal'] == "success"){

                            swal({
                                title: result.data['message'],
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-success"
                            }).then(function() {
                                window.location.reload();
                            }).catch(swal.noop)

                        }else{

                            swal({
                                title: result.data['message'],
                                buttonsStyling: false,
                                confirmButtonClass: "btn btn-danger"
                            });
                        }

                    }else{

                        swal({
                            title: 'Server error',
                            buttonsStyling: false,
                            confirmButtonClass: "btn btn-danger"
                        })
                    }
                }
            });
        });
    });
</script>
@endsection
