<?php

namespace App\Http\Controllers;

use App\Models\FeeAssign;
use Illuminate\Http\Request;

class FeeAssignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('FeeAssign/index')->with("page", "fee_assign");
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
     * @param  \App\Models\FeeAssign  $feeAssign
     * @return \Illuminate\Http\Response
     */
    public function show(FeeAssign $feeAssign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FeeAssign  $feeAssign
     * @return \Illuminate\Http\Response
     */
    public function edit(FeeAssign $feeAssign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FeeAssign  $feeAssign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FeeAssign $feeAssign)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FeeAssign  $feeAssign
     * @return \Illuminate\Http\Response
     */
    public function destroy(FeeAssign $feeAssign)
    {
        //
    }
}
