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
                <button class="btn btn-primary" onclick="exportTableToExcel('tblData', 'attendance-report<?php echo date('dmYhi'); ?>')">Export To Excel</button>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <table class="table" id="tblData" style="border-collapse:collapse;border:1px solid;">
                    <thead>
                        <tr><th colspan="5" class="text-center fw-500"><h3>{{ $institute->name }}</h3></th></tr>
                        <tr><th colspan="5" class="text-center fw-500">{{ $institute->address }}, {{ $institute->post_office }}, {{ $institute->pincode }}</th></tr>
                        <tr><th colspan="5" class="text-center fw-500">Daywise Absent Report</th></tr>
                        <tr><th colspan="5" class="text-center fw-500">Generated Time : @php echo date('d/m/Y H:i:s'); @endphp</th></tr>
                        <tr>
                            <th class="fw-500">STANDARD</th>
                            <th class="fw-500">ROLL NO.</th>
                            <th class="fw-500">UID</th>
                            <th class="fw-500">NAME</th>
                            <th class="fw-500">CONTACT</th>
                        </tr> 
                    </thead>
                    <tbody>
                        @foreach($getReportData['studentDetailArray'] as $index => $reportData)
                            @if($reportData['studentDetail'])
                                <tr>
                                    <td>{{ $reportData['studentDetail']['standard'] }}</td>
                                    <td>{{ $reportData['studentDetail']['roll_number'] }}</td>
                                    <td>{{ $reportData['studentDetail']['egenius_uid'] }}</td>
                                    <td>{{ $reportData['studentDetail']['name'] }}</td> 
                                    <td>{{ $reportData['studentDetail']['father_mobile_number'] }}</td>                 
                                </tr>
                            @endif
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