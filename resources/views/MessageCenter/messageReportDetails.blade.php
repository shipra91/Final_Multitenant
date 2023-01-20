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
                <button class="btn btn-primary" onclick="exportTableToExcel('tblData', 'message-report<?php echo date('dmYhi'); ?>')">Export To Excel</button>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 text-center">
                <table class="table" id="tblData" style="border-collapse:collapse;border:1px solid;">
                    <thead>
                        <tr><th colspan="10" class="text-center fw-500"><h3>{{ $messageReportDetails['institute']->name }}</h3></th></tr>
                        <tr><th colspan="10" class="text-center fw-500">{{ $messageReportDetails['institute']->address }}, {{ $messageReportDetails['institute']->post_office }}, {{ $messageReportDetails['institute']->pincode }}</th></tr>
                        <tr><th colspan="10" class="text-center fw-500">Message Report</th></tr>
                        <tr><th colspan="10" class="text-center fw-500">Generated Time : @php echo date('d/m/Y H:i:s'); @endphp</th></tr>
                        <tr>
                            <th class="fw-500">S.L.</th>
                            <th class="fw-500">UID</th>  
                            <th class="fw-500">NAME</th>
                            <th class="fw-500">MOBILE NUMBER</th>
                            <th class="fw-500">SENT AT</th>                      
                            <th class="fw-500">DELIVERED AT</th>
                            <th class="fw-500">STATUS</th>
                            <th class="fw-500">CREDIT</th>
                            <th class="fw-500">MESSAGE ID</th>
                            <th class="fw-500">DESCRIPTION</th>
                        </tr> 
                    </thead>
                    <tbody>
                        @php $count = 0; @endphp
                        @foreach($messageReportDetails['messageReportData'] as $index => $reportData)
                            @php $count++; @endphp
                            <tr>
                                <td>{{ $count }}</td>
                                <td>{{ $reportData->uid }}</td>
                                <td>{{ $reportData->name }}</td>
                                <td>{{ $reportData->recipient_number }}</td>
                                <td>{{ $reportData->sms_sent_at }}</td>
                                <td>{{ $reportData->sms_delivered_at }}</td>
                                <td>{{ $reportData->sent_status }}</td>
                                <td>{{ $reportData->sms_charge }}</td>
                                <td>{{ $reportData->sms_message_id }}</td>
                                <td>{{ $reportData->sms_description }}</td>                          
                            </tr>
                        @endforeach
                        
                        <tr>
                            <th class="fw-500" colspan="8">Total Credit</th>
                            <th class="fw-500">{{ $messageReportDetails['totalCreditCountConsumed'] }}</th>
                            <th class="fw-500" colspan="1"></th>
                        </tr>
                    </tbody>
                </table>

                <table class="table"  id="tblData" style="border-collapse:collapse;border:1px solid;margin-top:30px;">
                    <thead>
                        <tr>
                            <th class="fw-500">SENT</th>
                            <th class="fw-500">DELIVERED</th>  
                            <th class="fw-500">FAILED</th>
                            <th class="fw-500">TOTAL</th>
                        </tr> 
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $messageReportDetails['sentCount'] }}</td>
                            <td>{{ $messageReportDetails['deliveredCount'] }}</td>
                            <td>{{ $messageReportDetails['failedCount'] }}</td>
                            <td>{{ $messageReportDetails['totalMessageCount'] }}</td>                      
                        </tr>
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