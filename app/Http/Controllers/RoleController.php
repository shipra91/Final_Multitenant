<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Services\RoleService;
use App\Http\Requests\StoreRoleRequest;
use App\Repositories\RoleLabelRepository;
use DataTables;

class RoleController extends Controller
{
    
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $roles = $this->roleService->getAll();  
            return Datatables::of($roles)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        if($row->default == 'No'){

                            $btn = '<a href="/etpl/role/'.$row->id.'" type="button" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>                 
                            <a href="javascript:void(0);" type="button" data-id="'.$row->id.'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';

                        }else{
                            $btn = 'No Action';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        $roleLabelRepository = new RoleLabelRepository();
        $roleLabels = $roleLabelRepository->all();
          
        return view('Role/index', ['roleLabels' => $roleLabels])->with("page", "role");
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
    public function store(StoreRoleRequest $request)
    {        
        $result = ["status" => 200];
        try{
            $result['data'] = $this->roleService->add($request);    

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
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roleLabelRepository = new RoleLabelRepository();
        $roleLabels = $roleLabelRepository->all();
        $role = $this->roleService->find($id);  
        
        return view('Role/editRole', ['role' => $role, 'roleLabels' => $roleLabels])->with("page", "role");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $result = ["status" => 200];
        try{
            
            $result['data'] = $this->roleService->update($request, $id); 
            
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
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = ["status" => 200];
        try{
            
            $result['data'] = $this->roleService->delete($id);

        }catch(Exception $e){
            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        
        return response()->json($result, $result['status']);
    }
}
