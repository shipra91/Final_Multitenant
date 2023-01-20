<?php

namespace App\Http\Controllers;

use App\Models\InstitutionSmsTemplates;
use Illuminate\Http\Request;
use App\Services\SMSTemplateService;
use App\Services\InstitutionSMSTemplateService;
use App\Services\MessageSenderEntityService;
use App\Http\Requests\StoreInstitutionSmsTemplateRequest;
use Helper;

class InstitutionSmsTemplatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $SMSTemplateService = new SMSTemplateService(); 
        $institutionSMSTemplateService = new InstitutionSMSTemplateService();
        $allSessions = session()->all();

        $senderIdDetails = $SMSTemplateService->getInstitutionSenderId($allSessions);
        $moduleDetails = $institutionSMSTemplateService->getSmsModuleDetails($allSessions);
        return view("InstitutionSmsTemplate/institutionSmsTemplateCreation",['senderIdDetails' => $senderIdDetails, 'moduleDetails'=> $moduleDetails])->with("page", "institution_sms_template");
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
    public function store(StoreInstitutionSmsTemplateRequest $request)
    {
        $institutionSMSTemplateService = new InstitutionSMSTemplateService();
        $allSessions = session()->all();

        $result = ["status" => 200];

        try{
            
            $result['data'] = $institutionSMSTemplateService->add($request, $allSessions);    

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
     * @param  \App\Models\InstitutionSmsTemplates  $institutionSmsTemplates
     * @return \Illuminate\Http\Response
     */
    public function show(InstitutionSmsTemplates $institutionSmsTemplates)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InstitutionSmsTemplates  $institutionSmsTemplates
     * @return \Illuminate\Http\Response
     */
    public function edit(InstitutionSmsTemplates $institutionSmsTemplates)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InstitutionSmsTemplates  $institutionSmsTemplates
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $institutionSMSTemplateService = new InstitutionSMSTemplateService();
        $result = ["status" => 200];

        try{
            
            $result['data'] = $institutionSMSTemplateService->update($request, $id);  

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
     * @param  \App\Models\InstitutionSmsTemplates  $institutionSmsTemplates
     * @return \Illuminate\Http\Response
     */
    public function destroy(InstitutionSmsTemplates $institutionSmsTemplates)
    {
        //
    }

    public function getSmsTemplates(Request $request)
    {
        $SMSTemplateService = new SMSTemplateService(); 
        $allSessions = session()->all();

        return $SMSTemplateService->getSmsTemplatesUsingSenderId($request, $allSessions);
    }

    public function getTemplatesDetails(Request $request)
    {
        $SMSTemplateService = new SMSTemplateService(); 
        return $SMSTemplateService->getTemplatesDetailsUsingTemplateId($request);
    }

    public function getDetails(Request $request){

        $senderId = $request['senderId'];
        $messageSenderEntityService = new MessageSenderEntityService();

        return $messageSenderEntityService->fetchDetails($senderId);
    }
}
