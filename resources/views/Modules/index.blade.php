@php 

@endphp

@extends('layouts.master')

@section('content')
<div class="wrapper">
    @if(Auth::user()->type === 'developer')
        @include('/ETPLSliderbar/sliderbar')
    @else
        @include('sliderbar')
    @endif
    <div class="main-panel">
        @if(Auth::user()->type === 'developer')
            @include('/ETPLSliderbar/navigation')
        @else
            @include('navigation')
        @endif
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 col-sm-offset-0">  
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">event</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">View Event</h4>
                                <div class="toolbar">
                                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                                </div>
                                <div class="material-datatables">
                                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                        <thead style="font-size:12px;">
                                            <tr>
                                                <th><b>S.N.</b></th>
                                                <th><b>Module Label</b></th>
                                                <th><b>Display Name</b></th>
                                                <th><b>Parent Module</b></th>
                                                <th><b>File Path</b></th>
                                                <th><b>Icon</b></th>
                                                <th><b>Type</b></th>
                                                <th><b>Action</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($modules as $index => $data)
                                            <tr>
                                                <td>{{$index + 1}}</td>
                                                <td>{{$data->module_label}}</td>
                                                <td>{{$data->display_name}}</td>
                                                <td>{{$data->id_parent}}</td>
                                                <td>{{$data->file_path}}</td>
                                                <td>{{$data->icon}}</td>
                                                <td>{{$data->type}}</td>
                                                <td>
                                                    <a href="module/{{$data->id}}" type="button" rel="tooltip" title="Edit" class="btn btn-success btn-xs"><i class="material-icons">edit</i></a>
                                                    <button type="button" data-id="{{$data->id}}" rel="tooltip" title="Delete" class="btn btn-danger btn-xs delete"><i class="material-icons">delete</i></button>
                                                </td>
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
@endsection

@section('script-content')
<script>
    $(document).ready(function() {
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $(document).on('click', '.delete', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                        type: "DELETE",
                        url:"etpl/module/"+id, 
                        dataType: "json",
                        data: {id:id},
                        success: function (result) {
                            if(result['status'] == "200"){
                                if(result.data['signal'] == "success") { 
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
            // swal({
            //         title: "Are you sure!",
            //         type: "error",
            //         confirmButtonClass: "btn-danger",
            //         confirmButtonText: "Yes!",
            //         showCancelButton: true,
            //     },
            //     function() {
            //         alert('hello');
            //         $.ajax({
            //             type: "POST",
            //             url: "delete",
            //             dataType: "json",
            //             data: {id:id},
            //             success: function (data) {
            //                 console.log(data);
            //             }         
            //         });
            // });
        });
    });
</script>
@endsection    