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
        //dd($uniqueCategoryIds,$categoryItems);
        $data=[];
        $fundItems=$this->fund->items;
        foreach($categoryItems as $catIdx=>$catItem){
            // $data[]=[
            //     'index'=>$catIdx+1,
            //     'category'=>$catItem->name_zh,
            //     'description'=>'',
            //     'amount'=>''
            // ];

            foreach($fundItems as $itemIdx=>$fundItem){
                if($fundItem->category_item_id==$catItem->id){
                    if($fundItem->splits->count()==1){
                        $data[]=[
                            'index'=>($catIdx+1).'.'.($itemIdx+1),
                            'category'=>$fundItem->categoryItem->name_zh,
                            'description'=>$fundItem->splits[0]->description,
                            'amount'=>'',
                            'total'=>$fundItem->amount,
                        ];
                    }else{
                        foreach($fundItem->splits as $splitIdx=>$split){
                            $d=[
                                'index'=>($catIdx+1).'.'.($itemIdx+1).'.'.($splitIdx+1),
                                'category'=>$fundItem->categoryItem->name_zh,
                                'description'=>$split->description,
                                'amount'=>$split->amount
                            ];
                            if($splitIdx+1 == $fundItem->splits->count()){
                                $d['total']=$fundItem->amount;
                            }
                            $data[]=$d;
                        }
                    }
                }
            }
        };
        //dd($data);
        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Seq',  
            'Category',
            'Description',
            'Amount',
            'Total'
        ];
    }    
}
