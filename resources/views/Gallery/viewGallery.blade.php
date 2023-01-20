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
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="mediumaquamarine">
                                <i class="material-icons">photo</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">View Gallery Details</h4>
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
                                            <label class="control-label form-group">Gallery Details</label>
                                            <textarea class="ckeditor" name="eventDetails" rows="5">{{$selectedData['galleryData']->description}}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="control-label form-group">Gallery Image</label>
                                            {{-- @foreach($selectedData['galleryAttachment'] as $attachment)
                                                @if($attachment)
                                                <div class="get_image_preview mt-10">
                                                    <li class="list-inline-item">
                                                        <a href="{{ $attachment['file_url'] }}" data-toggle="lightbox" data-gallery="example-gallery">
                                                            <img src="{{ $attachment['file_url'] }}" class="img-fluid">
                                                        </a>
                                                    </li>
                                                </div>
                                                @else
                                                    <img src="https://cdn.egenius.in/img/placeholder.jpg" class="rounded">
                                                @endif
                                            @endforeach --}}
                                            <div class="get_image_preview mt-3">
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
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="pull-right">
                                            <a href="/gallery/{{$selectedData['galleryData']->id}}" type="button" class="btn btn-success btn-wd mr-5">Edit</a>
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
                                <h4 class="card-title">Gallery Attachment</h4>
                                <div class="text-center">
                                    @if(count($selectedData['galleryAttachment']) > 0)
                                        <a href="/gallery-download/{{$selectedData['galleryData']->id}}" class="btn btn-info btn-sm"><i class="material-icons">file_download</i> Download</a>
                                    @else
                                        <span class="badge badge-warning">No attachment found</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="card card-profile" style="margin-top: 50px;">
                            <div class="card-logo">
                                @if($selectedData['galleryData']->cover_image != '')
                                    <img class="img rounded" src="{{url($selectedData['galleryData']->cover_image)}}" />
                                @else
                                   <img class="img" rounded src="//cdn.egenius.in/img/placeholder.jpg" alt="Image" />
                                @endif
                            </div>
                            <h4 style="font-weight: 400; color: #5a5a5a; text-transform: capitalize;">Cover Image</h4>
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


