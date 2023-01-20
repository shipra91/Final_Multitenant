<?php

namespace App\Http\Controllers;

use App\Models\CustomField;
use Illuminate\Http\Request;
use App\Repositories\StudentRepository;
use App\Repositories\StaffRepository;
use App\Services\CustomFieldService;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staffRepository = new StaffRepository();
        $studentRepository = new StudentRepository();

        $totalStudent = $studentRepository->fetchStudentCount();
        $totalStaff = $staffRepository->fetchStaffCount();

        return view('dashboard', ['totalStudent' => $totalStudent, 'totalStaff' => $totalStaff]);
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
     * @param  \App\Models\DynamicTokens  $dynamicTokens
     * @return \Illuminate\Http\Response
     */
    public function show(DynamicTokens $dynamicTokens)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DynamicTokens  $dynamicTokens
     * @return \Illuminate\Http\Response
     */
    public function edit(DynamicTokens $dynamicTokens)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DynamicTokens  $dynamicTokens
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DynamicTokens $dynamicTokens)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DynamicTokens  $dynamicTokens
     * @return \Illuminate\Http\Response
     */
    public function destroy(DynamicTokens $dynamicTokens)
    {
        //
    }
}
