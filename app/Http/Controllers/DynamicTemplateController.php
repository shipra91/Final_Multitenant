<?php

namespace App\Http\Controllers;

use App\Models\DynamicTemplate;
use App\Repositories\TemplateCategoryRepository;
use App\Services\DynamicTemplateService;
use Illuminate\Http\Request;
use DataTables;

class DynamicTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $dynamicTemplateService = new DynamicTemplateService();
        // dd($dynamicTemplateService->getAll());

        if ($request->ajax()){
            $templates = $dynamicTemplateService->getAll();
            return Datatables::of($templates)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                            $btn = '<a href="/etpl/dynamic-template/'.$row->id.'" rel="tooltip" title="Edit" class="text-success"><i class="material-icons">edit</i></a>
                            <a href="/etpl/dynamic-template-detail/'.$row->id.'" rel="tooltip" title="View" class="text-info"><i class="material-icons">visibility</i></a>
                            <a href="javascript:void();" type="button" data-id="'.$row['id'].'" rel="tooltip" title="Delete" class="text-danger delete"><i class="material-icons">delete</i></a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('DynamicTemplate/index')->with("page", "dynamic_template");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $templateCategoryRepository = new TemplateCategoryRepository();
        $dynamicTemplateService = new DynamicTemplateService();

        $templateCategory = $templateCategoryRepository->all();
        $manualTokens = ['fromStandard', 'toStandard', 'fromAcademicYear', 'toAcademicYear', 'date', 'place', 'belongsToScheduledCaste', 'elligibleForPromotion', 'instructionMedium', 'paidFeeDueStatus', 'feeConcessionNature', 'scholarshipNature', 'medicallyExaminedStatus', 'lastAttendedMonth', 'applicationRequestDate', 'noOfWorkingDays', 'studentAttendedDays', 'characterConduct'];
        $tokens = $dynamicTemplateService->getTokens();

        return view('DynamicTemplate/create_template', ['templateCategory' => $templateCategory, 'tokens' => $tokens, 'manualTokens' => $manualTokens])->with("page", "dynamic_template");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dynamicTemplateService = new DynamicTemplateService();

        $result = ["status" => 200];
        try{

            $result['data'] = $dynamicTemplateService->add($request);

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
     * @param  \App\Models\DynamicTemplate  $dynamicTemplate
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dynamicTemplateService = new DynamicTemplateService();
        $templateData = $dynamicTemplateService->find($id);

        return view('DynamicTemplate/viewTemplate', ['templateData' => $templateData])->with("page", "dynamic_template");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DynamicTemplate  $dynamicTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $templateCategoryRepository = new TemplateCategoryRepository();
        $dynamicTemplateService = new DynamicTemplateService();

        $templateCategory = $templateCategoryRepository->all();
        $templateData = $dynamicTemplateService->find($id);
        // dd($templateData);
        $manualTokens = ['fromStandard', 'toStandard', 'fromAcademicYear', 'toAcademicYear', 'date', 'place', 'belongsToScheduledCaste', 'elligibleForPromotion', 'instructionMedium', 'paidFeeDueStatus', 'feeConcessionNature', 'scholarshipNature', 'medicallyExaminedStatus', 'lastAttendedMonth', 'applicationRequestDate', 'noOfWorkingDays', 'studentAttendedDays', 'characterConduct'];
        $tokens = $dynamicTemplateService->getTokens();

        return view('DynamicTemplate/edit_template', ['templateCategory' => $templateCategory, 'templateData' => $templateData, 'tokens' => $tokens, 'manualTokens' => $manualTokens])->with("page", "dynamic_template");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DynamicTemplate  $dynamicTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dynamicTemplateService = new DynamicTemplateService();

        $result = ["status" => 200];
        try{
            $result['data'] = $dynamicTemplateService->update($request, $id);

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
     * @param  \App\Models\DynamicTemplate  $dynamicTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(DynamicTemplate $dynamicTemplate)
    {
        //
    }
}
