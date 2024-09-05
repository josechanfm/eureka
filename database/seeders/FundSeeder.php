<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fund;
use App\Models\Category;

class FundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category=Category::find(1);
        $fund=Fund::create([
            'category_id'=>$category->id,
            'entity'=>'MPU',
            'declarant'=>'Jose',
            'birm'=>'12345678',
            'project_code'=>'P04-1234-5',
            'title'=>'Research funding budget management system',
            'responsible'=>'Simon',
            'amount'=>'123,456.00',
            'type'=>'P',
            'duration'=>'36',
            'grant'=>'3 phases',
            'grants'=>["10,000","20,000","30,000","40,000","50,000","60,000"],
            'is_closed'=>false,
            'owner_id'=>1,
            'repayments'=>[]
        ]);

        $categoryItems=$category->items;

        foreach($categoryItems as $i=>$item){
            $fundItem=$fund->items()->create([
                'category_item_id'=>$item->id,
                'description'=>'經費_'.$i,
                'account_code'=>$item->account_code,
                'amount'=>'12345'
            ]);
            $accounts=$item->accounts;
            foreach($accounts as $i=>$a){
                $fundItem->accounts()->create([
                    'category_item_account_id'=>$a->id,
                    'description'=>$a->name_zh,
                    'account_code'=>$a->account_code,
                    'amount'=>'100'.$i
                ]);
            }
        }
    }
}

