<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrganizationManagement;
use App\Services\OrganizationManagementService;

class OrganizationManagementController extends Controller
{
    
    protected $organizationManagementService;
    public function __construct(organizationManagementService $organizationManagementService)
    { 
        $this->organizationManagementService = $organizationManagementService;
    }

    public function destroy($id)
    {
        $result = ["status" => 200];

        try{
            
            $result['data'] = $this->organizationManagementService->delete($id);

        }catch(Exception $e){
            
            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        
        return response()->json($result, $result['status']);
    }

}
