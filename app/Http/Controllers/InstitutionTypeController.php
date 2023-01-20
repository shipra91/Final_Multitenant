<?php

namespace App\Http\Controllers;

use App\Models\InstitutionType;
use Illuminate\Http\Request;
use App\Services\InstitutionTypeService;
use App\Http\Requests\StoreInstitutionTypeRequest;
use DataTables;

class InstitutionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $institutionTypeService = new InstitutionTypeService();

        if ($request->ajax()){

            $institutionType = $institutionTypeService->getAll();

            return Datatables::of($institutionType)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $btn = '<a href="/institution-type/'.$row->id.'" type="button" rel="tooltip" title="Edit" class="btn btn-success btn-xs"><i class="material-icons">edit</i></a>
                        <button type="button" data-id="'.$row->id.'" rel="tooltip" title="Delete" class="btn btn-danger btn-xs delete"><i class="material-icons">delete</i></button>';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('Configurations/institutionType')->with("page", "institution_type");
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
    public function store(StoreInstitutionTypeRequest $request)
    {
        $institutionTypeService = new InstitutionTypeService();

        $result = ["status" => 200];

        try{

            $result['data'] = $institutionTypeService->add($request);

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
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $institutionTypeService = new InstitutionTypeService();

        $institutionType = $institutionTypeService->find($id);
        return view('Configurations/editinstitutionType', ["institutionType" => $institutionType])->with("page", "institution_type");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(StoreInstitutionTypeRequest $request, $id)
    {
        $institutionTypeService = new InstitutionTypeService();

        $result = ["status" => 200];

        try{

            $result['data'] = $institutionTypeService->update($request, $id);

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
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $institutionTypeService = new InstitutionTypeService();
        $result = ["status" => 200];

        try{

            $result['data'] = $institutionTypeService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
