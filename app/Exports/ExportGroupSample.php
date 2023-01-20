<?php

namespace App\Exports;


use App\Repositories\MessageGroupNameRepository;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Maatwebsite\Excel\Concerns\Exportable;
use Session;

class ExportGroupSample implements FromCollection,WithHeadings,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public function __construct()
    {
        $messageGroupNameData = array();
        $messageGroupNameRepository = new MessageGroupNameRepository();

        $messageGroupNameDetails = $messageGroupNameRepository->all();
      
        if(count($messageGroupNameDetails) > 0){
            foreach($messageGroupNameDetails as $groupName){
                $messageGroupNameData[] = $groupName->group_name;
            }
        }

        $selects=[  //selects should have column_name and options
            ['columns_name'=>'A','options'=>$messageGroupNameData],
        ];

        $this->selects=$selects;
        $this->row_count=200;//number of rows that will have the dropdown
        $this->column_count=1;//number of columns to be auto sized
    }

    public function collection()
    {
        return collect([]);
    }

    public function headings(): array
    {
        return [
            'group_name',
            'name',
            'phone_number',
        ];
    }

    public function registerEvents(): array
    {
        return [
            // handle by a closure.
            AfterSheet::class => function(AfterSheet $event) {
                $row_count = $this->row_count;
                $column_count = $this->column_count;
                foreach ($this->selects as $select){
                    $drop_column = $select['columns_name'];
                    $options = $select['options'];
                    // set dropdown list for first data row
                    $validation = $event->sheet->getCell("{$drop_column}2")->getDataValidation();
                    $validation->setType(DataValidation::TYPE_LIST );
                    $validation->setErrorStyle(DataValidation::STYLE_INFORMATION );
                    $validation->setAllowBlank(false);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);
                    $validation->setErrorTitle('Input error');
                    $validation->setError('Value is not in list.');
                    $validation->setPromptTitle('Pick from list');
                    $validation->setPrompt('Please pick a value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"',implode(',',$options)));

                    // clone validation to remaining rows
                    for ($i = 3; $i <= $row_count; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                    // set columns to autosize
                    for ($i = 1; $i <= $column_count; $i++) {
                        $column = Coordinate::stringFromColumnIndex($i);
                        $event->sheet->getColumnDimension($column)->setAutoSize(true);
                    }
                }

            },
        ];
    }
}
?>
