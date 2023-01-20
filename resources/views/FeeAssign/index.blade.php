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
                    <div class="col-md-12 col-md-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">account_balance_wallet</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Fee Assign</h4>
                                <form method="POST" id="boardForm">
                                    <div class="row">
                                        <div class="col-lg-12 text-center col-lg-offset-0">
                                            <form role="search" id="search_form" method="POST" action="#">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-3 col-lg-offset-2">
                                                        <input type="text" class="searchinput form-control" name="search" id="search" placeholder=" Search by Name/UID/Phone Number" />
                                                        <input type="hidden" class="searchinput form-control" name="search_person" id="search_person" placeholder=" Search by Name/UID/Phone Number"  />
                                                        <span class="material-input">
                                                        </span>
                                                    </div>
                                                    <div class="col-lg-4 col-md-6 col-sm-3" id="submit_btn">
                                                        <button type="submit" class="btn btn-finish btn-fill btn-info btn-wd pull-left" id="receive" name="receive">Submit</button>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="name" id="name"/>
                                                <input type="hidden" name="uid" id="uid"/>
                                                <input type="hidden" name="standard" id="standard"/>
                                                <input type="hidden" name="division" id="division"/>
                                                <input type="hidden" name="fee_type" value="school_fee"/>
                                            </form>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-md-offset-0">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">account_balance_wallet</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Fee Assign</h4>
                                <div class="material-datatables">
                                    <table class="table table-striped table-no-bordered table-hover data-table" cellspacing="0" width="100%" style="width:100%">
                                        <thead style="font-size:12px;">
                                            <tr>
                                                <th><b>S.N.</b></th>
                                                <th><b>Fee Heading</b></th>
                                                <th><b>Fee Amount(Rs.)</b></th>
                                                <th><b>Percentage(%)</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr colspan="3">
                                                <td><b>1</b></td>
                                                <td colspan="3"><b>Tution Fee</b></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>a. Tution fee 1</td>
                                                <td>
                                                    <input type="text" class="form-control" name="" value="">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="" value="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>b. Tution fee 2</td>
                                                <td>
                                                    <input type="text" class="form-control" name="" value="">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="" value="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>c. Tution fee 3</td>
                                                <td>
                                                    <input type="text" class="form-control" name="" value="">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="" value="">
                                                </td>
                                            </tr>

                                            <tr colspan="3">
                                                <td><b>2</b></td>
                                                <td colspan="3"><b>Library Fee</b></td>
                                            </tr>

                                            <tr>
                                                <td></td>
                                                <td>a. Library fee 1</td>
                                                <td>
                                                    <input type="text" class="form-control" name="" value="">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="" value="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>b. Library fee 2</td>
                                                <td>
                                                    <input type="text" class="form-control" name="" value="">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="" value="">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                {{-- <p class="text-info"><strong>Note:</strong>The board can not be edited or deleted if the board is already mapped</p> --}}
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



        // // Save Board
        // $('body').delegate('#boardForm', 'submit', function(e){
        //     e.preventDefault();

        //     var btn=$('#submit');

        //     $.ajax({
        //         url:"/board",
        //         type:"post",
        //         dataType:"json",
        //         data: new FormData(this),
        //         contentType: false,
        //         processData:false,
        //         beforeSend:function(){
        //             btn.html('Submitting...');
        //             btn.attr('disabled',true);
        //         },
        //         success:function(result){
        //             //console.log(result);
        //             btn.html('Submit');
        //             btn.attr('disabled',false);

        //             if(result['status'] == "200"){

        //                 if(result.data['signal'] == "success"){

        //                     swal({
        //                         title: result.data['message'],
        //                         buttonsStyling: false,
        //                         confirmButtonClass: "btn btn-success"
        //                     }).then(function() {
        //                         window.location.reload();
        //                     }).catch(swal.noop)

        //                 }else if(result.data['signal'] == "exist"){

        //                     swal({
        //                         title: result.data['message'],
        //                         buttonsStyling: false,
        //                         confirmButtonClass: "btn btn-warning"
        //                     });

        //                 }else{

        //                     swal({
        //                         title: result.data['message'],
        //                         buttonsStyling: false,
        //                         confirmButtonClass: "btn btn-danger"
        //                     });
        //                 }

        //             }else{

        //                 swal({
        //                     title: 'Server error',
        //                     buttonsStyling: false,
        //                     confirmButtonClass: "btn btn-danger"
        //                 })
        //             }
        //         }
        //     });
        // });
    });
</script>
@endsection
