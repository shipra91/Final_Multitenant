<?php

namespace App\Http\Controllers;

use App\Models\DocumentHeader;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDocumentHeaderRequest;
use App\Services\DocumentHeaderService;
use DataTables;

class DocumentHeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $documentHeaderService = new DocumentHeaderService ();

        if ($request->ajax()){
            $documentHeader = $documentHeaderService->getAll();
            return Datatables::of($documentHeader)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="/etpl/document-header/'.$row->id.'" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>';
                        // <a href="javascript:void();" type="button" data-id="'.$row->id.'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Configurations/documentHeader')->with("page", "doc_heading");
    }

    // public function index(Request $request)
    // {
    //     return view('Configurations/documentHeader')->with("page", "doc_heading");
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        return view("Configurations/documentHeaderCreation");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(StoreDocumentHeaderRequest $request)
    {
        $documentHeaderService = new DocumentHeaderService ();

        $result = ["status" => 200];

        try{

            $result['data'] = $documentHeaderService->add($request);

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
     * @param  \App\Models\DocumentHeader  $documentHeader
     * @return \Illuminate\Http\Response
     */

    public function show(DocumentHeader $documentHeader)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DocumentHeader  $documentHeader
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $documentHeaderService = new DocumentHeaderService ();

        $documentHeader = $documentHeaderService->find($id);
        return view('Configurations/editDocumentHeader', ["documentHeader" => $documentHeader])->with("page", "doc_heading");;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DocumentHeader  $documentHeader
     * @return \Illuminate\Http\Response
     */

    public function update(StoreDocumentHeaderRequest $request, $id)
    {
        $documentHeaderService = new DocumentHeaderService ();

        $result = ["status" => 200];

        try{

            $result['data'] = $documentHeaderService->update($request, $id);

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
     * @param  \App\Models\DocumentHeader  $documentHeader
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $documentHeaderService = new DocumentHeaderService ();

        $result = ["status" => 200];

        try{

            $result['data'] = $documentHeaderService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function getDeletedRecords(Request $request){

        $documentHeaderService = new DocumentHeaderService ();

        if ($request->ajax()){
            $deletedData = $documentHeaderService->getDeletedRecords();
            return Datatables::of($deletedData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<button type="button" data-id="'.$row->id.'" rel="tooltip" title="Restore" class="btn btn-success btn-xs restore"><i class="material-icons" >delete</i> Restore</button>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Configurations/documentHeaderDeletedRecords');
    }

    public function restore($id)
    {
        $documentHeaderService = new DocumentHeaderService ();

        $result = ["status" => 200];

        try{

            $result['data'] = $documentHeaderService->restore($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function restoreAll()
    {
        $documentHeaderService = new DocumentHeaderService ();

        $result = ["status" => 200];

        try{

            $result['data'] = $messageSenderEntityService->restoreAll();

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

}
