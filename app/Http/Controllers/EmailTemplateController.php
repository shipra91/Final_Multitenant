<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use App\Services\ModuleService;
use App\Services\EmailTemplateService;
use App\Http\Requests\StoreEmailRequest;
use App\Services\InstituteService;
use DataTables;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $emailTemplateService = new EmailTemplateService();

        if ($request->ajax()){
            $allTemplates = $emailTemplateService->getAll();
            return Datatables::of($allTemplates)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="/etpl/email-template/'.$row['id'].'" type="button" rel="tooltip" title="Edit" class="text-success" ><i class="material-icons">edit</i></a>
                    <a href="javascript:void(0);" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('EmailTemplateSettings/index')->with("page", "email_template");
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

        $allModules = $moduleService->getSmsModules();
        $institutionDetails = $instituteService->getAll();

        return view('EmailTemplateSettings/add_template', ['allModules' => $allModules, 'institutionDetails' => $institutionDetails])->with("page", "email_template");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(StoreEmailRequest $request)
    {
        $emailTemplateService = new EmailTemplateService();

        $result = ["status" => 200];

        try{

            $result['data'] = $emailTemplateService->add($request);

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
     * @param  \App\Models\EmailTemplate  $emailTemplate
     * @return \Illuminate\Http\Response
     */

    public function show(EmailTemplate $emailTemplate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmailTemplate  $emailTemplate
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $moduleService = new ModuleService();
        $instituteService = new InstituteService();
        $emailTemplateService = new EmailTemplateService();

        $allModules = $moduleService->getSmsModules();
        $selectedData = $emailTemplateService->find($id);
        $institutionData = $instituteService->find($selectedData->id_institute);

        return view('EmailTemplateSettings/edit_template', ['allModules' => $allModules, 'selectedData' => $selectedData, 'institutionData' => $institutionData])->with("page", "email_template");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmailTemplate  $emailTemplate
     * @return \Illuminate\Http\Response
     */

    public function update(StoreEmailRequest $request, $id)
    {
        $emailTemplateService = new EmailTemplateService();

        $result = ["status" => 200];

        try{

            $result['data'] = $emailTemplateService->update($request, $id);

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
     * @param  \App\Models\EmailTemplate  $emailTemplate
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $emailTemplateService = new EmailTemplateService();

        $result = ["status" => 200];

        try{

            $result['data'] = $emailTemplateService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    // Deleted email template records
    public function getDeletedRecords(Request $request){

        $emailTemplateService = new EmailTemplateService();

        if ($request->ajax()){
            $allEmailTemplates = $emailTemplateService->getDeletedRecords();
            return Datatables::of($allEmailTemplates)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<button type="button" data-id="'.$row['id'].'" rel="tooltip" title="Restore" class="btn btn-success btn-xs restore"><i class="material-icons">delete</i> Restore</button>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('EmailTemplateSettings/view-deleted-record')->with("page", "email_template");
    }

    /**
     * Write code on Method
     *
     * @return response()
     */

    public function restore($id)
    {
        $emailTemplateService = new EmailTemplateService();

        $result = ["status" => 200];

        try{

            $result['data'] = $emailTemplateService->restore($id);

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
        $emailTemplateService = new EmailTemplateService();

        $result = ["status" => 200];

        try{

            $result['data'] = $emailTemplateService->restoreAll();

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
