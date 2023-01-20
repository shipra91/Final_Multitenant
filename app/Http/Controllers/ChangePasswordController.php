<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\DynamicTemplateService;
use App\Repositories\CertificateRepository;
use Illuminate\Http\Request;
use PDF;

class ChangePasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Profile/change_password');
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
     * @param  \App\Models\CategoryFeeHeadingMaster  $categoryFeeHeadingMaster
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryFeeHeadingMaster $categoryFeeHeadingMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CategoryFeeHeadingMaster  $categoryFeeHeadingMaster
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoryFeeHeadingMaster $categoryFeeHeadingMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CategoryFeeHeadingMaster  $categoryFeeHeadingMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CategoryFeeHeadingMaster $categoryFeeHeadingMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CategoryFeeHeadingMaster  $categoryFeeHeadingMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryFeeHeadingMaster $categoryFeeHeadingMaster)
    {
        //
    }
}
