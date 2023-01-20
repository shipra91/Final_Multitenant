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
            <button class="btn btn-primary" onclick="exportTableToExcel('tblData', 'visitor-report<?php echo date('dmYhi'); ?>')">Export To Excel</button>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <table class="table" id="tblData" style="border-collapse:collapse;border:1px solid;">
                <thead>
                    <tr><th colspan="18" class="text-center fw-500"><h3>{{ $institute->name }}</h3></th></tr>
                    <tr><th colspan="18" class="text-center fw-500">{{ $institute->address }}, {{ $institute->post_office }}, {{ $institute->pincode }}</th></tr>
                    <tr><th colspan="18" class="text-center fw-500">Visitor Report</th></tr>
                    <tr><th colspan="18" class="text-center fw-500">Generated Time : @php echo date('d/m/Y H:i:s'); @endphp</th></tr>

                    <tr>
                        <th class="fw-500">S.L.</th>
                        <th class="fw-500">TYPE</th>
                        <th class="fw-500">VISITOR NAME</th>
                        <th class="fw-500">VISITOR CONTACT</th>
                        <th class="fw-500">VISITOR AGE</th>
                        <th class="fw-500">VISITOR ADDRESS</th>
                        <th class="fw-500">GENDER</th>
                        <th class="fw-500">PERSON TO MEET</th>
                        <th class="fw-500">CONCERNED PERSON</th>
                        <th class="fw-500">VISIT PURPOSE</th>
                        <th class="fw-500">VISITOR TYPE</th>
                        <th class="fw-500">VISITOR TYPE_NAME</th>
                        <th class="fw-500">VISITING DATETIME</th>
                        <th class="fw-500">END DATETIME</th>
                        <th class="fw-500">VISITING STATUS</th>
                        <th class="fw-500">CANCELLATION REASON</th>
                        <th class="fw-500">CANCELLED DATE</th>
                        <th class="fw-500">CANCELLED BY</th>
                    </tr>
                </thead>
                <tbody>
                    @php $count = 0; @endphp
                    @foreach($getReportData as $index => $reportData)
                        @php $count++; @endphp
                        <tr>
                            <td>{{ $count }}</td>
                            <td>{{ $reportData['type'] }}</td>
                            <td>{{ $reportData['visitor_name'] }}</td>
                            <td>{{ $reportData['visitor_contact'] }}</td>
                            <td>{{ $reportData['visitor_age'] }}</td>
                            <td>{{ $reportData['visitor_address'] }}</td>
                            <td>{{ $reportData['gender'] }}</td>
                            <td>{{ $reportData['person_to_meet'] }}</td>
                            <td>{{ $reportData['concerned_person'] }}</td>
                            <td>{{ $reportData['visit_purpose'] }}</td>
                            <td>{{ $reportData['visitor_type'] }}</td>
                            <td>{{ $reportData['visitor_type_name'] }}</td>
                            <td>{{ $reportData['visiting_datetime'] }}</td>
                            <td>{{ $reportData['end_datetime'] }}</td>
                            <td>{{ $reportData['visiting_status'] }}</td>
                            <td>{{ $reportData['cancellation_reason'] }}</td>
                            <td>{{ $reportData['cancelled_date'] }}</td>
                            <td>{{ $reportData['cancelled_by'] }}</td>
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
