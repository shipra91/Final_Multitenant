<?php

namespace App\Http\Controllers;

use App\Models\Workdone;
use Illuminate\Http\Request;
use App\Services\InstitutionStandardService;
use App\Services\WorkdoneService;
use App\Http\Requests\StoreWorkdoneRequest;
use DataTables;
use Helper;

class WorkdoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $workdoneService = new WorkdoneService();

        if($request->ajax()){
            $workdone = $workdoneService->getAll();
            return Datatables::of($workdone)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        if(Helper::checkAccess('assignment', 'edit')){
                            $btn .= '<a href="/workdone/'.$row['id'].'" type="button" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>';
                        }
                        if(Helper::checkAccess('assignment', 'view')){
                            // $btn .= '<a href="javascript:void();" data-id="'.$row['id'].'" rel="tooltip" title="View" class="text-info workdoneDetail"><i class="material-icons">visibility</i></a>';

                            $btn .= '<a href="/workdone-detail/'.$row['id'].'" rel="tooltip" title="View" class="text-info"><i class="material-icons">visibility</i></a>';

                            if($row['status'] == 'file_found'){
                                $btn .= '<a href="/workdone-download/'.$row['id'].'/staff_admin" rel="tooltip" title="Download Files" class="text-success" target="_blank"><i class="material-icons mr-right-8">file_download</i></a>';
                            }
                        }
                        if(Helper::checkAccess('assignment', 'delete')){
                            $btn .= '<a href="javascript:void();" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger btn-xs delete"><i class="material-icons">delete</i></a>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Workdone/index')->with("page", "workdone");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $institutionStandardService = new InstitutionStandardService();
        $standards = $institutionStandardService->fetchStaffStandard();

        return view('Workdone/addWorkdone', ['standards' => $standards])->with("page", "workdone");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWorkdoneRequest $request)
    {
        $workdoneService = new WorkdoneService();

        $result = ["status" => 200];

        try{

            $result['data'] = $workdoneService->add($request);

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
     * @param  \App\Models\Workdone  $workdone
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $workdoneService = new WorkdoneService();

        $workdone = $workdoneService->getWorkdoneSelectedData($id);
        $workdoneDetails = $workdoneService->getDetails($workdone['workdoneData']);
        //dd($workdone);
        return view('Workdone/viewWorkdoneDetail', ["workdone" => $workdone, 'workdoneDetails' => $workdoneDetails])->with("page", "workdone");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Workdone  $workdone
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $workdoneService = new WorkdoneService();

        $workdone = $workdoneService->getWorkdoneSelectedData($id);
        $workdoneDetails = $workdoneService->getDetails($workdone['workdoneData']);
        //dd($workdone);
        return view('Workdone/editWorkdone', ["workdone" => $workdone, 'workdoneDetails' => $workdoneDetails])->with("page", "workdone");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Workdone  $workdone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $workdoneService = new WorkdoneService();

        $result = ["status" => 200];

        try{

            $result['data'] = $workdoneService->update($request, $id);

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
     * @param  \App\Models\Workdone  $workdone
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $workdoneService = new WorkdoneService();

        $result = ["status" => 200];

        try{

            $result['data'] = $workdoneService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    // public function getWorkdoneDetails(Request $request){
    //     $workdoneService = new WorkdoneService();
    //     return $workdoneService->fetchDetails($request);
    // }

    // Download workdone attachment zip
    public function downloadWorkdoneFiles($id, $type){
        $workdoneService = new WorkdoneService();
        return $workdoneService->downloadWorkdoneFiles($id, $type);
    }

    // Deleted workdone records
    public function getDeletedRecords(Request $request){

        $workdoneService = new WorkdoneService();
        $deletedData = $workdoneService->getDeletedRecords();
        //dd($deletedData);

        if($request->ajax()){
            $deletedData = $workdoneService->getDeletedRecords();
            return Datatables::of($deletedData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn ='';
                        if(Helper::checkAccess('assignment', 'create')){
                            $btn .= '<button type="button" data-id="'.$row->id.'" rel="tooltip" title="Restore" class="btn btn-success btn-sm restore m0">Restore</button>';
                        }else{
                            $btn .= 'No Access';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Workdone/viewDeletedRecord')->with("page", "workdone");
    }

    // Restore workdone records
    public function restore($id){

        $workdoneService = new WorkdoneService();

        $result = ["status" => 200];

        try{

            $result['data'] = $workdoneService->restore($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    // public function restoreAll(){

    //     $workdoneService = new WorkdoneService();

    //     $result = ["status" => 200];

    //     try{

    //         $result['data'] = $workdoneService->restoreAll();

    //     }catch(Exception $e){

    //         $result = [
    //             "status" => 500,
    //             "error" => $e->getMessage()
    //         ];
    //     }

    //     return response()->json($result, $result['status']);
    // }
}
