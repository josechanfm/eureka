<?php

namespace App\Exports;

use App\Models\Fund;
use App\Models\CategoryItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FundExport implements FromCollection, WithHeadings
{
    protected $fund;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(Fund $fund){
        $this->fund=$fund;
    }
    public function collection()
    {
        //dd($this->fund->items->select('description','amount'));Collection
        $uniqueCategoryIds=$this->fund->items->pluck('category_item_id')->unique();
        $categoryItems=CategoryItem::whereIn('id',$uniqueCategoryIds)->get();
        dd($uniqueCategoryIds,$categoryItems);
        $data=[];
        $fundItems=$this->fund->items;
        foreach($categoryItems as $catItem){
            foreach($fundItems as $fundItem){
                if($fundItem->category_item_id==$catItem.id){
                    $data[]=[

                    ];
                }
            }
        };
        dd($data);
        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Description',
            'Amount',
        ];
    }    
}
