<?php

namespace App\Http\Controllers;

use App\Models\StandardSubjectStaffMapping;
use Illuminate\Http\Request;
use App\Services\InstitutionStandardService;
use App\Services\StandardSubjectStaffMappingService;
use App\Repositories\StaffRepository;
use Helper;

class StandardSubjectStaffMappingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $standardSubjectDetails['subject'] =  array();
        $institutionStandardService = new InstitutionStandardService();
        $allSessions = session()->all();

        $standard = $institutionStandardService->fetchStandardName($allSessions);
        
        return view('StandardSubjectStaffMapping/standardSubjectStaffMapping',['standard'=> $standard, 'standardSubjectDetails'=>$standardSubjectDetails])->with("page", "standard_subject_staff");
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
        $standardSubjectStaffMappingService =  new StandardSubjectStaffMappingService();
        $allSessions = session()->all();

        $result = ["status" => 200];
        try{
            
            $result['data'] = $standardSubjectStaffMappingService->add($request, $allSessions);

        } catch(Exception $e){
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
     * @param  \App\Models\StandardSubjectStaffMapping  $standardSubjectStaffMapping
     * @return \Illuminate\Http\Response
     */
    public function show(StandardSubjectStaffMapping $standardSubjectStaffMapping)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StandardSubjectStaffMapping  $standardSubjectStaffMapping
     * @return \Illuminate\Http\Response
     */
    public function edit(StandardSubjectStaffMapping $standardSubjectStaffMapping)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StandardSubjectStaffMapping  $standardSubjectStaffMapping
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StandardSubjectStaffMapping $standardSubjectStaffMapping)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StandardSubjectStaffMapping  $standardSubjectStaffMapping
     * @return \Illuminate\Http\Response
     */
    public function destroy(StandardSubjectStaffMapping $standardSubjectStaffMapping)
    {
        //
    }

    public function getDetails(Request $request)
    { 
        $institutionStandardService = new InstitutionStandardService();
        $standardSubjectStaffMappingService = new StandardSubjectStaffMappingService();
        $allSessions = session()->all();

        $standard = $institutionStandardService->fetchStandardName($allSessions);
        
        $request = $request->get('standard_stream');
        $standardSubjectDetails = $standardSubjectStaffMappingService->fetchDetails($request, $allSessions);
        // dd($standardSubjectDetails);
        return view('StandardSubjectStaffMapping/standardSubjectStaffMapping',['standard'=> $standard, 'standardSubjectDetails'=>$standardSubjectDetails])->with("page", "standard_subject_staff");
    }

    public function getStaffs(Request $request)
    { 
        $standardSubjectStaffMappingService = new StandardSubjectStaffMappingService();
        $allSessions = session()->all();

        $staffSubjectDetails = $standardSubjectStaffMappingService->fetchSubjectStaffs($request, $allSessions);
        return $staffSubjectDetails;
    }

    public function getStaffStudent(Request $request)
    { 
        $standardSubjectStaffMappingService = new StandardSubjectStaffMappingService();
        $allSessions = session()->all();

        $staffSubjectDetails = $standardSubjectStaffMappingService->fetchSubjectStaffStudents($request, $allSessions);
        return $staffSubjectDetails;
    }

    public function getStaffsStudents(Request $request)
    { 
        $standardSubjectStaffMappingService = new StandardSubjectStaffMappingService();
        $allSessions = session()->all();

        $staffSubjectDetails = $standardSubjectStaffMappingService->fetchSubjectsStaffsStudents($request, $allSessions);
        return $staffSubjectDetails;
    }
}  
