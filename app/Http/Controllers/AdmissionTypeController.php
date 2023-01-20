<?php

namespace App\Http\Controllers;

use App\Models\AdmissionType;
use Illuminate\Http\Request;
use App\Services\AdmissionTypeService;
use App\Http\Requests\StoreAdmissionTypeRequest;
use DataTables;

class AdmissionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $admissionTypeService = new AdmissionTypeService();

        if ($request->ajax()){
            $types = $admissionTypeService->getAll();
            return Datatables::of($types)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="/etpl/admission-type/'.$row->id.'" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>';
                        // <a href="javascript:void(0);" data-id="'.$row->id.'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Configurations/admissionType')->with("page", "admission_type");
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

    public function store(StoreAdmissionTypeRequest $request)
    {
        $admissionTypeService = new AdmissionTypeService();

        $result = ["status" => 200];

        try{

            $result['data'] = $admissionTypeService->add($request);

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
     * @param  \App\Models\AdmissionType  $admissionType
     * @return \Illuminate\Http\Response
     */
    public function show(AdmissionType $admissionType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AdmissionType  $admissionType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admissionTypeService = new AdmissionTypeService();

        $admissionType = $admissionTypeService->find($id);
        return view('Configurations/editAdmissionType', ['admissionType' => $admissionType])->with("page", "admission_type");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AdmissionType  $admissionType
     * @return \Illuminate\Http\Response
     */

    public function update(StoreAdmissionTypeRequest $request, $id)
    {
        $admissionTypeService = new AdmissionTypeService();

        $result = ["status" => 200];

        try{

            $result['data'] = $admissionTypeService->update($request, $id);

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
     * @param  \App\Models\AdmissionType  $admissionType
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $admissionTypeService = new AdmissionTypeService();

        $result = ["status" => 200];

        try{

            $result['data'] = $admissionTypeService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
