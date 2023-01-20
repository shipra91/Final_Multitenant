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
                <button class="btn btn-primary" onclick="exportTableToExcel('tblData', 'feeOutstanding-report<?php echo date('dmYhi'); ?>')">Export To Excel</button>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <table class="table" id="tblData" style="border-collapse:collapse;border:1px solid;">
                    <thead>
                        <tr><th colspan="{{ (count($getReportData['categoryList']) * 4 ) + 12 }}" class="text-center fw-500"><h3>{{ $institute->name }}</h3></th></tr>
                        <tr><th colspan="{{ (count($getReportData['categoryList']) * 4 ) + 12 }}" class="text-center fw-500">{{ $institute->address }}, {{ $institute->post_office }}, {{ $institute->pincode }}</th></tr>
                        <tr><th colspan="{{ (count($getReportData['categoryList']) * 4 ) + 12 }}" class="text-center fw-500">Fee Outstanding Report</th></tr>
                        <tr><th colspan="{{ (count($getReportData['categoryList']) * 4 ) + 12 }}" class="text-center fw-500">Generated Time : @php echo date('d/m/Y H:i:s'); @endphp</th></tr>

                        <tr rowspan="2">
                            <th class="fw-500" rowspan="2">S.L.</th>
                            <th class="fw-500" rowspan="2">STANDARD</th>
                            <th class="fw-500" rowspan="2">ROLL NO.</th>
                            <th class="fw-500" rowspan="2">UID</th>
                            <th class="fw-500" rowspan="2">NAME</th>
                            <th class="fw-500" rowspan="2">FATHER NAME</th>
                            <th class="fw-500" rowspan="2">FATHER CONTACT</th>
                            @foreach($getReportData['categoryList'] as $category)
                                <th class="fw-500" class="text-center" colspan="4">{{ $category['name'] }}</th>
                            @endforeach                            
                            <th class="fw-500" rowspan="2">TOTAL FEE</th>
                            <th class="fw-500" rowspan="2">TOTAL CONCESSION</th>
                            <th class="fw-500" rowspan="2">TOTAL PAID</th>
                            <th class="fw-500" rowspan="2">TOTAL DUE AMOUNT</th>
                            <th class="fw-500" rowspan="2">FEE DUE MSG</th>
                        </tr>  
                                        
                        <tr>  
                            @foreach($getReportData['categoryList'] as $category)                               
                                <th class="fw-500">FEE ASSIGN</th>                                  
                                <th class="fw-500">FEE CONCESSION</th>                                  
                                <th class="fw-500">FEE PAID</th>                                  
                                <th class="fw-500">DUE AMOUNT</th> 
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>                        
                        @php $count = 0; @endphp
                        @foreach($getReportData['studentDetailArray'] as $index => $reportData)
                            @php $count++; @endphp
                            <tr>
                                <td>{{ $count }}</td>
                                <td>{{ $reportData['studentDetail']['standard'] }}</td>
                                <td>{{ $reportData['studentDetail']['roll_number'] }}</td>
                                <td>{{ $reportData['studentDetail']['egenius_uid'] }}</td>
                                <td>{{ $reportData['studentDetail']['name'] }}</td>
                                <td>{{ $reportData['studentDetail']['father_name'] }}</td>
                                <td>{{ $reportData['studentDetail']['father_mobile_number'] }}</td>
                                @foreach($getReportData['categoryList'] as $category)
                                    <td>{{ $reportData['feeDetail'][$category['id']]['feeAssigned'] }}</td>
                                    <td>{{ $reportData['feeDetail'][$category['id']]['concession'] }}</td>
                                    <td>{{ $reportData['feeDetail'][$category['id']]['feePaid'] }}</td>
                                    <td>{{ $reportData['feeDetail'][$category['id']]['dueAmount'] }}</td>  
                                @endforeach
                                <td>{{ $reportData['Total']['totalfee'] }}</td>
                                <td>{{ $reportData['Total']['totalConcession'] }}</td>
                                <td>{{ $reportData['Total']['totalPaid'] }}</td>       
                                <td>{{ $reportData['Total']['totalBalance'] }}</td>                                
                            </tr>
                        @endforeach
                    </tbody>
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