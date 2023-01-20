<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreModuleRequest;
use App\Repositories\ModuleRepository;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $moduleRepository = new ModuleRepository();
        $modules = $moduleRepository->allModules();
        return response()->json([
            "status"=> true,
            "modules"=> $modules
        ]);
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

    public function store(StoreModuleRequest $request)
    {
        $data = array(
            'module_label' => $request->module_label, 
            'display_name' => $request->display_name, 
            'id_parent' => $request->id_parent, 
            'file_path' => $request->file_path, 
            'icon' => $request->icon, 
            'type' => $request->type
        );

        $module = $this->moduleRepository->store($request);
        return response()->json([
            "status" => true,
            "message" => 'Modules inserted successfully!',
            "modules"=>$data
        ], 200);
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
        return $modules = $this->moduleRepository->fetch($id);
        return response()->json([
            "status" => true,
            "modules"=>$modules
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function update(StoreModuleRequest $request, $id)
    {
        $data = array(
            'module_label' => $request->module_label, 
            'display_name' => $request->display_name, 
            'id_parent' => $request->id_parent, 
            'file_path' => $request->file_path, 
            'icon' => $request->icon, 
            'type' => $request->type
        );

        $module = $this->moduleRepository->update($data, $id);
        return response()->json([
            "status" => true,
            "message" => 'Modules updated successfully!',
            "modules"=>$module
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->moduleRepository->delete($id);
        return response()->json([
            "status" => true,
            "message" => 'Modules deleted successfully!'
        ], 200);
    }
}
