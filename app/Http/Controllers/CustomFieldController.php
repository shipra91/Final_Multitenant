<?php

namespace App\Http\Controllers;

use App\Models\CustomField;
use Illuminate\Http\Request;
use App\Services\ModuleService;
use App\Services\CustomFieldService;
use Helper;

class CustomFieldController extends Controller
{
    protected $yearSemService;
    protected $customFieldService;
    public function __construct(ModuleService $moduleService, CustomFieldService $customFieldService)
    {
        $this->moduleService = $moduleService; 
        $this->customFieldService = $customFieldService; 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $option ='Yes';
        $requiredModules = $this->moduleService->fetchRequiredModules($option);
        $customFieldDetails =  $this->customFieldService->getAll();
        
        return view('CustomFieldConfiguration/customFieldCreation', ["requiredModules" => $requiredModules, "customFieldDetails" => $customFieldDetails])->with("page", "custom_field");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $allSessions = session()->all();
        $institutionId = $allSessions['institutionId'];

        $result = ["status" => 200];
        try{
            
            $result['data'] = $this->customFieldService->add($request, $institutionId);    

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
     * @param  \App\Models\CustomField  $customField
     * @return \Illuminate\Http\Response
     */
    public function show(CustomField $customField)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomField  $customField
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customFieldDetails = $this->customFieldService->find($id);
        return view('CustomFieldConfiguration/editCustomField', ["customFieldDetails" => $customFieldDetails])->with("page", "custom_field");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomField  $customField
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $result = ["status" => 200];

        try{
            
            $result['data'] = $this->customFieldService->update($request, $id);  

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
     * @param  \App\Models\CustomField  $customField
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = ["status" => 200];
        
        try{
            
            $result['data'] = $this->customFieldService->delete($id);

        }catch(Exception $e){
            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        
        return response()->json($result, $result['status']);
    }
}
