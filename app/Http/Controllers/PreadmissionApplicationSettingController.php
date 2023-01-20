<?php

namespace App\Http\Controllers;

use App\Models\PreadmissionApplicationSetting;
use App\Http\Requests\StoreApplicationSettingRequest;
use App\Services\InstitutionStandardService;
use App\Services\ApplicationSettingService;
use Illuminate\Http\Request;
use DataTables;

class PreadmissionApplicationSettingController extends Controller
{
    protected $institutionStandardService;
    protected $applicationSettingService;
    public function __construct(InstitutionStandardService $institutionStandardService, ApplicationSettingService $applicationSettingService)
    {
        $this->institutionStandardService = $institutionStandardService;
        $this->applicationSettingService = $applicationSettingService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $allSettingData = $this->applicationSettingService->getAll();
            return Datatables::of($allSettingData)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="/application-setting/'.$row['id'].'" type="button" rel="tooltip" title="Edit" class="btn btn-success btn-xs"><i class="material-icons">edit</i></a>
                        <button type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="btn btn-danger btn-xs delete"><i class="material-icons">delete</i></button>';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('Preadmission/application_setting');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allStandard = $this->institutionStandardService->fetchStandard();
        return view('Preadmission/add_setting', ['allStandard' => $allStandard]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApplicationSettingRequest $request)
    {
        $result = ["status" => 200];

        try{

            $result['data'] = $this->applicationSettingService->add($request);

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
     * @param  \App\Models\PreadmissionApplicationSetting  $preadmissionApplicationSetting
     * @return \Illuminate\Http\Response
     */
    public function show(PreadmissionApplicationSetting $preadmissionApplicationSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PreadmissionApplicationSetting  $preadmissionApplicationSetting
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $allStandard = $this->institutionStandardService->fetchStandard();
        $preadmissionData = $this->applicationSettingService->find($id);

        return view('Preadmission/edit_preadmission', ['preadmissionData' => $preadmissionData, 'allStandard' => $allStandard]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PreadmissionApplicationSetting  $preadmissionApplicationSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $result = ["status" => 200];

        try{

            $result['data'] = $this->applicationSettingService->update($request, $id);

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
     * @param  \App\Models\PreadmissionApplicationSetting  $preadmissionApplicationSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = ["status" => 200];

        try{

            $result['data'] = $this->applicationSettingService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function getDeletedRecords(Request $request)
    {
        if($request->ajax()){

            $allSettings = $this->applicationSettingService->getDeletedRecords();
            // dd($allSettings);
            return Datatables::of($allSettings)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<button type="button" data-id="'.$row['id'].'" rel="tooltip" title="Restore" class="btn btn-success btn-xs restore"><i class="material-icons">delete</i> Restore</button>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Preadmission/deleted_records');
    }

    public function restore($id)
    {
        $result = ["status" => 200];
        try{

            $result['data'] = $this->applicationSettingService->restore($id);

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
        $result = ["status" => 200];

        try{

            $result['data'] = $this->menuPermissionService->restoreAll();

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
