<?php

namespace App\Exports;

use App\Models\Budget;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BudgetExport implements FromCollection, WithHeadings
{
    protected $budget;

    public function __construct(Budget $budget){
        $this->budget=$budget;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->budget->items->select('description','amount','reference_code','account_code');
    }

    public function headings(): array
    {
        return [
            'Description',
            'Amount',   
            'Reference',
            'Account'
        ];
    }    

}
