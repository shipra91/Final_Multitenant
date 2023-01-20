<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\OrganizationManagement;
use Illuminate\Http\Request;
use App\Services\OrganizationService;
use App\Services\OrganizationManagementService;
use App\Http\Requests\StoreOrganizationRequest;
use DataTables;

class OrganizationController extends Controller
{
    protected $organizationService;
    protected $organizationManagementService;
    public function __construct(OrganizationService $organizationService, organizationManagementService $organizationManagementService)
    {
        $this->organizationService = $organizationService;
        $this->organizationManagementService = $organizationManagementService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $organization = $this->organizationService->all();
            return Datatables::of($organization)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        
                        $btn = '<a href="/etpl/organization/'.$row->id.'" type="button" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>
                        <a href="/etpl/organization-detail/'.$row->id.'" type="button" rel="tooltip" title="View" class="text-info"><i class="material-icons">visibility</i></a>         
                        <a href="javascript:void();" type="button" data-id="'.$row->id.'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                                                    
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('Organization/index')->with("page", "organization");
    }

    public function create()
    {
        return view('Organization/addOrganization')->with("page", "organization");
    }

    public function store(StoreOrganizationRequest $request)
    {
        $result = ["status" => 200];

        try{
            
            $result['data'] = $this->organizationService->add($request);    

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        
        return response()->json($result, $result['status']);
    }

    public function show($id)
    {
        $organization = $this->organizationService->find($id);
        // dd($organization);
        $organizationManagement = $this->organizationManagementService->getOrganizationManagements($id);
        return view('Organization/viewOrganization', ["organization" => $organization, "organizationManagement" => $organizationManagement])->with("page", "organization");
    }

    public function edit($id)
    {
        $organization = $this->organizationService->find($id);
        $organizationManagement = $this->organizationManagementService->getOrganizationManagements($id);
        return view('Organization/editOrganization', ["organization" => $organization, "organizationManagement" => $organizationManagement])->with("page", "organization");
    }

    public function update(Request $request, $id)
    {
        $result = ["status" => 200];

        try{
            
            $result['data'] = $this->organizationService->update($request, $id);  

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        
        return response()->json($result, $result['status']);
    }

    public function destroy($id)
    {
        $result = ["status" => 200];

        try{
            
            $result['data'] = $this->organizationService->delete($id);

        }catch(Exception $e){
            
            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        
        return response()->json($result, $result['status']);
    }

    public function fetchDetails($id)
    {
        return $this->organizationService->fetchDetails($id);
    }


    public function getDeletedRecords(Request $request){
        if ($request->ajax()) {
            $deletedOrganizations = $this->organizationService->getDeletedRecords(); 
            
            return Datatables::of($deletedOrganizations)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){                        
                        $btn = '<button type="button" data-id="'.$row['id'].'" rel="tooltip" title="Restore" class="btn btn-success btn-xs restore"><i class="material-icons">delete</i> Restore</button>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
          
        return view('Organization/viewDeletedOrganization')->with("page", "organization");
    }

    public function restore($id)
    {
        $result = ["status" => 200];
        try{
            
            $result['data'] = $this->organizationService->restore($id);

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
        $result = ["status" => 200];
        try{
            
            $result['data'] = $this->organizationService->restoreAll();

        }catch(Exception $e){
            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        
        return response()->json($result, $result['status']);
    }
}
