<style>
    td, th{
        border:1px solid;
    }
    .mb-20{
        margin-bottom:20px;
    }
</style>
<div class="container-fluid">
        <div class="row mb-20">
            <div class="col-md-12">
                <button class="btn btn-primary" onclick="exportTableToExcel('tblData', 'feeConcession-report<?php echo date('dmYhi'); ?>')">Export To Excel</button>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <table class="table" id="tblData" style="border-collapse:collapse;border:1px solid;">
                    <thead>
                        <tr><th colspan="{{ ($getReportData['categoryCount'] * $getReportData['headingCount'] * 3) + 6 }}" class="text-center fw-500"><h3>{{ $institute->name }}</h3></th></tr>
                        <tr><th colspan="{{ ($getReportData['categoryCount'] * $getReportData['headingCount'] * 3) + 6 }}" class="text-center fw-500">{{ $institute->address }}, {{ $institute->post_office }}, {{ $institute->pincode }}</th></tr>
                        <tr><th colspan="{{ ($getReportData['categoryCount'] * $getReportData['headingCount'] * 3) + 6 }}" class="text-center fw-500">Fee Concession Report</th></tr>
                        <tr><th colspan="{{ ($getReportData['categoryCount'] * $getReportData['headingCount'] * 3) + 6 }}" class="text-center fw-500">Generated Time : @php echo date('d/m/Y H:i:s'); @endphp</th></tr>
                        <tr>
                            <th class="fw-500" rowspan="3">S.L.</th>
                            <th class="fw-500" rowspan="3">STANDARD</th>
                            <th class="fw-500" rowspan="3">ROLL NO.</th>
                            <th class="fw-500" rowspan="3">UID</th>
                            <th class="fw-500" rowspan="3">NAME</th>
                            @foreach($getReportData['studentDetailArray']['feeCategory'] as $category)
                                <th class="fw-500" class="text-center" colspan="{{ count($category['feeHeading']) * 3 }}">{{ $category['categoryName'] }}</th>
                            @endforeach                          
                            <th class="fw-500" rowspan="3">TOTAL CONCESSION</th>
                        </tr>  
                                        
                        <tr>  
                            @foreach($getReportData['studentDetailArray']['feeCategory'] as $category)
                                @foreach($category['feeHeading'] as $feeHeading)
                                    <th class="fw-500" colspan="3">{{ $feeHeading['nameFeeHeading'] }}</th>  
                                @endforeach
                            @endforeach
                        </tr>

                        <tr>  
                            @foreach($getReportData['studentDetailArray']['feeCategory'] as $category)
                                @foreach($category['feeHeading'] as $feeHeading)
                                    <th class="fw-500">Amount</th>  
                                    <th class="fw-500">Date</th>  
                                    <th class="fw-500">Remark</th>  
                                @endforeach
                            @endforeach
                        </tr>

                    </thead>
                    <tbody>
                        @php $count = 0; @endphp
                        @foreach($getReportData['studentDetailArray']['student'] as $index => $student)
                            @if($student['totalConcession'] > 0)

                                @php $count++; @endphp

                                <tr>
                                    <td>{{ $count }}.</td>
                                    <td>{{ $student['standard'] }}</td>
                                    <td>{{ $student['roll_number'] }}</td>
                                    <td>{{ $student['egenius_uid'] }}</td>
                                    <td>{{ $student['name'] }}</td>
                                    @foreach($getReportData['studentDetailArray']['feeCategory'] as $category)
                                        @foreach($category['feeHeading'] as $feeHeading)                                        
                                            <td>{{ $student[$category['idCategory']][$feeHeading['idFeeHeading']]['concessionAmount'] }}</td>                                 
                                            <td>{{ $student[$category['idCategory']][$feeHeading['idFeeHeading']]['concessionDate'] }}</td>                                 
                                            <td>{{ $student[$category['idCategory']][$feeHeading['idFeeHeading']]['concessionRemark'] }}</td>
                                        @endforeach
                                    @endforeach
                                    <td class="text-center">{{ $student['totalConcession'] }}</td>
                                </tr>
                            @endif
                        @endforeach
                        
                    </tbody>
                    <tfoot>                        
                        <tr>
                            <th class="fw-500" colspan="5">Total</th>
                            @foreach($getReportData['studentDetailArray']['feeCategory'] as $category)
                                @foreach($category['feeHeading'] as $feeHeading)  
                                    <th class="fw-500" colspan="3">{{ $feeHeading['feeHeadingTotal'] }}</th>
                                @endforeach
                            @endforeach
                            <th>{{ $getReportData['totalConcession'] }}</th>
                        </tr>                        
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
    function exportTableToExcel(tableID, filename = ''){
        var downloadLink;
        var dataType = 'application/vnd.ms-excel';
        var tableSelect = document.getElementById(tableID);
        var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
        
        // Specify file name
        filename = filename?filename+'.xls':'excel_data.xls';
        
        // Create download link element
        downloadLink = document.createElement("a");
        
        document.body.appendChild(downloadLink);
        
        if(navigator.msSaveOrOpenBlob){
            var blob = new Blob(['\ufeff', tableHTML], {
                type: dataType
            });
            navigator.msSaveOrOpenBlob( blob, filename);
        }else{
            // Create a link to the file
            downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
        
            // Setting the file name
            downloadLink.download = filename;
            
            //triggering the function
            downloadLink.click();
        }
    }
    </script>