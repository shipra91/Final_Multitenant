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
                    <div class="col-md-8 col-md-offset-2">
                        <div class="card">
                        
                                    <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                        <i class="material-icons">class</i>
                                    </div>
                                    <div class="card-content">
                                        <h4 class="card-title">Add Division</h4>
                                        <form method="POST" id="form" action="#">
                                            <div class="form-group label-floating col-lg-6">
                                                <label class="control-label">Division Name</label>
                                                <input type="text" name="division" id="division" class="form-control"  style="text-transform: uppercase" required />
                                            </div> 
                                            <button type="submit" name='sub' value='sub' class="btn btn-fill btn-info" style="margin-top:3px;">Submit</button>
                                        </form>
                                    </div> 
                                   
                        </div>
                    </div>
                </div>
                   
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">class</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Division List</h4>
                                <div class="material-datatables">
                                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                        <thead style="font-size:12px;">
                                            <tr>
                                                <th class="text-center"><b>S.N.</b></th>
                                                <th class="text-center"><b>Division Name</b></th>
                                                 <th class="text-center"><b>Action</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="td-actions text-center">
                                                    <button type="button" rel="tooltip" class="btn btn-success" onclick = ""><i class="material-icons">edit</i></button>  
                                                    <button type="button" name="del" rel="tooltip" class="btn btn-danger btn-sm" onclick=""><i class="material-icons">close</i></button>
                                                </td>
                                            </tr>     
                                        </tbody>
                                    </table>
                                </div>
                                <p class="text-info"><strong>Note:</strong>The division can not be edited or deleted if the division is already mapped</p>
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