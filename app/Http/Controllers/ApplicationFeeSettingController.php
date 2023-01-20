<?php

namespace App\Http\Controllers;

use App\Models\ApplicationFeeSetting;
use App\Http\Requests\StoreFeeSettingRequest;
use App\Services\InstitutionStandardService;
use App\Services\ApplicationFeeSettingService;
use App\Services\ApplicationSettingService;
use Illuminate\Http\Request;
use DataTables;

class ApplicationFeeSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
        $applicationFeeSettingService = new ApplicationFeeSettingService();

        if ($request->ajax()) {

            $allFeeSettingData = $applicationFeeSettingService->getAll();

            return Datatables::of($allFeeSettingData)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    
                    $btn = '<a href="/preadmission-fee/'.$row['id'].'" type="button" rel="tooltip" title="Edit" class="btn btn-success btn-xs"><i class="material-icons">edit</i></a>

                    <button type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="btn btn-danger btn-xs delete"><i class="material-icons">delete</i></button>';
                                                
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Preadmission/fee_setting')->with("page", "preadmission_fee");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $institutionStandardService = new InstitutionStandardService();
        $applicationSettingService = new ApplicationSettingService();

        $allStandard = $institutionStandardService->fetchStandard();
        $allApplications = $applicationSettingService->getAll();
        
        return view('Preadmission/add_fee_setting', ['allStandard' => $allStandard, 'allApplications' => $allApplications])->with("page", "preadmission_fee");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFeeSettingRequest $request)
    {
        $applicationFeeSettingService = new ApplicationFeeSettingService();

        $result = ["status" => 200];

        try{
            
            $result['data'] = $applicationFeeSettingService->add($request);    

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
     * @param  \App\Models\ApplicationFeeSetting  $applicationFeeSetting
     * @return \Illuminate\Http\Response
     */
    public function show(ApplicationFeeSetting $applicationFeeSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ApplicationFeeSetting  $applicationFeeSetting
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $selectedFeeSetting = $applicationFeeSettingService->find($id);
        return view('Preadmission/edit_fee_setting', ['selectedFeeSetting' => $selectedFeeSetting])->with("page", "preadmission_fee");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ApplicationFeeSetting  $applicationFeeSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $applicationFeeSettingService = new ApplicationFeeSettingService();

        $result = ["status" => 200];

        try{
            
            $result['data'] = $applicationFeeSettingService->update($request, $id);  

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
     * @param  \App\Models\ApplicationFeeSetting  $applicationFeeSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $applicationFeeSettingService = new ApplicationFeeSettingService();

        $result = ["status" => 200];

        try{
            
            $result['data'] = $applicationFeeSettingService->delete($id);

        }catch(Exception $e){
            
            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        
        return response()->json($result, $result['status']);
    }

    public function getDeletedRecords(Request $request){

        $applicationFeeSettingService = new ApplicationFeeSettingService();

        if ($request->ajax()) {
            $allSettings = $applicationFeeSettingService->getDeletedRecords(); 
            
            return Datatables::of($allSettings)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        
                        $btn = '<button type="button" data-id="'.$row['id'].'" rel="tooltip" title="Restore" class="btn btn-success btn-xs restore"><i class="material-icons">delete</i> Restore</button>';
                        
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
          
        return view('Preadmission/deleted_fee_settings')->with("page", "preadmission_fee");
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function restore($id)
    {
        $result = ["status" => 200];
        try{
            
            $result['data'] = $applicationFeeSettingService->restore($id);

        }catch(Exception $e){
            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        
        return response()->json($result, $result['status']);
    }  
  
    /**
     * Write code on Method
     *
     * @return response()
    */

    public function restoreAll()
    {
        $applicationFeeSettingService = new ApplicationFeeSettingService();

        $result = ["status" => 200];
        try{
            
            $result['data'] = $applicationFeeSettingService->restoreAll();

        }catch(Exception $e){
            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        
        return response()->json($result, $result['status']);
    }
}
