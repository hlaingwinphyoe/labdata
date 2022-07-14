<?php

namespace App\Exports;

use App\Models\TestTypeValue;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;

class DataExport implements FromCollection,WithHeadings,WithColumnWidths,WithMapping
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $department;
    protected $startDate;
    protected $endDate;

    public function __construct($department,$startDate,$endDate)
    {
        $this->department=$department;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function headings():array{
        return[
            'Department',
            'Test Type',
            'Amount',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 23,
            'B' => 13,
            'C' => 12,
        ];
    }

    public function collection()
    {
        if ($this->department != null){
            return TestTypeValue::where('department_id','=',$this->department)->whereBetween('created_at', [$this->startDate, $this->endDate])->select('department_id','test_type_id','amount')->get();
        }else{
            return TestTypeValue::whereBetween('created_at', [$this->startDate, $this->endDate])->select('department_id','test_type_id','amount')->get();
        }
    }

    // export relationship data with looping
    public function map($testTypeValue) : array{
        return [
            $testTypeValue->department->name,
            $testTypeValue->testType->name,
            $testTypeValue->amount
        ];
    }

}
