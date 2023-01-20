<?php

namespace App\Http\Controllers;

use App\Models\Combination;
use Illuminate\Http\Request;
use App\Services\CombinationService;
use App\Services\SubjectService;
use App\Services\StreamService;
use App\Http\Requests\StoreCombinationRequest;
use DataTables;

class CombinationController extends Controller
{

    protected $combinationService;
    protected $subjectService;
    protected $streamService;
    public function __construct(CombinationService $combinationService, StreamService $streamService, SubjectService $subjectService)
    {
        $this->combinationService = $combinationService;
        $this->subjectService = $subjectService;
        $this->streamService = $streamService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $subject = $this->subjectService->getAll();
        $streams = $this->streamService->getAll();
        if ($request->ajax()) {

            $combinations = $this->combinationService->getAll(); 
          
            return Datatables::of($combinations)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        
                        $btn = '<a href="javascript:void()" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                                                    
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('Configurations/combinationCreation', ["subject" => $subject, "streams" => $streams])->with("page", "combination");  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCombinationRequest $request)
    {
        $result = ["status" => 200];
        try{
            
            $result['data'] = $this->combinationService->add($request);    

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
     * @param  \App\Models\Combination  $combination
     * @return \Illuminate\Http\Response
     */
    public function show(Combination $combination)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Combination  $combination
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Combination  $combination
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

         $result = ["status" => 200];
        try{
            
            $result['data'] = $this->combinationService->update($request, $id);  

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
     * @param  \App\Models\Combination  $combination
     * @return \Illuminate\Http\Response
     */
     
    public function destroy($id)
    {
        $result = ["status" => 200];
        try{
            
            $result['data'] = $this->combinationService->delete($id);

        }catch(Exception $e){
            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }
        
        return response()->json($result, $result['status']);
    }
}
