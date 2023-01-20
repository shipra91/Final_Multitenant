<?php

namespace App\Http\Controllers;

use App\Models\BloodGroup;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBloodGroupRequest;
use App\Services\BloodGroupService;
use DataTables;

class BloodGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $bloodGroupService = new BloodGroupService();

        if ($request->ajax()){
            $bloodGroups = $bloodGroupService->getAll();
            return Datatables::of($bloodGroups)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="/etpl/blood-group/'.$row->id.'" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>';
                        // <a href="javascript:void();" type="button" data-id="'.$row->id.'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Configurations/bloodGroupCreation')->with("page", "blood_group");
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

    public function store(StoreBloodGroupRequest $request)
    {
        $bloodGroupService = new BloodGroupService();

        $result = ["status" => 200];

        try{

            $result['data'] = $bloodGroupService->add($request);

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
     * @param  \App\Models\BloodGroup  $bloodGroup
     * @return \Illuminate\Http\Response
     */
    public function show(BloodGroup $bloodGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BloodGroup  $bloodGroup
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bloodGroupService = new BloodGroupService();

        $bloodGroup = $bloodGroupService->find($id);
        return view('Configurations/editBloodGroup', ["bloodGroup" => $bloodGroup])->with("page", "blood_group");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BloodGroup  $bloodGroup
     * @return \Illuminate\Http\Response
     */

    public function update(StoreBloodGroupRequest $request, $id)
    {
        $bloodGroupService = new BloodGroupService();

        $result = ["status" => 200];

        try{

            $result['data'] = $bloodGroupService->update($request, $id);

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
     * @param  \App\Models\BloodGroup  $bloodGroup
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $bloodGroupService = new BloodGroupService();

        $result = ["status" => 200];

        try{

            $result['data'] = $bloodGroupService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
