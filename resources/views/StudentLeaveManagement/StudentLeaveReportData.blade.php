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
            <button class="btn btn-primary" onclick="exportTableToExcel('tblData', 'student-leave-report<?php echo date('dmYhi'); ?>')">Export To Excel</button>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <table class="table" id="tblData" style="border-collapse:collapse;border:1px solid;">
                <thead>
                    <tr><th colspan="6" class="text-center fw-500"><h3>{{ $institute->name }}</h3></th></tr>
                    <tr><th colspan="6" class="text-center fw-500">{{ $institute->address }}, {{ $institute->post_office }}, {{ $institute->pincode }}</th></tr>
                    <tr><th colspan="6" class="text-center fw-500">Student Leave Report</th></tr>
                    <tr><th colspan="6" class="text-center fw-500">Generated Time : @php echo date('d/m/Y H:i:s'); @endphp</th></tr>

                    <tr>
                        <th class="fw-500">S.L.</th>
                        <th class="fw-500">STUDENT NAME</th>
                        <th class="fw-500">TITLE</th>
                        <th class="fw-500">FROM DATE</th>
                        <th class="fw-500">TO DATE</th>
                        <th class="fw-500">LEAVE STATUS</th>
                    </tr>
                </thead>

                <tbody>
                    @php $count = 0; @endphp
                    @foreach($getReportData as $index => $reportData)
                        @php $count++; @endphp
                        <tr>
                            <td>{{ $count }}</td>
                            <td>{{ $reportData['student'] }}</td>
                            <td>{{ $reportData['title'] }}</td>
                            <td>{{ $reportData['from_date'] }}</td>
                            <td>{{ $reportData['to_date'] }}</td>
                            <td>{{ $reportData['leave_status'] }}</td>
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
