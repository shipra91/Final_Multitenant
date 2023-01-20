<?php

namespace App\Http\Controllers;

use App\Models\StaffCategory;
use Illuminate\Http\Request;
use App\Services\StaffCategoryService;
use App\Http\Requests\StoreStaffCategoryRequest;
use DataTables;

class StaffCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $staffCategoryService = new StaffCategoryService();

        if ($request->ajax()){
            $staffCategory = $staffCategoryService->getAll();
            return Datatables::of($staffCategory)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = 'Default';
                        if($row->default_field == 'No'){
                            $btn = '<a href="/staff-category/'.$row->id.'" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>';
                            // <a href="javascript:void();" type="button" data-id="'.$row->id.'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Configurations/staffCategory')->with("page", "staff_category");
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

    public function store(StoreStaffCategoryRequest $request)
    {
        $staffCategoryService = new StaffCategoryService();

        $result = ["status" => 200];

        try{

            $result['data'] = $staffCategoryService->add($request);

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
     * @param  \App\Models\StaffCategory  $staffCategory
     * @return \Illuminate\Http\Response
     */

    public function show(StaffCategory $staffCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StaffCategory  $staffCategory
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $staffCategoryService = new StaffCategoryService();
        $staffCategory = $staffCategoryService->find($id);

        return view('Configurations/editStaffCategory', ["staffCategory" => $staffCategory])->with("page", "staff_category");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StaffCategory  $staffCategory
     * @return \Illuminate\Http\Response
     */

    public function update(StoreStaffCategoryRequest $request, $id)
    {
        $staffCategoryService = new StaffCategoryService();

        $result = ["status" => 200];

        try{

            $result['data'] = $staffCategoryService->update($request, $id);

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
     * @param  \App\Models\StaffCategory  $staffCategory
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $staffCategoryService = new StaffCategoryService();

        $result = ["status" => 200];

        try{

            $result['data'] = $staffCategoryService->delete($id);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
