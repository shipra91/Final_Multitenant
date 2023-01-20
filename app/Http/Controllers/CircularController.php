<?php

namespace App\Http\Controllers;

use App\Models\Circular;
use Illuminate\Http\Request;
use App\Services\CircularService;
use DataTables;
use ZipArchive;
use Helper;

class CircularController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $circularService = new CircularService();
        //dd($circularService->getAll());
        if ($request->ajax()){
            $circulars = $circularService->getAll();
            return Datatables::of($circulars)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        if(Helper::checkAccess('circular', 'edit')){
                            $btn = '<a href="/circular/'.$row['id'].'" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>';
                        }
                        if(Helper::checkAccess('circular', 'view')){
                            $btn .= '<a href="/circular-detail/'.$row['id'].'" rel="tooltip" title="View" class="text-info"><i class="material-icons">visibility</i></a>';

                            if($row['status'] == 'file_found'){
                                $btn .= '<a href="/circular-download/'.$row['id'].'" rel="tooltip" title="Download Files" class="text-success" target="_blank"><i class="material-icons">file_download</i></a>';
                            }
                        }
                        if(Helper::checkAccess('circular', 'delete')){
                            $btn .='<a href="javascript:void();" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Circular/index')->with("page", "circular");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $circularService = new CircularService();

        $circulardata = $circularService->getCircularData();
        return view('Circular/circular', ['circulardata' => $circulardata])->with("page", "circular");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $circularService = new CircularService();

        $result = ["status" => 200];

        try{

            $result['data'] = $circularService->add($request);

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
     * @param  \App\Models\Circular  $circular
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $circularService = new CircularService();

        $circularData = $circularService->getCircularData();
        $selectedData = $circularService->getCircularSelectedData($id);
        // dd($circularData);

        return view('Circular/view_circular_detail', ['circularData' => $circularData, 'selectedData' => $selectedData])->with("page", "circular");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Circular  $circular
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $circularService = new CircularService();

        $circulardata = $circularService->getCircularData();
        $selectedData = $circularService->getCircularSelectedData($id);
        //dd($selectedData);

        return view('Circular/editCircular', ['circulardata' => $circulardata, 'selectedData' => $selectedData])->with("page", "circular");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Circular  $circular
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $circularService = new CircularService();

        $result = ["status" => 200];

        try{

            $result['data'] = $circularService->update($request, $id);

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
     * @param  \App\Models\Circular  $circular
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $circularService = new CircularService();

        $result = ["status" => 200];

        try{

            $result['data'] = $circularService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function getDeletedRecords(Request $request){

        $circularService = new CircularService();

        if ($request->ajax()){
            $deletedData = $circularService->getDeletedRecords();
            return Datatables::of($deletedData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn ='';
                        if(Helper::checkAccess('circular', 'create')){
                            $btn .= '<button type="button" data-id="'.$row->id.'" rel="tooltip" title="Restore" class="btn btn-success btn-sm restore m0">Restore</button>';
                        }else{
                            $btn .= 'No Access';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Circular/view_deleted_record')->with("page", "circular");
    }

    public function restore($id)
    {
        $circularService = new CircularService();

        $result = ["status" => 200];

        try{

            $result['data'] = $circularService->restore($id);

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
        $circularService = new CircularService();

        $result = ["status" => 200];

        try{

            $result['data'] = $circularService->restoreAll();

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    // public function getCircularDetails($idCircular){

    //     $circularService = new CircularService();
    //     $circularData = $circularService->getCircularData();
    //     $selectedData = $circularService->getCircularSelectedData($idCircular);
    //     // dd($selectedData);

    //     return view('Circular/view_circular_detail', ['circularData' => $circularData, 'selectedData' => $selectedData]);
    // }

    public function downloadCircularFiles($id){

        $circularService = new CircularService();
        return $circularService->downloadCircularFiles($id);
    }
}
