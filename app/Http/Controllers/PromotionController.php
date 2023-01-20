<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentMapping;
use Illuminate\Http\Request;
use App\Services\PromotionService;
use App\Services\StudentService;
use App\Http\Requests\StoreStudentPromotionRequest;
use Session;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sessionData = Session::all();
        //dd($sessionData);
        $idInstitution = $sessionData['institutionId'];
        $idAcademics = $sessionData['academicYear'];
        $idOrganization = $sessionData['organizationId'];
        // dd($idAcademics);

        $promotionService = new PromotionService;
        $studentService = new StudentService;

        $institutionAcademics = $promotionService->getAllData($idInstitution, $idAcademics);
        $allStudents = $studentService->fetchPromotionElligibleStudents($request->standard);
        $instituteBasedOnOrganization = $studentService->fetchStandardStudents($request->standard);
        $institutions = $promotionService->allInstitution($idOrganization);
        
        return view ('Promotion/index', ['institutionAcademics' => $institutionAcademics, 'allStudents' => $allStudents, 'institutions' => $institutions])->with("page", "promotion");
        //return view ('Promotion/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudentPromotionRequest $request)
    {
        $promotionService = new PromotionService;

        $result = ["status" => 200];

        try{

            $result['data'] = $promotionService->add($request);

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
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function show(Promotion $promotion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function edit(Promotion $promotion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Promotion $promotion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promotion $promotion)
    {
        //
    }
}