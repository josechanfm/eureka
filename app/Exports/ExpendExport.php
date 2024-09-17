<?php

namespace App\Exports;

use App\Models\Expend;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExpendExport implements FromCollection, WithHeadings
{
    protected $expend;

    public function __construct(Expend $expend){
        $this->expend=$expend;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->expend->items->select('description','amount','reference_code','account_code');
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
