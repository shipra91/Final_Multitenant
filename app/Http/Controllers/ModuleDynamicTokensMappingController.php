<?php

namespace App\Http\Controllers;

use App\Models\ModuleDynamicTokensMapping;
use Illuminate\Http\Request;
use App\Services\ModuleDynamicTokensMappingService;

class ModuleDynamicTokensMappingController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ModuleDynamicTokensMapping  $moduleDynamicTokensMapping
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $moduleDynamicTokensMappingService = new ModuleDynamicTokensMappingService();

        $module = $request->moduleId;
        $allTokens = $moduleDynamicTokensMappingService->getModuleTokens($module);

        return json_encode($allTokens);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ModuleDynamicTokensMapping  $moduleDynamicTokensMapping
     * @return \Illuminate\Http\Response
     */
    public function edit(ModuleDynamicTokensMapping $moduleDynamicTokensMapping)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ModuleDynamicTokensMapping  $moduleDynamicTokensMapping
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ModuleDynamicTokensMapping $moduleDynamicTokensMapping)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ModuleDynamicTokensMapping  $moduleDynamicTokensMapping
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModuleDynamicTokensMapping $moduleDynamicTokensMapping)
    {
        //
    }
}
