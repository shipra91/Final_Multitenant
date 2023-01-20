<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use App\Services\ModuleService;
use App\Http\Requests\StoreModuleRequest;
use DataTables;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $moduleService = new ModuleService();
        $modules = $moduleService->getAll();

        if ($request->ajax()) {

            $modules = $moduleService->getAll();

            return Datatables::of($modules)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $btn = '<a href="/etpl/module/'.$row->id.'" type="button" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>
                                <a href="javascript:void(0);" type="button" data-id="'.$row->id.'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Modules/index', ["modules" => $modules])->with("page", "module");
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $moduleService = new ModuleService();
        $modules = $moduleService->getAll();
        // dd($modules);
        return view('Modules/module', ["modules" => $modules])->with("page", "module");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(StoreModuleRequest $request)
    {
        $moduleService = new ModuleService();

        $result = ["status" => 200];

        try{
            
            $result['data'] = $moduleService->add($request);    

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
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */

    public function show(Module $module)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $moduleService = new ModuleService();

        $modules = $moduleService->getAll();
        $selectedModule = $moduleService->find($id);
        return view('Modules/editModule', ["selectedModule" => $selectedModule, "modules" => $modules])->with("page", "module");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */

    public function update(StoreModuleRequest $request, $id){

        $moduleService = new ModuleService();

        $result = ["status" => 200];

        try{
            
            $result['data'] = $moduleService->update($request, $id);  

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
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $moduleService = new ModuleService();

        $result = ["status" => 200];

        try{
            
            $result['data'] = $moduleService->delete($id);

        }catch(Exception $e){
            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        
        return response()->json($result, $result['status']);
    }
}
