<?php

namespace App\Http\Controllers;

use App\Models\GalleryAttachment;
use Illuminate\Http\Request;
use App\Services\GalleryAttachmentService;

class GalleryAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GalleryAttachment  $galleryAttachment
     * @return \Illuminate\Http\Response
     */
    public function show(GalleryAttachment $galleryAttachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GalleryAttachment  $galleryAttachment
     * @return \Illuminate\Http\Response
     */
    public function edit(GalleryAttachment $galleryAttachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GalleryAttachment  $galleryAttachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GalleryAttachment $galleryAttachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GalleryAttachment  $galleryAttachment
     * @return \Illuminate\Http\Response
     */
    public function removeGalleryImage(Request $request)
    {
        $galleryAttachmentService = new GalleryAttachmentService();

        $idGalleryImage = $request->galleryImageId;

        $result = ["status" => 200];

        try{

            $result['data'] = $galleryAttachmentService->delete($idGalleryImage);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
