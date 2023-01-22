<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Services\GalleryService;
//use App\Http\Requests\StoreGalleryRequest;
use DataTables;
use ZipArchive;
use Helper;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $galleryService = new GalleryService();
        $allSessions = session()->all();
        
        //dd($galleryService->getAll());
        if ($request->ajax()) {
            $galleryData = $galleryService->getAll($allSessions);
            return Datatables::of($galleryData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        if(Helper::checkAccess('gallery', 'edit')){
                            $btn .= '<a href="/gallery/'.$row['id'].'" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>';
                        }
                        if(Helper::checkAccess('gallery', 'view')){
                            $btn .= '<a href="/gallery-details/'.$row['id'].'" rel="tooltip" title="View" class="text-info"><i class="material-icons">visibility</i></a>';

                            if($row['status'] == 'file_found'){
                                $btn .= '<a href="/gallery-download/'.$row['id'].'" rel="tooltip" title="Download Files" class="text-success" target="_blank"><i class="material-icons">file_download</i></a>';
                            }
                        }
                        if(Helper::checkAccess('gallery', 'delete')){
                            $btn .= '<a href="javascript:void();" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Gallery/index')->with("page", "gallery");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $galleryService = new GalleryService();
        $allSessions = session()->all();

        $gallerydata = $galleryService->getGalleryData($allSessions);
        //dd($gallerydata);
        return view('Gallery/addGallery', ['gallerydata' => $gallerydata])->with("page", "gallery");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $galleryService = new GalleryService();

        $result = ["status" => 200];

        try{

            $result['data'] = $galleryService->add($request);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $galleryService = new GalleryService();
        $allSessions = session()->all();

        $gallerydata = $galleryService->getGalleryData($allSessions);
        $selectedData = $galleryService->getGallerySelectedData($id);
        //dd($selectedData);

        return view('Gallery/viewGallery', ['gallerydata' => $gallerydata, 'selectedData' => $selectedData])->with("page", "gallery");
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $galleryService = new GalleryService();
        $allSessions = session()->all();

        $gallerydata = $galleryService->getGalleryData($allSessions);
        $selectedData = $galleryService->getGallerySelectedData($id);
        //dd($selectedData);

        return view('Gallery/editGallery', ['gallerydata' => $gallerydata, 'selectedData' => $selectedData])->with("page", "gallery");
        //return view('Gallery/editGallery');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $galleryService = new GalleryService();

        $result = ["status" => 200];

        try{

            $result['data'] = $galleryService->update($request, $id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $galleryService = new GalleryService();

        $result = ["status" => 200];

        try{

            $result['data'] = $galleryService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    // Download gallery attachment zip
    public function downloadGalleryFiles($id)
    {
        $galleryService = new GalleryService();

        $galleryAttachment = $galleryService->downloadGalleryFiles($id);
        // dd($galleryAttachment);
        return $galleryAttachment;
    }

    // Deleted gallery records
    public function getDeletedRecords(Request $request){

        $galleryService = new GalleryService();
        $allSessions = session()->all();
        //dd($galleryService->getDeletedRecords());

        if ($request->ajax()){
            $deletedData = $galleryService->getDeletedRecords($allSessions);
            return Datatables::of($deletedData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn ='';
                        if(Helper::checkAccess('gallery', 'create')){
                            $btn .= '<button type="button" data-id="'.$row['id'].'" rel="tooltip" title="Restore" class="btn btn-success btn-sm restore m0">Restore</button>';
                        }else{
                            $btn .= 'No Access';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Gallery/view_deleted_record')->with("page", "gallery");
    }

    // Restore gallery records
    public function restore($id)
    {
        $galleryService = new GalleryService();

        $result = ["status" => 200];

        try{

            $result['data'] = $galleryService->restore($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
