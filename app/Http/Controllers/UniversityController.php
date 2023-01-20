<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;
use App\Services\UniversityService;
use App\Http\Requests\StoreUniversityRequest;
use DataTables;

class UniversityController extends Controller
{

    /**
     * 
     * create Constructor to use the functions defined in the repositories
     */

    protected $universityService;
    public function __construct(UniversityService $universityService)
    {
        $this->universityService = $universityService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $university = $this->universityService->getAll();
            
            return Datatables::of($university)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        
                        $btn = '<a href="/university/'.$row->id.'" type="button" rel="tooltip" title="Edit" class="btn btn-success btn-xs"><i class="material-icons">edit</i></a>
                                <button type="button" data-id="'.$row->id.'" rel="tooltip" title="Delete" class="btn btn-danger btn-xs delete"><i class="material-icons">delete</i></button>';
                                                    
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('University/index')->with("page", "university");
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        return view('University/university');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(StoreUniversityRequest $request)
    {
        $result = ["status" => 200];

        try{
            
            $result['data'] = $this->universityService->add($request);    

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
     * @param  \App\Models\University  $university
     * @return \Illuminate\Http\Response
     */
    public function show(University $university)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\University  $university
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $selectedUniversity = $this->universityService->find($id);
        return view('University/editUniversity', ["selectedUniversity" => $selectedUniversity])->with("page", "university");
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\University  $university
     * @return \Illuminate\Http\Response
     */

    public function update(StoreUniversityRequest $request, $id)
    {
        $result = ["status" => 200];

        try{
            
            $result['data'] = $this->universityService->update($request, $id);  

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
     * @param  \App\Models\University  $university
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $result = ["status" => 200];

        try{
            
            $result['data'] = $this->universityService->delete($id);

        }catch(Exception $e){
            
            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        
        return response()->json($result, $result['status']);
    }
}
