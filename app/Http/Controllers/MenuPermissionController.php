<?php

namespace App\Http\Controllers;

use App\Models\MenuPermission;
use Illuminate\Http\Request;
use App\Services\MenuPermissionService;
use App\Repositories\RoleRepository;
use Session;
use DataTables;
use Helper;

class MenuPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $menuPermissionService = new MenuPermissionService();        
        $allSessions = session()->all();

        if ($request->ajax()){

            if($allSessions['role'] === 'developer'){
                $allPermissions = $menuPermissionService->getAllServicePermission($allSessions);
            }else{
                $allPermissions = $menuPermissionService->getAll($allSessions);
            }
            // dd($allPermissions);
            return Datatables::of($allPermissions)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        // if(Helper::checkAccess('menu-permission', 'edit')){
                            $btn .= '<a type="button" href="menu-permission/'.$row['id'].'" rel="tooltip" title="Edit" class="text-success btn-xs"><i class="material-icons">edit</i></a>';
                        // }
                        // if(Helper::checkAccess('menu-permission', 'delete')){
                            $btn .= '<a type="button" href="javascript:void();" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger btn-xs delete"><i class="material-icons">delete</i></a>';
                        // }

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('MenuPermission/index')->with("page", "menu_permission");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menuPermissionService = new MenuPermissionService();     
        $allSessions = session()->all();

        if($allSessions['role'] === 'developer'){
            $allData = $menuPermissionService->getServiceRoleModulesData($allSessions);
        }else{
            $allData = $menuPermissionService->getRolesModulesData($allSessions);
        }
        // dd($allData);
        return view('MenuPermission/addMenuPermission', ['allData' => $allData])->with("page", "menu_permission");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $menuPermissionService = new MenuPermissionService();
        $result = ["status" => 200];

        try{

            $result['data'] = $menuPermissionService->add($request);

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
     * @param  \App\Models\MenuPermission  $menuPermission
     * @return \Illuminate\Http\Response
     */
    public function show(MenuPermission $menuPermission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MenuPermission  $menuPermission
     * @return \Illuminate\Http\Response
     */
    public function edit($idRole)
    {
        $menuPermissionService = new MenuPermissionService();
        $allSessions = session()->all();

        $institutionId = $allSessions['institutionId'];
        $academicId = $allSessions['academicYear'];

        $allData = $menuPermissionService->roleMenuPermission($idRole, $institutionId, $allSessions);
        // dd($allData);
        return view('MenuPermission/edit_menupermission', ['allData' => $allData])->with("page", "menu_permission");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MenuPermission  $menuPermission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MenuPermission  $menuPermission
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menuPermissionService = new MenuPermissionService();

        $result = ["status" => 200];

        try{

            $result['data'] = $menuPermissionService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function getDeletedRecords(Request $request){

        $menuPermissionService = new MenuPermissionService();
        $allSessions = session()->all();

        if ($request->ajax()){
            $allPermissions = $menuPermissionService->getDeletedRecords($allSessions);
            // dd($allPermissions);
            return Datatables::of($allPermissions)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<button type="button" data-id="'.$row['id'].'" rel="tooltip" title="Restore" class="btn btn-success btn-sm restore m0">Restore</button>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('MenuPermission/viewDeletedRecord')->with("page", "menu_permission");
    }

    public function restore($id)
    {
        $menuPermissionService = new MenuPermissionService();

        $result = ["status" => 200];

        try{

            $result['data'] = $menuPermissionService->restore($id);

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
        $menuPermissionService = new MenuPermissionService();
        $allSessions = session()->all();

        $result = ["status" => 200];

        try{

            $result['data'] = $menuPermissionService->restoreAll($allSessions);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
