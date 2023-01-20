<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use App\Services\DocumentService;
use DataTables;
use Helper;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $documentService = new DocumentService();
        //dd($documentService->getAll());
        if($request->ajax()){
            $documents = $documentService->getAll();
            return Datatables::of($documents)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        if(Helper::checkAccess('document-management', 'edit')){
                            $btn .= '<a href="/document/'.$row['id'].'" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>
                            <a href="/document-release/'.$row['id'].'" rel="tooltip" title="Release" class="text-warning"><i class="material-icons">check_circle</i></a>';
                        }
                        // <a href="javascript:void();" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('DocumentManagement/index')->with("page", "doc_management");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $documentService = new DocumentService();

        $docHeader = $documentService->allDocumentHeader();

        return view('DocumentManagement/documentManagementCreation', ["docHeader" => $docHeader])->with("page", "doc_management");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $documentService = new DocumentService();

        $result = ["status" => 200];

        try{

            $result['data'] = $documentService->add($request);

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
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $documentService = new DocumentService();
        $docHeader = $documentService->allDocumentHeader();

        if($request->ajax()){
            $documentData = $documentService->getDocumentSelectedData(request()->route()->parameters['id']);
            // dd($documentData['documentDetails']);
            return Datatables::of($documentData['documentDetails'])
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        if($row['released_date'] != ''){
                            $releaseBtn = '<button type="button" data-id="'.$row['id'].'" rel="tooltip" title="View Release Documents" class="btn btn-warning btn-xs view_release_document"><i class="material-icons">visibility</i></button>';
                        }else{
                            $releaseBtn = '<button type="button" data-id="'.$row['id'].'" rel="tooltip" title="Release Documents" class="btn btn-success btn-xs release_document"><i class="material-icons">check_circle</i></button>';
                        }

                        $btn = ''.$releaseBtn.'';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('DocumentManagement/releaseDocumentManagement', ["docHeader" => $docHeader])->with("page", "doc_management");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $documentService = new DocumentService();

        $docHeader = $documentService->allDocumentHeader();
        //$selectedData = $documentService->find($id);
        // dd($selectedData);

        $selectedData = $documentService->getDocumentSelectedData($id);
        //dd($selectedData);

        return view('DocumentManagement/editDocumentManagement', ['docHeader' => $docHeader, 'selectedData' => $selectedData])->with("page", "doc_management");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $documentService = new DocumentService();

        $result = ["status" => 200];

        try{

            $result['data'] = $documentService->update($request, $id);

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
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        //
    }

    // Update release document
    public function storeDocumentRelease(Request $request, $id){

        $documentService = new DocumentService();

        $result = ["status" => 200];

        try{

            $result['data'] = $documentService->documentRelease($request, $id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function detailDocumentRelease($id)
    {
        $documentService = new DocumentService();
        $selectedData = $documentService->getPartcularDocumentDetail($id);
        // dd($selectedData);
        return $selectedData;
    }
}
