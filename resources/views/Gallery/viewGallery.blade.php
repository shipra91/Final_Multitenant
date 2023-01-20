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
                    <div class="col-lg-8 mb-20">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">photo</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Gallery Details</h4>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Gallery Name</label>
                                            <input type="text" class="form-control" value="{{$selectedData['galleryData']->title}}" disabled />
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="control-label mt-0">Date</label>
                                            <input type="text" class="form-control" value="{{$selectedData['galleryData']->date}}" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="control-label form-group mt-0">Gallery Details</label>
                                            <textarea class="ckeditor" name="eventDetails" rows="5">{{$selectedData['galleryData']->description}}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="pull-right">
                                            @if(Helper::checkAccess('gallery', 'edit'))
                                                <a href="/gallery/{{$selectedData['galleryData']->id}}" type="button" class="btn btn-success btn-wd mr-5">Edit</a>
                                            @endif
                                            <a href="{{ url('gallery') }}" class="btn btn-finish btn-fill btn-wd btn btn-danger">Close</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">attachment</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Cover Image</h4>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-logo1">
                                            @if($selectedData['galleryData']->cover_image != '')
                                                <img class="img rounded" src="{{url($selectedData['galleryData']->cover_image)}}" />
                                            @else
                                               <img class="img" rounded src="//cdn.egenius.in/img/placeholder.jpg" alt="Image" />
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">attachment</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Gallery Image</h4>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            @if(count($selectedData['galleryAttachment']) > 0)
                                            <div class="get_image_preview mt-3 text-center">
                                                @foreach($selectedData['galleryAttachment'] as $attachment)
                                                    @if($attachment)
                                                        <li>
                                                            <a href="{{ $attachment['file_url'] }}" data-toggle="lightbox" data-gallery="example-gallery">
                                                                <img src="{{ $attachment['file_url'] }}" class="rounded">
                                                            </a>
                                                        </li>
                                                        @else
                                                    <img src="https://cdn.egenius.in/img/placeholder.jpg" class="rounded">
                                                    @endif
                                                @endforeach
                                            </div>
                                            @else
                                                <div class="text-center">
                                                    <span class="badge badge-warning">No attachment found</span>
                                                </div>
                                            @endif
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
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '[data-toggle="lightbox"]', function(event){
            event.preventDefault();
            $(this).ekkoLightbox();
        });
    });
</script>
@endsection


