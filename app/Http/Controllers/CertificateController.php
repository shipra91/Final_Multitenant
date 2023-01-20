<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Services\DynamicTemplateService;
use App\Services\InstitutionStandardService;
use App\Services\CertificateService;
use App\Repositories\CertificateRepository;
use Illuminate\Http\Request;
use PDF;

class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dynamicTemplateService = new DynamicTemplateService();
        $institutionStandardService = new InstitutionStandardService();
        $manualTokens = ['fromStandard','toStandard', 'fromAcademicYear', 'toAcademicYear', 'date', 'place', 'belongsToScheduledCaste', 'elligibleForPromotion', 'instructionMedium', 'paidFeeDueStatus', 'feeConcessionNature', 'scholarshipNature', 'medicallyExaminedStatus', 'lastAttendedMonth', 'applicationRequestDate', 'noOfWorkingDays', 'studentAttendedDays', 'characterConduct'];
        $standards = $institutionStandardService->fetchStandard();
        $templates = $dynamicTemplateService->getAllCertificates('CERTIFICATE');

        return view('Certificates/study_certificate', ['templates' => $templates, 'standards' => $standards, 'manualTokens' => $manualTokens])->with("page", "certificate");
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
    public function store(Request $request)
    {
        $certificateService = new CertificateService();

        $manualTokens = ['fromStandard','toStandard', 'fromAcademicYear', 'toAcademicYear', 'date', 'place', 'belongsToScheduledCaste', 'elligibleForPromotion', 'instructionMedium', 'paidFeeDueStatus', 'feeConcessionNature', 'scholarshipNature', 'medicallyExaminedStatus', 'lastAttendedMonth', 'applicationRequestDate', 'noOfWorkingDays', 'studentAttendedDays', 'characterConduct'];

        $result = ["status" => 200];

        try{

            $result['data'] = $certificateService->add($request, $manualTokens);

        }catch(Exception $e){

            $result = [
                "status" => 500,
                "error" => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function previewCertificate(Request $request){

        $dynamicTemplateService = new DynamicTemplateService();
        $manualTokens = ['fromStandard','toStandard', 'fromAcademicYear', 'toAcademicYear', 'date', 'place', 'belongsToScheduledCaste', 'elligibleForPromotion', 'instructionMedium', 'paidFeeDueStatus', 'feeConcessionNature', 'scholarshipNature', 'medicallyExaminedStatus', 'lastAttendedMonth', 'applicationRequestDate', 'noOfWorkingDays', 'studentAttendedDays', 'characterConduct'];
        $getTemplate = $dynamicTemplateService->getDynamicTemplateData($request, $manualTokens);
        return $getTemplate;

    }

    public function downloadPDF($id)
    {
        // dd($request->studentId);
        $dynamicTemplateService = new DynamicTemplateService();
        $certificateRepository = new CertificateRepository();

        $getCertificateData = $certificateRepository->fetch($id);
        $templateContent = $getCertificateData->certificate_content;

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($templateContent);
        $pdf->setPaper('A4', 'P');
        return $pdf->stream();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudyCertificate  $studyCertificate
     * @return \Illuminate\Http\Response
     */
    public function show(StudyCertificate $studyCertificate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudyCertificate  $studyCertificate
     * @return \Illuminate\Http\Response
     */
    public function edit(StudyCertificate $studyCertificate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudyCertificate  $studyCertificate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudyCertificate $studyCertificate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudyCertificate  $studyCertificate
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudyCertificate $studyCertificate)
    {
        //
    }

    public function getCertificate(Request $request){

        $dynamicTemplateService = new DynamicTemplateService();

        $getTemplate = $dynamicTemplateService->getDynamicTemplateData($request);
        return $getTemplate;
    }
}
