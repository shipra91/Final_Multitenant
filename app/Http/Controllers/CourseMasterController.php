<?php

namespace App\Http\Controllers;

use App\Models\CourseMaster;
use Illuminate\Http\Request;
use App\Services\CourseMasterService;
use App\Services\InstitutionTypeService;
use App\Http\Requests\StoreCourseMasterRequest;
use DataTables;

class CourseMasterController extends Controller
{
    protected $courseMasterService;
    protected $institutionTypeService;
    public function __construct(CourseMasterService $courseMasterService)
    {
        $this->courseMasterService = $courseMasterService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $courses = $this->courseMasterService->fetchAll();
           
            return Datatables::of($courses)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        
                        $btn = '<a href="javascript:void(0);" type="button" data-id="'.$row['courseMasterdId'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                                                    
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('Configurations/courseMasterCreation')->with("page", "course_master");  
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
    public function store(StoreCourseMasterRequest $request)
    {
        $result = ["status" => 200];
        try{
            
            $result['data'] = $this->courseMasterService->add($request);    

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
     * @param  \App\Models\CourseMaster  $courseMaster
     * @return \Illuminate\Http\Response
     */
    public function show(CourseMaster $courseMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CourseMaster  $courseMaster
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseMaster $courseMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CourseMaster  $courseMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseMaster $courseMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CourseMaster  $courseMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = ["status" => 200];
        try{
            
            $result['data'] = $this->courseMasterService->delete($id);

        }catch(Exception $e){
            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        
        return response()->json($result, $result['status']);
    }
    
    public function getInstitutionType(Request $request)
    {
        $boardUniversity = $request['name'];
        $institutionTypeDetails = $this->courseMasterService->getInstitutionType($boardUniversity);
        return $institutionTypeDetails;
    }

    public function getCourse(Request $request)
    {
        $institutionType = $request['institutionType'];
        $boardUniversity = $request['boardUniversity'];
        $courseDetails = $this->courseMasterService->getCourse($institutionType, $boardUniversity);
        return $courseDetails;
    }

    public function getStream(Request $request)
    {
        $course = $request['course'];
        $boardUniversity = $request['boardUniversity'];
        $institutionType = $request['institutionType'];

        $courseDetails = $this->courseMasterService->getStream($institutionType, $boardUniversity, $course);
        return $courseDetails;
    }

     public function getCombination(Request $request)
    {
        $course = $request['course'];
        $boardUniversity = $request['boardUniversity'];
        $institutionType = $request['institutionType'];
        $stream = $request['stream'];

        $courseDetails = $this->courseMasterService->getCombination($institutionType, $boardUniversity, $course, $stream);
        return $courseDetails;
    }


    public function getCourseDetails(Request $request)
    {
       
        $boardUniversity = $request['boardUniversity'];
        $courseDetails = $this->courseMasterService->getCourseDetails($boardUniversity);
        return $courseDetails;
    }

    public function getStreamDetails(Request $request)
    {
        $course = $request['course'];
        $boardUniversity = $request['boardUniversity'];

        $courseDetails = $this->courseMasterService->getStreamDetails($boardUniversity, $course);
        return $courseDetails;
    }

     public function getCombinationDetails(Request $request)
    {
        $course = $request['course'];
        $boardUniversity = $request['boardUniversity'];
        $stream = $request['stream'];

        $courseDetails = $this->courseMasterService->getCombinationDetails($boardUniversity, $course, $stream);
        return $courseDetails;
    }
}
