<?php

namespace App\Http\Controllers;

use App\Models\CustomField;
use Illuminate\Http\Request;
use App\Services\ModuleService;
use App\Services\CustomFieldService;
use Helper;

class CustomFieldController extends Controller
{
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
        $moduleService = new ModuleService(); 
        $customFieldService = new CustomFieldService(); 

        $option ='Yes';
        $requiredModules = $moduleService->fetchRequiredModules($option);
        $customFieldDetails =  $customFieldService->getAll();
        
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
        $customFieldService = new CustomFieldService(); 

        $allSessions = session()->all();
        $institutionId = $allSessions['institutionId'];

        $result = ["status" => 200];
        try{
            
            $result['data'] = $customFieldService->add($request, $institutionId);    

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
        $customFieldService = new CustomFieldService(); 

        $customFieldDetails = $customFieldService->find($id);
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
        $customFieldService = new CustomFieldService(); 

        $result = ["status" => 200];

        try{
            
            $result['data'] = $customFieldService->update($request, $id);  

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
        $customFieldService = new CustomFieldService(); 
        $result = ["status" => 200];
        
        try{
            
            $result['data'] = $customFieldService->delete($id);

        }catch(Exception $e){
            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        
        return response()->json($result, $result['status']);
    }
}
