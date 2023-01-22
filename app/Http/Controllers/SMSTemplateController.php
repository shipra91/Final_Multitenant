<?php

namespace App\Http\Controllers;

use App\Models\SMSTemplate;
use Illuminate\Http\Request;
use App\Services\ModuleService;
use App\Services\MessageSenderEntityService;
use App\Services\SMSTemplateService;
use App\Http\Requests\StoreSmsRequest;
use App\Services\InstituteService;
use DataTables;

class SMSTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $SMSTemplateService = new SMSTemplateService();
        $allSessions = session()->all();

        if ($request->ajax()){
            $allTemplates = $SMSTemplateService->getAll($allSessions);
            return Datatables::of($allTemplates)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="/etpl/sms-template/'.$row['id'].'" type="button" rel="tooltip" title="Edit" class="text-success btn-xs" ><i class="material-icons">edit</i></a>
                        <a href="javascript:void(0);" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('SMSTemplateSettings/index')->with("page", "sms_template");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $moduleService = new ModuleService();
        $instituteService = new InstituteService();
        $messageSenderEntityService = new MessageSenderEntityService();
        $allModules = $moduleService->getSmsModules();
        $institutionDetails = $instituteService->getAll();
        $messageSenderEntityDetails = $messageSenderEntityService->getDetails();

        return view('SMSTemplateSettings/add_template', ['allModules' => $allModules, 'messageSenderEntityDetails' => $messageSenderEntityDetails, 'institutionDetails' => $institutionDetails])->with("page", "sms_template");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(StoreSmsRequest $request)
    {
        $SMSTemplateService = new SMSTemplateService();
        $result = ["status" => 200];

        try{

            $result['data'] = $SMSTemplateService->add($request);

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
     * @param  \App\Models\SMSTemplate  $sMSTemplate
     * @return \Illuminate\Http\Response
     */

    public function show(SMSTemplate $sMSTemplate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SMSTemplate  $sMSTemplate
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $moduleService = new ModuleService();
        $SMSTemplateService = new SMSTemplateService();
        $instituteService = new InstituteService();
        $messageSenderEntityService = new MessageSenderEntityService();
        $allModules = $moduleService->getSmsModules();
        $messageSenderEntityDetails = $messageSenderEntityService->getDetails();
        $selectedData = $SMSTemplateService->find($id);
        $institutionData = $instituteService->find($selectedData->id_institute);

        return view('SMSTemplateSettings/edit_template', ['allModules' => $allModules, 'selectedData' => $selectedData, 'messageSenderEntityDetails' => $messageSenderEntityDetails, 'institutionData' => $institutionData])->with("page", "sms_template");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SMSTemplate  $sMSTemplate
     * @return \Illuminate\Http\Response
     */

    public function update(StoreSmsRequest $request, $id)
    {
        $SMSTemplateService = new SMSTemplateService();

        $result = ["status" => 200];

        try{

            $result['data'] = $SMSTemplateService->update($request, $id);

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
     * @param  \App\Models\SMSTemplate  $sMSTemplate
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $SMSTemplateService = new SMSTemplateService();

        $result = ["status" => 200];

        try{

            $result['data'] = $SMSTemplateService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    // Deleted sms template records
    public function getDeletedRecords(Request $request){

        $SMSTemplateService = new SMSTemplateService();
        $allSessions = session()->all();

        if ($request->ajax()){
            $allSmsTemplates = $SMSTemplateService->getDeletedRecords($allSessions);
            // dd($allSmsTemplates);
            return Datatables::of($allSmsTemplates)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<button type="button" data-id="'.$row['id'].'" rel="tooltip" title="Restore" class="btn btn-success btn-xs restore"><i class="material-icons">delete</i> Restore</button>';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('SMSTemplateSettings/view-deleted-record')->with("page", "sms_template");
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function restore($id)
    {
        $SMSTemplateService = new SMSTemplateService();

        $result = ["status" => 200];

        try{

            $result['data'] = $SMSTemplateService->restore($id);

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
        $SMSTemplateService = new SMSTemplateService();

        $result = ["status" => 200];

        try{

            $result['data'] = $SMSTemplateService->restoreAll();

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
