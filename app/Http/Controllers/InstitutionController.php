<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use Illuminate\Http\Request;
use App\Services\InstituteService;
use App\Services\InstitutionTypeService;
use App\Services\OrganizationService;
use App\Services\CourseMasterService;
use App\Services\AcademicYearService;
use App\Services\ModuleService;
use App\Services\UniversityService;
use App\Services\InstitutionModuleService;
use App\Services\InstitutionBoardService;
use App\Http\Requests\StoreInstitutionRequest;
use App\Services\InstitutionCourseMasterService;
use App\Repositories\InstitutionRepository;
use DataTables;

class InstitutionController extends Controller
{
    /**
     *
     * create Constructor to use the functions defined in the repositories
     */

    protected $instituteService;
    private $institutionTypeService;
    private $organizationService;
    private $courseMasterService;
    private $academicYearService;
    private $moduleService;
    private $universityService;
    private $institutionModuleService;
    private $institutionBoardService;
    private $institutionCourseMasterService;

    public function __construct(InstituteService $instituteService, InstitutionTypeService $institutionTypeService, OrganizationService $organizationService, CourseMasterService $courseMasterService, AcademicYearService $academicYearService, ModuleService $moduleService, UniversityService $universityService, InstitutionModuleService $institutionModuleService, InstitutionBoardService $institutionBoardService, InstitutionCourseMasterService $institutionCourseMasterService)
    {
        $this->instituteService = $instituteService;
        $this->institutionTypeService = $institutionTypeService;
        $this->organizationService = $organizationService;
        $this->courseMasterService = $courseMasterService;
        $this->academicYearService = $academicYearService;
        $this->moduleService = $moduleService;
        $this->universityService = $universityService;
        $this->institutionModuleService = $institutionModuleService;
        $this->institutionBoardService = $institutionBoardService;
        $this->institutionCourseMasterService = $institutionCourseMasterService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $institutions = $this->instituteService->getAll();

            return Datatables::of($institutions)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $btn = '<a href="/etpl/institution/'.$row['id'].'" type="button" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>
                        <a href="/etpl/institution-detail/'.$row['id'].'" type="button" rel="tooltip" title="View" class="text-info"><i class="material-icons">visibility</i></a>
                        <a href="javascript:void();" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('Institutions/index')->with("page", "institution");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $institutionTypes = $this->institutionTypeService->getAll();
        $organizations = $this->organizationService->all();
        $courseMaster = $this->courseMasterService->getAll();
        // dd($courseMaster);
        $academicYears = $this->academicYearService->getAll();
        $module = $this->moduleService->getAllParents();
        $university = $this->universityService->getAll();

        return view('Institutions/institution', ["institutionTypes" => $institutionTypes, "organizations" => $organizations, "courseMaster" => $courseMaster, "academicYears" => $academicYears, "module" => $module, "university" => $university])->with("page", "institution");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(StoreInstitutionRequest $request)
    {
        $result = ["status" => 200];

        try{

            $result['data'] = $this->instituteService->add($request);

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
     * @param  \App\Models\Institution  $institution
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $institution = $this->instituteService->find($id);
        $institutionCourseDetails = $this->institutionCourseMasterService->getInstitutionCourseData($id);
        return view('Institutions/viewInstitution', ["institution" => $institution, "institutionCourseDetails" => $institutionCourseDetails])->with("page", "institution");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Institution  $institution
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $institutionTypeDetails = array();
        $courseDetails = array();
        $streamDetails = array();
        $combinationDetails = array();

        $selectedInstitution = $this->instituteService->find($id);
        // dd($selectedInstitution['university']->id);
        $institutionTypes = $this->institutionTypeService->getAll();
        $organizations = $this->organizationService->all();
        $courseMaster = $this->courseMasterService->getAll();
        $academicYears = $this->academicYearService->getAll();
        $modules = $this->moduleService->getAllParents();
        $universities = $this->universityService->getAll();
        $institutionModule = $this->institutionModuleService->getAllIds($id);
        
        $institutionCourseDetails = $this->institutionCourseMasterService->getInstitutionCourseDetails($id);
        $institutionCourseData = $this->instituteService->getInstitutionCourseData($id);
        //   dd($institutionCourseData['combinationDetails']);
        return view('Institutions/editInstitution', ["selectedInstitution" => $selectedInstitution, "institutionTypes" => $institutionTypes, "organizations" => $organizations, "academicYears" => $academicYears, "modules" => $modules, "universities" => $universities, "institutionModule" => $institutionModule, "institutionCourseDetails" => $institutionCourseDetails, "courseMaster" => $courseMaster , "institutionCourseData" => $institutionCourseData ])->with("page", "institution");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Institution  $institution
     * @return \Illuminate\Http\Response
     */

    public function update(StoreInstitutionRequest $request, $id)
    {
        $result = ["status" => 200];

        try{

            $result['data'] = $this->instituteService->update($request, $id);

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
     * @param  \App\Models\Institution  $institution
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $result = ["status" => 200];

        try{

            $result['data'] = $this->instituteService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function getBoard(Request $request)
    {
        $institutionId = $request['id'];
        $boardDetails = $this->instituteService->getBoardDetails($institutionId);
        return $boardDetails;
    }

    // Get Designation
    public function getDesignation(Request $request)
    {
        $term = $request->term;
        $designationDetails = $this->instituteService->getDesignationdetails($term);

        return $designationDetails;
    }


    public function getDeletedRecords(Request $request){
        
        if ($request->ajax()) {
            $deletedInstitutions = $this->instituteService->getDeletedRecords(); 
            
            return Datatables::of($deletedInstitutions)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        
                        $btn = '<button type="button" data-id="'.$row['id'].'" rel="tooltip" title="Restore" class="btn btn-success btn-xs restore"><i class="material-icons">delete</i> Restore</button>';
                        
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
          
        return view('Institutions/viewDeletedInstitution')->with("page", "institution");
    }

    public function restore($id)
    {
        $result = ["status" => 200];
        try{
            
            $result['data'] = $this->instituteService->restore($id);

        }catch(Exception $e){
            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        
        return response()->json($result, $result['status']);
    }  
  
    /**
     * Write code on Method
     *
     * @return response()
    */

    public function restoreAll()
    {
        $result = ["status" => 200];
        try{
            
            $result['data'] = $this->instituteService->restoreAll();

        }catch(Exception $e){
            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        
        return response()->json($result, $result['status']);
    }

    public function getInstitutions(Request $request){

        $institutionRepository = new InstitutionRepository();

        $data = $institutionRepository->fetchInstitution($request->organizationId);
        return $data;
    }
}
