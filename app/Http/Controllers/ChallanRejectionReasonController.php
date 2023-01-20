<?php

namespace App\Http\Controllers;

use App\Models\ChallanRejectionReason;
use Illuminate\Http\Request;
use App\Services\ChallanRejectionReasonService;

class ChallanRejectionReasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {       
        $challanRejectionReasonService = new ChallanRejectionReasonService();
        return $challanRejectionReasonService->getAll();
        
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
     * @param  \App\Models\ChallanRejectionReason  $rejectionReason
     * @return \Illuminate\Http\Response
     */
    public function show(ChallanRejectionReason $rejectionReason)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChallanRejectionReason  $rejectionReason
     * @return \Illuminate\Http\Response
     */
    public function edit(ChallanRejectionReason $rejectionReason)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChallanRejectionReason  $rejectionReason
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChallanRejectionReason $rejectionReason)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChallanRejectionReason  $rejectionReason
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChallanRejectionReason $rejectionReason)
    {
        //
    }
}
