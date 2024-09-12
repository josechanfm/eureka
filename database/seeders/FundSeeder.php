<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fund;
use App\Models\FundItem;
use App\Models\Category;
use App\Models\CategoryItemAccount;
use App\Models\FundItemAccount;

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
            // 'entity'=>'MPU',
            // 'declarant'=>'Jose',
            // 'birm'=>'12345678',
            'project_code'=>'P04-1234-5',
            'title'=>'Research funding budget management system',
            'responsible'=>'Simon',
            'amount'=>'123,456.00',
            'type'=>'P',
            'duration'=>'36',
            'grant'=>'6',
            'grants'=>["10,000","20,000","30,000","40,000","50,000","60,000"],
            'is_closed'=>false,
            'owner_id'=>1,
            'repayments'=>[]
        ]);

        $categoryItems=$category->items;

        foreach($categoryItems as $i=>$item){
            $splits=$item->accounts;
            foreach($splits as $i=>$a){
                $fundItem=$fund->items()->create([
                    'category_item_id'=>$item->id,
                    'sequence'=>$i,
                    'description'=>$item->name_zh,
                    'amount'=>rand(1000,50000)
                ]);
    
                $fundItem->splits()->create([
                    'sequence'=>1,
                    'description'=>$a->name_zh,
                    'amount'=>null
                ]);
            }
        }
        $fundItem=FundItem::find(5);
        //$categoryItemAccount=CategoryItemAccount::find(1);
        $fundItem->splits()->create([
            'sequence'=>2,
            'description'=>'Additional item'
           //'description'=>$categoryItemAccount->name_zh.' B',
        ]);
        $fundItem=FundItem::find(7);
        $categoryItemAccount=CategoryItemAccount::find(7);
        $fundItem->splits()->create([
            'sequence'=>2,
            'description'=>'Additional item'
           //'description'=>$categoryItemAccount->name_zh.' B',
        ]);
    }
}


