<?php
    $pdf = \App::make('dompdf.wrapper');
    // dd($hallTicketDetails);
    $html = '';
    foreach($hallTicketDetails['student_subject'] as $data){

        $html.= '<table border ="1" width="100%" style="margin-bottom:13px;">
                    <tr>
                        <td>
                            <table class="main" width="100%" style="border-collapse: collapse;">
                                <tbody>
                                    <tr>
                                        <td width="10%" class="f" align="center"><img id="im" src="'.$hallTicketDetails['institute']->institution_logo.'" alt="N/A" width="80"></td>
                                        <td width="80%" class="f" style ="font-family:Calibri;padding-top:-40px;" align="center">
                                            <p style="font-family:Calibre;font-size:18px;font-weight:normal;" align="center"><b>'.$hallTicketDetails['institute']->name.'</b></p><p style="font-size:14px;"><b>'.$hallTicketDetails['institute']->address.'</b></p>
                                        </td>
                                        <td width="10%" class="f" align="center"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="main" width="100%">
                                <tbody>
                                    <tr>
                                        <td class="f" colspan="4" style="font-family:Calibri;font-size:15px;text-decoration:underline;padding-top:-40px;" align="center"><p>HALL TICKET</p></td>
                                    </tr>
                                    <tr>
                                        <td class="f" colspan="4" style="font-family:Calibri;font-size:15px;padding-top:-10px;padding-bottom:10px;" align="center"><p >'.$hallTicketDetails['exam']->name.'</p></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="main" width="100%">
                                <tbody>
                                    <tr>
                                        <td class="ff" width=50%" >Student Name : '.ucwords($data['studentName']).'</</td>
                                        <td class="ff" align="right" width="50%">Standard : '.$data['student']->standard.'</td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="main" id="gg" width="100%" style="border-collapse: collapse;" cellspacing="5" cellpadding="1">
                                <tbody>
                                    <tr>
                                        <td class="fff" width="11%" style="border:1px solid black;padding:7px 3px;" align="center">DATE</td>
                                        <td class="fff" width="11%" style="border:1px solid black;padding:7px 3px;" align="center">DAY</td>
                                        <td class="fff" width="32%" style="border:1px solid black;padding:7px 3px;" align="center">SUBJECTS</td>
                                        <td class="fff" width="20%" style="border:1px solid black;padding:7px 3px;" align="center">TIMINGS</td>
                                        <td class="fff" width="26%" style="border:1px solid black;padding:7px 3px;" align="center">INVIGILATOR'."'".'S SIGN</td>
                                    </tr>';

                                    foreach($data['exam_subject_data'] as $subjectData){
                                        $html .='<tr>
                                            <td class="fff" width="11%" style="border:1px solid black;padding:7px 3px;" align="center">'.$subjectData->exam_date.'</td>
                                            <td class="fff" width="11%" style="border:1px solid black;padding:7px 3px;" align="center">'.$subjectData->exam_day.'</td>
                                            <td class="fff" width="32%" style="border:1px solid black;padding:7px 3px;" align="left">'.$subjectData->name.'</td>
                                            <td class="fff" width="20%" style="border:1px solid black;padding:7px 3px;" align="center">'.$subjectData->start_time.' - '.$subjectData->end_time.'</td>
                                            <td class="fff" width="26%" style="border:1px solid black;padding:7px 3px;" align="center"></td>
                                        </tr>';
                                    }
                                //    <tr>
                                //         <td colspan="5">Note : Reporting Time - </td>
                                //     </tr>
                                $html .='</tbody>
                            </table>

                            <table class="main1" width="100%" style="border-collapse: collapse;margin-top:80px;margin-bottom:20px;">
                                <tbody>
                                    <tr>
                                        <td class="fff" width="85%" valign="bottom" align="left">CLASS TEACHER</td>
                                        <td class="fff" width="15%" valign="bottom" align="center">HEAD MASTER</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>';
               // $pdf->loadHTML($html);
    }
    print_r($html);

        // $pdf->setPaper('A4', 'P');
        // $pdf->stream();
?>
