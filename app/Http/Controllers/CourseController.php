<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Services\CourseService;
use App\Services\InstitutionTypeService;
use App\Http\Requests\StoreCourseRequest;
use DataTables;

class CourseController extends Controller
{
    protected $courseService;
    protected $institutionTypeService;
    public function __construct(CourseService $courseService, InstitutionTypeService $institutionTypeService)
    {
        $this->courseService = $courseService;
        $this->institutionTypeService = $institutionTypeService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $institutionType = $this->institutionTypeService->getAll();
      
        if ($request->ajax()) {
            $courses = $this->courseService->getAll();
            return Datatables::of($courses)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        
                        $btn = '<a href="/course/'.$row->id.'" type="button" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>
                                <a type="button" data-id="'.$row->id.'" rel="tooltip" title="Delete" class="text-danger btn-xs delete"><i class="material-icons">delete</i></a>';
                                                    
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('Configurations/courseCreation', ["institution_type" => $institutionType]);
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
    public function store(StoreCourseRequest $request)
    {
        $result = ["status" => 200];
        try{
            
            $result['data'] = $this->courseService->add($request);    

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
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $course = $this->courseService->find($id);
        return view('Configurations/editCourse', ["course" => $course]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

         $result = ["status" => 200];
        try{
            
            $result['data'] = $this->courseService->update($request, $id);  

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
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = ["status" => 200];
        try{
            
            $result['data'] = $this->courseService->delete($id);

        }catch(Exception $e){
            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        
        return response()->json($result, $result['status']);
    }
}
